<?php

namespace Api\Resources;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response as Response;

class HttpHelpers {

    /**
     * @param Response $response
     * @param string $message
     *
     * @return Response
     */
    function createNotFoundView(
        Response $response,
        string $message = 'Not Found'
    ): Response {
        return $response->withJson([
            "statusCode" => 404,
            "message" => $message
        ]);
    }

    /**
     * @param Response $response
     * @param string $message
     *
     * @return Response
     */
    function createConflictView(
        Response $response,
        string $message = 'Conflict'
    ): Response {
        return $response->withJson([
            "statusCode" => 409,
            "message" => $message
        ]);
    }

    /**
     * @param Response $response
     * @param string $message
     *
     * @return Response
     */
    function createUnauthorizedView(
        Response $response,
        string $message = 'Unauthorized'
    ): Response {
        return $response->withJson([
            "statusCode" => 401,
            "message" => $message
        ]);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    function getJsonObjectFromResponse(ResponseInterface $response) {
        return json_decode($response->getBody()->getContents());
    }
}