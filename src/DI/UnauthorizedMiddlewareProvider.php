<?php

namespace Mouf\Security\DI;

use TheCodingMachine\Funky\Annotations\Factory;
use TheCodingMachine\Funky\ServiceProvider;
use Mouf\Security\Controllers\LoginController;
use Mouf\Security\UnauthorizedMiddleware;
use Mouf\Security\UserService\UserServiceInterface;

class UnauthorizedMiddlewareProvider extends ServiceProvider
{
    /**
     * @Factory()
     */
    public static function createUnauthorizedMiddleware(UserServiceInterface $userService, LoginController $loginController): UnauthorizedMiddleware
    {
        return new UnauthorizedMiddleware($userService, $loginController);
    }
}
