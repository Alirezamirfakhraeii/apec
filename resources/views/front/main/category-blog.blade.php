<div class="container my-5 home-news-services" dir="rtl">

    @if(isset($homeCategories) && $homeCategories->count() > 0)
        <div class="row">

            @foreach($homeCategories->take(3) as $category)
                <div class="col-lg-4 col-md-6 col-12 mb-4">

                    <div class="home-service-card h-100">

                        <div class="home-service-header">
                            <div class="home-service-title">
                                <span class="home-service-dot"></span>

                                <h3>
                                    {{ $category->name ?? $category->title }}
                                </h3>
                            </div>

                            <a href="{{ route('front.news.show', $category->slug) }}" class="home-service-link">
                                مشاهده همه
                                <i class="fa fa-chevron-left"></i>
                            </a>
                        </div>

                        <div class="home-service-posts">

                            @if($category->posts && $category->posts->count() > 0)

                                @foreach($category->posts->take(3) as $index => $post)

                                    @php
                                        $postImage = $post->main_image_url
                                            ?? ($post->image ? asset('storage/' . $post->image) : asset('front/images/default-news.jpg'));

                                        $postDate = $post->published_at ?? $post->created_at;
                                    @endphp

                                    @if($index === 0)
                                        <article class="home-featured-mini-post">

                                            <a href="{{ route('front.posts.show', $post->slug) }}" class="home-featured-mini-img">
                                                <img src="{{ $postImage }}" alt="{{ $post->title }}">

                                                <span>
                                                    {{ $category->name ?? $category->title }}
                                                </span>
                                            </a>

                                            <div class="home-featured-mini-body">
                                                <a href="{{ route('front.posts.show', $post->slug) }}" class="home-featured-mini-title">
                                                    {{ $post->title }}
                                                </a>

                                                <div class="home-post-date">
                                                    <i class="fa fa-calendar-alt"></i>
                                                    {{ verta($postDate)->format('Y/m/d') }}
                                                </div>
                                            </div>

                                        </article>
                                    @else
                                        <article class="home-small-post {{ $index < 2 ? 'with-border' : '' }}">

                                            <a href="{{ route('front.posts.show', $post->slug) }}" class="home-small-post-img">
                                                <img src="{{ $postImage }}" alt="{{ $post->title }}">
                                            </a>

                                            <div class="home-small-post-content">
                                                <a href="{{ route('front.posts.show', $post->slug) }}" class="home-small-post-title">
                                                    {{ $post->title }}
                                                </a>

                                                <div class="home-post-date">
                                                    <i class="fa fa-calendar-alt"></i>
                                                    {{ verta($postDate)->format('Y/m/d') }}
                                                </div>
                                            </div>

                                        </article>
                                    @endif

                                @endforeach

                            @else
                                <div class="home-service-empty">
                                    <i class="fa fa-folder-open"></i>
                                    <p>هیچ مطلبی در این دسته یافت نشد.</p>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>
            @endforeach

        </div>
    @else

        <div class="row">
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="home-service-card h-100">

                        <div class="home-service-header">
                            <div class="home-service-title">
                                <span class="home-service-dot"></span>
                                <h3>دسته‌بندی نمونه {{ $i }}</h3>
                            </div>
                        </div>

                        <div class="home-service-empty">
                            <i class="fa fa-newspaper"></i>
                            <p>مطالب نمونه بعد از ثبت خبرها نمایش داده می‌شود.</p>
                        </div>

                    </div>
                </div>
            @endfor
        </div>

    @endif

