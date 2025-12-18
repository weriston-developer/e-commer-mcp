<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Produto\ProdutoRepository;
use App\Infrastructure\Persistence\EloquentProdutoRepository;
use App\Infrastructure\AI\Tools\ToolRegistry;
use App\Infrastructure\AI\Tools\BuscarProdutosTool;
use App\Application\Produto\BuscarProdutosUseCase;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind do repositório
        $this->app->bind(ProdutoRepository::class, EloquentProdutoRepository::class);

        // Registra o ToolRegistry como singleton
        $this->app->singleton(ToolRegistry::class, function ($app) {
            $registry = new ToolRegistry();
            
            // Registra as tools disponíveis
            $registry->register(
                new BuscarProdutosTool(
                    $app->make(BuscarProdutosUseCase::class)
                )
            );

            return $registry;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
