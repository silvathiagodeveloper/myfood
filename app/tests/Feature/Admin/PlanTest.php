<?php

namespace Tests\Feature\Admin;

use App\Repositories\Admin\PlanRepository;
use Database\Seeders\Admin\PlanSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanTest extends TestCase
{
    use RefreshDatabase;

    private function init()
    {
        $planRep = new PlanRepository();
        $planRep->create(['name' => 'Teste 1', 'price' => 0]);
        $planRep->create(['name' => 'Teste 2', 'price' => 0]);
        $planRep->create(['name' => 'Teste 3', 'price' => 0]);
        $planRep->create(['name' => 'Outro', 'price' => 0]);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_index()
    {
        (new DatabaseSeeder())->call(PlanSeeder::class);
        $response = $this->call('GET', 'admin/plans');
        $response->assertStatus(200);    
        $response->assertViewHas('plans');
        $plans = $response->original['plans'];
        $this->assertEquals(6, count($plans));       
    }

    public function test_search()
    {
        $this->init();
        $response = $this->call('POST', 'admin/plans/search', ['filter' => 'Teste']);
        $response->assertStatus(200);    
        $response->assertViewHas('plans');
        $plans = $response->original['plans'];
        $this->assertEquals(3, count($plans));
    }

    public function test_create()
    {
        $response = $this->call('GET', 'admin/plans/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.plans.create');
    }

    public function test_store() 
    {
        $response = $this->call('POST', 'admin/plans', ['name' => 'Teste', 'price' => 5]);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans');
    }

    public function test_show() 
    {
        $this->init();
        $response = $this->call('get', 'admin/plans/teste1');
        $response->assertStatus(200);    
        $response->assertViewHas('plan');
        $plan = $response->original['plan'];
        $this->assertEquals('Teste 1', $plan['name']);
    }

    public function test_destroy() 
    {
        $planRep = new PlanRepository();
        $planRep->create(['name' => 'Teste 1', 'price' => 0]);
        $plan = $planRep->getByUrl('teste1');
        $response = $this->call('DELETE', "admin/plans/{$plan->id}");
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans');
    }

    public function test_edit() 
    {
        $this->init();
        $response = $this->call('get', 'admin/plans/teste1/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.plans.edit');
    }

    public function test_update() 
    {
        $planRep = new PlanRepository();
        $planRep->create(['name' => 'Teste 1', 'price' => 0]);
        $plan = $planRep->getByUrl('teste1');
        $response = $this->call('PUT', "admin/plans/{$plan->id}", ['name' => 'Teste', 'price' => 5]);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans');
    }
}