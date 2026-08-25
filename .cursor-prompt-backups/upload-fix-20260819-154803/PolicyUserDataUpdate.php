<?php

namespace App\Http\Requests;

use App\Rules\MobileLinkedToCnic;
use App\Support\Concerns\PreparesAgeNearestBirthday;
use App\Support\Concerns\PreparesAppointee;
use App\Support\Concerns\PreparesDualNationality;
use App\Support\Concerns\PreparesFemaleDiseaseHistory;
use App\Support\Concerns\PreparesFilerStatus;
use App\Support\Concerns\PreparesHealthMeasurements;
use App\Support\Concerns\PreparesLifeProposed;
use App\Support\Concerns\PreparesMiscarriageDates;
use App\Models\UserPolicyData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PolicyUserDataUpdate extends FormRequest
{
    use PreparesAgeNearestBirthday;
    use PreparesAppointee;
    use PreparesDualNationality;
    use PreparesFemaleDiseaseHistory;
    use PreparesFilerStatus;
    use PreparesHealthMeasurements;
    use PreparesLifeProposed;
    use PreparesMiscarriageDates;

    /**
     * Authorize user
     */
    public function authorize(): bool
    {
        if (!Auth::check() || (int) Auth::user()->user_type !== 1) {
            return false;
        }

        $id = $this->route('id');
        try {
            $id = decrypt($id);
        } catch (\Throwable) {
            return false;
        }

        return UserPolicyData::query()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->exists();
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        $data = $this->applyFemaleDiseaseValidated($data, $key);

        return $this->exceptHealthMeasurementUiKeys($data, $key);
    }

    protected function prepareForValidation(): void
    {
        $this->mergeAgeNearestBirthday();
        $this->mergeDualNationalityDefaults();
        $this->mergeFilerStatusDefaults();
        $this->mergeFemaleDiseaseDefaults();
        $this->mergeMiscarriageDates();
        $this->mergeAppointeeDefaults();
        $this->mergeLifeProposedDefaults();
        $this->mergeConvertedHealthMeasurements();
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            // ===== Address =====
            'permanent_province_id' => 'required|integer',
            'permanent_city_id' => 'required|integer',
            'permanent_district_id' => 'required|integer',
            'permanent_address' => 'required|string|max:255',

            'corres_province_id' => 'required|integer',
            'corres_city_id' => 'required|integer',
            'corres_district_id' => 'required|integer',
            'corres_address' => 'required|string|max:255',

            'temp_province_id' => 'required|integer',
            'temp_city_id' => 'required|integer',
            'temp_district_id' => 'required|integer',
            'temp_address' => 'required|string|max:255',











            // ===== Personal Info =====
            'life_proposed_full_name' => 'required|string|max:100',
            'mobile_number' => ['required', 'string', 'max:20', new MobileLinkedToCnic('cnic_number')],
            'cnic_number' => 'required|string|max:20',
            'cnic_issue_date' => 'nullable|date',
            'cnic_expiry_date' => 'nullable|date|after:cnic_issue_date',
            'date_of_birth' => [
                'required',
                'date',
                'before:today',
                'before_or_equal:' . now('Asia/Karachi')->subYears(18)->toDateString(),
            ],

            'age_nearest_date' => 'required|integer|min:18|max:120',
            'gender' => 'required|in:Male,Female,Other',
            'marital_status' => 'required|in:Married,Unmarried',

            'mother_maiden_name' => 'required|string|max:100',
            'father_name' => 'required|string|max:100',
            'husband_name' => [
                Rule::requiredIf(fn () => $this->input('gender') === 'Female' && $this->input('marital_status') === 'Married'),
                'nullable',
                'string',
                'max:100',
            ],
            'wife_name' => [
                Rule::requiredIf(fn () => $this->input('gender') === 'Male' && $this->input('marital_status') === 'Married'),
                'nullable',
                'string',
                'max:100',
            ],

            'religion' => 'required|string|max:50',
            'user_email' => 'required|email',
            

            // 'cnic_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',

            // ===== Contact =====
            'phone_number_office' => 'nullable|string|max:20',
            'phone_number_residente' => 'nullable|string|max:20',

            // ===== Nationality =====
            ...$this->dualNationalityRules(),

            'birth_place_city_id' => 'required|integer|exists:cities,id',
            'birth_placed' => 'nullable|string|max:100',

            ...$this->lifeProposedRules(),

           
           
           
           
           
            // Occupation start

            'is_emaployemnt' => 'required|in:Yes,No',
            'employment_designation' => 'required_if:is_emaployemnt,Yes|nullable|string|max:255',
            'employment_company_name' => 'required_if:is_emaployemnt,Yes|nullable|string|max:255',



            'is_business' => 'required|in:Yes,No',
            'business_name' => 'required_if:is_business,Yes|nullable|string|max:255',
            'nature_of_business' => 'required_if:is_business,Yes|nullable|string|max:255',

            ...$this->filerStatusRules(),

            // ===== Holding Land =====
            'is_holding_land' => 'required|in:Yes,No',
            'land_unit' => 'required_if:is_holding_land,Yes|nullable|in:Marla,Kanal,Acre,Square Yard,Square Feet,Hectare',
            'total_acreage' => 'required_if:is_holding_land,Yes|nullable|numeric',
            'land_location' => 'required_if:is_holding_land,Yes|nullable|string|max:255',
            'land_type' => 'required_if:is_holding_land,Yes|nullable|in:Agricultural,Commercial,Residential',
            'estimated_land_value' => 'required_if:is_holding_land,Yes|nullable|numeric',


            'avaerage_monthly_income' => 'required|numeric|min:0',

            'ex_defence_personal' => 'required|in:Yes,No',
            'discharged_on_medical' => 'required|in:Yes,No',
            'hazardous_occupation' => 'required|in:Yes,No',

            'comment' => 'nullable|string|max:500',

            // Occupation end


            // ===== Health Info start =====
            ...$this->healthMeasurementUiRules(),
            ...$this->healthMeasurementDbRules(),

            'daily_consumption' => 'required|string|max:255',
            'physical_impairments' => 'nullable|string|max:255',
            'last_illness_injury' => 'required|string|max:255',
            'medical_investigations' => 'required|string|max:255',
            'medical_history' => 'required|string|max:255',

          // ===== Health Info end =====

            // ===== Others =====
            // 'profession' => 'required|integer',
            // 'marital_status' => 'required|integer',
            // 'city' => 'required|integer',


            // ===== Product Details =====

            // 'plan' => 'required',
            // 'table_no' => 'required',
            // 'term' => 'required',
            // 'sum_assured' => 'required',
            // 'is_nd_applied' => 'required',
            // 'payment_mode' => 'required',
            // remove fields by statelife 
            // 'automatic_paid_up' => 'required',
            // 'automatic_premium_loan' => 'required',
            // 'aib_rider' => 'required',
            // 'adb_rider' => 'required',
            // 'tir_rider' => 'required',
            // 'fib_rider' => 'required',

            // ===== Family History =====
            'father_age' => 'required',
            'mother_age' => 'required',
            'mother_health' => 'required',
            'father_health' => 'required',
            // 'premium_paid' => 'required',




            //    female section


            'date_of_last_delivery' => 'nullable|string|max:255',
            'miscarriage_dates' => 'nullable|string|max:255',
            'is_pregnant' => 'nullable|string|max:255',
            'caesarean_details' => 'nullable|string|max:255',
            'lmp_date' => 'nullable|string|max:255',
            ...$this->femaleDiseaseRules(),
            'self_monthly_income' => 'nullable|string|max:255',
            'husband_monthly_income' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'pays_tax_land_revenue' => 'nullable|string|max:255',
            'husband_policy_no' => 'nullable|string|max:255',
            'husband_zone_company' => 'nullable|string|max:255',
            'husband_sum_assured' => 'nullable|string|max:255',



            ...$this->appointeeRules(),

        //    documents
            ...$this->lifeProposedDocumentRules(false),

            'proposer_cnic_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'proposer_cnic_back' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'nominee_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'proposer_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:4096',
            'income_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',



            
            
            
            
            
            
            













        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [
            // Address
            'premium_paid.required' => 'Kindly First Calculate the Premium Amount.',
            'permanent_province_id.required' => 'Permanent province is required.',
            'permanent_city_id.required' => 'Permanent city is required.',
            'permanent_district_id.required' => 'Permanent district is required.',
            'permanent_address.required' => 'Permanent address cannot be empty.',

            'corres_province_id.required' => 'Correspondence province is required.',
            'corres_city_id.required' => 'Correspondence city is required.',
            'corres_district_id.required' => 'Correspondence district is required.',
            'corres_address.required' => 'Correspondence address is required.',

            'temp_province_id.required' => 'Temporary province is required.',
            'temp_city_id.required' => 'Temporary city is required.',
            'temp_district_id.required' => 'Temporary district is required.',
            'temp_address.required' => 'Temporary address is required.',

            // Personal Info
            'life_proposed_full_name.required' => 'Full name is required.',
            'mobile_number.required' => 'Mobile number is required.',
            'birth_place_city_id.required' => 'Birth place is required.',
            'birth_place_city_id.exists' => 'Please select a valid city from the list.',

            'cnic_expiry_date.after' => 'CNIC expiry date must be after issue date.',

            'date_of_birth.before_or_equal' => 'Proposer must be 18 years or older.',
            'age_nearest_date.required' => 'Age is required and must be valid.',
            'age_nearest_date.min' => 'Proposer must be 18 years or older.',

            // Gender
            'gender.required' => 'Please select gender.',

            // Income
            'avaerage_monthly_income.required' => 'Monthly income is required.',
            'avaerage_monthly_income.numeric' => 'Monthly income must be a number.',

            // Yes/No fields
            'is_client_dual_national.required' => 'Please select dual nationality option.',
            'primary_nationality.required' => 'Primary nationality is required.',
            'primary_nationality.in' => 'Primary nationality must be Pakistani when dual nationality is No.',
            ...$this->dualNationalityMessages(),
            ...$this->filerStatusMessages(),
            ...$this->femaleDiseaseMessages(),
            ...$this->appointeeMessages(),
            ...$this->lifeProposedMessages(),
            'is_emaployemnt.required' => 'Employment status is required.',
            'is_business.required' => 'Business status is required.',

            // Physical
            'height_cm.required' => 'Height (cm) is required.',
            'weight_kg.required' => 'Weight is required.',

            // Email
            'email.email' => 'Please enter a valid email address.',


            'plan.required' => 'Please select a plan to continue.',
            'table_no.required' => 'Please select table number.',
            'term.required' => 'Policy term is required.',
            'sum_assured.required' => 'Please enter sum assured amount.',

            'is_nd_applied.required' => 'Select ND applied option.',
            'payment_mode.required' => 'Please choose payment mode.',

            'automatic_paid_up.required' => 'Select automatic paid up option.',
            'automatic_premium_loan.required' => 'Select premium loan option.',
            'aib_rider.required' => 'Please select Accidental Death & Indemnity Benefit Option.',
            'adb_rider.required' => 'Please select Accidental Death Benefit (ADB) Option.',
            'tir_rider.required' => 'Please select Term Insurance Rider (TIR) Option.',
            'fib_rider.required' => 'Please select Family Income Benefit (FIB) Option.',


            // 'cnic_image.required' => 'Please upload your CNIC copy.',
            // 'cnic_image.image'    => 'The uploaded file must be an image.',
            // 'cnic_image.mimes'    => 'Only JPG, JPEG and PNG images are allowed.',
            // 'cnic_image.max'      => 'The CNIC image size must not exceed 2 MB.',

        ];
    }
}