@extends('frontend.layout.master')
@section('content')
<style>
    /* ================= Policy Listing - Professional Styling ================= */

    .policy-listing-wrapper {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
        padding: 30px;
        margin-bottom: 40px;
    }

    .policy-listing-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eef0f3;
    }

    .policy-listing-header h4 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
        position: relative;
        padding-left: 14px;
    }

    .policy-listing-header h4::before {
        content: "";
        position: absolute;
        left: 0;
        top: 3px;
        height: 22px;
        width: 4px;
        border-radius: 4px;
        background: linear-gradient(180deg, #ff6a00, #ff9a3d);
    }

    .btn-add-policy {
        background: linear-gradient(135deg, #ff6a00, #ff8c3d);
        color: #fff !important;
        font-weight: 600;
        font-size: 14px;
        padding: 11px 26px;
        border-radius: 30px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 6px 15px rgba(255, 106, 0, 0.3);
        transition: all 0.25s ease;
        border: none;
    }

    .btn-add-policy:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255, 106, 0, 0.4);
        color: #fff;
    }

    /* Table container */
    .table-responsive-custom {
        overflow-x: auto;
    }

    table#policyTable.claim-document-table {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    table#policyTable thead th {
        background: #1a1a2e;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border: none;
        white-space: nowrap;
    }

    table#policyTable thead th:first-child {
        border-radius: 10px 0 0 10px;
    }

    table#policyTable thead th:last-child {
        border-radius: 0 10px 10px 0;
    }

    table#policyTable tbody tr {
        background: #fafbfc;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    table#policyTable tbody tr:hover {
        background: #fff5ec;
        box-shadow: 0 6px 18px rgba(255, 106, 0, 0.12);
        transform: translateY(-1px);
    }

    table#policyTable tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border: none;
        border-top: 1px solid #f0f1f4;
        border-bottom: 1px solid #f0f1f4;
    }

    table#policyTable tbody td:first-child {
        border-left: 1px solid #f0f1f4;
        border-radius: 10px 0 0 10px;
    }

    table#policyTable tbody td:last-child {
        border-right: 1px solid #f0f1f4;
        border-radius: 0 10px 10px 0;
    }

    table#policyTable tbody td a {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .claim-document-image {
        width: 55px;
        height: 55px;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .claim-document-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 5px;
    }

    .claim-document-tittle {
        font-size: 15px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 3px;
    }

    .claim-document-small {
        font-size: 12px;
        color: #8a8f98;
        font-weight: 500;
        margin-bottom: 2px;
    }

    .claim-document-num {
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    /* Status badges */
    .completed-status {
        background: rgba(40, 167, 69, 0.12);
        color: #1e8e3e;
        padding: 6px 14px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 700;
        font-size: 12.5px;
    }

    .completed-status::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #1e8e3e;
    }

    .completed-status.rejected-status {
        background: rgba(220, 53, 69, 0.12) !important;
        color: #dc3545 !important;
    }

    .completed-status.rejected-status::before {
        background: #dc3545;
    }

    /* Action buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 20px;
        text-decoration: none !important;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .action-btn-show {
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd !important;
    }

    .action-btn-show:hover {
        background: #0d6efd;
        color: #fff !important;
    }

    .action-btn-edit {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545 !important;
    }

    .action-btn-edit:hover {
        background: #dc3545;
        color: #fff !important;
    }

    /* Empty state */
    .empty-policy-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-policy-state i {
        font-size: 50px;
        color: #dcdfe4;
        margin-bottom: 15px;
        display: block;
    }

    .empty-policy-state p {
        font-size: 15px;
        color: #8a8f98;
        font-weight: 500;
        margin: 0;
    }

    /* DataTables overrides */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 20px;
        border: 1px solid #e2e5eb;
        padding: 7px 16px;
        margin-left: 8px;
        outline: none;
    }

    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        border: 1px solid #e2e5eb;
        padding: 5px 10px;
        margin: 0 6px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        margin: 0 3px;
        padding: 6px 13px !important;
        border: 1px solid #e2e5eb !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #ff6a00 !important;
        border-color: #ff6a00 !important;
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #ff6a00 !important;
        border-color: #ff6a00 !important;
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_info {
        color: #8a8f98;
        font-size: 13px;
        padding-top: 15px;
    }

    @media (max-width: 767px) {
        .policy-listing-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-add-policy {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- header-area-start -->
<link rel="stylesheet" href="{{ asset('frontend/css/sub-header.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/profile.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- header-area-end -->

<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="{{ asset('Frontend/images/breadcrumb_bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">Self-Policy Listing</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('frontend.index')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Self-Policy</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb__shape">
            <img src="images/breadcrumb_shape01.png" alt="">
            <img src="images/breadcrumb_shape02.png" alt="" class="rightToLeft">
            <img src="images/breadcrumb_shape03.png" alt="">
            <img src="images/breadcrumb_shape04.png" alt="">
            <img src="images/breadcrumb_shape05.png" alt="" class="alltuchtopdown">
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- main-area -->
    <section id="scroll" class="services-area services-bg desktop-devices" data-background="images/services_bg.jpg">
        <div class="container">
            <div class="policy-listing-wrapper">

                <div class="policy-listing-header">
                    <h4>Policy Listing</h4>
                    <a class="btn-add-policy" href="{{ route('frontend.index') }}">
                        <i class="fa fa-plus"></i> Add Policy
                    </a>
                </div>

                <div class="table-responsive-custom">
                    <table id="policyTable" class="claim-document-table">
                        <thead>
                            <tr>
                                <th>{{ policy_label('plan_name') }}</th>
                                <th>{{ policy_label('policy_number') }}</th>
                                <th>{{ policy_label('policy_date') }}</th>
                                <th>{{ policy_label('status') }}</th>
                                <th>{{ policy_label('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($policies as $row)
                            @php
                            $encryptedId = encrypt($row['id']);
                            $planName = data_get($row, 'policyPlan.name')
                                ?? (is_numeric($row['plan'] ?? null) ? null : ($row['plan'] ?? null))
                                ?? 'N/A';
                            $mainClassName = data_get($row, 'policyPlan.mainClass.name') ?? '';
                            @endphp

                            <tr>

                                <td>
                                    <a href="{{ route('frontend.policyDetail',$encryptedId) }}">
                                        <div class="claim-document-tittle">{{ $planName }}</div>
                                        @if($mainClassName !== '')
                                        <div class="claim-document-small">{{ $mainClassName }}</div>
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('frontend.policyDetail',$encryptedId) }}">
                                        <div class="claim-document-small">{{ policy_label('policy_number') }}</div>
                                        <div class="claim-document-num">{{ $row['policy_id'] }}</div>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('frontend.policyDetail',$encryptedId) }}">
                                        <div class="claim-document-small">{{ policy_label('policy_date') }}</div>
                                        <div class="claim-document-num">{{ $row['created_at'] }}</div>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('frontend.policyDetail',$encryptedId) }}">
                                        <div class="completed-status {{ $row['status'] == 'Rejected' ? 'rejected-status' : '' }}">
                                            {{ $row['status'] }}
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('frontend.policyDetail', $encryptedId) }}" class="action-btn action-btn-show">
                                            <i class="fa fa-eye"></i> Show
                                        </a>
                                        @if($row['status'] == 'Rejected')
                                        <a href="{{ route('frontend.policyDetail.edit', $encryptedId) }}" class="action-btn action-btn-edit">
                                            <i class="fa fa-pen"></i> Edit
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-policy-state">
                                        <i class="fa fa-file-circle-xmark"></i>
                                        <p>No policies found.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
    <!-- main-area-end -->
</main>

@push('js')
<!-- jQuery (agar layout mein already included hai to ye line hata dein) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#policyTable').DataTable({
            "order": [],
            "language": {
                "search": "",
                "searchPlaceholder": "Search policy...",
                "emptyTable": "No policies found."
            },
            "columnDefs": [
                { "orderable": false, "targets": [0, 4] }
            ]
        });
    });
</script>
@endpush

@endsection
