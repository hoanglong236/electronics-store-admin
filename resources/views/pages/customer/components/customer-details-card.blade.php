<div class="card">
    <div class="card-header card-header-flex--space-center">
        <div class="card-title--medium">ID:&nbsp; {{ $customer->id }}</div>
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
                <div class="text-truncate">Status:&nbsp; {{ $customer->disable_flag ? 'Disabled' : 'Enable' }}</div>
            </div>
        </div>
    </div>
</div>
