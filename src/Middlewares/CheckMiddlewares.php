<?php

namespace Api\Middlewares;

use Api\Resources\HttpHelpers;
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;

class CheckMiddlewares
{
    /** @var HttpHelpers $httpHelps */
    protected $httpHelps;

    function __construct() {
        $this->httpHelps = new HttpHelpers();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $next
     *
     * @return mixed
     */
    public function __invoke(
        Request $request,
        Response $response,
        $next
    ) {
        if (empty($request->getQueryParam('q'))) {
            return $this->httpHelps->createNotFoundView($response);
        }

        return $next($request, $response);
    }
}