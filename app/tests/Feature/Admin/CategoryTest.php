<?php

namespace Tests\Feature\Admin;

use App\Models\Admin\Category;
use App\Models\User;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    private function init(User $user) : array
    {
        session()->put(['user' => $user]);
        $result = [];
        $categoryRep = new CategoryRepository();
        $result['category2'] = $categoryRep->create(['name' => 'Test 2']);
        $result['category1'] = $categoryRep->create(['name' => 'Test 1']);
        $result['category3'] = $categoryRep->create(['name' => 'Test 3']);
        $result['category4'] = $categoryRep->create(['name' => 'Outro']);
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
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('GET', 'admin/categories');
        $response->assertStatus(200);    
        $response->assertViewHas('categories');
        $categories = $response->original['categories'];
        $this->assertEquals(6, count($categories));       
    }

    public function test_search()
    {
        $user = $this->auth();
        $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('POST', 'admin/categories/search', ['filter' => 'Test']);
        $response->assertStatus(200);    
        $response->assertViewHas('categories');
        $categories = $response->original['categories'];
        $this->assertEquals(3, count($categories));
    }

    public function test_create()
    {
        $user = $this->auth();
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('GET', 'admin/categories/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.categories.create');
    }

    public function test_store() 
    {
        $user = $this->auth();
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('POST', 'admin/categories', ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/categories');
    }

    public function test_show() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('get', 'admin/categories/'.$seeds['category1']->url);
        $response->assertStatus(200);    
        $response->assertViewHas('category');
        $category = $response->original['category'];
        $this->assertEquals('Test 1', $category['name']);
    }

    public function test_destroy() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('DELETE', "admin/categories/".$seeds['category1']->id);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/categories');
    }

    public function test_edit() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('get', 'admin/categories/'.$seeds['category1']->url.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.categories.edit');
    }

    public function test_update() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('PUT', "admin/categories/".$seeds['category1']->id, ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/categories');
    }
}