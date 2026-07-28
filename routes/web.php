<?php

use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\backend\CityController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\DistrictController;
use App\Http\Controllers\backend\MainClassController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\SubClassController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\UserPolicyController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\PolicyController;
use App\Http\Controllers\Frontend\VoucheController;
use App\Http\Controllers\Frontend\PolicyCalculatorController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
        return view('welcome');
});

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['middleware' => ['user.role']], function () {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('city', CityController::class);
        Route::resource('district', DistrictController::class);

        Route::prefix('admin/dashboard')->name('admin.')->controller(DashboardController::class)->group(function () {
                Route::get('/', 'dashboard')->name('dashboard');
        });
        Route::prefix('admin/dashboard/class')->name('class.')->controller(MainClassController::class)->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
                Route::get('/toggleStatus/{id}', 'toggleStatus')->name('toggleStatus');
        });
        Route::prefix('admin/dashboard/subclass')->name('subclass.')->controller(SubClassController::class)->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::post('/list', 'list')->name('list');
                Route::get('/create', 'create')->name('create');
                Route::get('/filter', 'filter')->name('filter');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
                Route::get('/toggleStatus/{id}', 'toggleStatus')->name('toggleStatus');
        });
        Route::prefix('admin/dashboard/userPolicy')->name('user.policy.')->controller(UserPolicyController::class)->group(function () {
                Route::post('/list', 'list')->name('list');
                Route::get('/filter', 'filter')->name('filter');
                Route::get('/policyDetail/{id}', 'policy_detail')->name('policyDetail');
                // Route::get('/profile/{id}/download-pdf', 'downloadPolicyUserPdf')
                // ->name('download.pdf');
                Route::post('/export', 'export')->name('export');
                Route::post('/update/status', 'updateStatus')->name('update.status');
        });
});


Route::prefix('admin')->name('admin.')->controller(AuthController::class)->group(function () {
        Route::get('login/', 'loginPage')->name('login');
        Route::post('user/login', 'login')->name('login.user');
        Route::get('user/logout', 'logout')->name('logout.user');
});


Route::prefix('admin/dashboard/userPolicy')->name('user.policy.')->controller(UserPolicyController::class)->group(function () {
        Route::get('/profile/{id}/download-pdf', 'downloadPolicyUserPdf')->name('download.pdf');
});



Route::prefix('/')->name('frontend.')->controller(FrontendController::class)->group(function () {
        Route::get('/', 'home')->name('index');
        Route::get('/cart', 'cart')->name('cart');
        Route::get('/forget-password', 'forget_password')->name('forget_password');
        Route::get('/contact', 'contact')->name('contact');
        Route::get('/product', 'product')->name('product');
        Route::post('/signup', 'signup')->name('signup');
        Route::post('/signin', 'signin')->name('signin');
        Route::post('/forgot-password', 'forgotPassword')->name('forgot.password');
        Route::post('/get-policies', 'getPolicies')->name('getPolicies');
        Route::get('/policy-form', 'policyForm')->name('policyForm');
        Route::get('/dashboard/{id}', 'dashboard')->name('dashboard');
        Route::get('/profile-form', 'profileForm')->name('profileForm');
        Route::post('/updateBasicDetails', 'updateBasicDetails')->name('updateBasicDetails');
        Route::post('/updateAddressInfo', 'updateAddressInfo')->name('updateAddressInfo');
        Route::post('/updateOccupation', 'updateOccupation')->name('updateOccupation');
        Route::post('/updateHealth', 'updateHealth')->name('updateHealth');
        Route::post('policy/user/data/save', 'policyDataSave')->name('policyUserDataSave');
        Route::post('get/plan/data', 'getPlanData')->name('getPlanData');
        Route::post('get/sum/aasured', 'getSumAssured')->name('getSumAssured');
        Route::get('payment/success', 'successPayment')->name('successPayment');

        Route::post('/get/city/data', 'getcityData')->name('getcityData');
        Route::post('/get/district/data', 'getDistrictData')->name('getDistrictData');
        Route::post('/updateProfile', 'updateProfile')->name('updateProfile');
        Route::get('/logout', 'logout')->name('logout');
        Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
        Route::post('/resend-otp', 'resendOtp')->name('resend.otp');
});

Route::prefix('/voucher')->name('voucher.')->controller(VoucheController::class)->middleware('prevent-back-history')->group(function () {
        Route::get('/{id}', 'voucher')->name('voucher');
});

Route::prefix('/policy-calculator')->name('PolicyCalculator.')->controller(PolicyCalculatorController::class)->group(function () {
        Route::post('/', 'policy_calculation')->name('policy_calculation');
});














Route::prefix('/')->name('frontend.')->controller(FrontendController::class)
        ->middleware('front.role')
        ->group(function () {
                Route::get('/profile', 'profile')->name('profile');
        });

//self policy listing
Route::prefix('/')->name('frontend.')->controller(PolicyController::class)
        ->middleware('front.role')
        ->group(function () {
                Route::get('/self-policy', 'self_policy')->name('self-policy');
                Route::get('/self-policy-detail/{id}', 'policy_detail')->name('policyDetail');
                Route::get('/self-policy-edit/{id}', 'policyDetailEdit')->name('policyDetail.edit');
                Route::post('/self-policy-update/{id}', 'policyDetailEdit')->name('policyDetail.update');
        });

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $user = User::findOrFail($request->id);
        Auth::login($user);
        $request->fulfill();
        return redirect()->route('frontend.index');
})->middleware(['auth', 'signed'])->name('verification.verify');



Route::get('/test-email', function () {

        $toEmail = "shoaibnasir315@gmail.com";

        Mail::raw('This is a test email from Laravel web route.', function ($message) use ($toEmail) {
                $message->to($toEmail)
                        ->subject('Test Email');
        });

        return "Test email sent successfully!";
});
