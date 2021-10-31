@extends('layouts.app')

@section('content')
@if(session('info'))
<div class="alert alert-info">
    {{ session('info') }}
</div>
@endif
<x-breadcrumb link="{{ route('icons.index') }}" is-active=1 current-page='Icons' icon-class='fas fa-icons' >
</x-breadcrumb>

<!-- Icons Section Start -->
<section class="categories-section row justify-content-center py-4">
    <div class="col-md-9 col-lg-12 px-3 px-lg-5">
        <h3 class="">
            {{ __('Icons') }}
            <a href="{{ route('icons.create') }}" class="float-end ms-4 btn bg-active text-white">
                <i class="fas fa-plus"></i>
                <span class="">{{ __('Add Icon') }}</span>
            </a>
        </h3>
        <div class="d-flex flex-wrap p-2 my-3">
            @forelse ($icons as $icon)
            <span class="d-flex flex-column align-items-center mb-3 mx-2 border border-secondary px-2">
                <i class="cat-icon {{ $icon->class }} mx-2 my-2" style="background-color: <?= htmlspecialchars($icon->color) ?>" data-id="{{ $icon->id }}"></i>
                <div class="d-flex">
                    <a href="{{ route('icons.edit', [ 'id' => $icon->id]) }}"><i class="fas fa-edit text-white"></i></a>
                </div>
            </span>
            @empty
            <p class="text-center text-muted mt-5 w-100">No Icon</p>
            @endforelse
        </div>
    </div>
</section>
<!-- Icons Section End -->
@endsection