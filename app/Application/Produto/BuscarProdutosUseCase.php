<?php

namespace App\Application\Produto;

use App\Domain\Produto\ProdutoRepository;

class BuscarProdutosUseCase
{
    public function __construct(
        private readonly ProdutoRepository $produtoRepository
    ) {}

    /**
     * Executa a busca de produtos com filtros
     * 
     * @param array $filters ['category' => string, 'size' => string, 'station' => string, 'min_price' => float, 'max_price' => float]
     * @return array
     */
    public function execute(array $filters = []): array
    {
        $produtos = $this->produtoRepository->buscar($filters);

        return array_map(
            fn($produto) => $produto->toArray(),
            $produtos
        );
    }
}
