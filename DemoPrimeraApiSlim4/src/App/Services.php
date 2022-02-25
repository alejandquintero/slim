<?php

declare(strict_types=1);

$container['user_service'] = static function (Pimple\Container $container): App\Service\userService {
    return new App\Service\userService($container['user_repository']);
};