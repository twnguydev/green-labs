<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;

class SearchbarProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $productResults = [];

        if (request()->has('search')) {
            $products = Product::where('title', 'like', '%' . request('search') . '%')
                                ->orWhere('description', 'like', '%' . request('search') . '%')
                                ->get();
            $productResults = $products;
        }

        view()->share('productResults', $productResults);
    }
}