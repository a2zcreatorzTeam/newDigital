<!-- header-area-start -->
<link rel="stylesheet" href="css/sub-header.css">
<?php include "header.php" ?>
<!-- header-area-end -->

<!-- main-area -->
<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="images/breadcrumb_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">Login</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Login</li>
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
    <!-- about-area -->
    <section class="login__area-one">
        <div class="container">
            <div class="text-center mb-55">
                <h1 class="text-48-bold">Welcome back!</h1>
            </div>
            <div class="box-form-login">
                <div class="head-login">
                    <h3>Sign in</h3>
                    <p>Sign in with your email and password</p>
                    <div class="box-login-with">
                        <div class="form-group">
                            <a href="#" class="btn btn-login-social">
                                <img src="images/google.svg">
                                Sign In With Google
                            </a>
                        </div>
                        <div class="form-group">
                            <a href="#" class="btn btn-login-social">
                                <img src="images/apple.png">
                                Sign In With Apple Id
                            </a>
                        </div>
                    </div>
                    <div class="text-or"><span>or</span></div>
                    <div class="form-login">
                        <div class="form-group">
                            <input type="text" class="form-control account" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password">
                            <span class="view-password"></span>
                        </div>
                        <div class="box-forgot-pass">
                           
                            <a href="forgot-password.php">Forgot Password ?</a>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-login" value="Sign In">
                        </div>
                        <p>Don’t have an account? <a class="link-bold" href="register.php">Sign up</a> now</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-area-end -->
</main>
<!-- main-area-end -->

<!-- footer-area -->
<?php include "footer.php" ?>
<!-- footer-area-end -->