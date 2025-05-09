<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Tag;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        // Add home page
        $sitemap->add(
            Url::create(route('home'))
                ->setLastModificationDate(Carbon::yesterday())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0)
        );

        // Add static pages
        $this->addStaticPages($sitemap);

        // Add posts
        $this->addPosts($sitemap);

        // Add categories
        // $this->addCategories($sitemap);

        // Add subcategories
        $this->addSubCategories($sitemap);

        // Add tags
        $this->addTags($sitemap);

        // Generate and output the sitemap
        return $sitemap->toResponse(request());
    }

    private function addStaticPages($sitemap)
    {
        // Add all static pages from your website
        $staticPages = [
            'about' => 0.8,
            'contact' => 0.8,
            'faq' => 0.7,
            'terms' => 0.7,
            'privacy' => 0.7,
            'disclaimer' => 0.7,
            'photo_gallery' => 0.8,
            'video_gallery' => 0.8,
        ];

        foreach ($staticPages as $routeName => $priority) {
            $sitemap->add(
                Url::create(route($routeName))
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority($priority)
            );
        }
    }

    private function addPosts($sitemap)
    {
        // Only include published posts
        Post::published()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create(route('news_detail', $post->post_slug))
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                    ->setPriority(0.9)
            );
        });
    }

    private function addCategories($sitemap)
    {
        Category::whereHas('subCategories')->each(function (Category $category) use ($sitemap) {
            // You may need to adjust this based on your actual category URL structure
            if (isset($category->slug)) {
                $sitemap->add(
                    Url::create(route('category', $category->slug))
                        ->setLastModificationDate($category->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.8)
                );
            }
        });
    }

    private function addSubCategories($sitemap)
    {
        SubCategory::whereHas('rPost')->each(function (SubCategory $subCategory) use ($sitemap) {
            $sitemap->add(
                Url::create(route('category', $subCategory->slug))
                    ->setLastModificationDate($subCategory->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        });
    }

    private function addTags($sitemap)
    {
        Tag::whereHas('posts')->each(function (Tag $tag) use ($sitemap) {
            $sitemap->add(
                Url::create(route('tag_post_show', $tag->slug))
                    ->setLastModificationDate($tag->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.6)
            );
        });
    }
}
