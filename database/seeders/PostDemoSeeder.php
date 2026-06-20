<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ۱. دریافت یا ایجاد کاربر نویسنده برای پست‌ها
        $user = User::first() ?? User::factory()->create(['name' => 'مدیر سیستم']);

        // ۲. ایجاد ۳ دسته‌بندی هدف با نام‌های واقعی برای فرانت
        $categories = [
            ['name' => 'اخبار فناوری و تکنولوژی', 'slug' => 'tech-news'],
            ['name' => 'اقتصاد و بازار سرمایه', 'slug' => 'economy-news'],
            ['name' => 'گزارش‌های روز و بین‌الملل', 'slug' => 'world-news'],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $createdCat = BlogCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
            $categoryIds[] = $createdCat->id;
        }

        // ۳. ایجاد ۵۰ مطلب تستی و توزیع متوازن بین این ۳ دسته‌بندی
        // (اگر فکتوری برای مدل پست نداری، این متد مستقیماً با آرایه دیتای فیک لود می‌کند)
        for ($i = 1; $i <= 50; $i++) {
            $title = "تیتر خبر تستی شماره " . $i . " برای بررسی ظاهر و ریسپانسیو قالب بلاگ";

            Post::create([
                'title'        => $title,
                'slug'         => Str::slug($title) . '-' . rand(100, 999),
                'summary'      => "این یک خلاصه خبر تستی برای بررسی ابعاد، فونت و چیدمان باکس سه کلاسی صفحه اصلی است که در خطوط فرانت رندر می‌شود.",
                'body'         => "<p>متن کامل خبر تستی شماره {$i}. لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است.</p>",
                'image'        => null, // می‌توانی آدرس عکس پیش‌فرض مثل 'front/img/default.jpg' بگذاری
                'views'        => rand(50, 3000),
                'status'       => 'published',
                'published_at' => now()->subHours(rand(1, 100)),
                'user_id'      => $user->id,
            ]);
        }
    }
}
