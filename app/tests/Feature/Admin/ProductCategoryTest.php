<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Repositories\Admin\ProductCategoryRepository;
use App\Repositories\Admin\ProductRepository;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    use RefreshDatabase;

    private function init(User $user) : array
    {
        session()->put(['user' => $user]);
        $result = [];
        $productRep = new ProductRepository();
        $categoryRep = new CategoryRepository();
        $productCategoryRep = new ProductCategoryRepository();
        $result['product1'] = $productRep->create(['name' => 'Test 1', 'price' => 0, 'description' => 'Test 1 d']);
        $result['product2'] = $productRep->create(['name' => 'Test 2', 'price' => 2, 'description' => 'Test 2 d']);
        $result['product3'] = $productRep->create(['name' => 'Test 3', 'price' => 4, 'description' => 'Test 3 d']);
        $result['category1'] = $categoryRep->create(['name' => 'Test 1']);
        $result['category2'] = $categoryRep->create(['name' => 'Test 2']);
        $result['category3'] = $categoryRep->create(['name' => 'Test 3']);
        $productCategoryRep->attachCategories($result['product1']->id, [$result['category1']->id,$result['category2']->id]);
        $productCategoryRep->attachCategories($result['product2']->id, [$result['category1']->id,$result['category2']->id]);
        return $result;
    }

    public function test_categories()
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withsession(['user' => $user])
                         ->call('GET', 'admin/products/'.$seeds['product1']->id.'/categories');
        $response->assertStatus(200);    
        $response->assertViewHas('categories');
        $categories = $response->original['categories'];
        $this->assertEquals(2, count($categories));
    }

    public function test_products()
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withsession(['user' => $user])
                         ->call('GET', 'admin/categories/'.$seeds['category1']->id.'/products');
        $response->assertStatus(200);    
        $response->assertViewHas('products');
        $products = $response->original['products'];
        $this->assertEquals(2, count($products));
    }

    public function test_searchCategories()
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withsession(['user' => $user])
                         ->call('POST', 'admin/products/'.$seeds['product1']->id.'/categories/search',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('categories');
        $categories = $response->original['categories'];
        $this->assertEquals(1, count($categories));
    }

    public function test_searchProducts()
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withsession(['user' => $user])
                         ->call('POST', 'admin/categories/'.$seeds['category1']->id.'/products/search',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('products');
        $products = $response->original['products'];
        $this->assertEquals(1, count($products));
    }

    public function test_categoriesAvailable()
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withsession(['user' => $user])
                         ->call('GET', 'admin/products/'.$seeds['product1']->id.'/categories/create');
        $response->assertStatus(200);    
        $response->assertViewHas('categories');
        $categories = $response->original['categories'];
        $this->assertEquals(1, count($categories));
    }

    public function test_categoriesAvailableFilter()
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withsession(['user' => $user])
                         ->call('GET', 'admin/products/'.$seeds['product1']->id.'/categories/create',['filter' => 'Test 1']);
        $response->assertStatus(200);    
        $response->assertViewHas('categories');
        $categories = $response->original['categories'];
        $this->assertEquals(0, count($categories));
    }

    public function test_categoriesAttach()
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withsession(['user' => $user])
                         ->call(
                            'POST', 
                            'admin/products/'.$seeds['product1']->id.'/categories',
                            ['categories' => [$seeds['category3']->id]]
                        );
        $response->assertStatus(302);    
        $response->assertRedirect('admin/products/'.$seeds['product1']->id.'/categories');
    }

    public function test_categoriesDetach()
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withsession(['user' => $user])
                         ->call(
                            'GET', 
                            'admin/products/'.$seeds['product1']->id.'/categories/'.$seeds['category1']->id.'/detach'
                        );
        $response->assertStatus(302);    
        $response->assertRedirect('admin/products/'.$seeds['product1']->id.'/categories');
    }
}