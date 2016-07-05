<?php

namespace Mouf\Security\DI;

use Interop\Container\ContainerInterface;
use Interop\Container\ServiceProvider;
use Mouf\Security\Controllers\LoginController;
use Mouf\Security\UnauthorizedMiddleware;
use Mouf\Security\UserService\UserServiceInterface;

class UnauthorizedMiddlewareProvider implements ServiceProvider
{
    /**
     * Returns a list of all container entries registered by this service provider.
     *
     * - the key is the entry name
     * - the value is a callable that will return the entry, aka the **factory**
     *
     * Factories have the following signature:
     *        function(ContainerInterface $container, callable $getPrevious = null)
     *
     * About factories parameters:
     *
     * - the container (instance of `Interop\Container\ContainerInterface`)
     * - a callable that returns the previous entry if overriding a previous entry, or `null` if not
     *
     * @return callable[]
     */
    public function getServices()
    {
        return [
            UnauthorizedMiddleware::class => function (ContainerInterface $container) {
                return new UnauthorizedMiddleware($container->get(UserServiceInterface::class), $container->get(LoginController::class));
            },
        ];
    }
}
