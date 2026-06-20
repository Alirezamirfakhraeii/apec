<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::first() ?? new Setting();

        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * بروزرسانی یا ایجاد تنظیمات
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'copyright' => 'nullable|string|max:500',
            'telegram'  => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'twitter'   => 'nullable|string|max:255',
            'whatsapp'  => 'nullable|string|max:255',
        ], [
            'copyright.max' => 'متن کپی‌رایت نمی‌تواند بیشتر از ۵۰۰ کاراکتر باشد.',
        ]);

        Setting::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with('success', 'تنظیمات فوتر با موفقیت بروزرسانی شد.');
    }
}
