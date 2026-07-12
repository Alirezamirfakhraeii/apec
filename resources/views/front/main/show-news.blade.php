@extends('front.layouts.app') {{-- مطمئن شو نام لایه اصلی‌ات درست باشد --}}

@section('content')
    <div class="container my-5" dir="rtl" style="text-align: right;">
        <div class="row">

            <!-- ستون اصلی: محتوای خبر -->
            <div class="col-lg-8 col-12 mb-4">
                <div class="bg-white p-4 border rounded">

                    <!-- عنوان خبر -->
                    <h1 class="h3 font-weight-bold mb-3 line-height-text text-dark">{{ $post->title }}</h1>

                    <!-- اطلاعات متای خبر (تاریخ، نویسنده، بازدید) -->
                    <div class="d-flex flex-wrap align-items-center text-muted font_12 border-bottom pb-3 mb-4">
                    <span class="ml-3">
                        <i class="fa fa-calendar-alt ml-1"></i>
                        {{ jdate($post->published_at)->format('%d %B %Y') }} {{-- فرض بر استفاده از پکیج Morilog/Jalali --}}
                    </span>
                        <span class="ml-3">
                        <i class="fa fa-user ml-1"></i>
                        نویسنده: {{ $post->user->name ?? 'مدیر سایت' }}
                    </span>
                        <span class="ml-3">
                        <i class="fa fa-eye ml-1"></i>
                        {{ $post->views ?? 0 }} بازدید
                    </span>
                        @if($post->blog_category_id)
                            <span>
                            <i class="fa fa-folder ml-1"></i>
                            دسته بندی: {{ $post->category->title ?? 'عمومی' }}
                        </span>
                        @endif
                    </div>

                    <!-- تصویر شاخص خبر -->
                    @if($post->image)
                        <div class="mb-4 text-center">
                            <img src="{{ asset($post->image) }}" class="img-fluid rounded w-100" alt="{{ $post->title }}" style="max-height: 450px; object-fit: cover;">
                        </div>
                    @endif

                    <!-- لید یا خلاصه خبر -->
                    @if($post->summary)
                        <div class="alert alert-light border-right border-secondary font_13 line-height-text mb-4 text-justify text-muted bg-light p-3">
                            <strong>خلاصه خبر:</strong> {{ $post->summary }}
                        </div>
                    @endif

                    <!-- متن کامل خبر -->
                    <div class="font_15 text-p line-height-text text-justify mb-5 text-dark">
                        {!! $post->body !!}
                    </div>

                    <!-- تگ‌ها / برچسب‌ها (Spatie Tags) -->
                    @if($post->tags && $post->tags->count() > 0)
                        <div class="border-top pt-3 mb-4">
                            <span class="font_13 font-weight-bold ml-2 text-muted">برچسب‌ها:</span>
                            @foreach($post->tags as $tag)
                                <a href="#" class="badge badge-light border p-2 font_12 text-secondary mb-1">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    @endif

                    <!-- دکمه‌های اشتراک‌گذاری -->
                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                        <span class="font_13 text-muted">اشتراک گذاری این مطلب:</span>
                        <div>
                            <a href="https://telegram.me/share/url?url={{ request()->url() }}&text={{ $post->title }}" target="_blank" class="btn btn-sm btn-outline-info mx-1">
                                <i class="fab fa-telegram-plane"></i> تلگرام
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ request()->url() }}&text={{ $post->title }}" target="_blank" class="btn btn-sm btn-outline-dark mx-1">
                                <i class="fab fa-twitter"></i> توییتر
                            </a>
                            <a href="whatsapp://send?text={{ request()->url() }}" target="_blank" class="btn btn-sm btn-outline-success mx-1">
                                <i class="fab fa-whatsapp"></i> واتساپ
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- سایدبار سمت چپ -->
            <div class="col-lg-4 col-12">
                <div class="sticky-top" style="top: 20px; z-index: 10;">

                    <!-- باکس آخرین اخبار سایدبار -->
                    <div class="bg-white border rounded p-3 mb-4">
                        <div class="border-bottom pb-2 mb-3 d-flex align-items-center">
                            <div class="circle-title2 ml-2" style="width: 8px; height: 8px; background: #007bff; border-radius: 50%;"></div>
                            <h4 class="h6 font-weight-bold mb-0 text-dark">آخرین اخبار مرتبط</h4>
                        </div>

                        @isset($latestPosts)
                            @foreach($latestPosts->take(5) as $latest)
                                <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                                    @if($latest->image)
                                        <img src="{{ asset($latest->image) }}" class="rounded ml-2" alt="{{ $latest->title }}" style="width: 65px; height: 65px; object-fit: cover;">
                                    @endif
                                    <div style="flex: 1;">
                                        <a href="{{ route('front.posts.show', $latest->slug) }}" class="text-decoration-none text-dark d-block font_13 line-height-text mb-1">
                                            {{ Str::limit($latest->title, 60) }}
                                        </a>
                                        <small class="text-muted font_11">
                                            <i class="fa fa-calendar-alt ml-1"></i>
                                            {{ jdate($latest->published_at)->format('%d %B') }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>

                    <!-- باکس دسته‌بندی‌ها -->
                    <div class="bg-white border rounded p-3">
                        <div class="border-bottom pb-2 mb-3 d-flex align-items-center">
                            <div class="circle-title2 ml-2" style="width: 8px; height: 8px; background: #28a745; border-radius: 50%;"></div>
                            <h4 class="h6 font-weight-bold mb-0 text-dark">دسته‌بندی‌های پیشنهادی</h4>
                        </div>
                        <ul class="list-unstyled mb-0 font_13">
                            {{-- این بخش را می‌توانی بر اساس دسته‌بندی‌های پویا لوپ کنی --}}
                            <li class="py-2 border-bottom d-flex justify-content-between align-items-center">
                                <a href="#" class="text-secondary text-decoration-none">اخبار انجمن و اپک</a>
                                <i class="fa fa-chevron-left font_10 text-muted"></i>
                            </li>
                            <li class="py-2 border-bottom d-flex justify-content-between align-items-center">
                                <a href="#" class="text-secondary text-decoration-none">اخبار اقتصادی و انرژی</a>
                                <i class="fa fa-chevron-left font_10 text-muted"></i>
                            </li>
                            <li class="py-2 d-flex justify-content-between align-items-center">
                                <a href="#" class="text-secondary text-decoration-none">گزارش‌ها و بیانیه‌ها</a>
                                <i class="fa fa-chevron-left font_10 text-muted"></i>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
