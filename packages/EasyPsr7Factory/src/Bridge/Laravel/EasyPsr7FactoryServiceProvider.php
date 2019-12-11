<?php
declare(strict_types=1);

namespace EonX\EasyPsr7Factory\Bridge\Laravel;

use Illuminate\Support\ServiceProvider;
use EonX\EasyPsr7Factory\EasyPsr7Factory;
use EonX\EasyPsr7Factory\Interfaces\EasyPsr7FactoryInterface;

final class EasyPsr7FactoryServiceProvider extends ServiceProvider
{
    /**
     * Register EasyEasyPsr7Factory service.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(EasyPsr7FactoryInterface::class, EasyPsr7Factory::class);
    }
}


