@extends('frontend.layout.master')
@section('content')


<!-- main-area -->
<main class="fix">

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
    <!-- banner-area-end -->

    <!-- about-area -->
    <!-- <section id="about" class="about-area pt-120 pb-120">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-img-wrap">
                            <div class="mask-img-wrap">
                                <img src="{{asset('frontend/images/about_img01.jpg')}}" alt="">
                            </div>
                            <div class="shape">
                                <img src="{{asset('frontend/images/about_shape01.png')}}" alt="">
                            </div>
                            <div class="experience-year">
                                <div class="icon">
                                    <img style="max-width: 60% !important;" src="{{asset('frontend/images/state-life.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h6 class="circle rotateme"><span style="transform: rotate(0deg);">Y</span><span style="transform: rotate(17deg);">e</span><span style="transform: rotate(34deg);">a</span><span style="transform: rotate(51deg);">r</span><span style="transform: rotate(68deg);">s</span> <span style="transform: rotate(85deg);">O</span><span style="transform: rotate(102deg);">f</span> <span style="transform: rotate(119deg);">-</span> <span style="transform: rotate(136deg);">E</span><span style="transform: rotate(153deg);">x</span><span style="transform: rotate(170deg);">p</span><span style="transform: rotate(187deg);">e</span><span style="transform: rotate(204deg);">r</span><span style="transform: rotate(221deg);">i</span><span style="transform: rotate(238deg);">e</span><span style="transform: rotate(255deg);">n</span><span style="transform: rotate(272deg);">c</span><span style="transform: rotate(289deg);">e</span> <span style="transform: rotate(306deg);">2</span><span style="transform: rotate(323deg);">5</span> <span style="transform: rotate(340deg);">-</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-content">
                            <div class="section-title mb-35 tg-heading-subheading animation-style3">
                                <span class="sub-title">Simply Know About</span>
                                <h2 class="title tg-element-title">We Help Organizations To <br> Make Ultimate Businesses Growth Success.</h2>
                            </div>
                            <div class="about-list">
                                <ul class="list-wrap">
                                    <li>
                                        <div class="icon">
                                            <i class="flaticon-target"></i>
                                        </div>
                                        <div class="content">
                                            <h4 class="title">Business Solutions</h4>
                                            <p>Semper egetuis tellus urna condi</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="flaticon-profit"></i>
                                        </div>
                                        <div class="content">
                                            <h4 class="title">Quality Services</h4>
                                            <p>Semper egetuis tellus urna condi</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <p>We successfully cope with tasks of varying complexityprovide longerty term guarantees and regularly master new Practice Area technol ogiesOur portfolio includes dozen</p>
                            <div class="about-bottom">
                                <div class="author-wrap">
                                    <div class="thumb">
                                        <img src="{{asset('frontend/images/author_img.png')}}" alt="">
                                    </div>
                                    <div class="content">
                                        <img src="{{asset('frontend/images/sign.png')}}" alt="">
                                        <h4 class="title">Martinaze <span>, CEO</span></h4>
                                    </div>
                                </div>
                                <a href="about.html" class="btn btn-two">Read More</a>
                            </div>
                            <div class="about-shape-wrap">
                                <img src="{{asset('frontend/images/about_shape03.png')}}" alt="">
                                <img src="{{asset('frontend/images/about_shape04.png')}}" alt="" class="ribbonRotate">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-left-shape">
                <img src="{{asset('frontend/images/about_shape02.png')}}" alt="">
            </div>
        </section> -->
    <!-- about-area-end -->

    <!-- services-area -->
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
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="box" id="box1">
                            <div class="services-item shine-animate-item">
                                <div class="services-thumb">
                                    <a href="#section1" class="shine-animate"><img src="{{asset('frontend/images/services_img01.jpg')}}" alt=""></a>
                                </div>
                                <div class="services-content">
                                    <div class="icon">
                                        <img src="{{asset('frontend/images/life-insurance.png')}}" alt="">
                                    </div>
                                    <h4 class="title"><a href="#section1">Life Insurance</a></h4>
                                    <a href="#section1" class="btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="box" id="box2">
                            <div class="services-item shine-animate-item">
                                <div class="services-thumb">
                                    <a href="#section2" class="shine-animate"><img src="{{asset('frontend/images/services_img04.jpg')}}" alt=""></a>
                                </div>
                                <div class="services-content">
                                    <div class="icon">
                                        <img src="{{asset('frontend/images/health-insurance.png')}}" alt="">
                                    </div>
                                    <h4 class="title"><a href="#section2">Health Insurance</a></h4>
                                    <a href="#section2" class="btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="text-align: center;"><img width="600px" src="{{asset('frontend/images/line.png')}}" alt=""></div>

            </div>

            <!-- Start Life Insurance -->
            <div class="section" id="section1" style="display: none;">
                <div class="services-item-wrap mt-50">
                    <h2 style="text-align: center;">Life Insurance</h2>
                    <div class="row justify-content-center mt-50">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                            <div class="box" id="box3">
                                <div class="services-item shine-animate-item">
                                    <div class="services-thumb">
                                        <a href="#section3" class="shine-animate"><img src="{{asset('frontend/images/mahfooz.jpg')}}" alt=""></a>
                                    </div>
                                    <div class="services-content">
                                        <div class="icon">
                                            <img src="{{asset('frontend/images/Mahfooz-Plan.png')}}" alt="">
                                        </div>
                                        <h4 class="title"><a href="#section3">Mahfooz Plan</a></h4>
                                        <a href="#section3" class="btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="text-align: center;"><img width="600px" src="{{asset('frontend/images/line.png')}}" alt=""></div>
                </div>
            </div>
            <!-- End Life Insurance -->

            <!-- Start Health Insurance -->
            <div class="section" id="section2" style="display: none;">
                <div class="services-item-wrap mt-50">
                    <h2 style="text-align: center;">Health Insurance</h2>
                    <div class="row justify-content-center mt-50">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                            <div class="box" id="box4">
                                <div class="services-item shine-animate-item">
                                    <div class="services-thumb">
                                        <a href="#section4" class="shine-animate"><img src="{{asset('frontend/images/services_img02.jpg')}}" alt=""></a>
                                    </div>
                                    <div class="services-content">
                                        <div class="icon">
                                            <img src="{{asset('frontend/images/icon1.png')}}" alt="">
                                        </div>
                                        <h4 class="title"><a href="#section4">Sehat Zindagi Plan</a></h4>
                                        <a href="#section4" class="btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                            <div class="services-item shine-animate-item">
                                <div class="box" id="box5">
                                    <div class="services-thumb">
                                        <a href="#section5" class="shine-animate"><img src="{{asset('frontend/images/health-img1.jpg')}}" alt=""></a>
                                    </div>
                                    <div class="services-content">
                                        <div class="icon">
                                            <img width="35px" src="{{asset('frontend/images/icon2.png')}}" alt="">
                                        </div>
                                        <h4 class="title"><a href="#section5">Sinf E Aahan Cancer Protection</a></h4>
                                        <a href="#section5" class="btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="text-align: center;"><img width="600px" src="{{asset('frontend/images/line.png')}}" alt=""></div>
                </div>
            </div>
            <!-- End Health Insurance -->

        </div>
    </section>
    <!-- services-area-end -->

    <!-- choose-area -->
    <!-- <section class="choose-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 order-0 order-lg-2">
                        <div class="choose-img-wrap">
                            <img src="{{asset('frontend/images/choose_img01.jpg')}}" alt="">
                            <img 50="" src="{{asset('frontend/images/choose_img02.jpg')}}" alt="" data-parallax="{" x"="" :="" }"="">
                            <img src="{{asset('frontend/images/choose_img_shape.png')}}" alt="" class="alltuchtopdown">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="choose-content">
                            <div class="section-title white-title mb-30 tg-heading-subheading animation-style3">
                                <span class="sub-title">Why We Are The Best</span>
                                <h2 class="title tg-element-title">We Offer Business Insight <br> World Class Consulting</h2>
                            </div>
                            <p>We successfully cope with tasks of varying complexity provide area longerty guarantees and regularly master new Practice Following gies heur portfolio includes dozen.</p>
                            <div class="choose-list">
                                <ul class="list-wrap">
                                    <li>
                                        <div class="icon">
                                            <i class="flaticon-investment"></i>
                                        </div>
                                        <div class="content">
                                            <h4 class="title">Business Solutions</h4>
                                            <p>Semper egetuis kelly for tellus urna area condition.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="flaticon-investment-1"></i>
                                        </div>
                                        <div class="content">
                                            <h4 class="title">Market Analysis</h4>
                                            <p>Semper egetuis kelly for tellus urna area condition.</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="choose-shape-wrap">
                <img src="{{asset('frontend/images/choose_shape01.png')}}" alt="" data-aos="fade-right" data-aos-delay="400">
                <img src="{{asset('frontend/images/choose_shape02.png')}}" alt="" data-aos="fade-left" data-aos-delay="400">
            </div>
        </section> -->
    <!-- choose-area-end -->

    <!-- counter-area -->
    <!-- <section class="counter-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="counter-item">
                            <div class="icon">
                                <i class="flaticon-trophy"></i>
                            </div>
                            <div class="content">
                                <h2 class="count"><span class="odometer" data-count="45"></span>+</h2>
                                <p>Successfully <br> Completed Projects</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="counter-item">
                            <div class="icon">
                                <i class="flaticon-happy"></i>
                            </div>
                            <div class="content">
                                <h2 class="count"><span class="odometer" data-count="92"></span>K</h2>
                                <p>Satisfied <br> 100% Our Clients</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="counter-item">
                            <div class="icon">
                                <i class="flaticon-china"></i>
                            </div>
                            <div class="content">
                                <h2 class="count"><span class="odometer" data-count="19"></span>+</h2>
                                <p>All Over The World <br> We Are Available</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="counter-item">
                            <div class="icon">
                                <i class="flaticon-time"></i>
                            </div>
                            <div class="content">
                                <h2 class="count"><span class="odometer" data-count="25"></span>+</h2>
                                <p>Years of Experiences <br> To Run This Company</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="counter-shape-wrap">
                <img src="{{asset('frontend/images/counter_shape01.png')}}" alt="" data-aos="fade-right" data-aos-delay="400">
                <img 100="" src="{{asset('frontend/images/counter_shape02.png')}}" alt="" data-parallax="{" x"="" :="" ,="" "y"="" -100="" }"="">
                <img src="{{asset('frontend/images/counter_shape03.png')}}" alt="" data-aos="fade-left" data-aos-delay="400">
            </div>
        </section> -->
    <!-- counter-area-end -->

    <!-- project-area -->
    <section class="project-area section" id="section3" style="display: none;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7">
                    <div class="section-title text-center mb-50 tg-heading-subheading animation-style3">
                        <span class="sub-title">Life Insurance</span>
                        <h2 class="title tg-element-title">Let’s Discover All Our Products</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="project-item-wrap">
            <div class="container custom-container-two">
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-md-6">
                        <div class="project-item">
                            <div class="project-thumb">
                                <a href="dashboard.php"><img src="{{asset('frontend/images/project_img01.jpg')}}" alt=""></a>
                            </div>
                            <div class="project-content">
                                <div class="left-side-content">
                                    <h4 class="title"><a href="dashboard.php">Accidental & Indemnity Product (150K Coverage)</a></h4>
                                    <span>Mahfooz Plan</span>
                                </div>
                                <div class="link-arrow">
                                    <a href="dashboard.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="project-item">
                            <div class="project-thumb">
                                <a href="dashboard.php"><img src="{{asset('frontend/images/project_img01.jpg')}}" alt=""></a>
                            </div>
                            <div class="project-content">
                                <div class="left-side-content">
                                    <h4 class="title"><a href="dashboard.php">Accidental & Indemnity Product (250K Coverage)</a></h4>
                                    <span>Mahfooz Plan</span>
                                </div>
                                <div class="link-arrow">
                                    <a href="dashboard.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="project-item">
                            <div class="project-thumb">
                                <a href="dashboard.php"><img src="{{asset('frontend/images/project_img01.jpg')}}" alt=""></a>
                            </div>
                            <div class="project-content">
                                <div class="left-side-content">
                                    <h4 class="title"><a href="dashboard.php">Accidental & Indemnity Product (400K Coverage)</a></h4>
                                    <span>Mahfooz Plan</span>
                                </div>
                                <div class="link-arrow">
                                    <a href="dashboard.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="project-content-bottom">
                                <p>We successfully cope with tasks of varying complexity, <br> provide long-term guarantees and regularly</p>
                                <a href="dashboard.php" class="btn">See All Projects</a>
                            </div>
                        </div>
                    </div> -->
            </div>
        </div>
        <div class="project-shape-wrap">
            <img src="{{asset('frontend/images/project_shape01.png')}}" alt="" class="alltuchtopdown">
            <img src="{{asset('frontend/images/project_shape02.png')}}" alt="" class="rotateme">
        </div>
    </section>

    <!-- ---------- -->
    <section class="project-area section" id="section4" style="display: none;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7">
                    <div class="section-title text-center mb-50 tg-heading-subheading animation-style3">
                        <span class="sub-title">Health Insurance</span>
                        <h2 class="title tg-element-title">Let’s Discover All Our Products</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="project-item-wrap">
            <div class="container custom-container-two">
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-md-6">
                        <div class="project-item">
                            <div class="project-thumb">
                                <a href="dashboard.php"><img src="{{asset('frontend/images/project_img02.jpg')}}" alt=""></a>
                            </div>
                            <div class="project-content">
                                <div class="left-side-content">
                                    <h4 class="title"><a href="dashboard.php">Basic Hospitalization Cover</a></h4>
                                    <span>Sehat Zindagi Plan</span>
                                </div>
                                <div class="link-arrow">
                                    <a href="dashboard.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="project-item">
                            <div class="project-thumb">
                                <a href="dashboard.php"><img src="{{asset('frontend/images/project_img03.jpg')}}" alt=""></a>
                            </div>
                            <div class="project-content">
                                <div class="left-side-content">
                                    <h4 class="title"><a href="dashboard.php">Basic Hospitalization Cover (Including Maternity)</a></h4>
                                    <span>Sehat Zindagi Plan</span>
                                </div>
                                <div class="link-arrow">
                                    <a href="dashboard.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="project-shape-wrap">
            <img src="{{asset('frontend/images/project_shape01.png')}}" alt="" class="alltuchtopdown">
            <img src="{{asset('frontend/images/project_shape02.png')}}" alt="" class="rotateme">
        </div>
    </section>

    <!-- ---------- -->
    <section class="project-area section" id="section5" style="display: none;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7">
                    <div class="section-title text-center mb-50 tg-heading-subheading animation-style3">
                        <span class="sub-title">Health Insurance</span>
                        <h2 class="title tg-element-title">Let’s Discover All Our Products</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="project-item-wrap">
            <div class="container custom-container-two">
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-md-6">
                        <div class="project-item">
                            <div class="project-thumb">
                                <a href="dashboard.php"><img src="{{asset('frontend/images/project_img04.jpg')}}" alt=""></a>
                            </div>
                            <div class="project-content">
                                <div class="left-side-content">
                                    <h4 class="title"><a href="dashboard.php">Sinf e Aahan Cancer Protection</a></h4>
                                    <span>Sinf E Aahan Cancer Protection</span>
                                </div>
                                <div class="link-arrow">
                                    <a href="dashboard.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 15" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6293 3.27957C17.7117 2.80341 17.4427 2.34763 17.0096 2.17812C16.9477 2.15385 16.8824 2.13552 16.8144 2.12376L6.96081 0.419152C6.41654 0.325049 5.89911 0.689856 5.80491 1.23411C5.71079 1.77829 6.07564 2.29578 6.61982 2.38993L14.0946 3.68295L1.36574 12.6573C0.914365 12.9756 0.806424 13.5995 1.12467 14.0509C1.44292 14.5022 2.06682 14.6102 2.51819 14.2919L15.247 5.31753L13.954 12.7923C13.8598 13.3365 14.2247 13.854 14.7689 13.9482C15.3131 14.0422 15.8305 13.6774 15.9248 13.1332L17.6293 3.27957Z" fill="currentcolor"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="project-shape-wrap">
            <img src="{{asset('frontend/images/project_shape01.png')}}" alt="" class="alltuchtopdown">
            <img src="{{asset('frontend/images/project_shape02.png')}}" alt="" class="rotateme">
        </div>
    </section>
    <!-- project-area-end -->

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

    <!-- brand-area -->
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
    <!-- brand-area -->

    <!-- team-area -->
    <!-- <section class="team-area pt-120 pb-90">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-6">
                        <div class="section-title mb-40 tg-heading-subheading animation-style3">
                            <span class="sub-title">MEET OUR TEAM</span>
                            <h2 class="title tg-element-title">Financial Expertise You <br> Can Trust</h2>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <div class="section-content">
                            <p>Our power of choice is untrammelled and when nothing preven tsbeing able to do what we like best every pleasure.</p>
                        </div>
                    </div>
                </div>
                <div class="team-item-wrap">
                    <div class="row justify-content-center">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                            <div class="team-item">
                                <div class="team-thumb">
                                    <img src="{{asset('frontend/images/team_img01.jpg')}}" alt="">
                                    <div class="team-social">
                                        <div class="social-toggle-icon">
                                            <i class="fas fa-share-alt"></i>
                                        </div>
                                        <ul class="list-wrap">
                                            <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="team-content">
                                    <h4 class="title"><a href="team-details.html">Jone Cooper</a></h4>
                                    <span>Finance Advisor</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                            <div class="team-item">
                                <div class="team-thumb">
                                    <img src="{{asset('frontend/images/team_img02.jpg')}}" alt="">
                                    <div class="team-social">
                                        <div class="social-toggle-icon">
                                            <i class="fas fa-share-alt"></i>
                                        </div>
                                        <ul class="list-wrap">
                                            <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="team-content">
                                    <h4 class="title"><a href="team-details.html">Eleanor Pena</a></h4>
                                    <span>Finance Advisor</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                            <div class="team-item">
                                <div class="team-thumb">
                                    <img src="{{asset('frontend/images/team_img03.jpg')}}" alt="">
                                    <div class="team-social">
                                        <div class="social-toggle-icon">
                                            <i class="fas fa-share-alt"></i>
                                        </div>
                                        <ul class="list-wrap">
                                            <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="team-content">
                                    <h4 class="title"><a href="team-details.html">Floyd Miles</a></h4>
                                    <span>Finance Advisor</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                            <div class="team-item">
                                <div class="team-thumb">
                                    <img src="{{asset('frontend/images/team_img04.jpg')}}" alt="">
                                    <div class="team-social">
                                        <div class="social-toggle-icon">
                                            <i class="fas fa-share-alt"></i>
                                        </div>
                                        <ul class="list-wrap">
                                            <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="team-content">
                                    <h4 class="title"><a href="team-details.html">Ralph Edwards</a></h4>
                                    <span>Finance Advisor</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    <!-- team-area-end -->

    <!-- consulting-area -->
    <!-- <section class="consulting-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="consulting-inner-wrap shine-animate-item">
                            <div class="consulting-content">
                                <div class="content-left">
                                    <h2 class="title">40+</h2>
                                    <span>Consulting <br> farm</span>
                                </div>
                                <div class="content-right">
                                    <h2 class="title">Trusted , Happy &amp; Satisfied Businesses</h2>
                                    <p>When you work with HR Solutions, you get the best. We provide adaptable solutions that allow you to be a part of the entire process</p>
                                </div>
                            </div>
                            <div class="consulting-img shine-animate">
                                <img src="{{asset('frontend/images/consulting_img.jpg')}}" alt="">
                            </div>
                            <div class="consulting-shape">
                                <img src="{{asset('frontend/images/consulting_shape.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    <!-- consulting-area-end -->

    <!-- testimonial-area -->
    <!-- <section class="testimonial-area">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 order-0 order-lg-2">
                        <div class="swiper-container testimonial-active">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-info">
                                            <h4 class="title">Mr.Robey Alexa</h4>
                                            <span>CEO, Apexa Agency</span>
                                        </div>
                                        <div class="testimonial__rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>“ Morem ipsum dolor sit amet, consectetur adipisc awing elita florai sum dolor sit amet, consectetur area Borem ipsum dolor sit amet, consectetur.”</p>
                                            <div class="icon"><i class="fas fa-quote-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-info">
                                            <h4 class="title">Mr.Robey Alexa</h4>
                                            <span>CEO, Apexa Agency</span>
                                        </div>
                                        <div class="testimonial__rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>“ Morem ipsum dolor sit amet, consectetur adipisc awing elita florai sum dolor sit amet, consectetur area Borem ipsum dolor sit amet, consectetur.”</p>
                                            <div class="icon"><i class="fas fa-quote-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-info">
                                            <h4 class="title">Mr.Robey Alexa</h4>
                                            <span>CEO, Apexa Agency</span>
                                        </div>
                                        <div class="testimonial__rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>“ Morem ipsum dolor sit amet, consectetur adipisc awing elita florai sum dolor sit amet, consectetur area Borem ipsum dolor sit amet, consectetur.”</p>
                                            <div class="icon"><i class="fas fa-quote-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="testimonial-info">
                                            <h4 class="title">Mr.Robey Alexa</h4>
                                            <span>CEO, Apexa Agency</span>
                                        </div>
                                        <div class="testimonial__rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>“ Morem ipsum dolor sit amet, consectetur adipisc awing elita florai sum dolor sit amet, consectetur area Borem ipsum dolor sit amet, consectetur.”</p>
                                            <div class="icon"><i class="fas fa-quote-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-slider-dot">
                            <div class="swiper testimonial-nav">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <button><img src="{{asset('frontend/images/testi_avatar01.png')}}" alt=""></button>
                                    </div>
                                    <div class="swiper-slide">
                                        <button><img src="{{asset('frontend/images/testi_avatar02.png')}}" alt=""></button>
                                    </div>
                                    <div class="swiper-slide">
                                        <button><img src="{{asset('frontend/images/testi_avatar03.png')}}" alt=""></button>
                                    </div>
                                    <div class="swiper-slide">
                                        <button><img src="{{asset('frontend/images/testi_avatar04.png')}}" alt=""></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-8">
                        <div class="testimonial-img-wrap">
                            <img src="{{asset('frontend/images/testimonial_img.png')}}" alt="">
                            <div class="img-shape">
                                <img src="{{asset('frontend/images/testimonial_shape01.png')}}" alt="">
                                <img src="{{asset('frontend/images/testimonial_shape02.png')}}" alt="" class="alltuchtopdown">
                                <img 80="" src="{{asset('frontend/images/testimonial_shape03.png')}}" alt="" data-parallax="{" y"="" :="" }"="">
                                <img src="{{asset('frontend/images/testimonial_shape04.png')}}" alt="" class="rightToLeft">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-shape-wrap">
                <img src="{{asset('frontend/images/testimonial_shape05.png')}}" alt="" data-aos="fade-up" data-aos-delay="400">
                <img src="{{asset('frontend/images/testimonial_shape06.png')}}" alt="" data-aos="fade-left" data-aos-delay="400">
            </div>
        </section> -->
    <!-- testimonial-area-end -->

    <!-- blog-post-area -->
    <!-- <section class="blog-post-area blog-post-bg" data-background="assets/img/bg/blog_post_bg.jpg')}}">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="section-title text-center mb-40 tg-heading-subheading animation-style3">
                            <span class="sub-title">OUR BLOG UPDATE</span>
                            <h2 class="title tg-element-title">Featured News And Insights</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-6 col-md-10">
                        <div class="blog-post-item shine-animate-item">
                            <div class="blog-post-thumb">
                                <a href="blog-details.html" class="shine-animate"><img src="{{asset('frontend/images/blog_post01.jpg')}}" alt=""></a>
                                <a href="blog.html" class="post-tag">Business</a>
                            </div>
                            <div class="blog-post-content">
                                <h2 class="title"><a href="blog-details.html">Marketing your are business downturn now a days</a></h2>
                                <div class="blog-avatar">
                                    <div class="avatar-thumb">
                                        <img src="{{asset('frontend/images/blog_avatar01.png')}}" alt="">
                                    </div>
                                    <div class="avatar-content">
                                        <p>By <a href="blog-details.html">Doman Smith</a></p>
                                    </div>
                                </div>
                                <div class="blog-post-meta">
                                    <ul class="list-wrap">
                                        <li>
                                            <a href="blog-details.html" class="btn">Read More</a>
                                        </li>
                                        <li><i class="fas fa-calendar-alt"></i>Oct 21, 2024</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-10">
                        <div class="blog-post-item shine-animate-item">
                            <div class="blog-post-thumb">
                                <a href="blog-details.html" class="shine-animate"><img src="{{asset('frontend/images/blog_post02.jpg')}}" alt=""></a>
                                <a href="blog.html" class="post-tag">Audit</a>
                            </div>
                            <div class="blog-post-content">
                                <h2 class="title"><a href="blog-details.html">Marketing your are business downturn now a days</a></h2>
                                <div class="blog-avatar">
                                    <div class="avatar-thumb">
                                        <img src="{{asset('frontend/images/blog_avatar01.png')}}" alt="">
                                    </div>
                                    <div class="avatar-content">
                                        <p>By <a href="blog-details.html">Doman Smith</a></p>
                                    </div>
                                </div>
                                <div class="blog-post-meta">
                                    <ul class="list-wrap">
                                        <li>
                                            <a href="blog-details.html" class="btn">Read More</a>
                                        </li>
                                        <li><i class="fas fa-calendar-alt"></i>Oct 21, 2024</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-10">
                        <div class="blog-post-item shine-animate-item">
                            <div class="blog-post-thumb">
                                <a href="blog-details.html" class="shine-animate"><img src="{{asset('frontend/images/blog_post03.jpg')}}" alt=""></a>
                                <a href="blog.html" class="post-tag">Investment</a>
                            </div>
                            <div class="blog-post-content">
                                <h2 class="title"><a href="blog-details.html">Marketing your are business downturn now a days</a></h2>
                                <div class="blog-avatar">
                                    <div class="avatar-thumb">
                                        <img src="{{asset('frontend/images/blog_avatar01.png')}}" alt="">
                                    </div>
                                    <div class="avatar-content">
                                        <p>By <a href="blog-details.html">Doman Smith</a></p>
                                    </div>
                                </div>
                                <div class="blog-post-meta">
                                    <ul class="list-wrap">
                                        <li>
                                            <a href="blog-details.html" class="btn">Read More</a>
                                        </li>
                                        <li><i class="fas fa-calendar-alt"></i>Oct 21, 2024</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="blog-shape-wrap">
                <img src="{{asset('frontend/images/blog_shape01.png')}}" alt="" data-aos="fade-right" data-aos-delay="400">
                <img src="{{asset('frontend/images/blog_shape02.png')}}" alt="" data-aos="fade-left" data-aos-delay="400">
            </div>
        </section> -->
    <!-- blog-post-area-end -->

    <!-- call-back-area -->
    <!-- <section class="call-back-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="call-back-content">
                            <div class="section-title white-title mb-10 tg-heading-subheading animation-style3">
                                <h2 class="title tg-element-title">Request A Call Back</h2>
                            </div>
                            <p>Ever find yourself staring at your computer screen a good consulting slogan to come to mind? Oftentimes.</p>
                            <div class="shape">
                                <img src="{{asset('frontend/images/call_back_shape.png')}}" alt="" data-aos="fade-right" data-aos-delay="400">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="call-back-form">
                            <form action="#">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <input type="text" placeholder="Name *">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <input type="email" placeholder="E-mail *">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <input type="number" placeholder="Phone *">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn">Send Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    <!-- call-back-area-end -->

</main>
<!-- main-area-end -->


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // jQuery code
    $(document).ready(function() {
        // Attach click event to each box
        $(".box").click(function() {
            // Hide all sections
            $(".section").hide();

            // Get the ID of the clicked box
            var boxID = $(this).attr("id");

            // Show the corresponding section
            $("#section" + boxID.slice(-1)).show();
        });
    });
</script>
@endsection