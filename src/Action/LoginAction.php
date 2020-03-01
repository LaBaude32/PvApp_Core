<?php

namespace App\Action;

use DateTime;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use UnexpectedValueException;
use App\Domain\Token\Data\TokenData;
use App\Domain\User\Service\UserGetter;
use App\Domain\User\Data\UserCreateData;
use App\Domain\Token\Service\TokenGetter;
use App\Domain\Token\Service\TokenCreator;
use App\Domain\Token\Service\TokenDeletor;

final class LoginAction
{
    private $userGetter;
    protected $tokenGetter;
    protected $tokenDeletor;
    protected $tokenCreator;

    public function __construct(UserGetter $userGetter, TokenGetter $tokenGetter, TokenDeletor $tokenDeletor, TokenCreator $tokenCreator)
    {
        $this->userGetter = $userGetter;
        $this->tokenGetter = $tokenGetter;
        $this->tokenDeletor = $tokenDeletor;
        $this->tokenCreator = $tokenCreator;
    }

    public function __invoke(ServerRequest $request, Response $response): Response
    {
        // Collect input from the HTTP request
        $data = (array) $request->getParsedBody();

        // Mapping (should be done in a mapper class)
        $userLogged = new UserCreateData();
        $userLogged->email = $data['email'];
        $userLogged->pwd = $data['password'];

        // Invoke the Domain with inputs and retain the result
        $userRegistred = $this->userGetter->identifyUser($userLogged->email);

        if (empty($userRegistred->email)) {
            // throw new UnexpectedValueException("Erreur sur l'email ou le mot de passe");
            $result = [
                'login_result' => 'error',
                'message' => 'Identifiant ou mot de passe incorrect'
            ];
        }

        //Check if user pwd is good
        if ($userLogged->pwd === $userRegistred->pwd) {

            $datas = [
                'userId' => $userRegistred->id_user,
                'device' => $data['device']
            ];

            //Check if a token exist
            $token = $this->tokenGetter->getLoggedToken($datas);

            $actualDate = new DateTime();

            $expirationDate = new DateTime($token->expirationDate);

            $expirationDate = $expirationDate->getTimestamp();
            $actualDate = $actualDate->getTimestamp();
            $dateResult =  $expirationDate - $actualDate;

            if (empty($token->token)) {
                //Create a  new one
                $date = new DateTime();
                $date->modify('+24hours');

                $token = new TokenData();
                $token->device = $data['device'];
                $token->expirationDate = $date->format('Y-m-d H:i:s');
                $token->userId = $userRegistred->id_user;
                // Génération automatique du token de 44 valeurs
                $token->token = bin2hex(openssl_random_pseudo_bytes(22));

                // Invoke the Domain with inputs and retain the result
                $this->tokenCreator->createToken($token);
                $newToken = $this->tokenGetter->getTokenById($token->token);
                $tokenToReturn = $newToken;
            } elseif ($dateResult < 0) {

                $this->tokenDeletor->deleteToken($token->token);

                //Create a  new one
                $date = new DateTime();
                $date->modify('+24hours');

                $token = new TokenData();
                $token->device = $data['device'];
                $token->expirationDate = $date->format('Y-m-d H:i:s');
                $token->userId = $userRegistred->id_user;
                // Génération automatique du token de 44 valeurs
                $token->token = bin2hex(openssl_random_pseudo_bytes(22));

                // Invoke the Domain with inputs and retain the result
                $this->tokenCreator->createToken($token);
                $newToken = $this->tokenGetter->getTokenById($token->token);
                $tokenToReturn = $newToken;
            } elseif (!empty($token->token) && $dateResult > 0) {
                $tokenToReturn = $token;
            } else {
                throw new UnexpectedValueException("Erreur dans la création d'un nouveau token");
            }

            // Transform the result into the JSON representation
            $result = [
                'login_result' => "success",
                'token' => $tokenToReturn->token,
                'user_id' => $tokenToReturn->userId
            ];
        } else {
            $result = [
                'login_result' => 'error',
                'message' => 'Identifiant ou mot de passe incorrect'
            ];
        }

        // Build the HTTP response
        return $response->withJson($result)->withStatus(201);
    }
}
