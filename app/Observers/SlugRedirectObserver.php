<?php

namespace App\Observers;

use App\Models\BlogCategory;
use App\Models\Page;
use App\Models\Post;
use App\Models\SlugRedirect;
use Illuminate\Database\Eloquent\Model;

class SlugRedirectObserver
{
    // ثبت slug قبلی بعد از تغییر
    public function updated(Model $model): void
    {
        if (!$model->wasChanged('slug')) {
            return;
        }

        $oldSlug = $model->getOriginal(
            'slug'
        );

        $newSlug = $model->slug;

        if (
            blank($oldSlug)
            || blank($newSlug)
            || $oldSlug === $newSlug
        ) {
            return;
        }

        $routeName = $this->getRouteName(
            $model
        );

        if (!$routeName) {
            return;
        }

        /*
         * اگر slug جدید قبلاً یک slug قدیمی بوده،
         * دیگر نباید Redirect شود چون الان URL اصلی است.
         */
        SlugRedirect::query()
            ->where(
                'route_name',
                $routeName
            )
            ->where(
                'old_slug',
                $newSlug
            )
            ->delete();

        /*
         * slug قبلی را ذخیره می‌کنیم.
         *
         * مقصد را URL ذخیره نمی‌کنیم.
         * فقط ID محتوا ذخیره می‌شود تا همیشه به
         * جدیدترین slug همان محتوا Redirect شود.
         */
        SlugRedirect::updateOrCreate(
            [
                'route_name' =>
                    $routeName,

                'old_slug' =>
                    $oldSlug,
            ],
            [
                'redirectable_type' =>
                    $model::class,

                'redirectable_id' =>
                    $model->getKey(),
            ]
        );
    }


    // Route مربوط به هر مدل
    private function getRouteName(
        Model $model
    ): ?string {
        return match (true) {
            $model instanceof Post =>
            'front.posts.show',

            $model instanceof BlogCategory =>
            'front.news.show',

            $model instanceof Page =>
            'front.pages.show',

            default => null,
        };
    }
}
