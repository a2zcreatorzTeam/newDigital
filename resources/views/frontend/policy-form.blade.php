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

    .contact__area {
        padding: 25px 0;
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
                                <h5 class="mb-3">Address Details (پتے کی تفصیلات)</h5>

                                <div class="row">

                                    <!-- Permanent Address -->
                                    <div class="col-md-4">
                                        <h6>Permanent Address (مستقل پتہ)</h6>

                                        <div class="mb-2">
                                            <label class="form-label">Select Province (صوبہ منتخب کریں)</label>
                                            <select name="perm_province" class="form-control">
                                                <option value="">Select Province</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Select District (ضلع منتخب کریں)</label>
                                            <select name="perm_district" class="form-control">
                                                <option value="">Select District</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Select City (شہر منتخب کریں)</label>
                                            <select name="perm_city" class="form-control">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Address Line (ایڈریس لائن)</label>
                                            <textarea name="perm_address" class="form-control" placeholder="Enter permanent address"></textarea>
                                        </div>
                                    </div>

                                    <!-- Correspondence Address -->
                                    <div class="col-md-4">
                                        <h6>Correspondence Address (خط و کتابت کا پتہ)</h6>

                                        <div class="mb-2">
                                            <label class="form-label">Select Province (صوبہ منتخب کریں)</label>
                                            <select name="cor_province" class="form-control">
                                                <option value="">Select Province</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Select District (ضلع منتخب کریں)</label>
                                            <select name="cor_district" class="form-control">
                                                <option value="">Select District</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Select City (شہر منتخب کریں)</label>
                                            <select name="cor_city" class="form-control">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Address Line (ایڈریس لائن)</label>
                                            <textarea name="cor_address" class="form-control" placeholder="Enter correspondence address"></textarea>
                                        </div>
                                    </div>

                                    <!-- Temporary Address -->
                                    <div class="col-md-4">
                                        <h6>Temporary Address (عارضی پتہ)</h6>

                                        <div class="mb-2">
                                            <label class="form-label">Select Province (صوبہ منتخب کریں)</label>
                                            <select name="temp_province" class="form-control">
                                                <option value="">Select Province</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Select District (ضلع منتخب کریں)</label>
                                            <select name="temp_district" class="form-control">
                                                <option value="">Select District</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Select City (شہر منتخب کریں)</label>
                                            <select name="temp_city" class="form-control">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Address Line (ایڈریس لائن)</label>
                                            <textarea name="temp_address" class="form-control" placeholder="Enter temporary address"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <hr>

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