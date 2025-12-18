<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Produto\Produto;
use App\Domain\Produto\ProdutoRepository;
use App\Models\Product;

class EloquentProdutoRepository implements ProdutoRepository
{
    public function buscar(array $filters = []): array
    {
        $query = Product::query();

        // Filtro por categoria
        if (isset($filters['category'])) {
            $query->where('category', 'like', '%' . $filters['category'] . '%');
        }

        // Filtro por tamanho
        if (isset($filters['size'])) {
            $query->where('size', $filters['size']);
        }

        // Filtro por estação
        if (isset($filters['station'])) {
            $query->where('station', 'like', '%' . $filters['station'] . '%');
        }

        // Filtro por preço mínimo
        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        // Filtro por preço máximo
        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        $products = $query->get();

        return $products->map(function ($product) {
            return $this->toDomain($product);
        })->toArray();
    }

    public function buscarPorId(int $id): ?Produto
    {
        $product = Product::find($id);

        if (!$product) {
            return null;
        }

        return $this->toDomain($product);
    }

    private function toDomain(Product $product): Produto
    {
        return new Produto(
            id: $product->id,
            urlImg: $product->url_img,
            name: $product->name,
            category: $product->category,
            size: $product->size,
            price: (float) $product->price,
            station: $product->station,
        );
    }
}
