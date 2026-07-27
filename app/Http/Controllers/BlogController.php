<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use DOMDocument;
use DOMXPath;

class BlogController extends Controller
{
    public function Blog($cate_subcate)
    {
        $category = Category::where('slug', $cate_subcate)->first();

        if (!$category) {
            $category = Subcategory::where('slug', $cate_subcate)->first();
        }

        $blogs = Blog::with(['category', 'subcategory'])
            ->where('is_draft', 0)
            ->where(function ($query) use ($cate_subcate) {
                $query->whereHas('category', function ($q) use ($cate_subcate) {
                    $q->where('slug', $cate_subcate);
                })
                ->orWhereHas('subcategory', function ($q) use ($cate_subcate) {
                    $q->where('slug', $cate_subcate);
                });
            })
            ->latest()
            ->paginate(6);

        return view('blogs.blog', compact('blogs', 'category'));
    }

public function BlogDetails($cate_subcate, $blog_slug)
{
    $blog = Blog::with(['category', 'subcategory', 'faqs'])
        ->where('is_draft', 0)
        ->get()
        ->first(function ($item) use ($cate_subcate, $blog_slug) {

            $slug = $item->subcategory->slug ?? $item->category->slug;

            return $slug === $cate_subcate
                && Str::slug($item->blog_heading) === $blog_slug;
        });

    abort_if(!$blog, 404);

    [$content, $toc] = $this->generateTocFromContent($blog->blog_description);

    $relatedPosts = Blog::with(['category', 'subcategory']) // <-- eager load added
        ->where('is_draft', 0)
        ->where('id', '!=', $blog->id)
        ->where(function ($q) use ($blog) {
            if ($blog->subcategory_id) {
                $q->where('subcategory_id', $blog->subcategory_id);
            } else {
                $q->where('category_id', $blog->category_id);
            }
        })
        ->latest()
        ->take(4)
        ->get()
        ->filter(function ($post) {
            // drop any post that has neither category nor subcategory,
            // since route() would throw without a valid cate_subcate slug
            return $post->subcategory || $post->category;
        });

    return view('blogs.blog_details', compact('blog', 'content', 'toc', 'relatedPosts'));
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
