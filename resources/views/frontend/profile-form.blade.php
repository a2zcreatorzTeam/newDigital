@extends('frontend.layout.master')
@section('content')
<!-- header-area-start -->
<link rel="stylesheet" href="{{ asset('frontend/css/sub-header.css') }}">
<style>
    /* Custom Styling for a Professional Look */
    .profile-section-title {
        font-size: 24px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 3px solid #007bff;
        display: inline-block;
    }

    .box-form-login {
        background: #ffffff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        margin-bottom: 40px;
        border: 1px solid #eef2f6;
    }

    .form-group label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #dce1e7;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .1);
    }

    .update-btn-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px inset #f1f1f1;
    }

    .btn-update {
        background-color: #007bff;
        color: white;
        padding: 10px 30px;
        border-radius: 6px;
        font-weight: 600;
        border: none;
        transition: 0.3s;
    }

    .btn-update:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        color: #fff;
    }

    .text-48-bold {
        color: #1a1a1a;
        line-height: 1.2;
    }

    .breadcrumb__area {
        padding: 100px 0;
    }
</style>
<!-- header-area-end -->

<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="{{ asset('frontend/images/breadcrumb_bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">Professional Profile</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('frontend.index')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="profile-form-area mt-80 mb-80">
        <div class="container">
            <div class="text-center mb-50">
                <h1 class="text-48-bold">Complete Your Professional Profile</h1>
                <p class="text-muted">Please ensure all details match your official documents.</p>
            </div>

            <!-- Section 1: Basic Details -->
            @include('frontend.profile.basic_detail',['user'=>$user])
            <!-- Section 2: Personal Details / Addresses -->
            @include('frontend.profile.address_info',['user'=>$user,'provinces'=>$provinces])
            <!-- Section 3: Occupation -->
            @include('frontend.profile.occupation',['user'=>$user])
            <!-- Section 4: Health Information -->
            @include('frontend.profile.health_info',['user'=>$user])


        </div>
    </section>
</main>
@endsection