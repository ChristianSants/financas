<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoriaTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
    
    /**
     * @test
     */
    public function indexWithSuccess(): void
    {
        $this->actingAs($this->user);

        Categoria::factory()->for($this->user)->count(10)->create();

        $response = $this->get(route('categorias.index'));

        $response->assertStatus(200);

        $this->assertEquals(10, count($response->json('categorias')));
    }

    /**
     * @test
     */
    public function indexWithAnotherUser(): void
    {
        $this->actingAs(User::factory()->create());

        Categoria::factory()->for($this->user)->count(10)->create();

        $response = $this->get(route('categorias.index'));

        $response->assertStatus(200);

        $this->assertEquals(0, count($response->json('categorias')));
    }

    /**
     * @test
     */
    public function findWithSuccess(): void
    {
        $this->actingAs($this->user);

        $categoria = Categoria::factory()->for($this->user)->create();

        $response = $this->get(route('categorias.show', ['categoria' => $categoria->getKey()]));

        $response->assertStatus(200)
                ->assertJson(['categoria' => ['id' => $categoria->id]]);
    }

    /**
     * @test
     */
    public function findWithAnotherUser(): void
    {
        $this->actingAs(User::factory()->create());

        $categoria = Categoria::factory()->for($this->user)->create();

        $response = $this->get(route('categorias.show', ['categoria' => $categoria->getKey()]));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function storeCategoria(): void
    {
        $this->actingAs($this->user);

        $categoriaData = [
            'nome'      => 'Luz',
            'descricao' => "",
            'status'    => 1,
        ];

        $this->assertEquals(0, Categoria::count());

        $response = $this->post(route('categorias.store'), $categoriaData);

        $response->assertStatus(201);

        $this->assertEquals(1, Categoria::count());
    }

    /**
     * @test
     */
    public function updateCategoria(): void
    {
        $this->actingAs($this->user);

        $categoria = Categoria::factory()->for($this->user)->create();

        $categoriaData = [
            'nome'      => 'Nova Luz',
            'descricao' => 'Atualização de descrição',
            'status'    => 1,
        ];

        $response = $this->put(route('categorias.update', ['categoria' => $categoria->getKey()]), $categoriaData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('categorias', [
            'nome' => $categoriaData['nome']
        ]);
    }

    /**
     * @test
     */
    public function updateCategoriaAnotherUser(): void
    {
        $this->actingAs(User::factory()->create());

        $categoria = Categoria::factory()->for($this->user)->create();

        $categoriaData = [
            'nome'      => 'Nova Luz',
            'descricao' => 'Atualização de descrição',
            'status'    => 1,
        ];

        $response = $this->put(route('categorias.update', ['categoria' => $categoria->getKey()]), $categoriaData);
        
        $response->assertStatus(500);

        $this->assertEquals("Categoria do usuário não encontrada!", $response->exception->getMessage());
    }

    /**
     * @test
     */
    public function deleteCategoria(): void
    {
        $this->actingAs($this->user);

        $categoria = Categoria::factory()->for($this->user)->create();

        $response = $this->delete(route('categorias.destroy', ['categoria' => $categoria->getKey()]));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('categorias', ['id' => $categoria->id]);
    }
}
