@extends('frontend.layout.master')
@section('content')<!-- header-area-start -->
<link rel="stylesheet" href="{{ asset('frontend/css/sub-header.css') }}">
<style>
    .h2{
        font-size: 30px;
        color: #000000;
    }
</style>
<!-- header-area-end -->

<!-- main-area -->
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
        <div class="breadcrumb__shape">
            <img src="{{ asset('Frontend/images/breadcrumb_shape01.png')}}" alt="">
            <img src="{{ asset('Frontend/images/breadcrumb_shape02.png')}}" alt="" class="rightToLeft">
            <img src="{{ asset('Frontend/images/breadcrumb_shape03.png')}}" alt="">
            <img src="{{ asset('Frontend/images/breadcrumb_shape04.png')}}" alt="">
            <img src="{{ asset('Frontend/images/breadcrumb_shape05.png')}}" alt="" class="alltuchtopdown">
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <!-- about-area -->
    <section class="forgot__area-one">
        <div class="container">
            <div class="text-center mb-55">
                <h1 class="text-48-bold">Complete your professional profile information</h1>
            </div>
            <h2>Basic Details</h2>
            <div class="box-form-login">
                <div class="head-login">

                    <div class="form-login form-forgot row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Life Proposed Full Name (بیمہ زندگی کے لئے مجوزہ کا پورا نام)</label>
                                <input type="text" class="form-control account">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Mobile Number Personal (ذاتی موبائل نمبر)</label>
                                <input type="text" class="form-control account">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="">CNIC / B-FORM NO (قومی شناختی کارڈ نمبر)</label>
                                <input type="text" class="form-control account">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Cnic Issue Date (شناختی کارڈ جاری کرنے کی تاریخ)</label>
                                <input type="text" class="form-control account">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Cnic Expiry Date (شناختی کارڈ کی میعاد ختم ہونے کی تاریخ)</label>
                                <input type="text" class="form-control account">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Date Of Birth (تاریخِ پیدائش)</label>
                                <input type="text" class="form-control account">
                            </div>

                        </div>
                        <div class="row">

                            <!-- Age -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Age Nearest Birth-date (عمر)*</label>
                                    <input type="text" class="form-control account" name="age">
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Gender/Sex (جنس)*</label>
                                    <input type="text" class="form-control account" name="gender">
                                </div>
                            </div>

                            <!-- Mother Maiden Name -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Mother Maiden Name (والدہ کا خاندانی نام)*</label>
                                    <input type="text" class="form-control account" name="mother_name">
                                </div>
                            </div>

                            <!-- Father Name -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Father’s Name of Life Proposed (مجوزہ بیمہ کے والد کا نام)*</label>
                                    <input type="text" class="form-control account" name="father_name">
                                </div>
                            </div>

                            <!-- Husband Name -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Husband Name of Life Proposed (بیمہ کنندہ کے شوہر کا نام)*</label>
                                    <input type="text" class="form-control account" name="husband_name">
                                </div>
                            </div>

                            <!-- Religion -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Religion (مذہب)*</label>
                                    <input type="text" class="form-control account" name="religion">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Email Address (ای میل ایڈریس)*</label>
                                    <input type="email" class="form-control account" name="email">
                                </div>
                            </div>

                            <!-- Age Proof -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Age Proof (عمر کا ثبوت)*</label>
                                    <input type="text" class="form-control account" name="age_proof">
                                </div>
                            </div>

                            <!-- Office Phone -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Phone Number Office (آفس فون نمبر)*</label>
                                    <input type="text" class="form-control account" name="office_phone">
                                </div>
                            </div>

                            <!-- Residential Phone -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Phone Number Residential (رہائشی فون نمبر)*</label>
                                    <input type="text" class="form-control account" name="residential_phone">
                                </div>
                            </div>

                            <!-- Fax -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Fax No (فیکس نمبر)*</label>
                                    <input type="text" class="form-control account" name="fax">
                                </div>
                            </div>

                            <!-- Dual National -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Is Client Dual National? (کیا سائل ڈوئل قومیت رکھتا ہے؟)*</label>
                                    <input type="text" class="form-control account" name="dual_national">
                                </div>
                            </div>

                            <div class="row">

                                <!-- Primary Nationality -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Primary Nationality (قومیت)*</label>
                                        <input type="text" class="form-control account" name="primary_nationality">
                                    </div>
                                </div>

                                <!-- Dual Nationality -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Dual Nationality (دوہری قومیت)*</label>
                                        <input type="text" class="form-control account" name="dual_nationality">
                                    </div>
                                </div>

                                <!-- Birth Place -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Birth Place (مقامِ پیدائش)*</label>
                                        <input type="text" class="form-control account" name="birth_place">
                                    </div>
                                </div>

                                <!-- Proposer & Life Proposed Same -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Proposer & Life Proposed are same?*</label>
                                        <input type="text" class="form-control account" name="is_same_person">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <h2>Personal Details</h2>
            <div class="box-form-login">
                <div class="head-login">
                    <!-- ================= Permanent Address ================= -->
                    <p class="text-16-semibold mt-4">Permanent Address (مستقل پتہ)</p>
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label>Select Province (صوبہ منتخب کریں)*</label>
                                <input type="text" class="form-control account" name="permanent_province">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Select District (ضلع منتخب کریں)*</label>
                                <input type="text" class="form-control account" name="permanent_district">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Select City (شہر منتخب کریں)*</label>
                                <input type="text" class="form-control account" name="permanent_city">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Address Line (پتہ لائن)*</label>
                                <input type="text" class="form-control account" name="permanent_address">
                            </div>
                        </div>

                    </div>

                    <!-- ================= Correspondence Address ================= -->
                    <p class="text-16-semibold mt-4">Correspondence Address (رابطے کا پتہ)</p>
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label>Select Province (صوبہ منتخب کریں)*</label>
                                <input type="text" class="form-control account" name="correspondence_province">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Select District (ضلع منتخب کریں)*</label>
                                <input type="text" class="form-control account" name="correspondence_district">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Select City (شہر منتخب کریں)*</label>
                                <input type="text" class="form-control account" name="correspondence_city">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Address Line (پتہ لائن)*</label>
                                <input type="text" class="form-control account" name="correspondence_address">
                            </div>
                        </div>

                    </div>

                    <!-- ================= Temporary Address ================= -->
                    <p class="text-16-semibold mt-4">Temporary Address (عارضی پتہ)</p>
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label>Select Province (صوبہ منتخب کریں)*</label>
                                <input type="text" class="form-control account" name="temporary_province">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Select District (ضلع منتخب کریں)*</label>
                                <input type="text" class="form-control account" name="temporary_district">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Select City (شہر منتخب کریں)*</label>
                                <input type="text" class="form-control account" name="temporary_city">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Address Line (پتہ لائن)*</label>
                                <input type="text" class="form-control account" name="temporary_address">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <h2>Occupation</h2>
            <div class="box-form-login">
                <div class="head-login">
                    <div class="row">
                        <!-- Is Employment? -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Is Employment? ((کام/پیشہ کی نوعیت (مکمل تفصیلات کے ساتھ)*</label>
                                <select class="form-control account" name="is_employment">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- Is Businessman? -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Is Businessman? ((کیا کاروبار ہے؟ (مکمل تفصیلات کے ساتھ)*</label>
                                <select class="form-control account" name="is_businessman">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- If holding Land? -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>If holding Land? ((کیا زراعتی زمین ہے؟ (مکمل تفصیلات کے ساتھ)*</label>
                                <select class="form-control account" name="holding_land">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- Monthly Income -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>What is your average monthly income from all sources? (آپ کی تمام ذرائع سے حاصل کردہ ماہانہ آمدنی کیا ہے؟)*</label>
                                <input type="number" class="form-control account" name="monthly_income" placeholder="Rs.">
                            </div>
                        </div>

                        <!-- Defence / Airline Crew -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>If Defence or Ex-Defence Personal, commercial Airline Flight Crew or plant protection pilot? (کیا آپ فوجی/سابقہ فوجی، عملہ شہری ہوا بازی/تحفظ فصل کے ہوا باز ہیں؟)*</label>
                                <select class="form-control account" name="defence_airline_crew">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- Discharged on Medical Grounds -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Have you ever been discharged on medical grounds from service / employeement? (کیا آپ کبھی طبی اسباب کی وجہ سے ملازمت/خدمات سے برخاست کئے گئے ہیں؟)*</label>
                                <select class="form-control account" name="medical_discharge">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- Hazardous Occupation -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Are you presently engaged or intent to engage in any hazardous occupation or pastime? (کیا آپ فی الوقت کسی پر خطر پیشے یا مشغلے سے وابستہ ہیں یا آئندہ وابستہ ہونے کا ارادہ ہے؟)*</label>
                                <select class="form-control account" name="hazardous_occupation">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Please Enter Your Comments (If any)? (براہ کرم اپنی رائے درج کریں (اگر کوئی ہو)*</label>
                                <textarea class="form-control account" name="comments" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2>Health Information</h2>
            <div class="box-form-login">
                <div class="head-login">
                    <div class="row">
                        <!-- Height (In cm) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Height (In cm) (قد سینٹی میٹر میں)*</label>
                                <input type="text" class="form-control" name="height_cm">
                            </div>
                        </div>
                        <!-- Height (In Feet) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Height (In Feet)*</label>
                                <input type="text" class="form-control" name="height_feet">
                            </div>
                        </div>

                        <!-- Weight (In Kg) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Weight (In Kg) (وزن کلوگرام میں)*</label>
                                <input type="text" class="form-control" name="weight_kg">
                            </div>
                        </div>
                        <!-- Chest Insp (In cm) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Chest Insp (In cm) (سینہ پھیلانے کے ساتھ - سینٹی میٹر میں)*</label>
                                <input type="text" class="form-control" name="chest_insp_cm">
                            </div>
                        </div>

                        <!-- Chest Insp (In Inches) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Chest Insp (In Inches)*</label>
                                <input type="text" class="form-control" name="chest_insp_inches">
                            </div>
                        </div>
                        <!-- Chest Exp (In cm) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Chest Exp (In cm) (سینہ پھیلانے کے بغیر - سینٹی میٹر میں)*</label>
                                <input type="text" class="form-control" name="chest_exp_cm">
                            </div>
                        </div>

                        <!-- Chest Exp (In Inches) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Chest Exp (In Inches)*</label>
                                <input type="text" class="form-control" name="chest_exp_inches">
                            </div>
                        </div>
                        <!-- Abdomen (In cm) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Abdomen (In cm) (پیٹ - سینٹی میٹر میں)*</label>
                                <input type="text" class="form-control" name="abdomen_cm">
                            </div>
                        </div>

                        <!-- Abdomen (In Inches) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Abdomen (In Inches)*</label>
                                <input type="text" class="form-control" name="abdomen_inches">
                            </div>
                        </div>
                        <!-- Weight Loss (In Kg) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Weight Loss (In Kg) (وزن میں کمی - کلوگرام میں)*</label>
                                <input type="text" class="form-control" name="weight_loss_kg">
                            </div>
                        </div>

                        <!-- Weight Gain (In Kg) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Weight Gain (In Kg) (وزن میں اضافہ - کلوگرام میں)*</label>
                                <input type="text" class="form-control" name="weight_gain_kg">
                            </div>
                        </div>

                        <!-- Empty column for layout balance if needed -->
                        <div class="col-6"></div>

                        <!-- Reason of Increase Weight -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Reason of Increase Weight (وزن بڑھنے کی وجہ)*</label>
                                <textarea class="form-control" name="weight_increase_reason" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-area-end -->
</main>
<!-- main-area-end -->

@endsection