<?php

namespace Tests\Feature\Admin;

use App\Models\Admin\Profile;
use App\Repositories\Admin\ProfileRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private function init() : array
    {
        $result = [];
        $profileRep = new ProfileRepository();
        $result['profile1'] = $profileRep->create(['name' => 'Test 1']);
        $result['profile2'] = $profileRep->create(['name' => 'Test 2']);
        $result['profile3'] = $profileRep->create(['name' => 'Test 3']);
        $result['profile4'] = $profileRep->create(['name' => 'Outro']);
        return $result;
    }

    public function test_index_error_permission()
    {
        $user = $this->auth();
        Profile::factory(10)->create();
        $response = $this->actingAs($user)->call('GET', 'admin/profiles');
        $response->assertStatus(403);     
    }

    public function test_index()
    {
        $user = $this->authAdmin();
        Profile::factory(10)->create();
        $response = $this->actingAs($user)->call('GET', 'admin/profiles');
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(6, count($profiles));       
    }

    public function test_search()
    {
        $user = $this->authAdmin();
        $this->init();
        $response = $this->actingAs($user)->call('POST', 'admin/profiles/search', ['filter' => 'Test']);
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(3, count($profiles));
    }

    public function test_create()
    {
        $user = $this->authAdmin();
        $response = $this->actingAs($user)->call('GET', 'admin/profiles/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.profiles.create');
    }

    public function test_store() 
    {
        $user = $this->authAdmin();
        $response = $this->actingAs($user)->call('POST', 'admin/profiles', ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/profiles');
    }

    public function test_show() 
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('get', 'admin/profiles/'.$seeds['profile1']->id);
        $response->assertStatus(200);    
        $response->assertViewHas('profile');
        $profile = $response->original['profile'];
        $this->assertEquals('Test 1', $profile['name']);
    }

    public function test_destroy() 
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('DELETE', "admin/profiles/".$seeds['profile1']->id);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/profiles');
    }

    public function test_edit() 
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('get', 'admin/profiles/'.$seeds['profile1']->id.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.profiles.edit');
    }

    public function test_update() 
    {
        $user = $this->authAdmin();
        $seeds = $this->init();
        $response = $this->actingAs($user)->call('PUT', "admin/profiles/".$seeds['profile1']->id, ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/profiles');
    }
}