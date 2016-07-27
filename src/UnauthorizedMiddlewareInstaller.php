<?php
/*
 * Copyright (c) 2014 David Negrier
 * 
 * See the file LICENSE.txt for copying permission.
 */

namespace Mouf\Security;

use Mouf\Installer\PackageInstallerInterface;
use Mouf\MoufManager;
use Mouf\Actions\InstallUtils;
use Mouf\Html\Renderer\RendererUtils;

/**
 * The installer for Moufpress.
 */
class UnauthorizedMiddlewareInstaller implements PackageInstallerInterface
{
    /**
     * (non-PHPdoc).
     *
     * @see \Mouf\Installer\PackageInstallerInterface::install()
     */
    public static function install(MoufManager $moufManager)
    {
        RendererUtils::createPackageRenderer($moufManager, 'mouf/security.simplelogincontroller');

        $moufManager = MoufManager::getMoufManager();

        // These instances are expected to exist when the installer is run.
        $userService = $moufManager->getInstanceDescriptor('userService');
        
        // Let's create the instances.
        $unauthorizedMiddleWare = InstallUtils::getOrCreateInstance('Mouf\\Security\\UnauthorizedMiddleware', 'Mouf\\Security\\UnauthorizedMiddleware', $moufManager);

        // Let's bind instances together.
        if (!$unauthorizedMiddleWare->getConstructorArgumentProperty('userService')->isValueSet()) {
            $unauthorizedMiddleWare->getConstructorArgumentProperty('userService')->setValue($userService);
        }
        if (!$unauthorizedMiddleWare->getConstructorArgumentProperty('loginController')->isValueSet() && $moufManager->has('simpleLoginController')) {
            $simpleLoginController = $moufManager->getInstanceDescriptor('simpleLoginController');
            $unauthorizedMiddleWare->getConstructorArgumentProperty('loginController')->setValue($simpleLoginController);
        }

        // Let's rewrite the MoufComponents.php file to save the component
        $moufManager->rewriteMouf();
    }
}
