<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Policy PDF</title>

    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color:#333;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        .section-title{
            background:#0d47a1;
            color:#fff;
            padding:8px;
            margin-top:20px;
            font-size:14px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }

        table td{
            border:1px solid #ddd;
            padding:8px;
            vertical-align:top;
        }

        .label{
            font-weight:bold;
            width:35%;
            background:#f5f5f5;
        }
    </style>
</head>

<body>

    <h2>Policy Detail</h2>

    <div class="section-title">Personal Information</div>

    <table>
        <tr>
            <td class="label">Policy Number</td>
            <td>{{ $data->policy_id ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Full Name</td>
            <td>{{ $data->life_proposed_full_name ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Mobile Number</td>
            <td>{{ $data->mobile_number ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">CNIC</td>
            <td>{{ $data->cnic_number ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Email</td>
            <td>{{ $data->user_email ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Date Of Birth</td>
            <td>{{ $data->date_of_birth ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Gender</td>
            <td>{{ $data->gender ?? '---' }}</td>
        </tr>
    </table>

    <div class="section-title">Policy Information</div>

    <table>

        <tr>
            <td class="label">Plan Name</td>
            <td>{{ $data->product->name ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Term</td>
            <td>{{ $data->term ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Payment Mode</td>
            <td>{{ $data->payment_mode ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Sum Assured</td>
            <td>{{ $data->sum_assured ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Status</td>
            <td>{{ $data->status ?? '---' }}</td>
        </tr>

    </table>

    <div class="section-title">Address Information</div>

    <table>

        <tr>
            <td class="label">Permanent Address</td>
            <td>{{ $data->permanent_address ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Correspondence Address</td>
            <td>{{ $data->corres_address ?? '---' }}</td>
        </tr>

        <tr>
            <td class="label">Temporary Address</td>
            <td>{{ $data->temp_address ?? '---' }}</td>
        </tr>

    </table>

</body>
</html>