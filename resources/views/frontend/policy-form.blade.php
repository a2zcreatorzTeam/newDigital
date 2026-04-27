@extends('frontend.layout.master')
@section('content')
<style>
    .accordion-button {
        font-weight: 600;
        font-size: 16px;
    }

    .accordion-item {
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .accordion-body {
        background: #f9f9f9;
    }

    .accordion-body h5 {
        font-weight: 600;
        border-left: 4px solid #007bff;
        padding-left: 10px;
    }

    .form-control {
        border-radius: 8px;
    }
</style>
<link rel="stylesheet" href="{{ asset('frontend/css/sub-header.css') }}">
<!-- main-area -->
<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="{{ asset('frontend/images/breadcrumb_bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">Policy Form</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contact</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb__shape">
            <img src="{{ asset('Frontend/images/breadcrumb_shape01.png')}}" alt="">
            <img src="{{ asset('Frontend/images/breadcrumb_shape02.png')}}" alt="" class="rightToLeft">
            <img src="{{ asset('Frontend/images/breadcrumb_shape03.png')}}" alt="">
            <img src="{{ asset('Frontend/images/breadcrumb_shape04.png')}}" alt="">
            <img src="{{ asset('Frontend/images/breadcrumb_shape05.png')}}" alt="" class="alltuchtopdown">
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <!-- contact-area -->
    <section class="contact__area">
        <div class="container">

            <h2 class="title mb-4 text-center">Digital Proposal Form</h2>

            <form method="POST">
                @csrf

                <div class="accordion" id="proposalAccordion">

                    <!-- 1. BASIC INFO -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#basicInfo">
                                1. Basic Information
                            </button>
                        </h2>

                        <div id="basicInfo" class="accordion-collapse collapse show">
                            <div class="accordion-body">

                                <!-- ADDRESS SECTION -->
                                <h5 class="mb-3">Address Information</h5>

                                <div class="row">
                                    <!-- Permanent Address -->
                                    <div class="col-md-4">
                                        <h6>Permanent Address</h6>

                                        <select name="perm_province" class="form-control mb-2">
                                            <option>Select Province</option>
                                        </select>

                                        <select name="perm_district" class="form-control mb-2">
                                            <option>Select District</option>
                                        </select>

                                        <select name="perm_city" class="form-control mb-2">
                                            <option>Select City</option>
                                        </select>

                                        <textarea name="perm_address" class="form-control" placeholder="Address"></textarea>
                                    </div>

                                    <!-- Correspondence Address -->
                                    <div class="col-md-4">
                                        <h6>Correspondence Address</h6>

                                        <select name="cor_province" class="form-control mb-2">
                                            <option>Select Province</option>
                                        </select>

                                        <select name="cor_district" class="form-control mb-2">
                                            <option>Select District</option>
                                        </select>

                                        <select name="cor_city" class="form-control mb-2">
                                            <option>Select City</option>
                                        </select>

                                        <textarea name="cor_address" class="form-control" placeholder="Address"></textarea>
                                    </div>

                                    <!-- Temporary Address -->
                                    <div class="col-md-4">
                                        <h6>Temporary Address</h6>

                                        <select name="temp_province" class="form-control mb-2">
                                            <option>Select Province</option>
                                        </select>

                                        <select name="temp_district" class="form-control mb-2">
                                            <option>Select District</option>
                                        </select>

                                        <select name="temp_city" class="form-control mb-2">
                                            <option>Select City</option>
                                        </select>

                                        <textarea name="temp_address" class="form-control" placeholder="Address"></textarea>
                                    </div>
                                </div>

                                <hr>

                                <!-- PERSONAL INFO -->
                                <h5 class="mb-3">Personal Information</h5>

                                <div class="row">

                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="name" class="form-control" placeholder="Full Name">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="cnic" class="form-control" placeholder="CNIC">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="passport" class="form-control" placeholder="Passport No">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>DOB</label>
                                        <input type="date" name="dob" class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="number" name="age" class="form-control" placeholder="Age">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <select name="gender" class="form-control">
                                            <option>Select Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="father_name" class="form-control" placeholder="Father Name">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="mother_name" class="form-control" placeholder="Mother Name">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="birth_place" class="form-control" placeholder="Birth Place">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="religion" class="form-control" placeholder="Religion">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <select name="dual_nationality" class="form-control">
                                            <option>Dual Nationality?</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="primary_nationality" class="form-control" placeholder="Primary Nationality">
                                    </div>

                                </div>

                                <hr>

                                <!-- CONTACT INFO -->
                                <h5 class="mb-3">Contact Information</h5>

                                <div class="row">

                                    <div class="col-md-4 mb-3">
                                        <input type="email" name="email" class="form-control" placeholder="Email">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="number" name="phone_self" class="form-control" placeholder="Mobile Number">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="number" name="phone_office" class="form-control" placeholder="Office Number">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <input type="number" name="phone_res" class="form-control" placeholder="Residence Number">
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- SUBMIT -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5">Submit Proposal</button>
                </div>

            </form>

        </div>
    </section>
    <!-- contact-area-end -->
</main>
<!-- main-area-end -->

@endsection