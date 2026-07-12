@if ($errors->any())
    <div class="alert alert-danger">
        <strong>خطا در ثبت اطلاعات:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="filter-card mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">عنوان صفحه</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $page->title) }}"
                    class="form-control"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">اسلاگ</label>
                <input
                    type="text"
                    name="slug"
                    value="{{ old('slug', $page->slug) }}"
                    class="form-control"
                    required
                    placeholder="contact-us"
                    dir="ltr"
                >
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">خلاصه صفحه</label>
                <textarea
                    name="summary"
                    rows="3"
                    class="form-control"
                >{{ old('summary', $page->summary) }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">تمپلیت صفحه</label>
                <select name="template" class="form-control">
                    @foreach($templates as $key => $template)
                        <option
                            value="{{ $key }}"
                            @selected(old('template', $page->template) === $key)
                        >
                            {{ $template['label'] }}
                        </option>
                    @endforeach
                </select>

                @if($page->exists)
                    <small class="text-muted d-block mt-2">
                        بعد از تغییر تمپلیت و ذخیره، فیلدهای مخصوص همان تمپلیت نمایش داده می‌شود.
                    </small>
                @else
                    <small class="text-muted d-block mt-2">
                        ابتدا صفحه را بسازید؛ سپس در مرحله ویرایش، فیلدهای مخصوص تمپلیت را تکمیل می‌کنید.
                    </small>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">وضعیت</label>
                <select name="status" class="form-control">
                    <option value="1" @selected(old('status', (int) $page->status) == 1)>فعال</option>
                    <option value="0" @selected(old('status', (int) $page->status) == 0)>غیرفعال</option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">متن اصلی صفحه</label>
                <textarea
                    name="body"
                    rows="8"
                    class="form-control"
                >{{ old('body', $page->body) }}</textarea>
            </div>
        </div>
    </div>

    @if($page->exists && count($templateFields))
        <div class="filter-card mb-4">
            <h3 class="mb-4">فیلدهای مخصوص تمپلیت</h3>

            <div class="row">
                @foreach($templateFields as $field)
                    @php
                        $key = $field['key'];
                        $value = old("template_data.$key", $page->template_data[$key] ?? null);
                    @endphp

                    <div class="col-md-12 mb-3">
                        <label class="form-label">{{ $field['label'] }}</label>

                        @if($field['type'] === 'text')
                            <input
                                type="text"
                                name="template_data[{{ $key }}]"
                                value="{{ $value }}"
                                class="form-control"
                            >
                        @elseif($field['type'] === 'textarea')
                            <textarea
                                name="template_data[{{ $key }}]"
                                rows="4"
                                class="form-control"
                            >{{ $value }}</textarea>
                        @elseif($field['type'] === 'image')
                            <input
                                type="file"
                                name="template_files[{{ $key }}]"
                                class="form-control"
                                accept="image/*"
                            >

                            @if($value)
                                <div class="mt-3">
                                    <img
                                        src="{{ asset('storage/' . $value) }}"
                                        alt="{{ $field['label'] }}"
                                        style="max-width: 180px; border-radius: 12px;"
                                    >
                                </div>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="filter-card mb-4">
        <h3 class="mb-4">تنظیمات سئو</h3>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label">عنوان سئو</label>
                <input
                    type="text"
                    name="meta_title"
                    value="{{ old('meta_title', $page->meta_title) }}"
                    class="form-control"
                >
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">توضیحات سئو</label>
                <textarea
                    name="meta_description"
                    rows="3"
                    class="form-control"
                >{{ old('meta_description', $page->meta_description) }}</textarea>
            </div>
        </div>
    </div>

    <button type="submit" class="news-create-btn">
        ذخیره صفحه
    </button>
</form>
