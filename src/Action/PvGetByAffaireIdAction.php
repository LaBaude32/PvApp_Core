<?php

namespace App\Action;

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use App\Domain\Pv\Service\PvGetter;

final class PvGetByAffaireIdAction
{
    private $pvGetter;

    public function __construct(PvGetter $pvGetter)
    {
        $this->pvGetter = $pvGetter;
    }

    public function __invoke(ServerRequest $request, Response $response): Response
    {
      // Collect input from the HTTP request
      $data = (array) $request->getParsedBody();

      $id = (int) $data['id_affaire'];
      
      // Invoke the Domain with inputs and retain the result
      $pvs = $this->pvGetter->getPvByAffaireId($id);
      
      // Build the HTTP response
      return $response->withJson($pvs)->withStatus(201);
    }
}