<?php

namespace Tests\Feature\Admin;

use App\Repositories\Admin\DetailPlanRepository;
use App\Repositories\Admin\PlanRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanDetailTest extends TestCase
{
    use RefreshDatabase;

    private function init() : array
    {
        $result = [];
        $planRep = new PlanRepository();
        $detailPlanRep = new DetailPlanRepository();
        $result['plan1'] = $planRep->create(['name' => 'Test 1', 'price' => 0]);
        $result['plan2'] = $planRep->create(['name' => 'Outro', 'price' => 0]);
        $result['detail1'] = $detailPlanRep->create([
            'plan_id' => $result['plan1']->id, 
            'name' => 'Detail 1']);
        $result['detail2'] = $detailPlanRep->create([
            'plan_id' => $result['plan1']->id, 
            'name' => 'Detail 2']);
        return $result;
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_index()
    {
        $seeds = $this->init();
        $response = $this->call('GET', 'admin/plans/'.$seeds['plan1']->url.'/details');
        $response->assertStatus(200);    
        $response->assertViewHas('details');
        $details = $response->original['details'];
        $this->assertEquals(2, count($details));       
    }

    public function test_search()
    {
        $seeds = $this->init();
        $response = $this->call('POST', 'admin/plans/'.$seeds['plan1']->url.'/search', ['filter' => 'Detail 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('details');
        $details = $response->original['details'];
        $this->assertEquals(1, count($details));
    }

    public function test_create()
    {
        $seeds = $this->init();
        $response = $this->call('GET', 'admin/plans/'.$seeds['plan1']->url.'/details/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.plans.details.create');
    }

    public function test_store() 
    {
        $seeds = $this->init();
        $response = $this->call('POST', 'admin/plans/'.$seeds['plan1']->url.'/details', ['name' => 'Detail']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans/'.$seeds['plan1']->url.'/details');
    }

    public function test_show() 
    {
        $seeds = $this->init();
        $response = $this->call('get', 'admin/plans/test1/details/'.$seeds['detail1']->id);
        $response->assertStatus(200);    
        $response->assertViewHas('detail');
        $detail = $response->original['detail'];
        $this->assertEquals($seeds['detail1']->name, $detail['name']);
    }

    public function test_destroy() 
    {
        $seeds = $this->init();
        $response = $this->call('DELETE', 'admin/plans/'.$seeds['plan1']->url.'/details/'.$seeds['detail1']->id);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans/'.$seeds['plan1']->url.'/details');
    }

    public function test_edit() 
    {
        $seeds = $this->init();
        $response = $this->call('get', 'admin/plans/'.$seeds['plan1']->url.'/details/'.$seeds['detail1']->id.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.plans.details.edit');
    }

    public function test_update() 
    {
        $seeds = $this->init();
        $response = $this->call('PUT', 'admin/plans/'.$seeds['plan1']->url.'/details/'.$seeds['detail1']->id, ['name' => 'Test', 'price' => 5]);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans/'.$seeds['plan1']->url.'/details');
    }
}