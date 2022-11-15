<?php

namespace Tests\Feature\Admin;

use App\Models\Admin\Product;
use App\Models\User;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    private function init(User $user) : array
    {
        session()->put(['user' => $user]);
        $result = [];
        $productRep = new ProductRepository();
        $result['product1'] = $productRep->create(['name' => 'Test 1', 'price' => 0, 'description' => 'Test 1 d']);
        $result['product2'] = $productRep->create(['name' => 'Test 2', 'price' => 2, 'description' => 'Test 2 d']);
        $result['product3'] = $productRep->create(['name' => 'Test 3', 'price' => 4, 'description' => 'Test 3 d']);
        $result['product4'] = $productRep->create(['name' => 'Outro', 'price' => 6, 'description' => 'Outro d']);
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
        Product::factory(10)->create(['tenant_id' => $user->tenant_id]);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('GET', 'admin/products');
        $response->assertStatus(200);    
        $response->assertViewHas('products');
        $products = $response->original['products'];
        $this->assertEquals(6, count($products));       
    }

    public function test_search()
    {
        $user = $this->auth();
        $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('POST', 'admin/products/search', ['filter' => 'Test']);
        $response->assertStatus(200);    
        $response->assertViewHas('products');
        $products = $response->original['products'];
        $this->assertEquals(3, count($products));
    }

    public function test_create()
    {
        $user = $this->auth();
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('GET', 'admin/products/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.products.create');
    }

    public function test_store() 
    {
        $user = $this->auth();
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('POST', 'admin/products', ['name' => 'Test', 'price' => 0, 'description' => 'Test d']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/products');
    }

    public function test_show() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('get', 'admin/products/'.$seeds['product1']->url);
        $response->assertStatus(200);    
        $response->assertViewHas('product');
        $product = $response->original['product'];
        $this->assertEquals('Test 1', $product['name']);
    }

    public function test_destroy() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('DELETE', "admin/products/".$seeds['product1']->id);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/products');
    }

    public function test_edit() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('get', 'admin/products/'.$seeds['product1']->url.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.products.edit');
    }

    public function test_update() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('PUT', "admin/products/".$seeds['product1']->id, ['name' => 'Test', 'price' => 0, 'description' => 'Test d']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/products');
    }
}