<?php

namespace App\Infrastructure\AI\Tools;

abstract class Tool
{
    /**
     * Nome da ferramenta
     */
    abstract public function getName(): string;

    /**
     * Descrição da ferramenta
     */
    abstract public function getDescription(): string;

    /**
     * Schema dos parâmetros em formato JSON Schema
     */
    abstract public function getParametersSchema(): array;

    /**
     * Executa a ferramenta com os parâmetros fornecidos
     */
    abstract public function execute(array $parameters): mixed;

    /**
     * Converte a ferramenta para o formato esperado pela OpenAI
     */
    public function toOpenAIFormat(): array
    {
        return [
            'type' => 'function',
            'function' => [
                'name' => $this->getName(),
                'description' => $this->getDescription(),
                'parameters' => $this->getParametersSchema(),
            ],
        ];
    }
}
