<div class="table-responsive m-b-40">
    <table class="table table-borderless table-data5 table-radius">
        <thead>
            <tr>
                <th>Province</th>
                <th>District</th>
                <th>Ward</th>
                <th>Specific address</th>
                <th>Address type</th>
                <th>Default</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customerAddresses as $customerAddress)
                <tr>
                    <td>{{ $customerAddress->city }}</td>
                    <td>{{ $customerAddress->district }}</td>
                    <td>{{ $customerAddress->ward }}</td>
                    <td>{{ $customerAddress->specific_address }}</td>
                    <td>{{ $customerAddress->address_type }}</td>
                    <td>
                        <div class="form-check">
                            <label class="form-check-label">&nbsp;</label>
                            <input class="form-check-input" type="checkbox" @checked($customerAddress->default_flag)>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
