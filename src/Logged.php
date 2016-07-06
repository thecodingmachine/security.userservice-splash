<?php

namespace Mouf\Security;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * The @Logged filter should be used to check whether a user is logged or not.
 * It will try to do so by using the "Unauthorizedmiddleware::class" instance.
 * 
 * You can pass an additional parameter to overide the name of the instance.
 * For instance: @Logged(middlewareName = "myUnauthorizedmiddleware")
 *
 *
 * @Annotation
 * @Attributes({
 *   @Attribute("middlewareName", type = "string"),
 * })
 */
class Logged
{
    /**
     * The value passed to the filter.
     */
    protected $middlewareName;

    /**
     * Logged constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (!isset($values['middlewareName'])) {
            $values['middlewareName'] = UnauthorizedMiddleware::class;
        }
        $this->middlewareName = $values['middlewareName'];
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable               $next
     * @param ContainerInterface     $container
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next, ContainerInterface $container)
    {
        $middlewareName = $container->get($this->middlewareName);

        $response = $middlewareName($request, $response, $next, $container);

        return $response;
    }
}
