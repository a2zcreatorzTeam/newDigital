<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KuickpayController extends Controller
{   
    // Credentials jo Kuickpay ke headers ko verify karne ke liye use honge 
    private $apiUser = "Kuickpaytest"; // Replace with Live Username 
    private $apiPass = "Kuickpay@test12"; // Replace with Live Password 

    /**
     * Auth Middleware check alternative (Manual Verification) 
     */
    private function isAuthorized(Request $request)
    {
        return $request->header('username') === $this->apiUser &&
            $request->header('password') === $this->apiPass;
    }

    /**
     * 1. BILL INQUIRY API [cite: 14, 30]
     */
    public function billInquiry(Request $request)
    {
        // Security Check [cite: 34]
        if (!$this->isAuthorized($request)) {
            return response()->json(['response_Code' => '04', 'message' => 'Invalid Data/Credentials'], 400); // [cite: 85, 140]
        }

        $consumerNumber = $request->input('consumer_number'); // [cite: 40]

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
            'consumer Detail'       => str_pad($voucher->customer_name, 30, ' ', STR_PAD_RIGHT), // Left justified, right padded [cite: 85]
            'bill_status'           => $voucher->status, // U or P [cite: 85]
            'due_date'              => Carbon::parse($voucher->due_date)->format('Ymd'), // yyyyMMdd [cite: 91]
            'amount_within_dueDate' => Voucher::formatKuickpayAmount($voucher->amount_within_due_date, true), // [cite: 91]
            'amount_after_dueDate'  => Voucher::formatKuickpayAmount($voucher->amount_after_due_date, true), // [cite: 91]
            'email_address'         => str_pad($voucher->email ?? 'example@gmail.com', 30, ' '), // [cite: 91]
            'contact_number'        => $voucher->contact_number ?? '923000000000', // [cite: 95]
            'billing_month'         => $voucher->billing_month, // [cite: 95]
            'date_paid'             => $voucher->status === 'P' ? Carbon::parse($voucher->date_paid)->format('Ymd') : '', // [cite: 95]
            'amount_paid'           => $voucher->status === 'P' ? Voucher::formatKuickpayAmount($voucher->amount_within_due_date, false) : '', // [cite: 95]
            'tran_auth_Id'          => $voucher->tran_auth_id ?? '', // [cite: 95]
            'reserved'              => $request->input('reserved', '') // [cite: 42]
        ];

        return response()->json($response);
    }

    /**
     * 2. BILL PAYMENT API [cite: 15, 110]
     */
    public function billPayment(Request $request)
    {
        // Security Check [cite: 114]
        if (!$this->isAuthorized($request)) {
            return response()->json(['response_Code' => '04', 'message' => 'Invalid Data/Credentials'], 400); // [cite: 137, 140]
        }

        $consumerNumber = $request->input('consumer_number'); // [cite: 120]
        $tranAuthId = $request->input('tran_auth_id'); // [cite: 121]
        $amountPaid = $request->input('transaction_amount'); // [cite: 122]
        $bankMnemonic = $request->input('bank mnemonic'); // [cite: 125]

        // Voucher search karna
        $voucher = Voucher::where('consumer_number', $consumerNumber)->first();

        if (!$voucher) {
            return response()->json(['response_Code' => '01']); // Not found [cite: 137, 140]
        }

        // Agar pehle se hi paid ho [cite: 137, 140]
        if ($voucher->status === 'P') {
            return response()->json(['response_Code' => '03']); // Duplicate/Bad Transaction [cite: 137, 140]
        }

        // Business Logic: Database Update karke Paid mark karna
        $voucher->update([
            'status'        => 'P', // Paid [cite: 66, 85]
            'tran_auth_id'  => $tranAuthId, // [cite: 105]
            'date_paid'     => Carbon::now(),
            'bank_mnemonic' => $bankMnemonic // [cite: 105]
        ]);

        // Success Response according to document page 10 [cite: 127]
        return response()->json([
            'response_Code'            => '00', // [cite: 130, 137]
            'Identification_parameter' => $voucher->email ?? 'success@client.com', // [cite: 131]
            'reserved'                 => $request->input('reserved', '') // [cite: 132]
        ]);
    }
}
