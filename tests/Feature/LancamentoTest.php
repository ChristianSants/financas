<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Lancamento;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LancamentoTest extends TestCase
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

        Lancamento::factory()->for($this->user)->count(10)->create();

        $response = $this->get(route('lancamentos.index'));

        $response->assertStatus(200);

        $this->assertEquals(10, count($response->json('lancamentos')));
    }

    /**
     * @test
     */
    public function indexWithAnotherUser(): void
    {
        $this->actingAs(User::factory()->create());

        Lancamento::factory()->for($this->user)->count(10)->create();

        $response = $this->get(route('lancamentos.index'));

        $response->assertStatus(200);

        $this->assertEquals(0, count($response->json('lancamentos')));
    }

    /**
     * @test
     */
    public function findWithSuccess(): void
    {
        $this->actingAs($this->user);

        $lancamento = Lancamento::factory()->for($this->user)->create();

        $response = $this->get(route('lancamentos.show', ['lancamento' => $lancamento->getKey()]));

        $response->assertStatus(200)
            ->assertJson(['lancamento' => ['id' => $lancamento->id]]);
    }

    /**
     * @test
     */
    public function findWithAnotherUser(): void
    {
        $this->actingAs(User::factory()->create());

        $lancamento = Lancamento::factory()->for($this->user)->create();

        $response = $this->get(route('lancamentos.show', ['lancamento' => $lancamento->getKey()]));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function storeLancamento(): void
    {
        $this->actingAs($this->user);

        $categoria = Categoria::factory()->for($this->user)->create();

        $lancamentoData = [
            'data' => now()->toDateString(),
            'identificador' => 'ABC123',
            'valor' => 100.00,
            'tipo' => 'C',
            'descricao' => 'Descrição do lançamento',
            'status' => 1,
            'categoria_id' => $categoria->id,
        ];

        $this->assertEquals(0, Lancamento::count());

        $response = $this->post(route('lancamentos.store'), $lancamentoData);

        $response->assertStatus(201);

        $this->assertEquals(1, Lancamento::count());
    }

    /**
     * @test
     */
    public function updateLancamento(): void
    {
        $this->actingAs($this->user);

        $categoria = Categoria::factory()->for($this->user)->create();
        $lancamento = Lancamento::factory()->for($this->user)->create(['categoria_id' => $categoria->id]);

        $lancamentoData = [
            'data' => now()->toDateString(),
            'identificador' => 'XYZ456',
            'valor' => 150.00,
            'tipo' => 'D',
            'descricao' => 'Atualização de descrição',
            'status' => 1,
            'categoria_id' => $categoria->id,
        ];

        $response = $this->put(route('lancamentos.update', ['lancamento' => $lancamento->getKey()]), $lancamentoData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('lancamentos', [
            'identificador' => $lancamentoData['identificador']
        ]);
    }

    /**
     * @test
     */
    public function updateLancamentoAnotherUser(): void
    {
        $this->actingAs(User::factory()->create());

        $categoria = Categoria::factory()->for($this->user)->create();
        $lancamento = Lancamento::factory()->for($this->user)->create(['categoria_id' => $categoria->id]);

        $lancamentoData = [
            'data' => now()->toDateString(),
            'identificador' => 'XYZ456',
            'valor' => 150.00,
            'tipo' => 'D',
            'descricao' => 'Atualização de descrição',
            'status' => 1,
            'categoria_id' => $categoria->id,
        ];

        $response = $this->put(route('lancamentos.update', ['lancamento' => $lancamento->getKey()]), $lancamentoData);

        $response->assertStatus(500);

        $this->assertEquals("Lançamento do usuário não encontrado!", $response->exception->getMessage());
    }

    /**
     * @test
     */
    public function deleteLancamento(): void
    {
        $this->actingAs($this->user);

        $categoria = Categoria::factory()->for($this->user)->create();
        $lancamento = Lancamento::factory()->for($this->user)->create(['categoria_id' => $categoria->id]);

        $response = $this->delete(route('lancamentos.destroy', ['lancamento' => $lancamento->getKey()]));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('lancamentos', ['id' => $lancamento->id]);
    }
}
