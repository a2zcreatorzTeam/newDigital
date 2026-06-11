<input type="hidden" name="premium_paid" value="{{$premium_paid}}">

<table class="table table-striped">
    <tbody>
        <tr>
            <th>Policy Name:</th>
            <td> {{ $policy_data->product->name }} ({{ $policy_data->product->table_no }})</td>
        </tr>
        <tr>
            <th>Term of Assurance:</th>
            <td>
                {{ $term }}
            </td>
        </tr>
        <tr>
            <th>Age:</th>
            <td>{{ $age }}</td>
        </tr>
        <tr>
            <th>Gender:</th>
            <td>{{ $gender }}</td>
        </tr>
        <tr>
            <th>Sum Assured:</th>
            <td>Rs. {{ number_format($sum_assured) }}/-</td>
        </tr>
        <tr>
            <th>Payment Mode:</th>
            <td>{{ $payment_mode }}</td>
        </tr>
        <tr>
            <th>Premium to be paid:</th>
            <td><strong>Rs. {{ number_format($premium_paid) }}/-</strong></td>
        </tr>
    </tbody>
</table>