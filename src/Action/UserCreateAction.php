<?php

namespace App\Action;

use App\Domain\User\Data\UserCreateData;
use App\Domain\User\Service\UserCreator;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

final class UserCreateAction
{
    private $userCreator;

    public function __construct(UserCreator $userCreator)
    {
        $this->userCreator = $userCreator;
    }

    public function __invoke(ServerRequest $request, Response $response): Response
    {
        // Collect input from the HTTP request
        $data = (array) $request->getParsedBody();

        // Mapping (should be done in a mapper class)
        $user = new UserCreateData();
        $user->email = $data['email'];
        $user->pwd = $data['password'];
        $user->firstName = $data['first_name'];
        $user->lastName = $data['last_name'];
        $user->phone = $data['phone'];
        $user->user_group = $data['user_group'];
        $user->function = $data['function'];
        $user->organism = $data['organism'];

        // Invoke the Domain with inputs and retain the result
        $userId = $this->userCreator->createUser($user);

        // Transform the result into the JSON representation
        $result = [
            'id_user' => $userId
        ];

        // Build the HTTP response
        return $response->withJson($result)->withStatus(201);
    }
}
