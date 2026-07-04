<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\ContactPageRequest;
use App\Models\ContactPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactPageController extends Controller
{
    public function index(): View
    {
        $contactPages = ContactPage::latest()->paginate(10);

        return view('back.admin.contact-pages.index', compact('contactPages'));
    }

    public function create(): View
    {
        return view('back.admin.contact-pages.create');
    }

    public function store(ContactPageRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        ContactPage::create($data);

        return redirect()
            ->route('admin.contact-pages.index')
            ->with('success', 'صفحه تماس با ما با موفقیت ثبت شد.');
    }

    public function edit(ContactPage $contactPage): View
    {
        return view('back.admin.contact-pages.edit', compact('contactPage'));
    }

    public function update(ContactPageRequest $request, ContactPage $contactPage): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status');

        $contactPage->update($data);

        return redirect()
            ->route('admin.contact-pages.index')
            ->with('success', 'صفحه تماس با ما با موفقیت ویرایش شد.');
    }

    public function destroy(ContactPage $contactPage): RedirectResponse
    {
        $contactPage->delete();

        return redirect()
            ->route('admin.contact-pages.index')
            ->with('success', 'صفحه تماس با ما حذف شد.');
    }
}
