<div class="container my-5" dir="rtl" style="text-align: right;">
    <div class="row">

        @if(isset($homeCategories) && $homeCategories->count() > 0)
            @foreach($homeCategories->take(3) as $category)
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="bg-white p-3 border rounded shadow-sm h-100">

                        <div class="border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="circle-title2 ml-2"
                                     style="width: 8px; height: 8px; background: #007bff; border-radius: 50%;">
                                </div>

                                <h3 class="h6 font-weight-bold text-dark mb-0">
                                    {{ $category->name }}
                                </h3>
                            </div>

                            <a href="#" class="font_11 text-primary text-decoration-none">
                                مشاهده همه
                                <i class="fa fa-chevron-left font_9"></i>
                            </a>
                        </div>

                        <div class="category-posts-horizontal-list">
                            @if($category->posts && $category->posts->count() > 0)
                                @foreach($category->posts->take(3) as $index => $post)

                                    <div class="d-flex align-items-center mb-3 pb-3 {{ $index < 2 ? 'border-bottom' : '' }}">

                                        <div class="news-thumb-right ml-3" style="flex-shrink: 0;">
                                            <a href="{{ route('front.posts.show', $post->slug) }}" class="d-block">
                                                <img src="{{ $post->main_image_url }}"
                                                     class="rounded border"
                                                     alt="{{ $post->title }}"
                                                     style="width: 85px; height: 70px; object-fit: cover;">
                                            </a>
                                        </div>

                                        <div class="news-content-left" style="flex: 1; min-width: 0;">
                                            <a href="{{ route('front.posts.show', $post->slug) }}"
                                               class="text-decoration-none text-dark d-block font_12 font-weight-bold line-height-text mb-1 text-truncate-2"
                                               style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $post->title }}
                                            </a>

                                            <div class="text-muted font_10 mt-1">
                                                <i class="fa fa-calendar-alt ml-1"></i>
                                                {{ $post->published_at ? $post->published_at->format('Y-m-d') : $post->created_at->format('Y-m-d') }}
                                            </div>
                                        </div>

                                    </div>

                                @endforeach
                            @else
                                <p class="text-muted font_12 text-center my-5">
                                    هیچ مطلبی در این دسته یافت نشد.
                                </p>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        @else
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="bg-white p-3 border rounded shadow-sm">
                        <div class="border-bottom pb-2 mb-3">
                            <span class="font_13 font-weight-bold text-dark">
                                دسته بندی نمونه {{ $i }}
                            </span>
                        </div>

                        @for ($j = 1; $j <= 3; $j++)
                            <div class="d-flex align-items-center mb-2 pb-2 {{ $j < 3 ? 'border-bottom' : '' }}">
                                <div class="bg-light rounded ml-3 border"
                                     style="width: 85px; height: 70px; flex-shrink: 0;">
                                </div>

                                <div style="flex: 1;">
                                    <span class="font_12 text-secondary d-block line-height-text mb-1">
                                        تیتر خبر نمونه در این ردیف قرار می‌گیرد...
                                    </span>
                                    <small class="text-muted font_10">
                                        ۱۴۰۵-۰۳-۱۰
                                    </small>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            @endfor
        @endif

    </div>
</div>
