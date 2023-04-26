<?php

namespace Site\ServiceFactory\ViewHelper;

use Site\ViewHelper\HeaderView;
use Site\Service\LoginService;
use Psr\Container\ContainerInterface;

class HeaderViewFactory
{
    public function __invoke(ContainerInterface $container)
    {
        if (method_exists($container, 'getServiceLocator')) {
            $container = $container->getServiceLocator() ?: $container;
        }

        $loginService = $container->get(LoginService::class);
        $configuration = $container->get('Site_Config');

        return new HeaderView($loginService, $configuration);
    }
}