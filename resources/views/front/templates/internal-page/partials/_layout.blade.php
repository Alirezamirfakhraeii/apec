{{-- Main content + sidebar layout --}}
<section class="komyte-main-section">
    <div class="container">
        <div class="komyte-layout">
            <div class="komyte-main-column">
                @include('front.templates.internal-page.partials._content-card')
            </div>

            @include('front.templates.internal-page.partials._sidebar')
        </div>
    </div>
</section>
