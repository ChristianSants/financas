<?php

namespace Tests\Unit\Services;

use App\Models\Categoria;
use App\Models\Lancamento;
use App\Models\User;
use App\Repositories\LancamentoRepository;
use App\Services\LancamentoService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class LancamentoServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected LancamentoService $lancamentoService;
    protected LancamentoRepository $lancamentoRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        // Crie um mock para o LancamentoRepository
        $this->lancamentoRepositoryMock = Mockery::mock(LancamentoRepository::class);

        // Use o mock no serviço
        $this->lancamentoService = new LancamentoService($this->lancamentoRepositoryMock);
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
    public function listLancamentos(): void
    {
        // Simule um usuário autenticado
        $this->actingAs(User::factory()->create());

        // Configure o mock para retornar uma coleção simulada
        $this->lancamentoRepositoryMock
                ->shouldReceive('listByUser')
                ->andReturn(Lancamento::factory()->count(5)->create());

        // Obtenha a lista de lançamentos usando o serviço
        $lancamentos = $this->lancamentoService->list();

        // Verifique se o resultado é uma instância de Collection
        $this->assertInstanceOf(Collection::class, $lancamentos);

        // Verifique se o número de lançamentos corresponde ao número simulado
        $this->assertEquals(5, $lancamentos->count());
    }

    /**
     * @test
     */
    public function testFindLancamento(): void
    {
        $this->actingAs($user = User::factory()->create());

        $lancamento = Lancamento::factory()->for($user)->create();

        $this->lancamentoRepositoryMock
            ->shouldReceive('find')
            ->with($lancamento->id)
            ->andReturn($lancamento);

        $result = $this->lancamentoService->find($lancamento->id);

        $this->assertInstanceOf(Lancamento::class, $result);
        $this->assertEquals($lancamento->id, $result->id);
    }

    /**
     * @test
     */
    public function testCreateLancamento(): void
    {
        $this->actingAs($user = User::factory()->create());

        $lancamentoData = [
            'data' => now(),
            'identificador' => '123456',
            'valor' => 100.00,
            'tipo' => 'C',
            'descricao' => 'Descrição do lançamento',
            'status' => 1,
            'categoria_id' => Categoria::factory()->create(['user_id' => $user->id])->id,
            'user_id' => $user->id,
        ];

        $this->lancamentoRepositoryMock
            ->shouldReceive('create')
            ->with($lancamentoData)
            ->andReturn(Lancamento::factory()->create($lancamentoData));

        $result = $this->lancamentoService->create(new Request($lancamentoData));

        $this->assertInstanceOf(Lancamento::class, $result);
        $this->assertEquals($user->id, $result->user_id);
    }

    /**
     * @test
     */
    public function testUpdateLancamento(): void
    {
        $this->actingAs($user = User::factory()->create());

        $categoria = Categoria::factory()->for($user)->create();
        $lancamento = Lancamento::factory()->for($user)->create(['categoria_id' => $categoria->id]);

        $lancamentoData = [
            'data' => now(),
            'identificador' => '654321',
            'valor' => 150.00,
            'tipo' => 'C',
            'descricao' => 'Nova descrição',
            'status' => 0,
            'categoria_id' => $categoria->getKey(),
        ];

        $this->lancamentoRepositoryMock
            ->shouldReceive('find')
            ->with($lancamento->id)
            ->andReturn($lancamento);

        $this->lancamentoRepositoryMock
            ->shouldReceive('update')
            ->with($lancamento->id, $lancamentoData)
            ->andReturn(true);

        $result = $this->lancamentoService->update($lancamento->id, new Request($lancamentoData));

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function testDeleteLancamento(): void
    {
        $this->actingAs($user = User::factory()->create());

        $lancamento = Lancamento::factory()->for($user)->create();

        $this->lancamentoRepositoryMock
            ->shouldReceive('find')
            ->with($lancamento->id)
            ->andReturn($lancamento);

        $this->lancamentoRepositoryMock
            ->shouldReceive('delete')
            ->with($lancamento->id)
            ->andReturn(true);

        $result = $this->lancamentoService->delete($lancamento->id);

        $this->assertTrue($result);
    }
}
