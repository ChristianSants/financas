<?php

namespace Tests\Unit\Services;

use App\Models\Categoria;
use App\Models\User;
use App\Repositories\CategoriaRepository;
use App\Services\CategoriaService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class CategoriaServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected CategoriaService $categoriaService;
    protected CategoriaRepository $categoriaRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        // Crie um mock para o CategoriaRepository
        $this->categoriaRepositoryMock = Mockery::mock(CategoriaRepository::class);

        // Use o mock no serviço
        $this->categoriaService = new CategoriaService($this->categoriaRepositoryMock);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // Feche o mock após cada teste
        Mockery::close();
    }

    /**
     * @test
     */
    public function listCategorias(): void
    {
        // Simule um usuário autenticado
        $this->actingAs(User::factory()->create());

        // Configure o mock para retornar uma coleção simulada
        $this->categoriaRepositoryMock
                ->shouldReceive('listByUser')
                ->andReturn(Categoria::factory()->count(5)->create());

        // Obtenha a lista de categorias usando o serviço
        $categorias = $this->categoriaService->list();

        // Verifique se o resultado é uma instância de Collection
        $this->assertInstanceOf(Collection::class, $categorias);

        // Verifique se o número de categorias corresponde ao número simulado
        $this->assertEquals(5, $categorias->count());
    }

    /**
     * @test
     */
    public function testFindCategoria(): void
    {
        $this->actingAs($user = User::factory()->create());

        $categoria = Categoria::factory()->for($user)->create();

        $this->categoriaRepositoryMock
            ->shouldReceive('find')
            ->with($categoria->id)
            ->andReturn($categoria);

        $result = $this->categoriaService->find($categoria->id);

        $this->assertInstanceOf(Categoria::class, $result);
        $this->assertEquals($categoria->id, $result->id);
    }

    /**
     * @test
     */
    public function testCreateCategoria(): void
    {
        $this->actingAs($user = User::factory()->create());

        $categoriaData = [
            'nome' => 'Nova Categoria',
            'descricao' => 'Descrição da nova categoria',
            'status' => 1,
            'user_id' => $user->id
        ];

        $this->categoriaRepositoryMock
            ->shouldReceive('create')
            ->with($categoriaData)
            ->andReturn(Categoria::factory()->create($categoriaData));

        $result = $this->categoriaService->create(new Request($categoriaData));

        $this->assertInstanceOf(Categoria::class, $result);
        $this->assertEquals($user->id, $result->user_id);
    }

    /**
     * @test
     */
    public function testUpdateCategoria(): void
    {
        $this->actingAs($user = User::factory()->create());

        $categoria = Categoria::factory()->for($user)->create();

        $categoriaData = [
            'nome' => 'Categoria Atualizada',
            'descricao' => 'Nova descrição',
            'status' => 0,
        ];

        $this->categoriaRepositoryMock
            ->shouldReceive('find')
            ->with($categoria->id)
            ->andReturn($categoria);

        $this->categoriaRepositoryMock
            ->shouldReceive('update')
            ->with($categoria->id, $categoriaData)
            ->andReturn(true);

        $result = $this->categoriaService->update($categoria->id, new Request($categoriaData));

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function testDeleteCategoria(): void
    {
        $this->actingAs($user = User::factory()->create());

        $categoria = Categoria::factory()->for($user)->create();

        $this->categoriaRepositoryMock
            ->shouldReceive('find')
            ->with($categoria->id)
            ->andReturn($categoria);

        $this->categoriaRepositoryMock
            ->shouldReceive('delete')
            ->with($categoria->id)
            ->andReturn(true);

        $result = $this->categoriaService->delete($categoria->id);

        $this->assertTrue($result);
    }


}
