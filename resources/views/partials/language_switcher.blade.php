    <!-- Change Language modal -->
    <div class="modal text-white" id="language-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="ps-3 py-3">
                    <h5 class="modal-title text-center">{{ __('Languages')}}</h5>
                </div>
                <div class="modal-body position-relative">
                    @include('partials/loading-spinner')
                    <ul>
                        @foreach($locales as $key => $value)
                        @if($loop->last)
                        <li class="bg-main d-flex text-white px-2 py-3 hover">

                            @else
                        <li class="bg-main d-flex text-white px-2 py-3 border-bottom border-secondary hover">
                            @endif
                            <img src='{{ asset("storage/flags/" . $value . ".svg") }}' alt="{{ $key }}" class="me-3 pointer" style="width: 30px;">
                            <label for="{{ $value }}" class="flex-fill my-auto pointer">{{ __($key) }}</label>
                            @if($current_locale === $value)
                            <input type="radio" name="language" value="{{ $value }}" id="{{ $value }}" class="my-auto" checked>
                            @else
                            <input type="radio" name="language" value="{{ $value }}" id="{{ $value }}" class="my-auto">
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