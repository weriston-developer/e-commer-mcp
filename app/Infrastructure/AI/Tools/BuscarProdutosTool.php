<?php

namespace App\Infrastructure\AI\Tools;

use App\Application\Produto\BuscarProdutosUseCase;

class BuscarProdutosTool extends Tool
{
    public function __construct(
        private readonly BuscarProdutosUseCase $buscarProdutosUseCase
    ) {}

    public function getName(): string
    {
        return 'buscar_produtos';
    }

    public function getDescription(): string
    {
        return 'Busca produtos no catálogo do e-commerce. Pode filtrar por categoria, tamanho, estação e faixa de preço. Use esta ferramenta quando o usuário perguntar sobre produtos disponíveis.';
    }

    public function getParametersSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'category' => [
                    'type' => 'string',
                    'description' => 'Categoria do produto (ex: Camisas, Calças, Vestidos, Jaquetas)',
                ],
                'size' => [
                    'type' => 'string',
                    'description' => 'Tamanho do produto (ex: P, M, G, 40, 42)',
                ],
                'station' => [
                    'type' => 'string',
                    'description' => 'Estação do ano (Verão, Outono, Inverno, Primavera)',
                ],
                'min_price' => [
                    'type' => 'number',
                    'description' => 'Preço mínimo',
                ],
                'max_price' => [
                    'type' => 'number',
                    'description' => 'Preço máximo',
                ],
            ],
            'required' => [],
        ];
    }

    public function execute(array $parameters): mixed
    {
        $filters = [];

        if (isset($parameters['category'])) {
            $filters['category'] = $parameters['category'];
        }

        if (isset($parameters['size'])) {
            $filters['size'] = $parameters['size'];
        }

        if (isset($parameters['station'])) {
            $filters['station'] = $parameters['station'];
        }

        if (isset($parameters['min_price'])) {
            $filters['min_price'] = $parameters['min_price'];
        }

        if (isset($parameters['max_price'])) {
            $filters['max_price'] = $parameters['max_price'];
        }

        return $this->buscarProdutosUseCase->execute($filters);
    }
}
