<?php

namespace App\Http\Controllers\Front\User\Dashboard;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


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


    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:150',
                ],


                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')
                        ->ignore($user->id),
                ],

                'mobile' => [
                    'nullable',
                    'string',
                    'max:20',
                ],

                'current_password' => [
                    'nullable',
                    'required_with:password',
                ],

                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'confirmed',
                ],
            ],
            [
                'name.required' =>
                    'نام و نام خانوادگی الزامی است.',

                'email.required' =>
                    'آدرس ایمیل الزامی است.',

                'email.email' =>
                    'فرمت آدرس ایمیل صحیح نیست.',

                'email.unique' =>
                    'این آدرس ایمیل قبلاً استفاده شده است.',

                'current_password.required_with' =>
                    'برای تغییر رمز عبور، رمز عبور فعلی را وارد کنید.',

                'password.min' =>
                    'رمز عبور جدید باید حداقل ۸ کاراکتر باشد.',

                'password.confirmed' =>
                    'تکرار رمز عبور جدید مطابقت ندارد.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | بررسی رمز عبور فعلی
        |--------------------------------------------------------------------------
        */

        if ($request->filled('password')) {

            if (
                ! Hash::check(
                    (string) $request->input('current_password'),
                    $user->password
                )
            ) {
                return back()
                    ->withErrors([
                        'current_password' =>
                            'رمز عبور فعلی صحیح نیست.',
                    ])
                    ->withInput(
                        $request->except([
                            'current_password',
                            'password',
                            'password_confirmation',
                        ])
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | بروزرسانی اطلاعات پایه
        |--------------------------------------------------------------------------
        */

        $user->name = $validated['name'];


        $user->email = $validated['email'];

        $user->mobile = $validated['mobile'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | تغییر رمز عبور
        |--------------------------------------------------------------------------
        */

        if ($request->filled('password')) {

            $user->password = Hash::make(
                $validated['password']
            );
        }


        $user->save();


        return redirect()
            ->route('user.profile.edit')
            ->with(
                'success',
                'اطلاعات حساب کاربری با موفقیت بروزرسانی شد.'
            );
    }





}
