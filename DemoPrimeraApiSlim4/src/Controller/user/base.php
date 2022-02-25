<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Service\userService;
use Pimple\Psr11\Container;

abstract class Base
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getUserService(): userService
    {
        return $this->container->get('user_service');
    }
}