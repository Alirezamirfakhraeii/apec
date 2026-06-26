<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Podcast;
use Illuminate\Database\Seeder;

class PodcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ایجاد دسته‌بندی‌های درختی تستی
        $parentCat = Category::updateOrCreate(['slug' => 'analysis'], ['title' => 'تحلیل']);
        $subCatOne = Category::updateOrCreate(['slug' => 'analysis-one', 'parent_id' => $parentCat->id], ['title' => 'تحلیل یک']);
        $subCatTwo = Category::updateOrCreate(['slug' => 'analysis-two', 'parent_id' => $parentCat->id], ['title' => 'تحلیل دو']);
        $healthCat = Category::updateOrCreate(['slug' => 'health'], ['title' => 'سلامت']);

        // ۱. پادکست شاخص بزرگ (همراه با کد آی‌فریم کست‌باکس برای پخش زنده)
        Podcast::create([
            'category_id' => $subCatTwo->id,
            'title' => 'اپیزود اول: بررسی آینده توسعه خطوط لوله انرژی',
            'slug' => 'energy-pipeline-future',
            'summary' => 'در این اپیزود تخصصی از رادیو نفت و توسعه، به بررسی چالش‌ها و فرصت‌های ژئوپلیتیک در مسیر توسعه خطوط انتقال انرژی در سال ۲۰۲۶ می‌پردازیم.',
            'image' => null, // کست‌باکس خودش کاور را رندر می‌کند
            'duration' => '42:15',
            'embed_code' => '<iframe src="https://castbox.fm/app/castbox/player/id/2944416/id/357904574?v=8.22.0&autoplay=0" style="width: 100%; height: 100%; border: none;" allow="autoplay"></iframe>',
            'castbox_url' => 'https://castbox.fm',
            'spotify_url' => 'https://spotify.com',
            'status' => 'published',
            'published_at' => now(),
        ]);

        // ۲. پادکست‌های فرعی لیست کناری
        Podcast::create([
            'category_id' => $subCatOne->id,
            'title' => 'تحلیل بازار نفت و نوسانات قیمت جهانی در فصل اول',
            'slug' => 'oil-market-analysis-q1',
            'summary' => 'بررسی آماری رفتار اوپک پلاس و تاثیر آن بر بازارهای آسیایی.',
            'image' => 'front/img/default-podcast.jpg',
            'duration' => '28:40',
            'castbox_url' => 'https://castbox.fm',
            'spotify_url' => 'https://spotify.com',
            'status' => 'published',
            'published_at' => now()->subDays(1),
        ]);

        Podcast::create([
            'category_id' => $healthCat->id,
            'title' => 'سلامت شغلی و ارگونومی در محیط‌های پالایشگاهی',
            'slug' => 'refinery-occupational-health',
            'summary' => 'راهکارهای بهبود بهداشت و سلامت کارکنان در شرایط سخت کاری.',
            'image' => 'front/img/default-podcast.jpg',
            'duration' => '19:15',
            'castbox_url' => 'https://castbox.fm',
            'status' => 'published',
            'published_at' => now()->subDays(2),
        ]);

        Podcast::create([
            'category_id' => $parentCat->id,
            'title' => 'گذار به انرژی‌های پاک؛ رویای شیرین یا واقعیت تلخ؟',
            'slug' => 'clean-energy-transition',
            'summary' => 'بررسی چالش‌های فنی زیرساخت‌های تجدیدپذیر در کشورهای در حال توسعه.',
            'image' => 'front/img/default-podcast.jpg',
            'duration' => '35:10',
            'spotify_url' => 'https://spotify.com',
            'status' => 'published',
            'published_at' => now()->subDays(3),
        ]);
    }
}
