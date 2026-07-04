{{-- Hero / Breadcrumb section --}}
<section class="komyte-top-hero">
    <div class="komyte-hero-overlay"></div>

    <div class="container">
        <div class="komyte-breadcrumb">
            <a href="{{ url('/') }}">خانه</a>

            @foreach($segments as $segment)
                <span>/</span>
                <span>{{ str_replace('-', ' ', $segment) }}</span>
            @endforeach
        </div>

        <div class="komyte-hero-content">
            <span class="komyte-page-label">
                <i class="fa fa-layer-group ml-1"></i>
                صفحه سازمانی
            </span>

            <h1>{{ $pageTitle }}</h1>

            @if($pageSummary)
                <p>{{ $pageSummary }}</p>
            @endif
        </div>
    </div>
</section>
