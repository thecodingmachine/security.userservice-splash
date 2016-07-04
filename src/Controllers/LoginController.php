<?php

namespace Mouf\Security\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

interface LoginController
{
    /**
     * @param string|null       $login
     * @param UriInterface|null $redirect
     *
     * @return ResponseInterface
     */
    public function loginPage(string $login = null, UriInterface $redirect = null) :ResponseInterface;
}
