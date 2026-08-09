{{-- Footer --}}
<div class="modal-footer company-modal-footer">
    <div class="company-modal-footer-actions">
        @if($websiteUrl)
            <a href="{{ $websiteUrl }}"
               target="_blank"
               rel="noopener noreferrer"
               class="btn company-website-btn">
                <i class="fa fa-globe"></i>
                مشاهده وب‌سایت
            </a>
        @endif

        @if($catalogUrl)
            <a href="{{ $catalogUrl }}"
               target="_blank"
               rel="noopener noreferrer"
               class="btn company-catalog-btn">
                <i class="fa fa-file-pdf"></i>
                کاتالوگ شرکت
            </a>
        @endif
    </div>

    <button type="button"
            class="btn company-modal-close-btn"
            data-bs-dismiss="modal">
        بستن
    </button>
</div>
