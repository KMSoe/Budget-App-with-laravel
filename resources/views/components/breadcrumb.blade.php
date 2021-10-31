<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <ol class="breadcrumb px-2 py-3 mx-3 mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class=""><i class="fas fa-home me-2"></i>{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item {{ $isActive ? 'active' : '' }}"><a href="{{ $link }}" class=""><i class="{{ $iconClass }} me-2"></i> {{ __($currentPage) }}</a></li>
                    {{ $slot }}
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->