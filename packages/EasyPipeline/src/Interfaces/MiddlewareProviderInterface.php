<?php
declare(strict_types=1);

namespace EonX\EasyPipeline\Interfaces;

interface MiddlewareProviderInterface
{
    /**
     * Get middleware list, middleware could be anything your container can resolve.
     *
     * @return mixed[]
     */
    public function getMiddlewareList(): array;
}


