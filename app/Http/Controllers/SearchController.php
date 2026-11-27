<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    /**
     * Full search (form submit / Enter key).
     *
     * Only blogs whose heading contains the searched word are returned. If nothing matches,
     * the user is sent back with a "no blogs found" message.
     */
    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));

        if ($query === '') {
            return redirect()->back();
        }

        $blogs = $this->runSearch($query, 1);

        if ($blogs === null) {
            return back()->with(
                'error',
                'Something went wrong while searching. Please try again.'
            );
        }

        $blog = $blogs->first();

        if (!$blog) {
            return back()->with(
                'error',
                'No blogs found matching "' . $query . '".'
            );
        }

        // Priority: subcategory slug -> category slug
        $slug = optional($blog->subcategory)->slug
            ?? optional($blog->category)->slug;

        if (!$slug) {
            return back()->with(
                'error',
                'That blog has no category assigned.'
            );
        }

        // Pass search term + best matched blog id to category page
        return redirect()->route(
            'categoryblogs',
            [
                'cate_subcate' => $slug,
                'q'            => $query,
                'blog'         => $blog->id,
            ]
        );
    }


    /**
     * Live/AJAX search used by the header dropdown.
     * Uses the same runSearch(), so the same rules apply.
     */
    public function ajaxSearch(Request $request)
    {
        $query = trim($request->get('q', ''));

        if ($query === '') {
            return response()->json([]);
        }

        $blogs = $this->runSearch($query, 8);

        if ($blogs === null) {
            return response()->json([], 500);
        }

        $results = $blogs->map(function ($blog) use ($query) {

            // Priority: subcategory slug -> category slug
            $slug = optional($blog->subcategory)->slug
                ?? optional($blog->category)->slug;

            return [
                'title' => $blog->blog_heading,

                'image' => $blog->image
                    ? asset('storage/' . $blog->image)
                    : null,

                'url' => $slug
                    ? route('categoryblogs', [
                        'cate_subcate' => $slug,
                        'q'            => $query,
                        'blog'         => $blog->id,
                    ])
                    : '#',
            ];
        });

        return response()->json($results);
    }


    /**
     * Shared search query builder.
     *
     * Matches ONLY the blog heading (blog_heading).
     * Meta title, description and category / subcategory names are
     * NOT searched. If the heading does not contain the word,
     * the blog is not returned.
     *
     * Old Blog category (slug: old-blog) is excluded from search only.
     * Direct URLs are NOT affected.
     */
    private function runSearch(string $query, ?int $limit)
    {
        // Escape LIKE wildcard characters
        $escapedQuery = str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\%', '\_'],
            $query
        );

        $searchTerm = '%' . $escapedQuery . '%';

        try {

            $builder = Blog::with([
                    'category',
                    'subcategory'
                ])

                // Only published blogs
                ->where('is_draft', false)

                // Exclude Old Blog from search
                ->whereDoesntHave('category', function ($categoryQuery) {
                    $categoryQuery->where('slug', 'old-blog');
                })

                // Match ONLY the blog heading
                ->where('meta_keywords', 'LIKE', $searchTerm)

                // Newest first
                ->latest();

            // Limit results
            if ($limit !== null) {
                $builder->limit($limit);
            }

            return $builder->get();

        } catch (\Throwable $e) {

            Log::error(
                'Search failed: ' . $e->getMessage()
            );

            return null;
        }
    }
}