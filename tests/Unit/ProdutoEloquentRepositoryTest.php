<?php

namespace Tests\Unit;

use App\Models\Produto;
use App\Repositories\Contracts\ProdutoRepositoryInterface;
use App\Repositories\Core\Eloquent\ProdutoEloquentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ProdutoEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ProdutoRepositoryInterface $produtoRepository;


    public function setUp(): void
    {
        parent::setUp();
        $this->produtoRepository = app(ProdutoRepositoryInterface::class);
    }

    public function test_find_all_produtos()
    {
        $this->produtoRepository->create([
            'nome' => 'Produto Exemplo',
            'descricao' => 'Descrição do produto Exemplo',
            'preco' => 10.5,
            'quantidade' => 10,
        ]);

        $this->produtoRepository->create([
            'nome' => 'Produto Exemplo 2',
            'descricao' => 'Descrição do produto Exemplo 2',
            'preco' => 20.5,
            'quantidade' => 20,
        ]);

        $produtos = $this->produtoRepository->findAll();
        $this->assertInstanceOf(Collection::class, $produtos);
        $this->assertCount(2, $produtos);
    }

    public function test_create_produto()
    {
        $data = [
            'nome' => 'Produto Exemplo',
            'descricao' => 'Descrição do produto Exemplo',
            'preco' => 10.5,
            'quantidade' => 10,
        ];

        $produto = $this->produtoRepository->create($data);

        $this->assertEquals($data['nome'], $produto->nome);
        $this->assertEquals($data['descricao'], $produto->descricao);
        $this->assertEquals($data['preco'], $produto->preco);
        $this->assertEquals($data['quantidade'], $produto->quantidade);
    }

    public function test_update_produto()
    {
        $produto = $this->produtoRepository->create([
            'nome' => 'Produto Exemplo',
            'descricao' => 'Descrição do produto Exemplo',
            'preco' => 10.5,
            'quantidade' => 10,
        ]);

        $data = [
            'nome' => 'Produto Exemplo 2',
            'descricao' => 'Descrição do produto Exemplo 2',
            'preco' => 20.5,
            'quantidade' => 20,
        ];

        $updated = $this->produtoRepository->update($produto->id, $data);

        $this->assertEquals($data['nome'], $updated->nome);
        $this->assertEquals($data['descricao'], $updated->descricao);
        $this->assertEquals($data['preco'], $updated->preco);
        $this->assertEquals($data['quantidade'], $updated->quantidade);
    }

    public function test_delete_produto()
    {
        $produto = $this->produtoRepository->create([
            'nome' => 'Produto Exemplo',
            'descricao' => 'Descrição do produto Exemplo',
            'preco' => 10.5,
            'quantidade' => 10,
        ]);

        $this->assertTrue($this->produtoRepository->delete($produto->id));
    }

    public function test_find_produto_by_id()
    {
        $produto = $this->produtoRepository->create([
            'nome' => 'Produto Exemplo',
            'descricao' => 'Descrição do produto Exemplo',
            'preco' => 10.5,
            'quantidade' => 10,
        ]);

        $produto = $this->produtoRepository->findById($produto->id);

        $foundUser = $this->produtoRepository->findById($produto->id);
        $this->assertInstanceOf(Produto::class, $foundUser);
        $this->assertEquals($produto->id, $foundUser->id);
    }

    public function test_find_produto_by_id_when_string_not_is_uuid()
    {
        $this->expectException(QueryException::class);
        $this->produtoRepository->findById('invalid-id');
    }

    public function test_find_produto_by_id_not_found()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->produtoRepository->findById('e79ef090-acc5-4ef6-bc55-b8bcfd68f0b6');
    }

    public function test_if_entity_is_produto()
    {
        $this->assertInstanceOf(Produto::class, new($this->produtoRepository->entity()));
    }
}
