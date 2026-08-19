<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuditSecurityRoutesTest extends TestCase
{
    public function test_guest_cannot_download_admin_policy_pdf(): void
    {
        $this->get('/admin/dashboard/userPolicy/profile/1/download-pdf')
            ->assertRedirect();
    }

    public function test_guest_cannot_open_profile_form(): void
    {
        $this->get('/profile-form')->assertRedirect();
    }

    public function test_guest_cannot_open_voucher_by_numeric_id(): void
    {
        $this->get('/voucher/1')->assertRedirect();
    }

    public function test_public_test_email_route_is_removed(): void
    {
        $this->get('/test-email')->assertNotFound();
    }

    public function test_class_status_toggle_is_not_a_get_route(): void
    {
        $this->get('/admin/dashboard/class/toggleStatus/1')
            ->assertStatus(405);
    }
}
