<?php

namespace App\Http\Controllers;

use App\Exceptions\DefaultErrorException;
use App\Exceptions\UuidFormatInvalidException;
use App\Http\Requests\CreateProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Repositories\Contracts\ProdutoRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class ProdutoController extends Controller
{
    private ProdutoRepositoryInterface $produtoRepository;

    public function __construct(ProdutoRepositoryInterface $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    /**
     * @throws DefaultErrorException
     */
    public function create(CreateProdutoRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $produto = $this->produtoRepository->create($data);

            return response()->json([
                'code' => 201,
                'status' => 'success',
                'message' => 'Produto alterado com sucesso!',
                'data' => $produto,
            ], 201);
        } catch (\Exception $e) {
            throw new DefaultErrorException();
        }
    }

    /**
     * @throws DefaultErrorException
     * @throws UuidFormatInvalidException
     * @throws \App\Exceptions\ModelNotFoundException
     */
    public function update(UpdateProdutoRequest $request, string $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $update = $this->produtoRepository->update($id, $data);

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Produto alterado com sucesso!',
                'data' => $update,
            ]);

        } catch (ModelNotFoundException $e) {
            throw new \App\Exceptions\ModelNotFoundException('Produto');
        } catch (QueryException $e) {
            throw new UuidFormatInvalidException();
        } catch (\Exception $e) {
            throw new DefaultErrorException();
        }
    }

    /**
     * @throws DefaultErrorException
     */
    public function findAll(): JsonResponse
    {
        try {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Produtos encontrados com sucesso!',
                'data' => $this->produtoRepository->findAll(),
            ]);
        } catch (\Exception $e) {
            throw new DefaultErrorException();
        }
    }

    /**
     * @throws DefaultErrorException
     * @throws \App\Exceptions\ModelNotFoundException
     */
    public function findById(string $id): JsonResponse
    {
        try {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Produto encontrado com sucesso!',
                'data' => $this->produtoRepository->findById($id),
            ]);
        } catch (ModelNotFoundException $e) {
            throw new \App\Exceptions\ModelNotFoundException('Produto');
        } catch (\Exception $e) {
            throw new DefaultErrorException();
        }
    }

    /**
     * @throws \App\Exceptions\ModelNotFoundException
     * @throws DefaultErrorException
     */
    public function delete(string $id): JsonResponse
    {
        try {
            $this->produtoRepository->delete($id);

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Produto deletado com sucesso!',
            ]);
        } catch (ModelNotFoundException $e) {
            throw new \App\Exceptions\ModelNotFoundException('Produto');
        } catch (\Exception $e) {
            throw new DefaultErrorException();
        }
    }
}
