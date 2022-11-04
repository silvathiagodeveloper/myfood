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

    private function init() : array
    {
        $result = [];
        $planRep = new PlanRepository();
        $result['plan1'] = $planRep->create(['name' => 'Test 1', 'price' => 0]);
        $result['plan2'] = $planRep->create(['name' => 'Test 2', 'price' => 2]);
        $result['plan3'] = $planRep->create(['name' => 'Test 3', 'price' => 4]);
        $result['plan4'] = $planRep->create(['name' => 'Outro', 'price' => 6]);
        return $result;
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
        $response = $this->call('POST', 'admin/plans/search', ['filter' => 'Test']);
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
        $response = $this->call('POST', 'admin/plans', ['name' => 'Test', 'price' => 5]);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans');
    }

    public function test_show() 
    {
        $seeds = $this->init();
        $response = $this->call('get', 'admin/plans/'.$seeds['plan1']->url);
        $response->assertStatus(200);    
        $response->assertViewHas('plan');
        $plan = $response->original['plan'];
        $this->assertEquals('Test 1', $plan['name']);
    }

    public function test_destroy() 
    {
        $seeds = $this->init();
        $response = $this->call('DELETE', "admin/plans/".$seeds['plan1']->id);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans');
    }

    public function test_edit() 
    {
        $seeds = $this->init();
        $response = $this->call('get', 'admin/plans/'.$seeds['plan1']->url.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.plans.edit');
    }

    public function test_update() 
    {
        $seeds = $this->init();
        $response = $this->call('PUT', "admin/plans/".$seeds['plan1']->id, ['name' => 'Test', 'price' => 5]);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans');
    }
}