<?php
namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Site\Service\LoginService;
use Site\Helper\RegisterHelper;
use Site\Filter\LoginFilter;
use Site\Filter\RegisterFilter;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class LoginController extends AbstractActionController
{
    protected $LoginService;
    protected $RegisterHelper;
    protected $LoginFilter;
    protected $RegisterFilter;

    public function __construct(
        LoginService $loginService,
        RegisterHelper $registerHelper,
        LoginFilter $loginFilter,
        RegisterFilter $registerFilter
    ) {
        $this->LoginService = $loginService;
        $this->RegisterHelper = $registerHelper;
        $this->LoginFilter = $loginFilter;
        $this->RegisterFilter = $registerFilter;
    }

    public function displayAction()
    {
        if (!$this->LoginService->checkLoginStatus()) {
            $template = $this->params()->fromRoute('template', NULL);
            $viewTemplate = $this->params()->fromRoute('view_template', NULL);
    
            $this->layout($template);
    
            $viewModel = new ViewModel(array(
                'redirect' => $this->params()->fromQuery('redir'),
            ));
            $viewModel->setTemplate($viewTemplate);
    
            return $viewModel;
        }

        // Already logged in
        return $this->redirect()->toRoute('home');
    }

    public function authAction()
    {
        $success = 0;
        $errors = array();

        $data = $this->params()->fromPost();
        $this->LoginFilter->setData($data);
        if ($this->LoginFilter->isValid()) {
            $login = $this->LoginService->login($this->LoginFilter->getValues());
            $success = $login['success'];
            $errors = $login['errors'];
        } else {
            $success = 0;
            $errors = $this->LoginFilter->getMessages();
        }

        return new JsonModel(array(
            'success' => $success,
            'errors'  => $errors
        ));
    }

    public function logoutAction()
    {
        $this->LoginService->logout();
        return $this->redirect()->toRoute('home');
    }

    public function registerAction()
    {
        $success = 0;
        $errors = array();

        $data = $this->params()->fromPost();
        $this->RegisterFilter->setData($data);
        if ($this->RegisterFilter->isValid()) {
            $register = $this->RegisterHelper->register($this->RegisterFilter->getValues());
            $success = $register['success'];
            $errors = $register['errors'];
        } else {
            $success = 0;
            $errors = $this->RegisterFilter->getMessages();
        }

        return new JsonModel(array(
            'success' => $success,
            'errors'  => $errors
        ));
    }
}
