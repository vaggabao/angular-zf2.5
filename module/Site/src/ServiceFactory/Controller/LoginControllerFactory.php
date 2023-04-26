<?php

namespace Site\ServiceFactory\Controller;

use Site\Controller\LoginController;
use Site\Service\LoginService;
use Site\Helper\RegisterHelper;
use Site\Filter\LoginFilter;
use Site\Filter\RegisterFilter;
use Psr\Container\ContainerInterface;

class LoginControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $container = $container->getServiceLocator(); // remove if zf3
        
        $loginService = $container->get(LoginService::class);
        $registerHelper = $container->get(RegisterHelper::class);
        $loginFilter = $container->get(LoginFilter::class);
        $registerFilter = $container->get(RegisterFilter::class);
        
        return new LoginController(
            $loginService,
            $registerHelper,
            $loginFilter,
            $registerFilter
        );
    }
}
