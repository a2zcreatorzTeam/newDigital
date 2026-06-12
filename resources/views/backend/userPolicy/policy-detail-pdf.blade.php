<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f4f6f9;
            font-size: 12px;
            color: #212529;
            margin: 0;
            padding: 20px;
        }

        .profile-card {
            background: #fff;
            border: 1px solid #ddd;
        }

        .profile-header {
            background: #0d47a1;
            color: #fff;
            padding: 20px;
        }

        .profile-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .profile-header p {
            margin-top: 5px;
            font-size: 12px;
        }

        .badge-status {
            margin-top: 10px;
            display: inline-block;
            background: #d4edda;
            color: #155724;
            padding: 5px 12px;
            font-size: 11px;
            border-radius: 20px;
        }

        .content {
            padding: 20px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #0d47a1;
            border-left: 4px solid #0d47a1;
            padding-left: 10px;
            margin-bottom: 15px;
            margin-top: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            width: 50%;
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: top;
        }

        .detail-label {
            font-size: 11px;
            color: #6c757d;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 13px;
            font-weight: bold;
        }

        .summary-table td {
            text-align: center;
        }

        .summary-title {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 18px;
            color: #0d47a1;
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #ccc;
            margin: 25px 0;
        }
    </style>
</head>

<body>

    <div class="profile-card">

        <div class="profile-header">
            <h2>Policy Detail</h2>
            <p>Complete information of policy holder and insurance profile</p>
        </div>

        <div class="content">

            {{-- POLICY SUMMARY --}}
            <table class="summary-table">

                <tr>
                    <td>
                        <div class="summary-title">Policy Number</div>
                        <div class="summary-value">{{ $data->policy_id ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="summary-title">Plan Name</div>
                        <div class="summary-value">{{ $data->product->name ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="summary-title">Sum Assured</div>
                        <div class="summary-value">{{ $data->sum_assured ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="summary-title">Policy Term</div>
                        <div class="summary-value">{{ $data->term ?? '---' }} Years</div>
                    </td>
                </tr>

            </table>

            {{-- PERSONAL INFORMATION --}}
            <div class="section-title">
                Personal Information
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Life Proposed Full Name</div>
                        <div class="detail-value">{{ $data->life_proposed_full_name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Mobile Number Personal</div>
                        <div class="detail-value">{{ $data->mobile_number ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">CNIC / B-FORM NO</div>
                        <div class="detail-value">{{ $data->cnic_number ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">CNIC Issue Date</div>
                        <div class="detail-value">{{ $data->cnic_issue_date ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">CNIC Expiry Date</div>
                        <div class="detail-value">{{ $data->cnic_expiry_date ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Date Of Birth</div>
                        <div class="detail-value">{{ $data->date_of_birth ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Age Nearest Birth-date</div>
                        <div class="detail-value">{{ $data->age_nearest_date ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Gender</div>
                        <div class="detail-value">{{ $data->gender ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Mother Maiden Name</div>
                        <div class="detail-value">{{ $data->mother_maiden_name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Father Name</div>
                        <div class="detail-value">{{ $data->father_name ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Husband Name</div>
                        <div class="detail-value">{{ $data->husband_name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Religion</div>
                        <div class="detail-value">{{ $data->religion ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Email Address</div>
                        <div class="detail-value">{{ $data->user_email ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Age Proof</div>
                        <div class="detail-value">{{ $data->age_proof ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Phone Number Office</div>
                        <div class="detail-value">{{ $data->phone_number_office ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Phone Number Residential</div>
                        <div class="detail-value">{{ $data->phone_number_residente ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Fax No</div>
                        <div class="detail-value">{{ $data->fax_number ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Dual National</div>
                        <div class="detail-value">{{ $data->is_client_dual_national ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Primary Nationality</div>
                        <div class="detail-value">{{ $data->primary_nationality ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Dual Nationality</div>
                        <div class="detail-value">{{ $data->dual_nationality ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Birth Place</div>
                        <div class="detail-value">{{ $data->birth_placed ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Proposer Same Person</div>
                        <div class="detail-value">{{ $data->is_same_person ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- POLICY INFORMATION --}}
            <div class="section-title">
                Policy Information
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Policy Status</div>
                        <div class="detail-value ">
                            <!-- Status Badge -->
                            <span style="
                                padding:4px 11px;
                                border-radius:30px;
                                font-size:11px;
                                font-weight:600;
                                letter-spacing:0.5px;
                                background-color:
                                            {{ $data->status == 'Approved' ? '#95f0b8' : 
                                            ($data->status == 'Pending' ? '#cdeaff' : 
                                            ($data->status == 'Rejected' ? '#f1c2c7' :
                                            ($data->status == 'InCart' ? '#f6ca90' : '#edf19e'))) }};
                            ">
                                {{ $data->status ?? '---' }}
                            </span>
                        </div>
                    </td>

                    <td>
                        <div class="detail-label">Table</div>
                        <div class="detail-value">{{ $data->table_no ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Term</div>
                        <div class="detail-value">{{ $data->term ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Sum Assured</div>
                        <div class="detail-value">{{ $data->sum_assured ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">IS ND APPLIED</div>
                        <div class="detail-value">{{ $data->is_nd_applied ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Payment Mode</div>
                        <div class="detail-value">{{ $data->payment_mode ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Automatic Paid-Up</div>
                        <div class="detail-value">{{ $data->automatic_paid_up ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Automatic Premium Loan</div>
                        <div class="detail-value">{{ $data->automatic_premium_loan ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Accidental Death & Indemnity Benefit (AIB)</div>
                        <div class="detail-value">{{ $data->aib_rider ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Accidental Death Benefit (ADB)</div>
                        <div class="detail-value">{{ $data->adb_rider ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Term Insurance Rider (TIR)</div>
                        <div class="detail-value">{{ $data->tir_rider ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Family Income Benefit (FIB)</div>
                        <div class="detail-value">{{ $data->fib_rider ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- ADDRESS INFORMATION --}}
            <div class="section-title">
                Address Information
            </div>

            <table>
                <tr>
                    <td colspan="2"> Permanent Address</td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">Province</div>
                        <div class="detail-value">{{ $data->get_permanent_province->name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">City</div>
                        <div class="detail-value">{{ $data->get_permanent_city->name ?? '---'}}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">District</div>
                        <div class="detail-value">{{ $data->get_permanent_district->name ?? '---'  }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Address</div>
                        <div class="detail-value">{{ $data->permanent_address ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> Correspondence Address</td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">Province</div>
                        <div class="detail-value">{{ $data->get_corres_province->name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">City</div>
                        <div class="detail-value">{{ $data->get_corres_city->name ?? '---'}}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">District</div>
                        <div class="detail-value">{{ $data->get_corres_district->name ?? '---'  }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Address</div>
                        <div class="detail-value">{{ $data->corres_address ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> Temporary Address</td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">Province</div>
                        <div class="detail-value">{{ $data->get_temp_province->name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">City</div>
                        <div class="detail-value">{{ $data->get_temp_city->name ?? '---'}}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">District</div>
                        <div class="detail-value">{{ $data->get_temp_district->name ?? '---'  }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Address</div>
                        <div class="detail-value">{{ $data->temp_address ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- OCCUPATION --}}
            <div class="section-title">
                Occupation & Income
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Employment</div>
                        <div class="detail-value">{{ $data->is_emaployemnt ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Businessman</div>
                        <div class="detail-value">{{ $data->is_business ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Holding Land</div>
                        <div class="detail-value">{{ $data->is_holding_land ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Monthly Income</div>
                        <div class="detail-value">{{ $data->avaerage_monthly_income ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Ex Defence Personal</div>
                        <div class="detail-value">{{ $data->ex_defence_personal ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Medical Discharge</div>
                        <div class="detail-value">{{ $data->discharged_on_medical ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Hazardous Occupation</div>
                        <div class="detail-value">{{ $data->hazardous_occupation ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Comments</div>
                        <div class="detail-value">{{ $data->comment ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- HEALTH INFORMATION --}}
            <div class="section-title">
                Health Information
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Height CM</div>
                        <div class="detail-value">{{ $data->height_cm ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Height FT</div>
                        <div class="detail-value">{{ $data->height_ft ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Weight KG</div>
                        <div class="detail-value">{{ $data->weight_kg ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Chest Insp CM</div>
                        <div class="detail-value">{{ $data->chest_insp_cm ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Chest Insp Inches</div>
                        <div class="detail-value">{{ $data->chest_insp_inches ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Chest Exp CM</div>
                        <div class="detail-value">{{ $data->chest_exp_cm ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Chest Exp Inches</div>
                        <div class="detail-value">{{ $data->chest_exp_inches ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Abdomen CM</div>
                        <div class="detail-value">{{ $data->abdomen_cm ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Abdomen Inches</div>
                        <div class="detail-value">{{ $data->abdomen_inches ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Weight Loss KG</div>
                        <div class="detail-value">{{ $data->weight_loss_kg ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Weight Gain KG</div>
                        <div class="detail-value">{{ $data->weight_gain_kg ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Weight Increase Reason</div>
                        <div class="detail-value">{{ $data->weight_increase_reason ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- Voucher Information --}}
            <div class="section-title">
                Payment Information
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Consumer No</div>
                        <div class="detail-value">{{ $data->voucher->consumer_number ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Amount With In Due Date</div>
                        <div class="detail-value">{{ number_format($data->voucher->amount_within_due_date) ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Amount After Date</div>
                        <div class="detail-value">{{ number_format($data->voucher->amount_after_due_date) ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Due Date</div>
                        <div class="detail-value">{{ $data->voucher->due_date ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- Family History Information --}}
            <div class="section-title">
                Family History Information
            </div>

            @if($data->family_history && $data->family_history->count() > 0)
            @foreach($data->family_history as $member)
            <table style="margin-bottom: 20px;">
                <tr>
                    <th colspan="2" style="text-transform: capitalize; color: #0d6efd; padding-bottom: 8px;">
                        <i class="fas fa-users" style="margin-right: 8px;"></i>{{ $member->memner_flag }}
                    </th>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Current Age</div>
                        <div class="detail-value">{{ $member->age ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">State of Health</div>
                        <div class="detail-value">{{ $member->state_of_health ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Year of Death</div>
                        <div class="detail-value">{{ $member->year_of_death ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Age of Death</div>
                        <div class="detail-value">{{ $member->age_of_death ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Cause of Death</div>
                        <div class="detail-value">{{ $member->cause_of_death ?? '---' }}</div>
                    </td>
                    <td></td>
                </tr>
            </table>
            @endforeach
            @else
            <table>
                <tr>
                    <td colspan="2" style="text-align: center; color: #6c757d; padding: 15px 0;">
                        No family history recorded for this policy.
                    </td>
                </tr>
            </table>
            @endif

        </div>

    </div>

</body>

</html>