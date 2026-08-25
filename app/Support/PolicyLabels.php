<?php

namespace App\Support;

/**
 * Canonical English + Urdu labels for Policy forms and Policy view screens.
 * Use these keys everywhere in the Policy module for consistent wording.
 */
final class PolicyLabels
{
    /** @var array<string, string> */
    public const MAP = [
        // Sections / tabs
        'address_details' => 'Address Details (پتے کی تفصیلات)',
        'basic_details' => 'Basic Details (بنیادی تفصیلات)',
        'occupation' => 'Occupation (پیشہ)',
        'product_details' => 'Product Details (پروڈکٹ کی تفصیلات)',
        'family_history' => 'Family History (خاندانی تاریخ)',
        'female_section' => 'Female Section (خواتین کا سیکشن)',
        'nominee' => 'Nominee (نامزد)',
        'documents' => 'Documents (دستاویزات)',
        'health_information' => 'Health Information (صحت کی معلومات)',
        'personal_information' => 'Personal Information (ذاتی معلومات)',
        'contact_and_residence' => 'Contact & Residence (رابطہ اور رہائش)',
        'dual_nationality_details' => 'Dual Nationality Details (دوہری شہریت کی تفصیلات)',
        'life_proposed_details' => 'Life Proposed Details (مجوزہ زندگی کی تفصیلات)',
        'appointee_details' => 'Appointee Details (سرپرست کی تفصیلات)',
        'required_documents' => 'Required Documents (ضروری دستاویزات)',
        'medical_documents' => 'Medical Documents (طبی دستاویزات)',
        'other_documents' => 'Other Documents (دیگر دستاویزات)',
        'health_measurements' => 'Health Measurements (صحت کی پیمائش)',
        'health_history' => 'Health History (صحت کی تاریخ)',
        'riders_and_benefits' => 'Riders & Benefits (اضافی فوائد)',
        'tax_and_income' => 'Tax & Income (ٹیکس اور آمدن)',
        'verification' => 'Verification (تصدیق)',
        'female_health' => 'Female Health (خواتین کی صحت)',
        'income_qualification' => 'Income & Qualification (آمدنی اور تعلیم)',
        'husband_insurance' => 'Husband’s Life Insurance (شوہر کی لائف انشورنس)',
        'policy_information' => 'Policy Information (پالیسی کی معلومات)',
        'occupation_income' => 'Occupation & Income (پیشہ اور آمدنی)',
        'payment_information' => 'Payment Information (ادائیگی کی معلومات)',
        'nominee_information' => 'Nominee Information (نامزد کی معلومات)',

        // Policy summary / view
        'policy_number' => 'Policy Number (پالیسی نمبر)',
        'policy_type' => 'Policy Type (پالیسی کی قسم)',
        'policy_holder_name' => 'Policy Holder Name (پالیسی ہولڈر کا نام)',
        'policy_status' => 'Policy Status (پالیسی کی حیثیت)',
        'plan_name' => 'Plan Name (منصوبے کا نام)',
        'policy_plan' => 'Policy Plan (پالیسی پلان)',
        'policy_date' => 'Policy Date (پالیسی کی تاریخ)',
        'policy_term' => 'Policy Term (پالیسی کی میعاد)',
        'submitted_date' => 'Submitted Date (جمع کرانے کی تاریخ)',
        'status' => 'Status (حیثیت)',
        'action' => 'Action (عمل)',
        'user' => 'User (صارف)',
        'user_detail' => 'User Detail (صارف کی تفصیل)',

        // Identity / personal
        'full_name' => 'Full Name (پورا نام)',
        'life_proposed_full_name' => 'Life Proposed Full Name (مجوزہ زندگی کا پورا نام)',
        'life_purposer_full_name' => 'Life Purposer Full Name (لائف پروپوزر کا پورا نام)',
        'father_name' => 'Father Name (والد کا نام)',
        'father_name_of_life_proposed' => 'Father’s Name of Life Proposed (مجوزہ بیمہ کے والد کا نام)',
        'mother_maiden_name' => 'Mother Maiden Name (والدہ کا خاندانی نام)',
        'wife_name' => 'Wife Name of Life Proposed (بیمہ کنندہ کی بیوی کا نام)',
        'husband_name' => 'Husband Name of Life Proposed (بیمہ کنندہ کے شوہر کا نام)',
        'date_of_birth' => 'Date of Birth (تاریخ پیدائش)',
        'place_of_birth' => 'Place of Birth (مقام پیدائش)',
        'age_nearest_birthdate' => 'Age Nearest Birth-date (قریب ترین تاریخ پیدائش کی عمر)',
        'age' => 'Age (عمر)',
        'gender' => 'Gender/Sex (جنس)',
        'marital_status' => 'Marital Status (ازدواجی حیثیت)',
        'religion' => 'Religion (مذہب)',
        'email_address' => 'Email Address (ای میل ایڈریس)',
        'mobile_number' => 'Mobile Number (موبائل نمبر)',
        'mobile_number_personal' => 'Mobile Number Personal (ذاتی موبائل نمبر)',
        'phone_office' => 'Phone Number Office (دفتری فون نمبر)',
        'phone_residential' => 'Phone Number Residential (رہائشی فون نمبر)',
        'cnic' => 'CNIC (قومی شناختی کارڈ نمبر)',
        'cnic_bform' => 'CNIC / B-Form No (شناختی کارڈ / بی فارم نمبر)',
        'cnic_issue_date' => 'CNIC Issue Date (شناختی کارڈ جاری کرنے کی تاریخ)',
        'cnic_expiry_date' => 'CNIC Expiry Date (شناختی کارڈ کی میعاد ختم ہونے کی تاریخ)',
        'nationality' => 'Nationality (قومیت)',
        'primary_nationality' => 'Primary Nationality (قومیت)',
        'country_of_residence' => 'Country of Residence (رہائش کا ملک)',
        'current_address' => 'Current Address (موجودہ پتہ)',
        'is_same_person' => 'Proposer & Life Proposed are same? (کیا تجویز کنندہ اور مجوزہ زندگی ایک ہی شخص ہیں؟)',
        'relationship_with_proposer' => 'Relationship with Proposer (تجویز کنندہ کے ساتھ رشتہ)',

        // Dual nationality
        'is_dual_national' => 'Is Client Dual National? (کیا کلائنٹ دوہری شہریت رکھتا ہے؟)',
        'dual_nationality_country' => 'Dual Nationality Country (دوہری شہریت کا ملک)',
        'tax_tin_number' => 'Tax/TIN Number (ٹیکس / ٹی آئی این نمبر)',
        'dual_mobile_number' => 'Mobile Number (موبائل نمبر)',
        'dual_address' => 'Address (پتہ)',
        'passport_number' => 'Passport Number (پاسپورٹ نمبر)',

        // Address
        'permanent_address' => 'Permanent Address (مستقل پتہ)',
        'correspondence_address' => 'Correspondence Address (رابطے کا پتہ)',
        'temporary_address' => 'Temporary Address (عارضی پتہ)',
        'province' => 'Province (صوبہ)',
        'city' => 'City (شہر)',
        'district' => 'District (ضلع)',
        'address_line' => 'Address Line (پتہ)',

        // Occupation
        'occupation_type' => 'Occupation Type (پیشہ کی نوعیت)',
        'designation' => 'Designation / Job Title (عہدہ / ملازمت کا عنوان)',
        'company_name' => 'Company Name (کمپنی کا نام)',
        'business_name' => 'Business Name (کاروبار کا نام)',
        'nature_of_business' => 'Nature of Business (کاروبار کی نوعیت)',
        'filer_status' => 'Filer Status (فائلر کی حیثیت)',
        'ntn_number' => 'NTN Number (این ٹی این نمبر)',
        'holding_land' => 'If holding Land? (کیا زراعتی زمین ہے؟)',
        'land_unit' => 'Land Unit (زمین کی اکائی)',
        'total_area' => 'Total Area (کل رقبہ)',
        'land_location' => 'Land Location (زمین کا مقام)',
        'land_type' => 'Land Type (زمین کی قسم)',
        'estimated_land_value' => 'Estimated Land Value (زمین کی تخمینی قیمت)',
        'average_monthly_income' => 'Average Monthly Income (اوسط ماہانہ آمدنی)',
        'average_monthly_income_q' => 'What is your average monthly income from all sources? (آپ کی تمام ذرائع سے حاصل کردہ ماہانہ آمدنی کیا ہے؟)',
        'ex_defence' => 'If Defence or Ex-Defence Personal, commercial Airline Flight Crew or plant protection pilot? (کیا آپ دفاعی / سابقہ دفاعی عملہ، کمرشل ایئر لائن فلائٹ کریو یا پودوں کے تحفظ کے پائلٹ ہیں؟)',
        'discharged_medical' => 'Have you ever been discharged on medical grounds? (کیا آپ کبھی طبی بنیادوں پر فارغ کیے گئے ہیں؟)',
        'hazardous_occupation' => 'Are you engaged in hazardous occupation? (کیا آپ خطرناک پیشے سے وابستہ ہیں؟)',
        'comments' => 'Comments (تبصرے)',
        'employment' => 'Employment (ملازمت)',
        'businessman' => 'Businessman (کاروباری)',

        // Product / policy fields
        'table' => 'Table (منصوبہ نمبر)',
        'term' => 'Term (میعاد)',
        'sum_assured' => 'Sum Assured (زرِ بیمہ)',
        'payment_mode' => 'Payment Mode (ادائیگی کا طریقہ)',
        'is_nd_applied' => 'IS ND APPLIED? (YES/NO) (کیا این ڈی لاگو ہے؟)',
        'adb_rider' => 'Accidental Death Benefit (ADB) (حادثاتی موت کے فوائد کا ضمنی معاہدہ)',
        'tir_rider' => 'Term Insurance Rider (TIR) (ٹرم انشورنس رائڈر)',
        'fib_rider' => 'Family Income Benefit (FIB) (خاندانی آمدنی کا ضمنی معاہدہ)',
        'automatic_paid_up' => 'Automatic Paid-Up (خودکار ادا شدہ)',
        'automatic_premium_loan' => 'Automatic Premium Loan (خودکار پریمیم قرض)',
        'aib_rider' => 'Accidental Death & Indemnity Benefit (AIB) (حادثاتی موت و نقصان کا ضمنی معاہدہ)',
        'premium_paid' => 'Premium Paid (ادا شدہ پریمیم)',
        'age_proof' => 'Age Proof (عمر کا ثبوت)',

        // Family
        'father' => 'Father (والد)',
        'mother' => 'Mother (والدہ)',
        'spouse' => 'Spouse (شریک حیات)',
        'brothers' => 'Brothers (بھائی)',
        'sisters' => 'Sisters (بہنیں)',
        'sons' => 'Sons (بیٹے)',
        'daughters' => 'Daughters (بیٹیاں)',
        'state_of_health' => 'State Of Health (صحت کی حالت)',
        'is_member_alive' => 'Is the member alive? (کیا رکن زندہ ہے؟)',
        'is_alive' => 'Is Alive? (کیا زندہ ہے؟)',
        'year_of_death' => 'Year Of Death (وفات کا سال)',
        'age_of_death' => 'Age Of Death (وفات کی عمر)',
        'cause_of_death' => 'Cause Of Death (وفات کی وجہ)',
        'current_age' => 'Current Age (موجودہ عمر)',
        'brother_age' => 'Brother Age (بھائی کی عمر)',
        'sister_age' => 'Sister Age (بہن کی عمر)',
        'son_age' => 'Son Age (بیٹے کی عمر)',
        'daughter_age' => 'Daughter Age (بیٹی کی عمر)',

        // Female
        'date_of_last_delivery' => 'Date of last delivery (آخری ڈیلیوری کی تاریخ)',
        'miscarriage_dates' => 'Date(s) of any miscarriage(s) (اسقاط حمل کی تاریخ/تاریخیں)',
        'are_you_pregnant' => 'Are you pregnant? (کیا آپ حاملہ ہیں؟)',
        'caesarean_details' => 'Date(s) of any caesarean (give reason) (آپریشن سے ہونے والی زچگی کی تاریخیں اور اسباب)',
        'lmp_date' => 'Date of L.M.P. (آخری ایام حیض کی تاریخ)',
        'female_disease_history' => 'Any history of female disease? (کیا آپ نسوانی مرض میں مبتلا رہی ہیں؟)',
        'female_disease' => 'Female disease (نسوانی مرض)',
        'description' => 'Description (تفصیل)',
        'self_monthly_income' => 'Approximate monthly income - Yourself (اندازاً ماہانہ آمدنی - آپ کی اپنی)',
        'husband_monthly_income' => 'Approximate monthly income - Husband (اندازاً ماہانہ آمدنی - شوہر کی)',
        'qualification' => 'Qualification (قابلیت)',
        'tax_paid' => 'Tax Paid (ادا شدہ ٹیکس)',
        'pays_tax_land_revenue' => 'Do you pay Income Tax/Land Revenue (کیا آپ انکم ٹیکس / مالگذاری ادا کرتی ہیں)',

        // Nominee
        'nominee_name' => 'Name of nominee(s) (نامزد کا نام)',
        'nominee_cnic' => 'C.N.I.C. No (Adult) or B-Form No (Minor) (شناختی کارڈ / بی فارم نمبر)',
        'relationship_with_you' => 'Relationship with you (آپ کے ساتھ رشتہ)',
        'appointee_name' => 'Appointee’s Name (نام سرپرست)',
        'appointee_relationship' => 'Appointee’s Relationship (سرپرست کا رشتہ)',
        'appointee_cnic' => 'Appointee’s CNIC (سرپرست کا شناختی کارڈ)',
        'appointee_mobile' => 'Appointee’s Mobile (سرپرست کا موبائل)',

        // Documents
        'proposer_cnic_front' => 'Proposer CNIC Front (شناختی کارڈ فرنٹ)',
        'proposer_cnic_back' => 'Proposer CNIC Back (شناختی کارڈ بیک)',
        'life_proposed_document' => 'Life Proposed CNIC / B-Form Copy (مجوزہ بیمہ کا شناختی کارڈ/بی فارم)',
        'nominee_document' => 'Nominee CNIC / B-Form (نامزد کا شناختی کارڈ/بی فارم)',
        'proposer_photo' => 'Passport Size Photograph (پاسپورٹ سائز تصویر)',
        'income_proof' => 'Proof of Income (آمدنی کا ثبوت)',
        'referred_opd' => 'Referred / OPD Documents (حوالہ / او پی ڈی دستاویزات)',
        'previous_opd' => 'Previous OPD Documents (سابقہ او پی ڈی دستاویزات)',
        'summary_discharge' => 'Summary / Discharge Documents (خلاصہ / ڈسچارج دستاویزات)',
        'present_history' => 'Present / Brief History (موجودہ / مختصر تاریخ)',
        'death_mlc' => 'Death / MLC Documents (وفات / ایم ایل سی دستاویزات)',
        'medicolegal' => 'Medicolegal Documents (میڈیکو لیگل دستاویزات)',
        'other_document' => 'Other Document (دیگر دستاویز)',
        'additional_medical_document' => 'Additional Medical Document (اضافی طبی دستاویز)',

        // Health
        'height' => 'Height (قد)',
        'weight' => 'Weight (وزن)',
        'weight_label' => 'Weight (وزن)',
        'chest_inspiration' => 'Chest Inspiration (سینے کی کشش)',
        'chest_expansion' => 'Chest Expansion (سینے کی توسیع)',
        'abdomen' => 'Abdomen (پیٹ)',
        'weight_change' => 'Weight Change (وزن میں تبدیلی)',
        'expected_weight_gain' => 'Expected Weight Gain (متوقع وزن میں اضافہ)',
        'expected_weight_loss' => 'Expected Weight Loss (متوقع وزن میں کمی)',
        'reason_weight_gain' => 'Reason for Weight Gain (وزن بڑھنے کی وجہ)',
        'reason_weight_loss' => 'Reason for Weight Loss (وزن کم ہونے کی وجہ)',
        'reason_weight_change' => 'Reason for Weight Change (وزن میں تبدیلی کی وجہ)',
        'daily_consumption' => 'State average daily consumption of Tobacco, Pan/Niswar, Alcohol, Drugs (تمباکو، پان/نسوار، الکحل، منشیات کی اوسط یومیہ مقدار)',
        'physical_impairments' => 'State Physical Impairments (if any) (جسمانی معذوریاں، اگر کوئی ہوں)',
        'last_illness_injury' => 'When did illness or injury last keep you away from work? (آخری بار بیماری یا چوٹ نے کب کام سے روکا؟)',
        'medical_investigations' => 'Medical Investigations History (طبی تحقیقات کی تاریخ)',
        'medical_history' => 'Heart Disease, Diabetes, BP, TB, Jaundice, Cancer, Asthma, etc. (دل کی بیماری، ذیابیطس، بلڈ پریشر، ٹی بی، یرقان، کینسر، دمہ وغیرہ)',
        'captcha' => 'Captcha (کیپچا)',
        'height_cm' => 'Height In cm (قد سینٹی میٹر میں)',
        'weight_kg' => 'Weight In kg (وزن کلو گرام میں)',
        'family_history_information' => 'Family History Information (خاندانی تاریخ کی معلومات)',
        'decision_management' => 'Decision Management (فیصلہ جات کا انتظام)',
        'serial_no' => 'No (نمبر)',
        'is_employment' => 'Is Employment? (کیا ملازم ہیں؟)',
        'is_businessman' => 'Is Businessman (کیا کاروباری ہیں؟)',
        'consumer_no' => 'Consumer No (کنزمیر نمبر)',
        'amount_within_due_date' => 'Amount Within Due Date (مقررہ تاریخ تک رقم)',
        'amount_after_due_date' => 'Amount After Due Date (مقررہ تاریخ کے بعد رقم)',
        'due_date' => 'Due Date (مقررہ تاریخ)',
        'brothers_details' => 'Brothers Details (بھائیوں کی تفصیلات)',
        'sisters_details' => 'Sisters Details (بہنوں کی تفصیلات)',
        'sons_details' => 'Sons Details (بیٹوں کی تفصیلات)',
        'daughters_details' => 'Daughters Details (بیٹیوں کی تفصیلات)',
        'nominee_age' => 'Nominee Age (نامزد کی عمر)',
        'husband_policy_no' => 'Husband Policy No. (شوہر کی پالیسی نمبر)',
        'husband_zone_company' => 'Husband Zone / Company (شوہر کا زون / کمپنی)',
        'husband_sum_assured' => 'Husband Sum Assured (شوہر کا زرِ بیمہ)',
        'cnic_image' => 'CNIC Image (شناختی کارڈ تصویر)',
        'height_ft' => 'Height In ft (قد فٹ میں)',
        'address' => 'Address (پتہ)',
    ];

    public static function get(string $key, ?string $fallback = null): string
    {
        if (isset(self::MAP[$key])) {
            return self::MAP[$key];
        }

        return $fallback ?? $key;
    }

    /**
     * @param  array<int, string>  $keys
     * @return array<string, string>
     */
    public static function many(array $keys): array
    {
        $out = [];
        foreach ($keys as $key) {
            $out[$key] = self::get($key);
        }

        return $out;
    }
}
