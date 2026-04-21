<!-- header-area-start -->
<link rel="stylesheet" href="css/sub-header.css">
<link rel="stylesheet" href="css/profile.css">
<?php include "header.php" ?>
<!-- header-area-end -->

<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="images/breadcrumb_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">Edit Profile</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="my-profile.php">My Profile</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
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
    <section id="scroll" class="services-area services-bg" data-background="images/services_bg.jpg">
        <div class="container">
            <div class="row my-pol">
                <div class="col-md-3">
                    <div class="profile-img">
                        <img src="images/user-img.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-9 edit-pro-form">
                    <form action="" class="box-form-login">
                    <div class="form-login">
                            <div class="form-group d-flex">
                                <input type="text" class="form-control account" placeholder="First Name">
                                <input type="text" class="form-control account" placeholder="Last Name">
                            </div>
                            <div class="form-group d-flex">
                                <input type="email" class="form-control email-address" placeholder="Email">
                                <input type="tel" class="form-control phone" placeholder="Mobile">
                            </div>
                            
                            <div class="form-group d-flex">
                                <input type="submit" class="btn btn-login" value="Update">
                                <input type="submit" class="btn btn-login" value="Cancel">
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>

        </div>
    </section>
    <!-- main-area-end -->
</main>


<?php include "footer.php" ?>