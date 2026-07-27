<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Header: categories + subcategories, filtered by locale
        View::composer(
            ['partials.header', 'es.partials.header'],
            function ($view) {
                $locale = App::getLocale();

                if ($locale === 'es') {
                    // Spanish header → ONLY Spanish categories
                    $categories = Category::with('subcategories')
                        ->whereIn('slug', ['articulos', 'espanol'])
                        ->get();
                } else {
                    // English header → EXCLUDE Spanish categories
                    $categories = Category::with('subcategories')
                        ->whereNotIn('slug', ['articulos', 'espanol'])
                        ->get();
                }

                $view->with('categories', $categories);
            }
        );

        // Footer: categories + subcategories, filtered by locale and hidden slugs
        View::composer(
            ['partials.footer', 'es.partials.footer'],
            function ($view) {
                $viewName = $view->getName();

                $hiddenSlugs    = ['more-policies', 'airline-policies', 'articulos', 'espanol'];
                $hiddenSubSlugs = ['reservation', 'refund-policy', 'seat-selection'];

                if ($viewName === 'es.partials.footer') {
                    $categories = Category::with('subcategories')
                        ->whereIn('slug', ['articulos', 'espanol'])
                        ->get();

                    $subcategories = Subcategory::whereHas('category', function ($q) {
                        $q->whereIn('slug', ['articulos', 'espanol']);
                    })->get();
                } else {
                    $categories = Category::with('subcategories')
                        ->whereNotIn('slug', $hiddenSlugs)
                        ->get();

                    $subcategories = Subcategory::whereHas('category', function ($q) use ($hiddenSlugs) {
                        $q->whereNotIn('slug', $hiddenSlugs);
                    })->whereNotIn('slug', $hiddenSubSlugs)
                      ->get();
                }

                $view->with([
                    'categories'    => $categories,
                    'subcategories' => $subcategories,
                ]);
            }
        );

        // Force HTTPS in production
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}