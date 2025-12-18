<?php

namespace App\Http\Controllers;

use App\Infrastructure\AI\OpenAIClient;
use App\Infrastructure\AI\ToolRouter;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(
        private readonly OpenAIClient $openAIClient,
        private readonly ToolRouter $toolRouter
    ) {}

    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        if (!$userMessage) {
            return response()->json(['error' => 'Mensagem não fornecida'], 400);
        }

        // Histórico de mensagens
        $messages = $request->input('messages', []);
        
        // Adiciona a mensagem do usuário
        $messages[] = [
            'role' => 'user',
            'content' => $userMessage,
        ];

        // System prompt
        if (count($messages) === 1) {
            array_unshift($messages, [
                'role' => 'system',
                'content' => 'Você é um assistente de e-commerce especializado em ajudar clientes a encontrar produtos. Use apenas as ferramentas disponíveis para buscar informações. Não invente filtros ou dados. Se o usuário pedir algo fora das ferramentas disponíveis, explique educadamente a limitação.',
            ]);
        }

        // Obtém as tools disponíveis
        $tools = $this->toolRouter->getAvailableTools();

        try {
            // Primeira chamada à OpenAI
            $response = $this->openAIClient->chat($messages, $tools);
            $processedResponse = $this->openAIClient->processResponse($response, $this->toolRouter);

            // Se a OpenAI quer executar tools
            if ($processedResponse['type'] === 'tool_calls') {
                $toolCalls = $processedResponse['tool_calls'];
                
                // Adiciona a resposta da assistente com tool_calls ao histórico
                $messages[] = [
                    'role' => 'assistant',
                    'content' => null,
                    'tool_calls' => $toolCalls,
                ];

                // Executa cada tool call
                foreach ($toolCalls as $toolCall) {
                    $toolName = $toolCall['function']['name'];
                    $parameters = json_decode($toolCall['function']['arguments'], true);

                    // Executa a tool
                    $toolResult = $this->toolRouter->execute($toolName, $parameters);

                    // Adiciona o resultado ao histórico
                    $messages[] = [
                        'role' => 'tool',
                        'tool_call_id' => $toolCall['id'],
                        'content' => json_encode($toolResult),
                    ];
                }

                // Segunda chamada à OpenAI com os resultados das tools
                $response = $this->openAIClient->chat($messages, $tools);
                $processedResponse = $this->openAIClient->processResponse($response, $this->toolRouter);
            }

            // Adiciona a resposta final ao histórico
            $messages[] = [
                'role' => 'assistant',
                'content' => $processedResponse['content'],
            ];

            // Extrai produtos das tool calls (se houver)
            $produtos = $this->extractProductsFromMessages($messages);

            return response()->json([
                'resposta' => $processedResponse['content'],
                'produtos' => $produtos,
                'messages' => $messages,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao processar sua solicitação: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Extrai produtos das mensagens de tool results
     */
    private function extractProductsFromMessages(array $messages): array
    {
        $produtos = [];

        foreach ($messages as $message) {
            if (isset($message['role']) && $message['role'] === 'tool') {
                try {
                    $content = json_decode($message['content'], true);
                    
                    if (is_array($content)) {
                        foreach ($content as $item) {
                            // Mapeia os campos do modelo Product para o formato esperado pelo frontend
                            if (isset($item['id'])) {
                                $produtos[] = [
                                    'id' => $item['id'],
                                    'nome' => $item['name'] ?? '',
                                    'preco' => $item['price'] ?? 0,
                                    'tamanho' => $item['size'] ?? '',
                                    'imagem_url' => $item['url_img'] ?? '',
                                    'categoria' => $item['category'] ?? '',
                                    'estacao' => $item['station'] ?? '',
                                ];
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // Ignora erros de parsing
                    continue;
                }
            }
        }

        return $produtos;
    }
}
