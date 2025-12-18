<?php

namespace App\Infrastructure\AI;

use Illuminate\Support\Facades\Http;

class OpenAIClient
{
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->model = config('services.openai.model', 'gpt-4-turbo-preview');
    }

    /**
     * Envia uma mensagem para a OpenAI com tools disponíveis
     */
    public function chat(array $messages, array $tools = []): array
    {
        $payload = [
            'model' => $this->model,
            'messages' => $messages,
        ];

        if (!empty($tools)) {
            $payload['tools'] = $tools;
            $payload['tool_choice'] = 'auto';
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', $payload);

        if ($response->failed()) {
            throw new \Exception('Erro ao comunicar com OpenAI: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Processa a resposta da OpenAI e executa tool calls se necessário
     */
    public function processResponse(array $response, ToolRouter $toolRouter): array
    {
        $choice = $response['choices'][0] ?? null;

        if (!$choice) {
            throw new \Exception('Resposta inválida da OpenAI');
        }

        $message = $choice['message'];
        $finishReason = $choice['finish_reason'];

        // Se a OpenAI quer executar uma tool
        if ($finishReason === 'tool_calls' && isset($message['tool_calls'])) {
            return [
                'type' => 'tool_calls',
                'tool_calls' => $message['tool_calls'],
            ];
        }

        // Resposta normal
        return [
            'type' => 'message',
            'content' => $message['content'] ?? '',
        ];
    }
}
