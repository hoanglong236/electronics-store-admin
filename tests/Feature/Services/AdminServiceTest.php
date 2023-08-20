<?php

namespace Tests\Feature\Services;

use App;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $setUpEmail;
    private $setUpPassword;
    private $adminService;

    private function setUpCommonBeforeRunningTest()
    {
        $this->setUpEmail = $this->faker()->safeEmail();
        $this->setUpPassword = $this->faker()->password(6, 6);
        $this->adminService = App::make(AdminService::class);

        Log::debug('Setup email: ' . $this->setUpEmail);
    }

    private function setUpCreateAdmin()
    {
        return Admin::factory()->create([
            'email' => $this->setUpEmail,
            'password' => Hash::make($this->setUpPassword),
        ]);
    }

    public function test_admin_should_be_register_ok(): void
    {
        // Setup
        $this->setUpCommonBeforeRunningTest();
        $setUpName = $this->faker()->userName();
        $registerProps = [
            'email' => $this->setUpEmail,
            'name' => $setUpName,
            'password' => $this->setUpPassword
        ];

        // Run
        $this->adminService->register($registerProps);

        // Asserts
        $this->assertDatabaseHas('admins', [
            'email' => $this->setUpEmail,
            'name' => $setUpName
        ]);
    }

    public function test_admin_should_be_login_ok(): void
    {
        // Setup
        $this->setUpCommonBeforeRunningTest();
        $this->setUpCreateAdmin();
        $loginProps = [
            'email' => $this->setUpEmail,
            'password' => $this->setUpPassword
        ];

        // Asserts
        $this->assertTrue($this->adminService->login($loginProps));
    }

    public function test_admin_should_be_logout_ok(): void
    {
        // Setup
        $this->setUpCommonBeforeRunningTest();
        $this->setUpCreateAdmin();
        $loginProps = [
            'email' => $this->setUpEmail,
            'password' => $this->setUpPassword
        ];
        $isLoginSuccess = $this->adminService->login($loginProps);

        // Run
        $this->adminService->logout();

        // Asserts
        $this->assertTrue($isLoginSuccess);
        $this->assertFalse(Auth::guard('admin')->check());
    }
}
