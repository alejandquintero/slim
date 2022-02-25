<?php

declare(strict_types=1);

$container['user_repository'] = static function (Pimple\Container $container): App\Repository\userRepository {
    return new App\Repository\userRepository($container['db']);
};