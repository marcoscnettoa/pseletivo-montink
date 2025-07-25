<?php
// # MXTera - !! Teste !!
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Configuration\Middleware;

class ListMiddlewareGroups extends Command
{
    protected $signature = 'middleware:groups';
    protected $description = 'Lista todos os grupos de middleware e suas classes associadas';

    public function handle()
    {
        $middlewareConfig = app(\Illuminate\Foundation\Configuration\Middleware::class);
        $groups = $middlewareConfig->getMiddlewareGroups();

        $this->info('Grupos de Middleware Registrados:');
        $this->line('--------------------------------');

        foreach ($groups as $group => $middlewares) {
            $this->info("Grupo: {$group}");
            foreach ($middlewares as $middleware) {
                $this->line("  - {$middleware}");
            }
            $this->line('');
        }
    }
}
