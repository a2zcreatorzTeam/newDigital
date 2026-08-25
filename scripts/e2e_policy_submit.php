<?php

/**
 * End-to-end policy submission runner against the local MySQL database.
 * Usage: php scripts/e2e_policy_submit.php
 */

use App\Models\City;
use App\Models\District;
use App\Models\FamilyHistory;
use App\Models\PlanAgeMaturity;
use App\Models\Provinces;
use App\Models\SubClass;
use App\Models\User;
use App\Models\UserPolicyData;
use App\Support\PolicyTempUpload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

function out(string $msg): void
{
    echo $msg . PHP_EOL;
}

function fail(string $msg, int $code = 1): void
{
    out('FAIL: ' . $msg);
    exit($code);
}

$user = User::where('user_type', 1)->orderBy('id')->first();
if (!$user) {
    fail('No frontend user (user_type=1) found.');
}

$product = SubClass::find(2) ?: SubClass::query()->first();
if (!$product) {
    fail('No product/plan found.');
}

$maturity = PlanAgeMaturity::where('plan_id', $product->id)
    ->where('age', '>=', 18)
    ->orderBy('age')
    ->first();
if (!$maturity) {
    fail('No plan age/maturity row for adult age.');
}

$province = Provinces::query()->first();
$city = City::query()->first();
$district = District::query()->first();
if (!$province || !$city || !$district) {
    fail('Missing province/city/district seed data.');
}

Auth::login($user);

// Build a session-backed request so CSRF + auth work like a browser.
$session = app('session.store');
$session->start();
Auth::login($user);
$session->put('login_web_' . sha1('App\\Models\\User'), $user->id);

out('AUTH user_id=' . $user->id . ' email=' . $user->email);
out('PLAN id=' . $product->id . ' age=' . $maturity->age . ' term=' . $maturity->term);

// Unique CNIC/mobile for this run to avoid link conflicts
$suffix = (string) random_int(1000000, 9999999);
$cnic = '42101-' . $suffix . '-1';
$mobile = '0300-' . substr($suffix, 0, 7);

$pngBinary = base64_decode(
    'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO5W2/0AAAAASUVORK5CYII='
);
$tmpPng = tempnam(sys_get_temp_dir(), 'e2e') . '.png';
file_put_contents($tmpPng, $pngBinary);

$requiredDocs = [
    'proposer_cnic_front',
    'proposer_cnic_back',
    'nominee_document',
    'proposer_photo',
];

$tokens = [];
foreach ($requiredDocs as $field) {
    $fieldTmp = tempnam(sys_get_temp_dir(), 'e2e') . '.png';
    file_put_contents($fieldTmp, $pngBinary);
    $upload = PolicyTempUpload::store(
        new UploadedFile($fieldTmp, $field . '.png', 'image/png', null, true),
        (int) $user->id,
        $field
    );
    $tokens[$field . '_temp_token'] = $upload['token'];
    out('UPLOAD_OK ' . $field . ' token=' . $upload['token']);
}

// Also verify base64 path (live ModSecurity path)
$base64Stored = PolicyTempUpload::storeFromBase64(
    'data:image/png;base64,' . base64_encode($pngBinary),
    'income_proof.png',
    (int) $user->id,
    'income_proof'
);
$tokens['income_proof_temp_token'] = $base64Stored['token'];
out('UPLOAD_BASE64_OK income_proof token=' . $base64Stored['token']);

$dob = now('Asia/Karachi')->subYears((int) $maturity->age)->subMonths(6)->toDateString();

$payload = array_merge([
    'permanent_province_id' => $province->id,
    'permanent_city_id' => $city->id,
    'permanent_district_id' => $district->id,
    'permanent_address' => 'E2E Permanent Address',
    'corres_province_id' => $province->id,
    'corres_city_id' => $city->id,
    'corres_district_id' => $district->id,
    'corres_address' => 'E2E Correspondence Address',
    'temp_province_id' => $province->id,
    'temp_city_id' => $city->id,
    'temp_district_id' => $district->id,
    'temp_address' => 'E2E Temporary Address',
    'life_proposed_full_name' => 'E2E Test Proposer',
    'mobile_number' => $mobile,
    'cnic_number' => $cnic,
    'cnic_issue_date' => '2020-01-01',
    'cnic_expiry_date' => '2030-01-01',
    'date_of_birth' => $dob,
    'age_nearest_date' => (int) $maturity->age,
    'gender' => 'Male',
    'marital_status' => 'Unmarried',
    'mother_maiden_name' => 'Test Mother',
    'father_name' => 'Test Father',
    'religion' => 'Islam',
    'user_email' => 'e2e+' . Str::random(6) . '@example.com',
    'is_client_dual_national' => 'No',
    'primary_nationality' => 'Pakistani',
    'birth_place_city_id' => $city->id,
    'is_same_person' => 'Yes',
    'is_emaployemnt' => 'No',
    'is_business' => 'No',
    'filer_status' => 'Non-Filer',
    'is_holding_land' => 'No',
    'avaerage_monthly_income' => 50000,
    'ex_defence_personal' => 'No',
    'discharged_on_medical' => 'No',
    'hazardous_occupation' => 'No',
    'height_value' => 170,
    'height_unit' => 'cm',
    'weight_value' => 70,
    'weight_unit' => 'kg',
    'chest_insp_value' => 90,
    'chest_insp_unit' => 'cm',
    'chest_exp_value' => 95,
    'chest_exp_unit' => 'cm',
    'abdomen_value' => 80,
    'abdomen_unit' => 'cm',
    'weight_change_type' => 'Gain',
    'weight_change_value' => 2,
    'weight_change_unit' => 'kg',
    'weight_increase_reason' => 'Diet',
    'daily_consumption' => 'None',
    'physical_impairments' => 'None',
    'last_illness_injury' => 'None',
    'medical_investigations' => 'None',
    'medical_history' => 'None',
    'plan' => $product->id,
    'table_no' => $product->table_no ?: 'Table-81',
    'term' => $maturity->term,
    'sum_assured' => 500000,
    'is_nd_applied' => 'No',
    'payment_mode' => 'Yearly',
    'adb_rider' => 'No',
    'tir_rider' => 'No',
    'father_age' => 60,
    'father_health' => 'Good',
    'father_is_alive' => 'Yes',
    'mother_age' => 55,
    'mother_health' => 'Good',
    'mother_is_alive' => 'Yes',
    'nominee_name' => 'E2E Nominee',
    'nominee_cnic' => '42101-7654321-1',
    'nominee_age' => 30,
    'nominee_relationship' => 'Brother',
], $tokens);

