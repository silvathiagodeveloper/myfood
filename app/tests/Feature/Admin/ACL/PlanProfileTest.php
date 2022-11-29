<?php

namespace Tests\Feature\Admin\ACL;

use App\Repositories\Admin\ACL\PlanProfileRepository;
use App\Repositories\Admin\PlanRepository;
use App\Repositories\Admin\ProfileRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanProfileTest extends TestCase
{
    use RefreshDatabase;

    private function init() : array
    {
        $result = [];
        $planRep = new PlanRepository();
        $profileRep = new ProfileRepository();
        $profilepermissionRep = new PlanProfileRepository();
        $result['plan1'] = $planRep->create(['name' => 'Test 1', 'price' => 1]);
        $result['plan2'] = $planRep->create(['name' => 'Test 2', 'price' => 2]);
        $result['plan3'] = $planRep->create(['name' => 'Test 3', 'price' => 3]);
        $result['profile1'] = $profileRep->create(['name' => 'Test 1']);
        $result['profile2'] = $profileRep->create(['name' => 'Test 2']);
        $result['profile3'] = $profileRep->create(['name' => 'Test 3']);
        $profilepermissionRep->attachProfiles($result['plan1']->id, [$result['profile1']->id,$result['profile2']->id]);
        $profilepermissionRep->attachProfiles($result['plan2']->id, [$result['profile1']->id,$result['profile2']->id]);
        return $result;
    }

    public function test_error_permission()
    {
        $user = $this->auth();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('GET', 'admin/plans/'.$seeds['plan1']->id.'/profiles');
        $response->assertStatus(403);
    }

    public function test_profiles()
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('GET', 'admin/plans/'.$seeds['plan1']->id.'/profiles');
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(2, count($profiles));
    }

    public function test_plans()
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('GET', 'admin/profiles/'.$seeds['profile1']->id.'/plans');
        $response->assertStatus(200);    
        $response->assertViewHas('plans');
        $plans = $response->original['plans'];
        $this->assertEquals(2, count($plans));
    }

    public function test_searchProfiles()
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('POST', 'admin/plans/'.$seeds['plan1']->id.'/profiles/search',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(1, count($profiles));
    }

    public function test_searchPlans()
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('POST', 'admin/profiles/'.$seeds['profile1']->id.'/plans/search',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('plans');
        $plans = $response->original['plans'];
        $this->assertEquals(1, count($plans));
    }

    public function test_profilesAvailable()
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('GET', 'admin/plans/'.$seeds['plan1']->id.'/profiles/create');
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(1, count($profiles));
    }

    public function test_profilesAvailableFilter()
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('GET', 'admin/plans/'.$seeds['plan1']->id.'/profiles/create',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(0, count($profiles));
    }

    public function test_profilesAttach()
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call(
            'POST', 
            'admin/plans/'.$seeds['plan1']->id.'/profiles',
            ['profiles' => [$seeds['profile3']->id]]
        );
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans/'.$seeds['plan1']->id.'/profiles');
    }

    public function test_profilesDetach()
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call(
            'GET', 
            'admin/plans/'.$seeds['plan1']->id.'/profiles/'.$seeds['profile1']->id.'/detach'
        );
        $response->assertStatus(302);    
        $response->assertRedirect('admin/plans/'.$seeds['plan1']->id.'/profiles');
    }
}