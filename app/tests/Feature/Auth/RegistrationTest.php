<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use App\Repositories\Admin\PlanRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function init() {
        $planRep = new PlanRepository();
        $plan = $planRep->create(['name' => 'Test 1', 'price' => 0]);
        session()->put('plan',$plan);
        return $plan;
    }

    public function test_registration_screen_can_be_rendered()
    {
        $this->init();

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $plan = $this->init();

        $response = $this->post('/register', [
            'plan_id' => $plan->id,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'tenantname' => 'Tenant Test',
            'cnpj' => '0101010101010',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