$csrf = $session->token();
$payload['_token'] = $csrf;

$beforeCount = UserPolicyData::where('user_id', $user->id)->count();

$request = Illuminate\Http\Request::create(
    '/policy/user/data/save',
    'POST',
    $payload,
    [],
    [],
    [
        'HTTP_ACCEPT' => 'application/json',
        'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
    ]
);
$request->setLaravelSession($session);
$request->setUserResolver(static fn () => $user);
$request->headers->set('X-CSRF-TOKEN', $csrf);

$response = $kernel->handle($request);
$status = $response->getStatusCode();
$content = $response->getContent();
$json = json_decode($content, true);

out('SAVE_STATUS=' . $status);
out('SAVE_BODY=' . substr($content, 0, 1000));

if ($status !== 200 || empty($json['success'])) {
    fail('Policy save failed.');
}

$policy = UserPolicyData::where('user_id', $user->id)->orderByDesc('id')->first();
if (!$policy) {
    fail('Policy row not found after save.');
}

$afterCount = UserPolicyData::where('user_id', $user->id)->count();
if ($afterCount <= $beforeCount) {
    fail('Policy count did not increase.');
}

$checks = [
    'policy_id' => filled($policy->policy_id),
    'cnic_number' => $policy->cnic_number === $cnic,
    'mobile_number' => $policy->mobile_number === $mobile,
    'proposer_cnic_front' => filled($policy->proposer_cnic_front),
    'proposer_cnic_back' => filled($policy->proposer_cnic_back),
    'nominee_document' => filled($policy->nominee_document),
    'proposer_photo' => filled($policy->proposer_photo),
    'income_proof' => filled($policy->income_proof),
    'premium_paid' => $policy->premium_paid !== null,
    'plan' => (string) $policy->plan === (string) $product->id,
];

foreach ($checks as $key => $ok) {
    out(($ok ? 'OK' : 'BAD') . ' field=' . $key . ' value=' . json_encode($policy->{$key} ?? null));
    if (!$ok) {
        fail('Field check failed: ' . $key);
    }
}

$family = FamilyHistory::where('user_personal_policy_data_id', $policy->id)->get();
out('FAMILY_ROWS=' . $family->count());
if ($family->count() < 2) {
    fail('Expected father/mother family history rows.');
}

foreach (['proposer_cnic_front', 'proposer_cnic_back', 'nominee_document', 'proposer_photo', 'income_proof'] as $docField) {
    $path = public_path('uploads/policy_documents/' . $policy->{$docField});
    if (!is_file($path)) {
        fail('Uploaded file missing on disk: ' . $docField);
    }
    out('FILE_OK ' . $docField . ' => ' . basename($path));
}

// Duplicate submit guard (same session policy_id should update, not duplicate blindly)
$request2 = Illuminate\Http\Request::create('/policy/user/data/save', 'POST', $payload, [], [], [
    'HTTP_ACCEPT' => 'application/json',
    'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
]);
$request2->setLaravelSession($session);
$request2->setUserResolver(static fn () => $user);
$request2->headers->set('X-CSRF-TOKEN', $csrf);
$response2 = $kernel->handle($request2);
$afterDup = UserPolicyData::where('user_id', $user->id)->count();
out('DUP_SUBMIT_STATUS=' . $response2->getStatusCode());
out('DUP_POLICY_COUNT_DELTA=' . ($afterDup - $afterCount));

out('PASS: End-to-end policy submission succeeded. policy_id=' . $policy->policy_id . ' db_id=' . $policy->id);
@unlink($tmpPng);
exit(0);
