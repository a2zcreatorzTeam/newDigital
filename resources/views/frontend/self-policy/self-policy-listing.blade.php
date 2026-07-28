@extends('frontend.layout.master')
@section('content')
<style>
    .completed-status {
        background: #28a745;
        /* Green */
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-block;
        font-weight: 600;
    }

    .rejected-status {
        background: #dc3545 !important;
        /* Red */
    }
</style>
<!-- header-area-start -->
<link rel="stylesheet" href="{{ asset('frontend/css/sub-header.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/profile.css') }}">

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
            <!-- Desktop Start -->
            <div class="row my-pol">
                <div class="col-xl-6 col-lg-8">
                    <div class="section-title mb-40 tg-heading-subheading animation-style3">
                        <h4 class="title tg-element-title" style="font-size: 25px;">Policy Listing</h4>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-8" style="text-align: -webkit-right;">
                    <a class="btn" href="{{ route('frontend.index') }}">ADD POLICY</a>
                </div>

                <table class="claim-document-table">
                    <tbody>
                        @forelse($policies as $row)
                        @php
                        $encryptedId = encrypt($row['id']);
                        @endphp

                        <tr>
                            <td> <a href="{{ route('frontend.policyDetail',$encryptedId) }}">
                                    <div class="claim-document-image">
                                        <img src="{{ asset('storage/'.$row['policyPlan']['logo']) }}" alt="svg">
                                    </div>
                                </a>
                            </td>
                            <td> <a href="{{ route('frontend.policyDetail',$encryptedId) }}">
                                    <div class="claim-document-tittle">{{ $row['policyPlan']['name'] }}</div>
                                    <div class="claim-document-small">{{ $row['policyPlan']['mainClass']['name'] }}</div>
                                </a>
                            </td>
                            <td> <a href="{{ route('frontend.policyDetail',$encryptedId) }}">
                                    <div class="claim-document-small">Policy No:</div>
                                    <div class="claim-document-num">{{ $row['policy_id'] }}</div>
                                </a>
                            </td>
                            <td> <a href="{{ route('frontend.policyDetail',$encryptedId) }}">
                                    <div class="claim-document-small">Policy Date.</div>
                                    <div class="claim-document-num">{{ $row['created_at'] }}</div>
                                </a>
                            </td>
                            <td> <a href="{{ route('frontend.policyDetail',$encryptedId) }}">
                                    <div class="claim-document-small">Status</div>
                                    <div class="completed-status {{ $row['status'] == 'Rejected' ? 'rejected-status' : '' }}">
                                        {{ $row['status'] }}
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('frontend.policyDetail', $encryptedId) }}" class="badge bg-success text-decoration-none" style="color:white;">
                                        Show
                                    </a>

                                    <a href="{{ route('frontend.policyDetail.edit', $encryptedId) }}" class="badge bg-danger text-decoration-none" style="color:white;">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="text-center p-4">
                                    <img src="{{ asset('images/no-data.svg') }}" width="120" alt="No Data">
                                    <p class="mt-2 mb-0">No policies found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Desktop End -->

        </div>
    </section>
    <!-- main-area-end -->
</main>


@endsection