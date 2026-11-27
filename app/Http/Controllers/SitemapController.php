<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Settings (keep in sync with the other controllers)
    |--------------------------------------------------------------------------
    */

    // Category that must never appear in the sitemap
    private const EXCLUDED_CATEGORY_SLUG = 'old-blog';

    // Category used by IndexPageController for the homepage blog list
    private const HOME_CATEGORY_SLUG = 'blog';

    // Same rules as PageController::authorBlogs()
    private const AUTHOR_NAME            = 'Gabriel Potter';
    private const AUTHOR_FROM_DATE       = '2026-09-10';
    private const AUTHOR_EXCLUDED_SLUGS  = ['articulos', 'espanol'];

    // Same pattern the routes use for {cate_subcate} and {blog_slug}.
    // A URL that doesn't match would 404, so it must not be in the sitemap.
    private const SLUG_PATTERN = '/^[a-zA-Z0-9\-]+$/';


    /**
     * Generate XML sitemap.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Load all published blogs ONCE (only the columns we need)
        |--------------------------------------------------------------------------
        |
        | - Drafts are excluded (is_draft = 0), same as the front-end.
        | - Old Blog is excluded.
        | - Trashed blogs are skipped automatically if the model uses SoftDeletes.
        |
        */

        $blogs = Blog::query()
            ->select([
                'id',
                'blog_heading',
                'blog_url',
                'category_id',
                'subcategory_id',
                'created_at',
                'updated_at',
            ])
            ->with([
                'category:id,slug',
                'subcategory:id,slug',
            ])
            ->where('is_draft', 0)
            ->whereDoesntHave('category', function ($query) {
                $query->where('slug', self::EXCLUDED_CATEGORY_SLUG);
            })
            ->get();


        /*
        |--------------------------------------------------------------------------
        | 2. Work out real "last modified" dates from the blogs themselves
        |--------------------------------------------------------------------------
        */

        $siteLastmod     = null; // newest blog overall
        $homeLastmod     = null; // newest blog shown on the homepage
        $authorLastmod   = null; // newest blog shown on the author page
        $categoryLastmod = [];   // [category_id    => Carbon]
        $subLastmod      = [];   // [subcategory_id => Carbon]

        $newest = function (?Carbon $current, Carbon $candidate): Carbon {
            return ($current === null || $candidate->greaterThan($current))
                ? $candidate
                : $current;
        };

        foreach ($blogs as $blog) {

            $date = $blog->updated_at ?? $blog->created_at;

            if (! $date) {
                continue;
            }

            $siteLastmod = $newest($siteLastmod, $date);

            if ($blog->category_id) {
                $categoryLastmod[$blog->category_id] =
                    $newest($categoryLastmod[$blog->category_id] ?? null, $date);
            }

            if ($blog->subcategory_id) {
                $subLastmod[$blog->subcategory_id] =
                    $newest($subLastmod[$blog->subcategory_id] ?? null, $date);
            }

            $categorySlug = optional($blog->category)->slug;

            // Homepage list: IndexPageController (category slug = "blog")
            if ($categorySlug === self::HOME_CATEGORY_SLUG) {
                $homeLastmod = $newest($homeLastmod, $date);
            }

            // Author page list: PageController::authorBlogs()
            if (
                $blog->created_at
                && $blog->created_at->toDateString() >= self::AUTHOR_FROM_DATE
                && $categorySlug
                && ! in_array($categorySlug, self::AUTHOR_EXCLUDED_SLUGS, true)
            ) {
                $authorLastmod = $newest($authorLastmod, $date);
            }
        }

        $fallbackLastmod = ($siteLastmod ?? now())->toDateString();


        /*
        |--------------------------------------------------------------------------
        | 3. Static pages
        |--------------------------------------------------------------------------
        |
        | lastmod = when the page's blade file was last changed
        | (instead of "today" on every request, which search engines learn to ignore).
        |
        */

        $viewDate = function (string $view) use ($fallbackLastmod): string {
            $path = resource_path('views/' . str_replace('.', '/', $view) . '.blade.php');

            return is_file($path)
                ? Carbon::createFromTimestamp(filemtime($path))->toDateString()
                : $fallbackLastmod;
        };

        $urls = [
            [
                'loc'      => route('home'),
                'lastmod'  => ($homeLastmod ?? $siteLastmod ?? now())->toDateString(),
                'priority' => '1.0',
            ],
            [
                'loc'      => route('about'),
                'lastmod'  => $viewDate('pages.about'),
                'priority' => '0.7',
            ],
            [
                'loc'      => route('contact'),
                'lastmod'  => $viewDate('pages.contact'),
                'priority' => '0.6',
            ],
            [
                'loc'      => route('disclaimer'),
                'lastmod'  => $viewDate('pages.disclaimer'),
                'priority' => '0.4',
            ],
            [
                'loc'      => route('privacyPolicy'),
                'lastmod'  => $viewDate('pages.privacy_policy'),
                'priority' => '0.4',
            ],
            [
                'loc'      => route('term_conditions'),
                'lastmod'  => $viewDate('pages.term_conditions'),
                'priority' => '0.4',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | 4. Author page  (/author/gabriel-potter)
        |--------------------------------------------------------------------------
        |
        | Only listed when the author page actually has blogs to show.
        |
        */

        if ($authorLastmod) {
            $urls[] = [
                'loc'      => route('author.blogs', [
                    'authorName' => Str::slug(self::AUTHOR_NAME),
                ]),
                'lastmod'  => $authorLastmod->toDateString(),
                'priority' => '0.5',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | 5. Categories  (/{category-slug})
        |--------------------------------------------------------------------------
        |
        | Same logic as BlogController::Blog():
        | a category page lists every published blog with that category_id.
        | Categories with no published blogs are skipped (empty pages).
        |
        */

        $categories = Category::query()
            ->select(['id', 'slug'])
            ->where('slug', '!=', self::EXCLUDED_CATEGORY_SLUG)
            ->get();

        foreach ($categories as $category) {

            if (empty($category->slug) || ! preg_match(self::SLUG_PATTERN, $category->slug)) {
                continue;
            }

            if (! isset($categoryLastmod[$category->id])) {
                continue;
            }

            $urls[] = [
                'loc'      => route('categoryblogs', [
                    'cate_subcate' => $category->slug,
                ]),
                'lastmod'  => $categoryLastmod[$category->id]->toDateString(),
                'priority' => '0.8',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | 6. Subcategories  (/{subcategory-slug})
        |--------------------------------------------------------------------------
        |
        | Subcategories that belong to Old Blog are excluded.
        | Subcategories with no published blogs are skipped.
        |
        */

        $subcategories = Subcategory::query()
            ->select(['id', 'slug', 'category_id'])
            ->whereHas('category', function ($query) {
                $query->where('slug', '!=', self::EXCLUDED_CATEGORY_SLUG);
            })
            ->get();

        foreach ($subcategories as $subcategory) {

            if (empty($subcategory->slug) || ! preg_match(self::SLUG_PATTERN, $subcategory->slug)) {
                continue;
            }

            if (! isset($subLastmod[$subcategory->id])) {
                continue;
            }

            $urls[] = [
                'loc'      => route('categoryblogs', [
                    'cate_subcate' => $subcategory->slug,
                ]),
                'lastmod'  => $subLastmod[$subcategory->id]->toDateString(),
                'priority' => '0.7',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | 7. Blog posts  (/{category-or-subcategory}/{blog-slug})
        |--------------------------------------------------------------------------
        |
        | Must produce exactly the URL BlogController::BlogDetails() accepts:
        |
        |  - Category part: the subcategory slug if the blog has a subcategory,
        |                   otherwise the category slug.
        |  - Blog part:     blog_url if it is filled in,
        |                   otherwise Str::slug(blog_heading).
        |
        */

        foreach ($blogs as $blog) {

            // Category part
            $cateSubcate = $blog->subcategory_id
                ? optional($blog->subcategory)->slug
                : optional($blog->category)->slug;

            if (empty($cateSubcate) || ! preg_match(self::SLUG_PATTERN, $cateSubcate)) {
                continue;
            }

            // Blog part (same priority as BlogDetails)
            $blogSlug = ! empty($blog->blog_url)
                ? $blog->blog_url
                : Str::slug($blog->blog_heading);

            if (empty($blogSlug) || ! preg_match(self::SLUG_PATTERN, $blogSlug)) {
                continue;
            }

            $date = $blog->updated_at ?? $blog->created_at;

            $urls[] = [
                'loc'      => route('blogdetails', [
                    'cate_subcate' => $cateSubcate,
                    'blog_slug'    => $blogSlug,
                ]),
                'lastmod'  => $date ? $date->toDateString() : $fallbackLastmod,
                'priority' => '0.9',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | 8. Remove duplicate URLs
        |--------------------------------------------------------------------------
        */

        $urls = collect($urls)
            ->unique('loc')
            ->values();


        /*
        |--------------------------------------------------------------------------
        | 9. Return XML sitemap
        |--------------------------------------------------------------------------
        */

        return response()
            ->view('sitemap', [
                'urls'     => $urls,
                'urlCount' => $urls->count(),
            ])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}