<?php

namespace Tests\Feature\Admin;

use App\Repositories\Admin\ProfileRepository;
use Database\Seeders\Admin\ProfileSeeder;
use Database\Seeders\DatabaseSeeder;
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
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_index()
    {
        (new DatabaseSeeder())->call(ProfileSeeder::class);
        $response = $this->call('GET', 'admin/profiles');
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(6, count($profiles));       
    }

    public function test_search()
    {
        $this->init();
        $response = $this->call('POST', 'admin/profiles/search', ['filter' => 'Test']);
        $response->assertStatus(200);    
        $response->assertViewHas('profiles');
        $profiles = $response->original['profiles'];
        $this->assertEquals(3, count($profiles));
    }

    public function test_create()
    {
        $response = $this->call('GET', 'admin/profiles/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.profiles.create');
    }

    public function test_store() 
    {
        $response = $this->call('POST', 'admin/profiles', ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/profiles');
    }

    public function test_show() 
    {
        $seeds = $this->init();
        $response = $this->call('get', 'admin/profiles/'.$seeds['profile1']->id);
        $response->assertStatus(200);    
        $response->assertViewHas('profile');
        $profile = $response->original['profile'];
        $this->assertEquals('Test 1', $profile['name']);
    }

    public function test_destroy() 
    {
        $seeds = $this->init();
        $response = $this->call('DELETE', "admin/profiles/".$seeds['profile1']->id);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/profiles');
    }

    public function test_edit() 
    {
        $seeds = $this->init();
        $response = $this->call('get', 'admin/profiles/'.$seeds['profile1']->id.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.profiles.edit');
    }

    public function test_update() 
    {
        $seeds = $this->init();
        $response = $this->call('PUT', "admin/profiles/".$seeds['profile1']->id, ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/profiles');
    }
}