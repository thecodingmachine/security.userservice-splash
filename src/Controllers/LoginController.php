<?php

namespace Mouf\Security\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

interface LoginController
{
    /**
     * Displays a login page.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function loginPage(ServerRequestInterface $request) : ResponseInterface;
}
