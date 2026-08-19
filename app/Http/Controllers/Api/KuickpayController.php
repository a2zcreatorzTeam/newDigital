<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KuickpayController extends Controller
{
    /**
     * Auth Middleware check alternative (Manual Verification)
     */
    private function isAuthorized(Request $request)
    {
        $apiUser = (string) config('services.kuickpay.username');
        $apiPass = (string) config('services.kuickpay.password');

        if ($apiUser === '' || $apiPass === '') {
            return false;
        }

        return $request->header('username') === $apiUser &&
            $request->header('password') === $apiPass;
    }

    private function bankMnemonicIsValid(Request $request): bool
    {
        $expected = config('services.kuickpay.bank_mnemonic');
        if ($expected === null || $expected === '') {
            return true;
        }

        return (string) $request->input('bank_mnemonic') === (string) $expected;
    }



    /**
 * @OA\Post(
 *     path="/api/v1/BillInquiry",
 *     tags={"Kuickpay"},
 *     summary="Bill Inquiry API",
 *     description="Fetch voucher/bill details using consumer number",
 *
 *     @OA\Parameter(
 *         name="username",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\Parameter(
 *         name="password",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"consumer_number", "bank_mnemonic"},
 *             @OA\Property(property="consumer_number", type="string", example="0152001123456"),
 *             @OA\Property(property="bank_mnemonic", type="string", example="KPY"),
 *             @OA\Property(property="reserved", type="string", example="")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Success Response"
 *     ),
 *
 *     @OA\Response(
 *         response=400,
 *         description="Invalid Credentials / Bad Request"
 *     )
 * )
 */

    /**
     * 1. BILL INQUIRY API [cite: 14, 30]
     */
    public function billInquiry(Request $request)
    {
        // Security Check [cite: 34]
        if (!$this->isAuthorized($request)) {
            return response()->json(['response_Code' => '04', 'message' => 'Invalid Data/Credentials'], 400); // [cite: 85, 140]
        }

        if (!$this->bankMnemonicIsValid($request)) {
            return response()->json([
                'response_Code' => '04',
                'message' => 'Invalid Data'
            ], 400);
        }

        $consumerNumber = $request->input('consumer_number'); // [cite: 40]

        // Bad Transaction
        if (empty($consumerNumber)) {
            return response()->json([
                'response_Code' => '03',
                'message' => 'Unknown Error/Bad Transaction'
            ]);
        }

        // Database me search karna
        $voucher = Voucher::where('consumer_number', $consumerNumber)->first();

        // Case: Voucher nahi mila [cite: 85, 140]
        if (!$voucher) {
            return response()->json([
                'response_Code' => '01', // Voucher does not exist [cite: 85, 140]
                'consumer Detail' => '',
                'bill_status' => ''
            ]);
        }

        // Case: Voucher Blocked hai [cite: 85, 140]
        if ($voucher->status === 'B') {
            return response()->json([
                'response_Code' => '02', // Blocked [cite: 85, 140]
                'consumer Detail' => $voucher->customer_name,
                'bill_status' => 'B' // [cite: 85]
            ]);
        }

        // Response Data Preparation ke format ke mutabiq [cite: 46, 62]
        $response = [
            'response_Code'         => '00', // Success [cite: 85, 140]
            'consumer_Detail'       => str_pad($voucher->customer_name, 30, ' ', STR_PAD_RIGHT), // Left justified, right padded [cite: 85]
            'bill_status'           => $voucher->status, // U or P [cite: 85]
            'due_date'              => Carbon::parse($voucher->due_date)->format('Ymd'), // yyyyMMdd [cite: 91]
            'amount_within_dueDate' => Voucher::formatTwoKuickpayAmount($voucher->amount_within_due_date, true), // [cite: 91]
            'amount_after_dueDate'  => Voucher::formatTwoKuickpayAmount($voucher->amount_after_due_date, true), // [cite: 91]
            'email_address'         => str_pad($voucher->email ?? 'example@gmail.com', 30, ' '), // [cite: 91]
            'contact_number'        => $voucher->contact_number ?? '923000000000', // [cite: 95]
            'billing_month'         => $voucher->billing_month, // [cite: 95]
            'date_paid'             => $voucher->status === 'P' ? Carbon::parse($voucher->date_paid)->format('Ymd') : '', // [cite: 95]
            'amount_paid'           => $voucher->status === 'P' ? Voucher::formatKuickpayAmount($voucher->amount_within_due_date) : '', // [cite: 95]
            'tran_auth_Id'          => $voucher->tran_auth_id ?? '', // [cite: 95]
            'reserved'              => $request->input('reserved', '') // [cite: 42]
        ];

        return response()->json($response);
    }





/**
 * @OA\Post(
 *     path="/api/v1/BillPayment",
 *     tags={"Kuickpay"},
 *     summary="Bill Payment API",
 *     description="Process bill payment and update voucher status",
 *
 *     @OA\Parameter(
 *         name="username",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\Parameter(
 *         name="password",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"consumer_number", "tran_auth_id", "transaction_amount", "bank_mnemonic"},
 *             @OA\Property(property="consumer_number", type="string", example="0152001123456"),
 *             @OA\Property(property="tran_auth_id", type="string", example="123456"),
 *             @OA\Property(property="transaction_amount", type="number", example=5000),
 *             @OA\Property(property="bank_mnemonic", type="string", example="KPY"),
 *             @OA\Property(property="reserved", type="string", example="")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Payment Success"
 *     ),
 *
 *     @OA\Response(
 *         response=400,
 *         description="Invalid Request"
 *     ),
 *
 *     @OA\Response(
 *         response=500,
 *         description="Processing Failed"
 *     )
 * )
 */

    public function billPayment(Request $request)
    {
        // 1. Security & Validation Check
        if (!$this->isAuthorized($request)) {
            return response()->json([
                'response_Code' => '04',
                'message' => 'Invalid Data/Credentials'
            ], 400);
        }

        if (!$this->bankMnemonicIsValid($request)) {
            return response()->json([
                'response_Code' => '04',
                'message' => 'Invalid Data'
            ], 400);
        }

        // 2. Fetch input parameters
        $consumerNumber = $request->input('consumer_number');
        $tranAuthId     = $request->input('tran_auth_id');
        $amountPaid     = $request->input('transaction_amount');
        $bankMnemonic   = $request->input('bank_mnemonic') ?? null;




        if (!preg_match('/^\d{6}$/', (string) $tranAuthId)) {
            return response()->json([
                'response_Code' => '04',
                'message' => 'tran_auth_id should be limited to 6 numeric digits only.'
            ], 400);
        }

        $normalizedAmount = Voucher::normalizeTransactionAmount($amountPaid);
        if ($normalizedAmount === null) {
            return response()->json([
                'response_Code' => '04',
                'message' => 'transaction_amount should support up to 12 digits with 2 decimal places.'
            ], 400);
        }



        // Start monitoring operations
        DB::beginTransaction();

        try {
            // 3. Voucher search karna
            $voucher = Voucher::where('consumer_number', $consumerNumber)->lockForUpdate()->first();

            // '01' - Voucher number does not exist
            if (!$voucher) {
                DB::rollBack();
                return response()->json(['response_Code' => '01']);
            }

            // '02' - Blocked / Dormant / Inactive (Example condition, adapt to your schema)
            if (isset($voucher->status) && $voucher->status === 'B') {
                DB::rollBack();
                return response()->json(['response_Code' => '02']);
            }

            // '03' - Duplicate / Bad Transaction (Already paid)
            if ($voucher->status === 'P') {
                DB::rollBack();
                return response()->json(['response_Code' => '03']);
            }

            if (!$voucher->paymentAmountMatches($amountPaid)) {
                DB::rollBack();
                return response()->json([
                    'response_Code' => '04',
                    'message' => 'Invalid Data'
                ], 400);
            }

            // 4. Business Logic: Database Update
            $voucher->update([
                'status'        => 'P',
                'tran_auth_id'  => $tranAuthId,
                'date_paid'     => now(),
                'bank_mnemonic' => $bankMnemonic ?? null,
                'payment_ip_address' => request()->ip()
            ]);

            // Commit changes if everything succeeds
            DB::commit();

            // Success Response ('00')
            return response()->json([
                'response_Code'            => '00',
                'Identification_parameter' => $voucher->email ?? 'success@client.com',
                'reserved'                 => $request->input('reserved', '')
            ]);
        } catch (Exception $e) {
            // Something broke unexpectedly (Database down, syntax error, missing field, etc.)
            DB::rollBack();

            // Log the actual error internally for debugging
            Log::error('Bill Payment Processing Failed: ' . $e->getMessage(), [
                'consumer_number' => $consumerNumber,
                'exception' => $e
            ]);

            // '05' - Processing Failed response according to your specification document
            return response()->json([
                'response_Code' => '05',
                'message' => 'Processing Failed'
            ], 500);
        }
    }
}
