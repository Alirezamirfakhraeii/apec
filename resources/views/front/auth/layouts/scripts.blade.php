{{-- Auth Layout Scripts --}}

<script src="{{ asset('back/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('back/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var loader = document.getElementById('global-loader');

        if (loader) {
            loader.style.opacity = '0';

            setTimeout(function () {
                loader.style.display = 'none';
            }, 300);
        }
    });
</script>

@stack('scripts')
