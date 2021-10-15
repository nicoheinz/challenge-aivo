<?php

namespace Api\Services;

use GuzzleHttp\Client;
use Api\Resources\HttpHelpers;

class Spotify {

    /** @var Client $client */
    protected $client;

    /** @var HttpHelpers  $httpHelps */
    protected $httpHelps;

    /** @var string $clientId */
    protected $clientId;

    /** @var string $clientSecret */
    protected $clientSecret;

    function __construct() {
        $this->client = new Client([
            "verify" => false
        ]);

        $this->httpHelps = new HttpHelpers();
        $this->clientId = "Agregar tu cliente id";
        $this->clientSecret = "Agregar tu secreto del cliente";
    }

    /**
     * @return null|string
     */
    function getToken(): ?string
    {
        $url = 'https://accounts.spotify.com/api/token';

        $headers = [
            "Content-Type" => "application/x-www-form-urlencoded",
            "Authorization" => "Basic " . base64_encode($this->clientId . ':' . $this->clientSecret)
        ];

        $body = 'grant_type=client_credentials';

        $response = $this->client->post($url, [
            "headers" => $headers,
            "body" => $body
        ]);

        if ($response->getStatusCode() > 200) {
            return null;
        }

        $data = $this->httpHelps->getJsonObjectFromResponse($response);

        return $data->access_token;
    }

    /**
     * @param string $token
     * @param string $name
     *
     * @return null|string
     */
    function getArtist(
        string $token,
        string $name
    ): ?string {
        $url = 'https://api.spotify.com/v1/search?q=' . $name . '&type=artist';

        $headers = [
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . $token
        ];

        $response = $this->client->get($url, [
            "headers" => $headers
        ]);

        $data = $this->httpHelps->getJsonObjectFromResponse($response);

        foreach ($data->artists->items as $artist) {
            if ($artist->name === $name) {
                return $artist->id;
            }
        }

        return null;
    }

    /**
     * @param string $token
     * @param string $id
     *
     * @return array
     */
    function getArtistsAlbums(
        string $token,
        string $id
    ): array {
        $url = 'https://api.spotify.com/v1/artists/' . $id . '/albums';

        $headers = [
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . $token
        ];

        $response = $this->client->get($url, [
            "headers" => $headers
        ]);

        $data = $this->httpHelps->getJsonObjectFromResponse($response);

        $albums = [];

        foreach ($data->items as $album) {
            $albums[] = [
                "name" => $album->name,
                "released" => $album->release_date,
                "tracks" => $album->total_tracks,
                "cover" => $album->images
            ];
        }

        return $albums;
    }
}