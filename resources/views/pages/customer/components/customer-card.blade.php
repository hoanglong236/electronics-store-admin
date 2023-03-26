<div class="card">
    <div class="card-header card-header-flex--space-center">
        <div class="card-title--medium">ID:&nbsp; {{ $customer->id }}</div>
        @include('shared.components.buttons.detail-icon-button', [
            'detailUrl' => route('manage.customer.details', [$customer->id]),
        ])
    </div>
    <div class="card-body">
        <div class="mx-auto d-block">
            <img class="rounded-circle-avatar" src="{{ asset('assets/images/icon/customer-avatar.png') }}"
                alt="Customer avatar">
            <h5 class="text-sm-center mt-2 mb-3">{{ $customer->name }}</h5>
            <hr>
            <div class="card-text mt-2">
                <div class="text-truncate">Gender:&nbsp; {{ $customer->gender ? 'Male' : 'Female' }}</div>
                <div class="text-truncate">Phone:&nbsp; {{ $customer->phone }}</div>
                <div class="text-truncate">Email:&nbsp; {{ $customer->email }}</div>
                <div class="mt-1">
                    <form action="{{ route('manage.customer.update-disable-flag', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <span>Action:&nbsp; </span>
                        @if ($customer->disable_flag)
                            <button name="disableFlag" value="false" type="submit"
                                class="btn btn-enable">Enable</button>
                        @else
                            <button name="disableFlag" value="true" type="submit"
                                class="btn btn-disable">Disable</button>
                        @endif
                        @error('disableFlag')
                            @if (intval(Session::get('customerId')) === $customer->id)
                                <div class="alert alert-danger mt-1 text--small" role="alert">{{ $message }}
                                </div>
                            @endif
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="card-action-wrapper">
            <div class="card-action-item">
                @include('shared.components.buttons.delete-button', [
                    'deleteUrl' => route('manage.customer.delete', [$customer->id]),
                ])
            </div>
        </div>
    </div>
</div>
