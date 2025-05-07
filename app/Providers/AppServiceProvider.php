<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Language;
use App\Models\LiveChannel;
use App\Models\OnlinePoll;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\SidebarAdvertisement;
use App\Models\SocialItem;
use App\Models\TopAdvertisement;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Paginator::useBootstrap();

        if (Schema::hasTable('top_advertisements')) {
            $top_ad_data = \App\Models\TopAdvertisement::find(1);
            view()->share('global_top_ad_data', $top_ad_data);
        }

        if (Schema::hasTable('sidebar_advertisements')) {
            $sidebar_top_ad = \App\Models\SidebarAdvertisement::where('sidebar_ad_location','Top')->get();
            $sidebar_bottom_ad = \App\Models\SidebarAdvertisement::where('sidebar_ad_location','Bottom')->get();
            view()->share('global_sidebar_top_ad', $sidebar_top_ad);
            view()->share('global_sidebar_bottom_ad', $sidebar_bottom_ad);
        }

        if (Schema::hasTable('categories') && Schema::hasTable('sub_categories')) {
            $categories = \App\Models\Category::with('rSubCategory')
                ->where('show_on_menu','Show')
                ->orderBy('category_order','asc')
                ->get();
            view()->share('global_categories', $categories);
        }

        if (Schema::hasTable('social_items')) {
            $social_item_data = \App\Models\SocialItem::get();
            view()->share('global_social_item_data', $social_item_data);
        }

        if (Schema::hasTable('settings')) {
            $setting_data = \App\Models\Setting::find(1);
            view()->share('global_setting_data', $setting_data);
        }

        if (Schema::hasTable('languages')) {
            $language_data = \App\Models\Language::get();
            $default_lang_data = \App\Models\Language::where('is_default','Yes')->first();
            view()->share('global_language_data', $language_data);
            view()->share('global_short_name', optional($default_lang_data)->short_name);
        }
    }
}
