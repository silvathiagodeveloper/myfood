<?php

namespace Tests\Feature\Admin;

use App\Models\Admin\Category;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    private function init(int $tenant_id) : array
    {
        $result = [];
        $categoryRep = new CategoryRepository();
        $result['category1'] = $categoryRep->create(['name' => 'Test 1', 'tenant_id' => $tenant_id]);
        $result['category2'] = $categoryRep->create(['name' => 'Test 2', 'tenant_id' => $tenant_id]);
        $result['category3'] = $categoryRep->create(['name' => 'Test 3', 'tenant_id' => $tenant_id]);
        $result['category4'] = $categoryRep->create(['name' => 'Outro', 'tenant_id' => $tenant_id]);
        return $result;
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_index()
    {
        $user = $this->auth();
        Category::factory(10)->create(['tenant_id' => $user->tenant_id]);
        $response = $this->actingAs($user)->call('GET', 'admin/categories');
        $response->assertStatus(200);    
        $response->assertViewHas('categories');
        $categories = $response->original['categories'];
        $this->assertEquals(6, count($categories));       
    }

    public function test_search()
    {
        $user = $this->auth();
        $this->init($user->tenant_id);
        $response = $this->actingAs($user)->call('POST', 'admin/categories/search', ['filter' => 'Test']);
        $response->assertStatus(200);    
        $response->assertViewHas('categories');
        $categories = $response->original['categories'];
        $this->assertEquals(3, count($categories));
    }

    public function test_create()
    {
        $user = $this->auth();
        $response = $this->actingAs($user)->call('GET', 'admin/categories/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.categories.create');
    }

    public function test_store() 
    {
        $user = $this->auth();
        $response = $this->actingAs($user)->call('POST', 'admin/categories', ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/categories');
    }

    public function test_show() 
    {
        $user = $this->auth();
        $seeds = $this->init($user->tenant_id);
        $response = $this->actingAs($user)->call('get', 'admin/categories/'.$seeds['category1']->url);
        $response->assertStatus(200);    
        $response->assertViewHas('category');
        $category = $response->original['category'];
        $this->assertEquals('Test 1', $category['name']);
    }

    public function test_destroy() 
    {
        $user = $this->auth();
        $seeds = $this->init($user->tenant_id);
        $response = $this->actingAs($user)->call('DELETE', "admin/categories/".$seeds['category1']->id);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/categories');
    }

    public function test_edit() 
    {
        $user = $this->auth();
        $seeds = $this->init($user->tenant_id);
        $response = $this->actingAs($user)->call('get', 'admin/categories/'.$seeds['category1']->url.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.categories.edit');
    }

    public function test_update() 
    {
        $user = $this->auth();
        $seeds = $this->init($user->tenant_id);
        $response = $this->actingAs($user)->call('PUT', "admin/categories/".$seeds['category1']->id, ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/categories');
    }
}