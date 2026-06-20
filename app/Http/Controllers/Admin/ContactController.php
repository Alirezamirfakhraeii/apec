<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // نمایش لیست پیام‌ها به ترتیب جدیدترین‌ها
    public function index()
    {
        $messages = Contact::latest()->paginate(15);
        return view('back.admin.contacts.index', compact('messages'));
    }

    // نمایش جزئیات یک پیام خاص
    public function show(Contact $contact)
    {
        return view('back.admin.contacts.show', compact('contact'));
    }
}
