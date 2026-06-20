<div class="mt-5" dir="rtl" style="text-align: right;">

    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom" style="border-width: 2px !important;">
        <div class="d-flex align-items-center">
            <span style="width: 12px; height: 12px; background: #e00000; display: inline-block; border-radius: 2px; margin-left: 10px;"></span>
            <h2 class="h5 font-weight-bold text-dark mb-0" style="letter-spacing: -0.5px;">
                نشریه نفت و توسعه
            </h2>
        </div>

        @if(isset($magazineCategory))
            <a href="{{ route('front.categories.show', $magazineCategory->slug) }}"
               class="font_12 text-decoration-none fw-bold"
               style="color: #e00000;">
                آرشیو نشریه
                <i class="fa fa-arrow-left font_9 mr-1"></i>
            </a>
        @endif
    </div>

    @if(isset($magazinePosts) && $magazinePosts->count() > 0)

        @php
            $mainMagazine = $magazinePosts->first();
        @endphp

        <div class="position-relative overflow-hidden rounded shadow-sm mb-4 border"
             style="height: 380px; background-color: #1a1a1a;">

            <img src="{{ $mainMagazine->main_image_url }}"
                 class="w-100 h-100"
                 alt="{{ $mainMagazine->title }}"
                 style="height: 380px; object-fit: cover; background-color: #f8f9fa;">

            <div class="position-absolute w-100 p-4"
                 style="bottom: 0; right: 0; background: rgba(15, 15, 15, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-top: 1px solid rgba(255,255,255,0.12); z-index: 10;">

                <div class="container-fluid px-0">
                    <span class="badge badge-danger mb-2 px-2 py-1 font_10 rounded-pill">
                        آخرین شماره
                    </span>

                    <a href="{{ route('front.posts.show', $mainMagazine->slug) }}"
                       class="text-decoration-none text-white d-block">
                        <h3 class="h5 font-weight-bold line-height-text mb-2 text-white style-hover-title"
                            style="transition: color 0.2s;">
                            {{ $mainMagazine->title }}
                        </h3>
                    </a>

                    @if($mainMagazine->summary)
                        <p class="text-white-50 font_12 line-height-text text-justify mb-0 text-truncate-2"
                           style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: #e0e0e0; opacity: 0.85;">
                            {{ $mainMagazine->summary }}
                        </p>
                    @endif
                </div>

            </div>
        </div>

        @if($magazinePosts->count() > 1)
            <div class="row">
                @foreach($magazinePosts->skip(1)->take(4) as $post)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
                        <div class="bg-white border rounded h-100 shadow-sm d-flex flex-column style-text overflow-hidden"
                             style="transition: transform 0.2s, box-shadow 0.2s;">

                            <div class="position-relative overflow-hidden w-100" style="flex-shrink: 0;">
                                <a href="{{ route('front.posts.show', $post->slug) }}" class="d-block w-100">
                                    <img src="{{ $post->main_image_url }}"
                                         class="w-100 img-fluid"
                                         alt="{{ $post->title }}"
                                         style="height: 180px; display: block; object-fit: cover;">
                                </a>
                            </div>

                            <div class="p-3 d-flex flex-column justify-content-between" style="flex: 1;">
                                <div>
                                    <a href="{{ route('front.posts.show', $post->slug) }}"
                                       class="text-decoration-none text-dark d-block mb-2">
                                        <h4 class="font_13 font-weight-bold line-height-text text-dark text-truncate-2"
                                            style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 38px;">
                                            {{ $post->title }}
                                        </h4>
                                    </a>
                                </div>

                                <div class="d-flex align-items-center justify-content-between border-top pt-2 mt-2">
                                    <span class="text-muted font_10">
                                        <i class="fa fa-calendar-alt ml-1"></i>
                                        {{ $post->published_at ? $post->published_at->format('Y-m-d') : $post->created_at->format('Y-m-d') }}
                                    </span>

                                    <span class="font_11 font-weight-bold text-danger">
                                        مطالعه مطلب
                                        <i class="fa fa-chevron-left font_8 mr-1"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    @else
        <div class="bg-white border rounded py-5 text-center text-muted font_13 shadow-sm">
            <i class="fa fa-book-open fa-2x d-block mb-2 text-light"></i>
            هنوز هیچ مطلبی در بخش نشریه نفت و توسعه ثبت نشده است.
        </div>
    @endif

</div>

<style>
    .style-hover-title:hover {
        color: #e00000 !important;
    }
</style>
