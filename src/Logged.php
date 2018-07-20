<?php

namespace Mouf\Security;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TheCodingMachine\Splash\Filters\FilterInterface;

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
class Logged implements FilterInterface
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
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler, ContainerInterface $container): ResponseInterface
    {
        /* @var UnauthorizedMiddlewareInterface $middleware */
        $middleware = $container->get($this->middlewareName);
        return $middleware->process($request, $handler);
    }
}
