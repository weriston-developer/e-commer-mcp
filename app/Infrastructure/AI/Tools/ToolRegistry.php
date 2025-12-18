<?php

namespace App\Infrastructure\AI\Tools;

class ToolRegistry
{
    /**
     * @var array<Tool>
     */
    private array $tools = [];

    public function register(Tool $tool): void
    {
        $this->tools[$tool->getName()] = $tool;
    }

    /**
     * @return array<Tool>
     */
    public function getAll(): array
    {
        return array_values($this->tools);
    }

    public function get(string $name): ?Tool
    {
        return $this->tools[$name] ?? null;
    }

    /**
     * Retorna todas as ferramentas no formato esperado pela OpenAI
     */
    public function toOpenAIFormat(): array
    {
        return array_map(
            fn(Tool $tool) => $tool->toOpenAIFormat(),
            $this->getAll()
        );
    }
}
