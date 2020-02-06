<?php

namespace App\Action;

use App\Domain\Affair\Data\AffairCreateData;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use App\Domain\Affair\Service\AffairCreator;

final class AffairCreateAction
{
    private $affairCreator;

    public function __construct(AffairCreator $affairCreator)
    {
        $this->affairCreator = $affairCreator;
    }

    public function __invoke(ServerRequest $request, Response $response): Response
    {
        // Collect input from the HTTP request
        $data = (array) $request->getParsedBody();

        // Mapping (should be done in a mapper class)
        $affair = new AffairCreateData();
        $affair->nom = $data['nom'];
        $affair->adresse = $data['adresse'];
        $affair->avancement = $data['avancement'];
        $affair->type_reu = $data['type_reu'];

        // Invoke the Domain with inputs and retain the result
        $affairId = $this->affairCreator->createAffair($affair);

        // Transform the result into the JSON representation
        $result = [
            'affair_id' => $affairId
        ];

        // Build the HTTP response
        return $response->withJson($result)->withStatus(201);
    }
}