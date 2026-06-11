@extends('frontend.layout.master')
@section('content')


<!-- main-area -->
<main class="fix">
    <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
    <!-- banner-area -->
    <section class="banner-area banner-bg" data-background="{{asset('frontend/images/Bd-1.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="banner-content">
                        <span class="sub-title" data-aos="fade-up" data-aos-delay="0">We Are Expert In This Field</span>
                        <h2 class="title" data-aos="fade-up" data-aos-delay="200">PROTECTION <br>In Your Hands</h2>
                        <p data-aos="fade-up" data-aos-delay="400">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                        <a href="#scroll" class="btn" data-aos="fade-up" data-aos-delay="600">Read More</a>
                    </div>
                    <div class="banner-shape">
                        <img src="{{asset('frontend/images/banner_shape01.png')}}" alt="" class="rightToLeft">
                        <img src="{{asset('frontend/images/banner_shape02.png')}}" alt="" class="ribbonRotate">
                    </div>
                </div>
            </div>
            <div class="banner-social">
                <h5 class="title">Follow us</h5>
                <ul class="list-wrap">
                    <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i></a></li>
                </ul>
            </div>
            <div class="banner-scroll">
                <a href="#scroll">Scroll Down <span><i class="fas fa-arrow-right"></i></span></a>
            </div>
        </div>
    </section>


    <section id="scroll" class="services-area services-bg" data-background="{{asset('frontend/images/services_bg.jpg')}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="section-title text-center mb-40 tg-heading-subheading animation-style3">
                        <span class="sub-title">WHAT WE OFFER</span>
                        <h2 class="title tg-element-title">We Offer An Effective Solutions</h2>
                    </div>
                </div>
            </div>


            <div class="services-item-wrap">
                <div class="row justify-content-center">
                    @foreach ($category as $data)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="box" id="box{{ $data->id }}" data-id="{{ $data->id }}">
                            <div class="services-item shine-animate-item">
                                <div class="services-thumb">
                                    <a href="#section1" class="shine-animate"><img src="{{ asset('storage/'.$data->logo) }}" alt=""></a>
                                </div>
                                <div class="services-content">
                                    <div class="icon">
                                        <img src="{{asset('frontend/images/life-insurance.png')}}" alt="">
                                    </div>
                                    <h4 class="title"><a href="#section1">{{ $data->name }}</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>

            <!-- Start Life Insurance -->
            <div id="policies_data"></div>
            <!-- End Life Insurance -->




        </div>
    </section>
    <!-- services-area-end -->




    <!-- request-area -->
    <section class="request-area request-bg" data-background="{{asset('frontend/images/request_bg.jpg')}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="request-content text-center tg-heading-subheading animation-style3">
                        <h2 class="title tg-element-title">Protect Your Life <br>You Care</h2>
                        <div class="content-bottom">
                            <a href="tel:0123456789" class="btn">Request a Free Call</a>
                            <div class="content-right">
                                <div class="icon">
                                    <i class="flaticon-phone-call"></i>
                                </div>
                                <div class="content">
                                    <span>Toll Free Call</span>
                                    <a href="tel:0123456789">+ 88 ( 9600 ) 6002</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="request-shape">
            <img src="{{asset('frontend/images/request_shape01.png')}}" alt="" data-aos="fade-right" data-aos-delay="400">
            <img src="{{asset('frontend/images/request_shape02.png')}}" alt="" data-aos="fade-left" data-aos-delay="400">
        </div>
    </section>
    <!-- request-area-end -->


    <div class="brand-area">
        <div class="container">
            <div class="swiper-container brand-active">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="{{asset('frontend/images/complaints.png')}}" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="{{asset('frontend/images/brand_img02.png')}}" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="{{asset('frontend/images/brand_img03.png')}}" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="{{asset('frontend/images/brand_img04.png')}}" alt="">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</main>



@push('js')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".box").click(function() {

            let category_id = $(this).data("id");
         
            

            $.ajax({
                url: "{{ route('frontend.getPolicies') }}",
                type: "POST",
                data: {
                    category_id: category_id
                },

                beforeSend: function() {
                    $('#loader_data').show();
                },

                success: function(response) {
                    $("#policies_data").html(response);

                    $('html, body').animate({
                        scrollTop: $("#policies_data").offset().top - 100
                    }, 500);
                },

                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert("CSRF error ya server issue");
                },

                complete: function() {
                    $('#loader_data').hide();
                }
            });

        });

    });
</script>
@endpush
@endsection