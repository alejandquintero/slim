<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Exception\UserException;
use App\Helper\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class delete extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response {
      
        $user = $this->getUserService()->delete((int) $args['id']);

        return JsonResponse::withJson($response, 'Usuario eliminado correctamente', 204);
    }
}