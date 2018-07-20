<?php

namespace Mouf\Security;

use Mouf\Security\Controllers\LoginController;
use Mouf\Security\UserService\UserServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UnauthorizedMiddleware implements UnauthorizedMiddlewareInterface
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var LoginController
     */
    private $loginController;

    /**
     * @param TemplateInterface $template     The template used by Splash for displaying error pages (HTTP 400, 404 and 500).
     * @param HtmlBlock         $contentBlock The content block the template will be written into.
     * @param bool              $debugMode    Whether we should display exception stacktrace or not in HTTP 500.
     */
    public function __construct(UserServiceInterface $userService, LoginController $loginController)
    {
        $this->userService = $userService;
        $this->loginController = $loginController;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $is_logged = $this->userService->isLogged();
        if (!$is_logged) {
            $response = $this->loginController->loginPage($request);
            if($response->getStatusCode() === 200) {
                $response->withStatus(401);
            }
            return $response;
        }
        return $handler->handle($request);
    }
}
