@extends('layouts.app')

@section('content')
@if($errors->any())
<div class="alert alert-warning">
    <ol>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ol>
</div>
@endif

<x-breadcrumb link="{{ route('categories.index') }}" is-active=0 current-page="Categories" icon-class='fas fa-th-large'>
    <li class="breadcrumb-item active"><a href="#" class=""><i class="fas fa-plus-circle me-2"></i>{{ __("Add $type Category") }}</a></li>
</x-breadcrumb>
<!-- Add Categories Section Start -->
<section class="add-categories-section row justify-content-center">
    <div class="col-sm-11 col-md-8 col-lg-7 col-xl-6 px-4">
        <h4 class="mt-2">
            <i class="fas fa-file-invoice-dollar {{ $type === 'Income' ? 'plus' : 'minus' }} me-2"></i>
            {{ __("$type Category")}}
        </h4>
        <form action="{{ route('categories.store') }}" method="post" class="my-3 py-2">
            @csrf
            <div class="icons-container d-flex flex-wrap p-2 mb-3 mx-auto">
                @foreach ($icons as $icon)
                <i class="cat-icon {{ $icon->class }} mx-2 my-2" style="background-color: <?= htmlspecialchars($icon->color) ?>" data-id="{{ $icon->id }}"></i>
                @endforeach
            </div>
            <div class="row g-0">
                <div class="col-3 input-group mb-3">
                    <span class="input-group-text" id="selected-icon"><i class="cat-icon {{ $first_icon->class }}" style="background-color: <?= htmlspecialchars($first_icon->color) ?>"></i></span>
                    <input type="hidden" id="icon-id" class="form-control" name="icon_id" value="{{ $first_icon->id }}">
                </div>
                <div class="col-9 form-floating mb-3">
                    <input type="hidden" name="type" value="{{ strtolower($type) }}">
                    <input type="text" class="form-control mb-1" id="name" name="name" placeholder="category name" autocomplete="off">
                    <small>{{ __('Maximum 15 letters') }}</small>
                    <label for="name">{{ __('Category Name') }}</label>
                </div>
            </div>
            <div class="row g-0">
                <div class="col-3"></div>
                <div class="col-9">
                    <button class="btn {{ $type === 'Income' ? 'btn-primary' : 'btn-danger' }} ms-2">{{ __('Add') }}</button>

                </div>
            </div>
        </form>
    </div>
</section>
<!-- Add Categories Section End -->
@endsection