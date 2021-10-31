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

<x-breadcrumb link="{{ route('icons.index') }}" is-active=0 current-page='Icons' icon-class='fas fa-icons'>
    <li class="breadcrumb-item active"><a href="#" class=""><i class="fas fa-plus-circle me-2"></i>{{ __('Add Icon') }}</a></li>
</x-breadcrumb>
<!-- Add Icon Section Start -->
<section class="add-budget-section row justify-content-center pt-1 pb-4">
    <div class="col-md-10 px-4">
        <h4 class="text-center mb-4">
            <i class="fas fa-icons me-2"></i>
            {{ __('Add Icon') }}
        </h4>

        <div class="card bg-main col-md-8 col-xl-6 mx-auto">
            <div class="card-body">
                <form method="POST" action="{{ route('icons.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="class">{{ __('Icon Class') }}</label>
                        <input type="text" class="form-control" id="class" name="class" autocomplete="off">

                    </div>

                    <div class="form-group">
                        <label for="color" class="">{{ __('Icon Color') }}</label>
                        <input type="color" class="form-control" id="color" name="color" autocomplete="off">

                    </div>
                    <button type="submit" id="btnsubmit" class="btn rounded mt-3 btn-primary">{{ __('Add') }}</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Add Icon Section End -->

@endsection