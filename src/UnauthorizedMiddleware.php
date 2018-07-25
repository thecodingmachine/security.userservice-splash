<?php

namespace Mouf\Security;

use Interop\Container\ContainerInterface;
use Mouf\Html\HtmlElement\HtmlBlock;
use Mouf\Html\Template\TemplateInterface;
use Mouf\Security\Controllers\LoginController;
use Mouf\Security\UserService\UserServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UnauthorizedMiddleware
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
     * @param ResponseInterface      $response
     * @param callable               $next
     * @param ContainerInterface     $container
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next, ContainerInterface $container)
    {
        $is_logged = $this->userService->isLogged();
        if (!$is_logged) {
            $response = $this->loginController->loginPage($request);
            if($response->getStatusCode() === 200) {
                $response = $response->withStatus(401);
            }
            return $response;
        }
        $response = $next($request, $response, $next);

        return $response;
    }
}
