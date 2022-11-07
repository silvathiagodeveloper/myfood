<?php

namespace Tests\Feature\Admin;

use App\Repositories\Admin\ACL\ProfilePermissionRepository;
use App\Repositories\Admin\PermissionRepository;
use App\Repositories\Admin\ProfileRepository;
use Database\Seeders\Admin\ProfileSeeder;
use Database\Seeders\DatabaseSeeder;
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
        $seeds = $this->init();
        $response = $this->call('GET', 'admin/profiles/'.$seeds['profile1']->id.'/permissions');
        $response->assertStatus(200);    
        $response->assertViewHas('permissions');
        $permissions = $response->original['permissions'];
        $this->assertEquals(2, count($permissions));
    }

    public function test_profiles()
    {
        $seeds = $this->init();
        $response = $this->call('GET', 'admin/permissions/'.$seeds['permission1']->id.'/profiles');
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(2, count($profiles));
    }

    public function test_searchPermissions()
    {
        $seeds = $this->init();
        $response = $this->call('POST', 'admin/profiles/'.$seeds['profile1']->id.'/permissions/search',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('permissions');
        $permissions = $response->original['permissions'];
        $this->assertEquals(1, count($permissions));
    }

    public function test_searchProfiles()
    {
        $seeds = $this->init();
        $response = $this->call('POST', 'admin/permissions/'.$seeds['permission1']->id.'/profiles/search',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(1, count($profiles));
    }

    public function test_permissionsAvailable()
    {
        $seeds = $this->init();
        $response = $this->call('GET', 'admin/profiles/'.$seeds['profile1']->id.'/permissions/create');
        $response->assertStatus(200);    
        $response->assertViewHas('permissions');
        $permissions = $response->original['permissions'];
        $this->assertEquals(1, count($permissions));
    }

    public function test_permissionsAvailableFilter()
    {
        $seeds = $this->init();
        $response = $this->call('GET', 'admin/profiles/'.$seeds['profile1']->id.'/permissions/create',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('permissions');
        $permissions = $response->original['permissions'];
        $this->assertEquals(0, count($permissions));
    }

    public function test_permissionsAttach()
    {
        $seeds = $this->init();
        $response = $this->call(
            'POST', 
            'admin/profiles/'.$seeds['profile1']->id.'/permissions',
            ['permissions' => [$seeds['permission3']->id]]
        );
        $response->assertStatus(302);    
        $response->assertRedirect('admin/profiles/'.$seeds['profile1']->id.'/permissions');
    }

    public function test_permissionsDetach()
    {
        $seeds = $this->init();
        $response = $this->call(
            'GET', 
            'admin/profiles/'.$seeds['profile1']->id.'/permissions/'.$seeds['permission1']->id.'/detach'
        );
        $response->assertStatus(302);    
        $response->assertRedirect('admin/profiles/'.$seeds['profile1']->id.'/permissions');
    }
}