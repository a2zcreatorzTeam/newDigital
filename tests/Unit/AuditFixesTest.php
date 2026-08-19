<?php

namespace Tests\Unit;

use App\Http\Requests\PolicyUserDataRequest;
use App\Http\Requests\PolicyUserDataUpdate;
use App\Models\Voucher;
use App\Support\FemaleDiseases;
use ReflectionClass;
use Tests\TestCase;

class AuditFixesTest extends TestCase
{
    public function test_policy_form_requests_do_not_have_validated_trait_collisions(): void
    {
        $this->assertTrue(class_exists(PolicyUserDataRequest::class));
        $this->assertTrue(class_exists(PolicyUserDataUpdate::class));

        $create = new ReflectionClass(PolicyUserDataRequest::class);
        $update = new ReflectionClass(PolicyUserDataUpdate::class);

        $this->assertTrue($create->hasMethod('validated'));
        $this->assertTrue($update->hasMethod('validated'));
        $this->assertSame(PolicyUserDataRequest::class, $create->getMethod('validated')->getDeclaringClass()->getName());
        $this->assertSame(PolicyUserDataUpdate::class, $update->getMethod('validated')->getDeclaringClass()->getName());
    }

    public function test_format_kuickpay_amount_accepts_optional_second_argument(): void
    {
        $formatted = Voucher::formatKuickpayAmount(12.34);
        $withFlag = Voucher::formatKuickpayAmount(12.34, false);

        $this->assertSame('000000001234', $formatted);
        $this->assertSame($formatted, $withFlag);
    }

    public function test_voucher_payment_amount_matches_due_amount(): void
    {
        $voucher = new Voucher();
        $voucher->amount_within_due_date = 5000;
        $voucher->amount_after_due_date = 5150;
        $voucher->due_date = now()->addDays(2)->toDateString();

        $this->assertTrue($voucher->paymentAmountMatches(5000));
        $this->assertTrue($voucher->paymentAmountMatches('5000.00'));
        $this->assertFalse($voucher->paymentAmountMatches(1));
        $this->assertFalse($voucher->paymentAmountMatches(null));
    }

    public function test_female_disease_pack_is_idempotent_for_already_packed_json(): void
    {
        $packed = FemaleDiseases::pack('PCOS', null);
        $unpacked = FemaleDiseases::unpack($packed);

        $this->assertSame('PCOS', $unpacked['name']);
        $this->assertSame($packed, FemaleDiseases::pack($unpacked['name'], $unpacked['details']));
    }
}
