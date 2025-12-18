<?php

namespace App\Infrastructure\AI;

use App\Infrastructure\AI\Tools\ToolRegistry;

class ToolRouter
{
    public function __construct(
        private readonly ToolRegistry $toolRegistry
    ) {}

    /**
     * Executa uma ferramenta pelo nome
     */
    public function execute(string $toolName, array $parameters): mixed
    {
        $tool = $this->toolRegistry->get($toolName);

        if (!$tool) {
            throw new \Exception("Tool '{$toolName}' não encontrada");
        }

        return $tool->execute($parameters);
    }

    /**
     * Retorna todas as ferramentas disponíveis no formato OpenAI
     */
    public function getAvailableTools(): array
    {
        return $this->toolRegistry->toOpenAIFormat();
    }
}
