<?php

namespace Tests\Feature\Services;

use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $adminService;

    private function allTestSetup()
    {
        $this->adminService = app(AdminService::class);
    }

    private function createAdminSetup(array $props)
    {
        return Admin::factory()->create([
            'email' => $props['email'],
            'password' => Hash::make($props['password']),
        ]);
    }

    public function test_it_should_be_registered_as_admin(): void
    {
        // Setup
        $this->allTestSetup();
        $registerProps = [
            'email' => $this->faker->safeEmail(),
            'name' => $this->faker->userName(),
            'password' => $this->faker->password(6, 6)
        ];

        // Run
        $this->adminService->register($registerProps);

        // Asserts
        $this->assertDatabaseHas('admins', [
            'email' => $registerProps['email'],
            'name' => $registerProps['name']
        ]);
    }

    public function test_it_should_be_logged_as_admin(): void
    {
        // Setup
        $this->allTestSetup();
        $loginProps = [
            'email' => $this->faker->safeEmail(),
            'password' => $this->faker->password(6, 6)
        ];
        $this->createAdminSetup($loginProps);

        // Run
        $isLoginSuccess = $this->adminService->login($loginProps);

        // Asserts
        $this->assertTrue($isLoginSuccess);
        $this->assertTrue(Auth::guard('admin')->check());
        $this->assertEquals($loginProps['email'], Auth::guard('admin')->user()->email);
    }

    public function test_it_should_be_logged_out_as_admin(): void
    {
        // Setup
        $this->allTestSetup();
        $loginProps = [
            'email' => $this->faker->safeEmail(),
            'password' => $this->faker->password(6, 6)
        ];
        $this->createAdminSetup($loginProps);
        $isLoginSuccess = $this->adminService->login($loginProps);

        // Run
        $this->adminService->logout();

        // Asserts
        $this->assertTrue($isLoginSuccess);
        $this->assertFalse(Auth::guard('admin')->check());
    }
}
