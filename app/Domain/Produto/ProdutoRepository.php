<?php

namespace App\Domain\Produto;

interface ProdutoRepository
{
    /**
     * Buscar produtos com filtros opcionais
     * 
     * @param array $filters ['category' => string, 'size' => string, 'station' => string, 'min_price' => float, 'max_price' => float]
     * @return array<Produto>
     */
    public function buscar(array $filters = []): array;

    /**
     * Buscar produto por ID
     */
    public function buscarPorId(int $id): ?Produto;
}
