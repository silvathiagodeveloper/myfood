<?php

namespace Tests\Feature\Admin\ACL;

use App\Repositories\Admin\ACL\ProfilePermissionRepository;
use App\Repositories\Admin\PermissionRepository;
use App\Repositories\Admin\ProfileRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePermissionTest extends TestCase
{
    use RefreshDatabase;

    private function init() : array
    {
        $result = [];
        $profileRep = new ProfileRepository();
        $permissionRep = new PermissionRepository();
        $profilepermissionRep = new ProfilePermissionRepository();
        $result['profile1'] = $profileRep->create(['name' => 'Test 1']);
        $result['profile2'] = $profileRep->create(['name' => 'Test 2']);
        $result['profile3'] = $profileRep->create(['name' => 'Test 3']);
        $result['permission1'] = $permissionRep->create(['name' => 'Test 1']);
        $result['permission2'] = $permissionRep->create(['name' => 'Test 2']);
        $result['permission3'] = $permissionRep->create(['name' => 'Test 3']);
        $profilepermissionRep->attachPermissions($result['profile1']->id, [$result['permission1']->id,$result['permission2']->id]);
        $profilepermissionRep->attachPermissions($result['profile2']->id, [$result['permission1']->id,$result['permission2']->id]);
        return $result;
    }

    public function test_permissions()
    {
        $user = $this->auth();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('GET', 'admin/profiles/'.$seeds['profile1']->id.'/permissions');
        $response->assertStatus(200);    
        $response->assertViewHas('permissions');
        $permissions = $response->original['permissions'];
        $this->assertEquals(2, count($permissions));
    }

    public function test_profiles()
    {
        $user = $this->auth();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('GET', 'admin/permissions/'.$seeds['permission1']->id.'/profiles');
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(2, count($profiles));
    }

    public function test_searchPermissions()
    {
        $user = $this->auth();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('POST', 'admin/profiles/'.$seeds['profile1']->id.'/permissions/search',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('permissions');
        $permissions = $response->original['permissions'];
        $this->assertEquals(1, count($permissions));
    }

    public function test_searchProfiles()
    {
        $user = $this->auth();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('POST', 'admin/permissions/'.$seeds['permission1']->id.'/profiles/search',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(1, count($profiles));
    }

    public function test_permissionsAvailable()
    {
        $user = $this->auth();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('GET', 'admin/profiles/'.$seeds['profile1']->id.'/permissions/create');
        $response->assertStatus(200);    
        $response->assertViewHas('permissions');
        $permissions = $response->original['permissions'];
        $this->assertEquals(1, count($permissions));
    }

    public function test_permissionsAvailableFilter()
    {
        $user = $this->auth();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('GET', 'admin/profiles/'.$seeds['profile1']->id.'/permissions/create',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('permissions');
        $permissions = $response->original['permissions'];
        $this->assertEquals(0, count($permissions));
    }

    public function test_permissionsAttach()
    {
        $user = $this->auth();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call(
            'POST', 
            'admin/profiles/'.$seeds['profile1']->id.'/permissions',
            ['permissions' => [$seeds['permission3']->id]]
        );
        $response->assertStatus(302);    
        $response->assertRedirect('admin/profiles/'.$seeds['profile1']->id.'/permissions');
    }

    public function test_permissionsDetach()
    {
        $user = $this->auth();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call(
            'GET', 
            'admin/profiles/'.$seeds['profile1']->id.'/permissions/'.$seeds['permission1']->id.'/detach'
        );
        $response->assertStatus(302);    
        $response->assertRedirect('admin/profiles/'.$seeds['profile1']->id.'/permissions');
    }
}