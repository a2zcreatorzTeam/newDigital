@extends('frontend.layout.master')
@section('content')
<style>
    .container {
        max-width: 1416px !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('frontend/css/sub-header.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/complaint.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/di-form.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('frontend/css/dashboard.css') }}">



<!-- header-area-end -->
<!-- main-area -->
<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="{{asset('frontend/images/breadcrumb_bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">{{ $product->name }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="products.php">Products</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb__shape">
            <img src="{{asset('frontend/images/breadcrumb_shape01.png')}}" alt="">
            <img src="{{asset('frontend/images/breadcrumb_shape02.png')}}" alt="" class="rightToLeft">
            <img src="{{asset('frontend/images/breadcrumb_shape03.png')}}" alt="">
            <img src="{{asset('frontend/images/breadcrumb_shape04.png')}}" alt="">
            <img src="{{asset('frontend/images/breadcrumb_shape05.png')}}" alt="" class="alltuchtopdown">
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- services-area -->
    <section id="scroll" class="services-area services-bg" data-background="{{asset('frontend/images/services_bg.jpg')}}">
        <div class="container">
            <div class="row my-pol">
                <form id="msform"
                    data-product-id="{{ $id }}"
                    data-product-name="{{ $product->name ?? '' }}"
                    data-queue-save-url="{{ route('frontend.queue.save') }}"
                    data-draft-id="{{ $draft->id ?? '' }}">
                    @csrf

                    @if(!empty($draft))
                    <div class="alert alert-primary border-start border-5 mb-3" style="border-left-color:#1f93d1 !important;">
                        <strong><i class="fas fa-layer-group me-1"></i> Resuming queued application</strong>
                        <span class="d-block mt-1">Your previously saved answers have been restored. Continue from where you left off — progress still auto-saves to Queue.</span>
                    </div>
                    @endif
               
                    <div class="">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <br> <!-- fieldsets -->
                    <!-- Upload Information -->
                    @include('frontend.policyFlow.form',['user'=>$user,'product'=>$product,'policy_data'=>$policy_data,'cities'=>$cities ?? collect(),'id'=>$id,'draft'=>$draft ?? null])
                    <!-- Choose Product -->
                    @include('frontend.policyFlow.step2',['user'=>$user])
                    <!-- Upload info & Documents -->
                    @include('frontend.policyFlow.step3',['user'=>$user])
                    <!-- Make Payment -->
                    @include('frontend.policyFlow.step4',['user'=>$user])
                    <!-- Summary -->
                    @include('frontend.policyFlow.step5',['user'=>$user])
                </form>
            </div>

        </div>
    </section>
    <!-- services-area-end -->

</main>
<!-- main-area-end -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script> -->
<script src="{{ asset('frontend/js/script.js') }}"></script>

@endsection