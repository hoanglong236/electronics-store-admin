<div class="table-data7-wrapper">
    <table class="table table-data7">
        <thead>
            <tr>
                <th>#</th>
                <th colspan="2">Customer Info</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>ID</td>
                <td>{{ $customer->id }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Name</td>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Phone</td>
                <td>{{ $customer->phone }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Email</td>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Status</td>
                <td>
                    @if ($customer->disable_flag)
                        <span class="disable-status">Disable</span>
                    @else
                        <span class="enable-status">Enable</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>6</td>
                <td>Created at</td>
                <td>
                    {{ $customer->created_at }}
                </td>
            </tr>
            <tr>
                <td>7</td>
                <td>Updated at</td>
                <td>
                    {{ $customer->updated_at }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
