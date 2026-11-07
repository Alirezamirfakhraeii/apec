<?php

namespace App\Http\Middleware;

use App\Models\BlogCategory;
use App\Models\Page;
use App\Models\Post;
use App\Models\SlugRedirect;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectOldSlug
{
    // بررسی URLهای قدیمی
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $segments = $request->segments();

        if (count($segments) !== 2) {
            return $next($request);
        }

        $prefix = $segments[0];

        $slug = $segments[1];

        $config = $this->getConfig(
            $prefix
        );

        if (!$config) {
            return $next($request);
        }

        [$modelClass, $routeName] =
            $config;


        /*
         * اول بررسی می‌کنیم slug فعلی معتبر است یا نه.
         *
         * اگر معتبر باشد هیچ Redirectی انجام نمی‌شود.
         */
        if (
            $this->currentSlugExists(
                $modelClass,
                $slug
            )
        ) {
            return $next($request);
        }


        /*
         * جستجوی slug در تاریخچه
         */
        $redirect = SlugRedirect::query()
            ->where(
                'route_name',
                $routeName
            )
            ->where(
                'old_slug',
                $slug
            )
            ->first();


        if (!$redirect) {
            return $next($request);
        }


        /*
         * محتوای اصلی را پیدا می‌کنیم.
         */
        $target = $redirect->redirectable;


        /*
         * اگر محتوای اصلی حذف شده باشد،
         * Redirect قدیمی دیگر معتبر نیست.
         */
        if (
            !$target
            || blank($target->slug)
        ) {
            $redirect->delete();

            return $next($request);
        }


        /*
         * Redirect دائمی 301
         */
        return redirect()->route(
            $routeName,
            $target->slug,
            301
        );
    }


    // تنظیم Route و Model بر اساس URL
    private function getConfig(
        string $prefix
    ): ?array {
        return match ($prefix) {
            'posts' => [
                Post::class,
                'front.posts.show',
            ],

            'news' => [
                BlogCategory::class,
                'front.news.show',
            ],

            'page' => [
                Page::class,
                'front.pages.show',
            ],

            default => null,
        };
    }


    // بررسی وجود slug فعلی
    private function currentSlugExists(
        string $modelClass,
        string $slug
    ): bool {
        /** @var Model $modelClass */

        return $modelClass::query()
            ->where(
                'slug',
                $slug
            )
            ->exists();
    }
}
