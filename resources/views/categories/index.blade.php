@extends('layouts.app')

@section('content')
@if(session('info'))
<div class="alert alert-info">
    {{ session('info') }}
</div>
@endif
<x-breadcrumb link="{{ route('categories.index') }}" is-active=1 current-page='Categories' icon-class='fas fa-th-large' >
</x-breadcrumb>

<!-- Categories Section Start -->
<section class="categories-section justify-content-center py-4">
    <h3 class="text-center">{{ __('Categories') }}</h3>
    <div class="col-md-9 col-lg-12 px-3 px-lg-5">
        <div class="swip-nav d-lg-none d-flex justify-content-center my-3">
            <a class="income-nav active btn select-btn text-white me-3 py-1 px-3">
                <i class="fas fa-check me-2"></i>{{ __('Income') }}
            </a>
            <a class="expense-nav btn select-btn text-white me-3 py-1 px-3">
                <i class="fas fa-check me-2"></i>{{ __('Expense') }}
            </a>
        </div>
        <div class="row mt-5">
            <div class="col-lg-6 income-categories-container">
                <h5 class="mb-3 ps-5">{{ __('Income Categories') }}</h5>
                <ul class="income-categories pe-4">
                    @forelse ($income_categories as $cat)
                    <li class="d-flex py-2">
                        <i class="cat-icon {{ $cat['class'] }} me-3 my-auto" style="background-color: <?= htmlspecialchars($cat['color']) ?>;"></i>
                        <span class="flex-fill my-auto pe-4 pe-lg-0 text-center">{{ __($cat['name']) }}</span>

                        @self($cat)
                        <form action="{{ route('categories.destroy') }}" method="POST" class="mt-2" style="box-sizing: border-box;">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $cat['id'] }}">
                            <button type="submit" class="text-white my-auto" style="outline: none;border: none;background-color: unset;" type="submit"><i class="fas fa-times-circle"></i></button>
                        </form>
                        @endself
                    </li>
                    @empty
                    <p class="text-center text-muted mt-5">{{ __('No category') }}</p>
                    @endforelse
                </ul>
                <a href="{{ route('categories.create') }}?type=income" class="my-3 ms-4 btn bg-active text-white">
                    <i class="fas fa-plus"></i>
                    <span class="">{{ __('Add Income Category') }}</span>
                </a>
            </div>
            <div class="col-lg-6 expense-categories-container">
                <h5 class="mb-3 ps-5">{{ __('Expense Categories') }}</h5>
                <ul class="expense-categories pe-4">
                    @forelse ($expense_categories as $cat)
                    <li class="d-flex py-2">
                        <i class="cat-icon {{ $cat['class'] }} me-3 my-auto" style="background-color: <?= htmlspecialchars($cat['color']) ?>;"></i>
                        <span class="flex-fill my-auto pe-4 pe-lg-0 text-center">{{ __($cat['name']) }}</span>

                      @self($cat)
                        <form action="{{ route('categories.destroy') }}" method="POST" class="mt-2" style="box-sizing: border-box;">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $cat['id'] }}">
                            <button type="submit" class="text-white my-auto" style="outline: none;border: none;background-color: unset;" type="submit"><i class="fas fa-times-circle"></i></button>
                        </form>
                       @endself
                    </li>
                    @empty
                    <p class="text-center text-muted mt-5">{{ __('No category') }}</p>
                    @endforelse

                </ul>

                <a href="{{ route('categories.create') }}?type=expense" class="my-3 ms-4 btn btn-danger">
                    <i class="fas fa-plus"></i>
                    <span class="">{{ __('Add Expense Category') }}</span>
                </a>

            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->
@endsection