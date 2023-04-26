<?php
namespace Site\ViewHelper;

use Site\Service\LoginService;
use Zend\View\Helper\AbstractHelper;

class HeaderView extends AbstractHelper
{
    protected $LoginService;
    protected $Configuration;

    public function __construct(
        LoginService $loginService,
        $configuration
    ) {
        $this->LoginService = $loginService;
        $this->Configuration = $configuration;
    }

    public function __invoke($template = 'HEADER', $params = array())
    {
        $template = strtoupper($template);

        if ($template == 'HEADER') {
            $params = array(
                'login_status' => $this->LoginService->checkLoginStatus(),
                'customer'     => $this->LoginService->getLoggedInCustomer()
            );
        }

        return $this->getView()->render($template, $params);
    }
}