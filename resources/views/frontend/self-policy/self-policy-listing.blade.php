@extends('frontend.layout.master')
@section('content')

<!-- header-area-start -->
<link rel="stylesheet" href="{{ asset('frontend/css/sub-header.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/profile.css') }}">

<!-- header-area-end -->

<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="images/breadcrumb_bg.jpg">
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
                     <a class="btn" href="{{ route('frontend.product') }}">ADD POLICY</a>
                </div>
                
                <table class="claim-document-table">
                    <tbody>
                        @forelse($policies as $row)
                        <tr>
                            <td> <a href="{{ route('frontend.policyDetail',$row['id']) }}">
                                    <div class="claim-document-image">
                                        <img src="{{ asset('storage/'.$row['policyPlan']['logo']) }}" alt="svg">
                                    </div>
                                </a>
                            </td>
                            <td> <a href="{{ route('frontend.policyDetail',$row['id']) }}">
                                    <div class="claim-document-tittle">{{ $row['policyPlan']['name'] }}</div>
                                    <div class="claim-document-small">{{ $row['policyPlan']['mainClass']['name'] }}</div>
                                </a>
                            </td>
                            <td> <a href="{{ route('frontend.policyDetail',$row['id']) }}">
                                    <div class="claim-document-small">Policy No:</div>
                                    <div class="claim-document-num">{{ $row['policy_id'] }}</div>
                                </a>
                            </td>
                            <td> <a href="{{ route('frontend.policyDetail',$row['id']) }}">
                                    <div class="claim-document-small">Policy Date.</div>
                                    <div class="claim-document-num">{{ $row['created_at'] }}</div>
                                </a>
                            </td>
                            <td> <a href="{{ route('frontend.policyDetail',$row['id']) }}">
                                    <div class="claim-document-small">Status</div>
                                    <div class="completed-status">{{ $row['status'] }} </div>
                                </a>
                            </td>
                            <td>
                                <div class="link-arrow">
                                    <a href="{{ route('frontend.policyDetail',$row['id']) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                        </svg>
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
                {{ $policies->links('pagination::bootstrap-4') }}
            </div>
            <!-- Desktop End -->

        </div>
    </section>
    <!-- main-area-end -->
</main>


@endsection