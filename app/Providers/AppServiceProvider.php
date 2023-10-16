<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $products = DB::select(
            'select p.*,c.name cate_title,s.name supplier_title from products p,categories c, suppliers s
             where p.category_id = c.id and p.supplier_id = s.id and p.qty > 0 and p.status = 1'
        );
        View::share('categories', Category::where('status',1)->get());
        View::share('products', $products);
        View::share('setting', Setting::first());
    }
}
