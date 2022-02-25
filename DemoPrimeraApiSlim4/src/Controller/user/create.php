<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Exception\UserException;
use App\Helper\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class create extends Base
{
    public function __invoke(Request $request, Response $response): Response {

        $input= (array) $request->getParsedBody();  
       
        $user = $this->getUserService()->createUser($input);

        return JsonResponse::withJson($response, (string) json_encode($user));
    }
}