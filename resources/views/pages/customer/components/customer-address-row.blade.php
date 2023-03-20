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