</div>
<style>
    .home-news-services {
        text-align: right;
    }

    .home-service-card {
        position: relative;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 18px;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.07);
        transition: all 0.28s ease;
    }

    .home-service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 24px 62px rgba(15, 23, 42, 0.12);
        border-color: rgba(37, 99, 235, 0.28);
    }

    .home-service-card::before {
        content: "";
        position: absolute;
        top: -70px;
        left: -70px;
        width: 165px;
        height: 165px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.10), rgba(245, 158, 11, 0.10));
        pointer-events: none;
    }

    .home-service-header {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 14px;
        margin-bottom: 16px;
        border-bottom: 1px solid #eef2f7;
    }

    .home-service-title {
        display: flex;
        align-items: center;
        min-width: 0;
    }

    .home-service-dot {
        width: 10px;
        height: 10px;
        margin-left: 8px;
        border-radius: 50%;
        background: #2563eb;
        box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.12);
        flex-shrink: 0;
    }

    .home-service-title h3 {
        margin: 0;
        color: #0f172a;
        font-size: 15px;
        font-weight: 900;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .home-service-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #2563eb;
        font-size: 11px;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
    }

    .home-service-link i {
        font-size: 9px;
        transition: 0.22s ease;
    }

    .home-service-link:hover {
        color: #1d4ed8;
        text-decoration: none;
    }

    .home-service-link:hover i {
        transform: translateX(-4px);
    }

    .home-service-posts {
        position: relative;
        z-index: 2;
    }

    .home-featured-mini-post {
        overflow: hidden;
        margin-bottom: 16px;
        border-radius: 18px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
    }

    .home-featured-mini-img {
        position: relative;
        display: block;
        height: 155px;
        overflow: hidden;
        background: #e2e8f0;
    }

    .home-featured-mini-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: 0.35s ease;
    }

    .home-featured-mini-post:hover .home-featured-mini-img img {
        transform: scale(1.06);
    }

    .home-featured-mini-img::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 45%, rgba(15, 23, 42, 0.72));
    }

    .home-featured-mini-img span {
        position: absolute;
        right: 12px;
        bottom: 12px;
        z-index: 2;
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.92);
        color: #0f172a;
        font-size: 10px;
        font-weight: 800;
    }

    .home-featured-mini-body {
        padding: 13px 14px 14px;
    }

    .home-featured-mini-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #0f172a;
        font-size: 14px;
        font-weight: 900;
        line-height: 1.8;
        text-decoration: none;
        margin-bottom: 8px;
    }

    .home-featured-mini-title:hover {
        color: #2563eb;
        text-decoration: none;
    }

    .home-small-post {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 13px;
        margin-bottom: 13px;
    }

    .home-small-post.with-border {
        border-bottom: 1px solid #eef2f7;
    }

    .home-small-post:last-child {
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .home-small-post-img {
        width: 92px;
        height: 74px;
        flex-shrink: 0;
        display: block;
        overflow: hidden;
        border-radius: 15px;
        background: #e2e8f0;
        border: 1px solid #e2e8f0;
    }

    .home-small-post-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: 0.3s ease;
    }

    .home-small-post:hover .home-small-post-img img {
        transform: scale(1.08);
    }

    .home-small-post-content {
        flex: 1;
        min-width: 0;
    }

    .home-small-post-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #0f172a;
        font-size: 12px;
        font-weight: 850;
        line-height: 1.75;
        text-decoration: none;
        margin-bottom: 7px;
    }

    .home-small-post-title:hover {
        color: #2563eb;
        text-decoration: none;
    }

    .home-post-date {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #94a3b8;
        font-size: 10px;
    }

    .home-post-date i {
        color: #2563eb;
        font-size: 10px;
    }

    .home-service-empty {
        min-height: 230px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        text-align: center;
    }

    .home-service-empty i {
        font-size: 34px;
        margin-bottom: 12px;
    }

    .home-service-empty p {
        margin: 0;
        color: #64748b;
        font-size: 12px;
    }

    @media (max-width: 575px) {
        .home-service-card {
            border-radius: 20px;
            padding: 15px;
        }

        .home-featured-mini-img {
            height: 145px;
        }

        .home-small-post-img {
            width: 86px;
            height: 68px;
        }
    }
</style>
