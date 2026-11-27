<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use DOMDocument;
use DOMXPath;

class BlogController extends Controller
{

public function Blog(Request $request, $cate_subcate)
{
    $category = Category::where('slug', $cate_subcate)->first();

    if (!$category) {
        $category = Subcategory::where('slug', $cate_subcate)->first();
    }

    $query = trim($request->get('q', ''));

    $blogs = Blog::with(['category', 'subcategory'])
        ->where('is_draft', 0)
        ->where(function ($q) use ($cate_subcate) {

            $q->whereHas('category', function ($cq) use ($cate_subcate) {
                $cq->where('slug', $cate_subcate);
            })

            ->orWhereHas('subcategory', function ($sq) use ($cate_subcate) {
                $sq->where('slug', $cate_subcate);
            });
        });


    // Search filter
    if ($query !== '') {

        $escapedQuery = str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\%', '\_'],
            $query
        );

        $searchTerm = '%' . $escapedQuery . '%';

        $blogs->where(function ($q) use ($searchTerm) {

            $q->where(
                'blog_heading',
                'LIKE',
                $searchTerm
            )

            ->orWhere(
                'blog_description',
                'LIKE',
                $searchTerm
            )

            ->orWhere(
                'meta_title',
                'LIKE',
                $searchTerm
            )

            ->orWhere(
                'meta_keywords',
                'LIKE',
                $searchTerm
            );
        });
    }


    // Pagination (newest published first)
    $blogs = $this->orderNewestFirst($blogs)
        ->paginate(6)
        ->appends(
            $request->only('q')
        );


    return view(
        'blogs.blog',
        compact(
            'blogs',
            'category',
            'query'
        )
    );
}

public function BlogDetails($cate_subcate, $blog_slug)
{
    $blog = Blog::with(['category', 'subcategory', 'faqs'])
        ->where('is_draft', 0)
        // Category rule: subcategory slug wins, else category slug
        ->where(function ($q) use ($cate_subcate) {
            $q->whereHas('subcategory', fn ($s) => $s->where('slug', $cate_subcate))
              ->orWhere(function ($q2) use ($cate_subcate) {
                  $q2->whereNull('subcategory_id')
                     ->whereHas('category', fn ($c) => $c->where('slug', $cate_subcate));
              });
        })
        // Candidates: exact blog_url match, or blogs with no blog_url
        ->where(function ($q) use ($blog_slug) {
            $q->where('blog_url', $blog_slug)
              ->orWhereNull('blog_url')
              ->orWhere('blog_url', '');
        })
        ->get()
        ->first(function ($item) use ($blog_slug) {
            // Priority 1: blog_url, Priority 2: slug from blog_heading
            $slug = !empty($item->blog_url)
                ? $item->blog_url
                : Str::slug($item->blog_heading);

            return $slug === $blog_slug;
        });

    abort_if(!$blog, 404);

    [$content, $toc] = $this->generateTocFromContent(
        $blog->blog_description
    );

    $relatedPosts = $this->orderNewestFirst(
            Blog::with(['category', 'subcategory'])
                ->where('is_draft', 0)
                ->where('id', '!=', $blog->id)
                ->where(function ($q) use ($blog) {

                    if ($blog->subcategory_id) {
                        $q->where('subcategory_id', $blog->subcategory_id);
                    } else {
                        $q->where('category_id', $blog->category_id);
                    }

                })
        )
        ->take(4)
        ->get()
        ->filter(function ($post) {
            return $post->subcategory || $post->category;
        });

    return view(
        'blogs.blog_details',
        compact(
            'blog',
            'content',
            'toc',
            'relatedPosts',
            'cate_subcate'
        )
    );
}


/**
 * Newest published first.
 * Uses published_at (falls back to created_at). If the published_at
 * column has not been migrated yet, it safely falls back to created_at
 * so the page never throws a 500.
 */
private function orderNewestFirst($query)
{
    if (Schema::hasColumn('blogs', 'published_at')) {
        $query->orderByRaw('COALESCE(published_at, created_at) DESC');
    } else {
        $query->orderByDesc('created_at');
    }

    return $query->orderByDesc('id');
}


/**
 * Parses HTML content, injects unique ids into <h2>/<h3> tags,
 * and returns [modifiedHtml, tocArray]
 */
private function generateTocFromContent($html)
{
    $toc = [];

    if (empty(trim((string) $html))) {
        return [$html, $toc];
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML(
        '<?xml encoding="utf-8" ?>' . $html,
        LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
    );
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query('//h2 | //h3'); // returns nodes in document order

    $usedSlugs = [];

    foreach ($nodes as $node) {
        $text = trim($node->textContent);
        if ($text === '') {
            continue;
        }

        $baseSlug = Str::slug($text);
        $slug = $baseSlug;
        $i = 1;
        while (in_array($slug, $usedSlugs)) {
            $slug = $baseSlug . '-' . $i++;
        }
        $usedSlugs[] = $slug;

        $node->setAttribute('id', $slug);

        $toc[] = [
            'text'  => $text,
            'slug'  => $slug,
            'level' => strtolower($node->nodeName), // h2 or h3
        ];
    }

    $content = $dom->saveHTML();

    return [$content, $toc];
}
}