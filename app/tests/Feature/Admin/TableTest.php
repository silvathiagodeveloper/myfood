<?php

namespace Tests\Feature\Admin;

use App\Models\Admin\Table;
use App\Models\User;
use App\Repositories\Admin\TableRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TableTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    private function init(User $user) : array
    {
        session()->put(['user' => $user]);
        $result = [];
        $tableRep = new TableRepository();
        $result['table1'] = $tableRep->create(['name' => 'Test 1']);
        $result['table2'] = $tableRep->create(['name' => 'Test 2']);
        $result['table3'] = $tableRep->create(['name' => 'Test 3']);
        $result['table4'] = $tableRep->create(['name' => 'Outro']);
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
        Table::factory(10)->create(['tenant_id' => $user->tenant_id]);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('GET', 'admin/tables');
        $response->assertStatus(200);    
        $response->assertViewHas('tables');
        $tables = $response->original['tables'];
        $this->assertEquals(6, count($tables));       
    }

    public function test_search()
    {
        $user = $this->auth();
        $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('POST', 'admin/tables/search', ['filter' => 'Test']);
        $response->assertStatus(200);    
        $response->assertViewHas('tables');
        $tables = $response->original['tables'];
        $this->assertEquals(3, count($tables));
    }

    public function test_create()
    {
        $user = $this->auth();
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('GET', 'admin/tables/create');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.tables.create');
    }

    public function test_store() 
    {
        $user = $this->auth();
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('POST', 'admin/tables', ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/tables');
    }

    public function test_show() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('get', 'admin/tables/'.$seeds['table1']->url);
        $response->assertStatus(200);    
        $response->assertViewHas('table');
        $table = $response->original['table'];
        $this->assertEquals('Test 1', $table['name']);
    }

    public function test_destroy() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('DELETE', "admin/tables/".$seeds['table1']->id);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/tables');
    }

    public function test_edit() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('get', 'admin/tables/'.$seeds['table1']->url.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.tables.edit');
    }

    public function test_update() 
    {
        $user = $this->auth();
        $seeds = $this->init($user);
        $response = $this->actingAs($user)
                         ->withSession(['user' => $user])
                         ->call('PUT', "admin/tables/".$seeds['table1']->id, ['name' => 'Test']);
        $response->assertStatus(302);    
        $response->assertRedirect('admin/tables');
    }
}