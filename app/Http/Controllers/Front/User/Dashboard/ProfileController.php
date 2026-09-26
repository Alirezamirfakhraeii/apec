<?php

namespace App\Http\Controllers\Front\User\Dashboard;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;


class ProfileController extends Controller
{
    /**
     * نمایش فرم ویرایش اطلاعات کاربر.
     */
    public function edit(): View
    {
        $user = auth()->user();

        return view(
            'front.user.dashboard.profile.edit',
            compact('user')
        );
    }

    public function update()
    {

    }
}
