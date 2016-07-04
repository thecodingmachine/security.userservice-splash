<?php

namespace Mouf\Security;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * The @Logged filter should be used to check whether a user is logged or not.
 * It will try to do so by using the "UnauthorizedMidleware::class" instance.
 * 
 * You can pass an additional parameter to overide the name of the instance.
 * For instance: @Logged(midlewareName = "myUnauthorizedMidleware")
 *
 *
 * @Annotation
 * @Attributes({
 *   @Attribute("midlewareName", type = "string"),
 * })
 */
class Logged
{
    /**
     * The value passed to the filter.
     */
    protected $midlewareName;

    /**
     * Logged constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (!isset($values['midlewareName'])) {
            $values['midlewareName'] = UnauthorizedMidleware::class;
        }
        $this->midlewareName = $values['midlewareName'];
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @param ContainerInterface $container
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next, ContainerInterface $container)
    {
        $midlewareName = $container->get($this->midlewareName);

        $response = $midlewareName($request, $response, $next);

        return $response;
    }
}
