<!-- Choose Income or Expense modal -->
<div class="modal" id="choose">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="py-3 ps-3">
                <h5 class="modal-title text-white text-center">
                    {{ __('Choose') }}
                </h5>
            </div>
            <div class="modal-body">
                <a href="{{ route('budgets.create') }}?type=income" class="hover me-3">
                    <i class="income fas fa-dollar-sign mb-1 plus"></i>
                    <p>{{ __('Income') }}</p>
                </a>
                <a href="{{ route('budgets.create') }}?type=expense" class="hover ms-3">
                    <i class="expense fas fa-file-invoice-dollar mb-1 minus"></i>
                    <p>{{ __('Expense') }}</p>
                </a>
            </div>
            <div class="pt-2 pb-3 text-center">
                <button class="btn btn-secondary text-light" data-bs-dismiss="modal">
                {{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>