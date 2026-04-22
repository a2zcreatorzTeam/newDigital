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
                        <h2 class="title">My Profile</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('frontend.index')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">My Profile</li>
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
    <section id="scroll" class="services-area services-bg" data-background="{{ asset('frontend/images/services_bg.jpg') }}">
        <div class="container">
            <div class="row my-pol">
                <div class="col-md-3">
                    <div class="profile-img">
                        <img src="images/user-img.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="section-title mt-3 tg-heading-subheading animation-style3">
                        <h4 class="title tg-element-title" style="font-size: 25px;">{{ ucfirst(Auth::user()->name) }}</h4>
                    </div>
                    <div class="claim-document-small">Email:</div>
                    <div class="claim-document-num">{{ Auth::user()->email }}</div>
                    
                    <div class="claim-document-small">Phone No:</div>
                    <div class="claim-document-num">{{ Auth::user()->phone_no }}</div>
    
                </div>
                <div class="col-md-2 text-end">
                    <div class="profile-edit-btn">
                        <a href="edit-profile.php" class="btn">Edit Profile</a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- main-area-end -->
</main>


@endsection