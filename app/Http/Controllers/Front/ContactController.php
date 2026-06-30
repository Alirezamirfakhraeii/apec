<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{

    public function index()
    {
        return view('front.contact.index');
    }

    /**
     * ذخیره پیام کاربر در دیتابیس
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'contact' => ['required', 'string', function ($attribute, $value, $fail) {
                $isEmail = filter_var($value, FILTER_VALIDATE_EMAIL);
                $isMobile = preg_match('/^09[0-9]{9}$/', $value);

                if (!$isEmail && !$isMobile) {
                    $fail('لطفاً یک شماره موبایل معتبر یا یک ایمیل صحیح وارد کنید.');
                }
            }],
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ], [
            'name.required'    => 'لطفاً نام و نام خانوادگی خود را وارد کنید.',
            'contact.required' => 'وارد کردن شماره موبایل یا ایمیل الزامی است.',
            'message.required' => 'متن پیام نمی‌تواند خالی باشد.',
            'message.min'      => 'متن پیام باید حداقل ۱۰ کاراکتر باشد.',
        ]);

        Contact::create([
            'name'    => $request->name,
            'contact' => $request->contact,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip'      => $request->ip(),
        ]);

        return redirect()->back()->with('contact_success', 'پیام شما با موفقیت ارسال شد. به زودی با شما تماس خواهیم گرفت.');
    }

    public function show(): View
    {
        $contactPage = ContactPage::where('status', true)
            ->latest()
            ->firstOrFail();


        return view('front.pages.contact', compact('contactPage'));
    }


}
