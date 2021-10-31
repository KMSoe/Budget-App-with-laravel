    <!-- Change Budget Unit modal -->
    <div class="modal text-white" id="unit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="ps-3 py-3">
                    <h5 class="modal-title text-center">{{ __('Unit')}}</h5>
                </div>
                <div class="modal-body position-relative">
                    @include('partials/loading-spinner')
                    <ul>
                        @foreach($units as $key => $value)
                        @if($loop->last)
                        <li class="bg-main d-flex text-white px-2 py-3 hover">
                            @else
                        <li class="bg-main d-flex text-white px-2 py-3 border-bottom border-secondary hover">
                            @endif
                            <label for="{{ $value }}" class="flex-fill my-auto pointer">{{ __($key) }}</label>
                            @if($current_unit === $value)
                            <input type="radio" name="unit" value="{{ $value }}" id="{{ $value }}" class="my-auto" checked>
                            @else
                            <input type="radio" name="unit" value="{{ $value }}" id="{{ $value }}" class="my-auto">
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="pt-2 pb-3 text-center">
                    <button class="btn btn-secondary text-light" data-bs-dismiss="modal">
                        {{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>