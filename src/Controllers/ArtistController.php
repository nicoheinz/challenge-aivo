<?php

namespace Api\Controllers;

use Api\Resources\HttpHelpers;
use Exception;
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Api\Services\Spotify;

class ArtistController {

    /** @var HttpHelpers $httpHelps */
    protected $httpHelps;

    function __construct() {
        $this->httpHelps = new HttpHelpers();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $arg
     *
     * @return Response
     */
    public function index(
        Request $request,
        Response $response,
        $arg
    ): Response {
        try {
            $spotifySdk = new Spotify();
            $token = $spotifySdk->getToken();

            if (empty($token)) {
                return $this->httpHelps->createUnauthorizedView($response);
            }

            $name = $request->getQueryParam('q');

            $artis = $spotifySdk->getArtist($token, $name);
            if (empty($artis)) {
                return $this->httpHelps->createNotFoundView($response);
            }

            $albums = $spotifySdk->getArtistsAlbums($token, $artis);

            return $response->withJson($albums);
        } catch (Exception $e) {
            return $this->httpHelps->createConflictView($response);
        }
    }
}