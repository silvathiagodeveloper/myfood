<?php

namespace Tests\Feature\Admin;

use App\Repositories\Admin\PermissionRepository;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    private function init() : array
    {
        $result = [];
        $permissionRep = new PermissionRepository();
        $result['permission1'] = $permissionRep->create(['name' => 'Test 1']);
        $result['permission2'] = $permissionRep->create(['name' => 'Test 2']);
        $result['permission3'] = $permissionRep->create(['name' => 'Test 3']);
        $result['permission4'] = $permissionRep->create(['name' => 'Outro']);
        return $result;
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_index()
    {
        (new DatabaseSeeder())->call(PermissionSeeder::class);
        $response = $this->call('GET', 'admin/permissions');
        $response->assertStatus(200);    
        $response->assertViewHas('permissions');
        $permissions = $response->original['permissions'];
        $this->assertEquals(6, count($permissions));       
    }

    public function test_search()
    {
        $this->init();
        $response = $this->call('POST', 'admin/permissions/search', ['filter' => 'Test']);
        $response->assertStatus(200);    
        $response->assertViewHas('permissions');
        $permissions = $response->original['permissions'];
        $this->assertEquals(3, count($permissions));
    }

    public function test_create()
    {
        $response = $this->call('GET', 'admin/permissions/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.permissions.create');
    }

    public function test_store() 
    {
        $response = $this->call('POST', 'admin/permissions', ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/permissions');
    }

    public function test_show() 
    {
        $seeds = $this->init();
        $response = $this->call('get', 'admin/permissions/'.$seeds['permission1']->id);
        $response->assertStatus(200);    
        $response->assertViewHas('permission');
        $permission = $response->original['permission'];
        $this->assertEquals('Test 1', $permission['name']);
    }

    public function test_destroy() 
    {
        $seeds = $this->init();
        $response = $this->call('DELETE', "admin/permissions/".$seeds['permission1']->id);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/permissions');
    }

    public function test_edit() 
    {
        $seeds = $this->init();
        $response = $this->call('get', 'admin/permissions/'.$seeds['permission1']->id.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.permissions.edit');
    }

    public function test_update() 
    {
        $seeds = $this->init();
        $response = $this->call('PUT', "admin/permissions/".$seeds['permission1']->id, ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/permissions');
    }
}