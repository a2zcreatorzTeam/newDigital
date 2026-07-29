 <div class="tg-header__top">
     <div class="container custom-container">
         <div class="row" style="align-items: center;">
             <div class="col-lg-8">
                 <ul class="tg-header__top-info left-side list-wrap">
                     <li><i class="flaticon-envelope"></i><a href="mailto:info@digital.statelife.com.pk">info@digital.statelife.com.pk</a></li>

                     <li><i class="flaticon-phone-call"></i><a href="tel:0123456789">+123 9898 500</a></li>
                 </ul>
             </div>
             <div class="col-lg-4">
                 <div class="top-menu">
                     <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-lg-flex">
                         <ul class="navigation justify-content-center">
                             <li class="menu-item-has-children"><a href="#" id="profile_name"><i class="flaticon-user"></i>shoaib nasir</a>
                                 <ul class="sub-menu">
                                     <li><a href="{{route('frontend.profileForm')}}"><i class="flaticon-user"></i> My Profile</a></li>

                                     {{--
                                     <li><a href="{{route('frontend.forget_password')}}"><i class="flaticon-target"></i> Change Password</a>
                             </li>
                             <li><a href="{{route('frontend.cart')}}"><i class="flaticon-shopping-cart"></i> Abandoned Cart</a></li>
                             --}}
                             <li><a href="{{route('frontend.logout')}}" class="top-signout-btn">Signout</a></li>
                         </ul>
                         </li>
                         </ul>
                     </div>
                 </div>
             </div>


         </div>
     </div>
 </div>
 <div id="sticky-header" class="tg-header__area">
     <div class="container custom-container">
         <div class="row">
             <div class="col-12">
                 <div class="tgmenu__wrap">
                     <nav class="tgmenu__nav">
                         <div class="logo">
                             <a href="{{ route('frontend.index') }}"><img src="{{ asset('frontend/images/logo.png') }}" alt="Logo"></a>
                         </div>
                         <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-lg-flex">
                             <ul class="navigation">
                                 <li class="active"><a href="{{route('frontend.index')}}">Home</a>
                                 </li>



                                 <li><a href="{{route('frontend.self-policy')}}">Self Policy</a>
                                 </li>
                                 {{-- <li class="menu-item-has-children"><a href="#">Policies</a>
                                            <ul class="sub-menu">
                                                <li class="mega"><a href="#">Policy Listing</a>
                                                    <ul class="sub-sub-menu">
                                                        <li><a href="{{ route('frontend.self-policy') }}">Self Policy Listing</a></li>
                                 <li><a href="nominated-policies.php">Nominated Policy Listing</a></li>
                             </ul>
                             </li>
                             <li><a href="policyservicing.php">Policy Servicing</a></li>
                             </ul>
                             </li>
                             <li class="menu-item-has-children"><a href="#">Claims</a>
                                 <ul class="sub-menu">
                                     <li class="mega"><a href="#">Claims Listing</a>
                                         <ul class="sub-sub-menu">
                                             <li><a href="self-claims.php">Self Claims Listing</a></li>
                                             <li><a href="nominated-claims.php">Nominated Claims Listing</a></li>
                                         </ul>
                                     </li>
                                     <li><a href="claim-form.php">Claim Forms</a></li>
                                 </ul>
                             </li>
                             <li class="menu-item-has-children"><a href="#">Documents</a>
                                 <ul class="sub-menu">
                                     <li class="mega"><a href="#">Policy Document</a>
                                         <ul class="sub-sub-menu">
                                             <li><a href="self-policy-documents.php">Self Policy Documents</a></li>
                                             <li><a href="nominated-policy-documents.php">Nominated Policy Documents</a></li>
                                         </ul>
                                     </li>
                                     <li class="mega"><a href="#">Claim Document</a>
                                         <ul class="sub-sub-menu">
                                             <li><a href="self-claim-documents.php">Self Claim Documents</a></li>
                                             <li><a href="nominated-claim-documents.php">Nominated Claim Documents</a></li>
                                         </ul>
                                     </li>
                                 </ul>
                             </li>
                             <li><a href="complaint-feedback.php">Complaints & Feedback</a></li>
                             --}}
                             <li><a href="{{route('frontend.contact')}}">Contact Us</a></li>

                             </ul>
                         </div>
                         <div class="tgmenu__action d-none d-md-block">
                             <ul class="list-wrap">
                                 <li class="header-search">

                                 </li>

                                 <!-- <li class="header-btn"><a href="contact.html" class="btn">let’s Talk</a></li> -->
                             </ul>
                         </div>
                         <div class="mobile-nav-toggler">
                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" fill="none">
                                 <path d="M0 2C0 0.895431 0.895431 0 2 0C3.10457 0 4 0.895431 4 2C4 3.10457 3.10457 4 2 4C0.895431 4 0 3.10457 0 2Z" fill="currentcolor"></path>
                                 <path d="M0 9C0 7.89543 0.895431 7 2 7C3.10457 7 4 7.89543 4 9C4 10.1046 3.10457 11 2 11C0.895431 11 0 10.1046 0 9Z" fill="currentcolor"></path>
                                 <path d="M0 16C0 14.8954 0.895431 14 2 14C3.10457 14 4 14.8954 4 16C4 17.1046 3.10457 18 2 18C0.895431 18 0 17.1046 0 16Z" fill="currentcolor"></path>
                                 <path d="M7 2C7 0.895431 7.89543 0 9 0C10.1046 0 11 0.895431 11 2C11 3.10457 10.1046 4 9 4C7.89543 4 7 3.10457 7 2Z" fill="currentcolor"></path>
                                 <path d="M7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9Z" fill="currentcolor"></path>
                                 <path d="M7 16C7 14.8954 7.89543 14 9 14C10.1046 14 11 14.8954 11 16C11 17.1046 10.1046 18 9 18C7.89543 18 7 17.1046 7 16Z" fill="currentcolor"></path>
                                 <path d="M14 2C14 0.895431 14.8954 0 16 0C17.1046 0 18 0.895431 18 2C18 3.10457 17.1046 4 16 4C14.8954 4 14 3.10457 14 2Z" fill="currentcolor"></path>
                                 <path d="M14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9Z" fill="currentcolor"></path>
                                 <path d="M14 16C14 14.8954 14.8954 14 16 14C17.1046 14 18 14.8954 18 16C18 17.1046 17.1046 18 16 18C14.8954 18 14 17.1046 14 16Z" fill="currentcolor"></path>
                             </svg>
                         </div>
                     </nav>
                 </div>

                 <!-- Mobile Menu  -->
                 <div class="tgmobile__menu">
                     <nav class="tgmobile__menu-box">
                         <div class="close-btn"><i class="fas fa-times"></i></div>
                         <div class="nav-logo">
                             <a href="index.html"><img src="{{ asset('frontend/images/logo.png')}}" alt="Logo"></a>
                         </div>
                         <div class="tgmobile__search">
                             <form action="#">
                                 <input type="text" placeholder="Search here...">
                                 <button><i class="fas fa-search"></i></button>
                             </form>
                         </div>
                         <div class="tgmobile__menu-outer">
                             <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                         </div>
                         <div class="tgmobile__menu-bottom">
                             <div class="contact-info">
                                 <ul class="list-wrap">
                                     <li><a href="login.php" class="btn log-btn">SignIn & SignUp</a></li>
                                     <li><a href="mailto:info@digital.statelife.com.pk">info@digital.statelife.com.pk</a></li>
                                     <li><a href="tel:0123456789">+123 888 9999</a></li>
                                 </ul>
                             </div>
                             <div class="social-links">
                                 <ul class="list-wrap">
                                     <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                     <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                     <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                     <li><a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i></a></li>
                                     <li><a href="javascript:void(0)"><i class="fab fa-youtube"></i></a></li>
                                 </ul>
                             </div>
                         </div>
                     </nav>
                 </div>
                 <div class="tgmobile__menu-backdrop"></div>
                 <!-- End Mobile Menu -->

             </div>
         </div>
     </div>
 </div>