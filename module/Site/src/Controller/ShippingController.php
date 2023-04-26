<?php
namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Site\Service\LoginService;
use Site\Service\ShippingService;
use Site\Helper\CartHelper;
use Site\Filter\ShippingFilter;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ShippingController extends AbstractActionController
{
    protected $LoginService;
    protected $ShippingService;
    protected $CartHelper;
    protected $ShippingFilter;

    public function __construct(
        LoginService $loginService,
        ShippingService $shippingService,
        CartHelper $cartHelper,
        ShippingFilter $shippingFilter
    ) {
        $this->LoginService = $loginService;
        $this->ShippingService = $shippingService;
        $this->CartHelper = $cartHelper;
        $this->ShippingFilter = $shippingFilter;
    }

    public function displayAction()
    {
        if ($this->LoginService->checkLoginStatus()) {
            $template = $this->params()->fromRoute('template', NULL);
            $viewTemplate = $this->params()->fromRoute('view_template', NULL);

            $this->layout($template);

            $this->CartHelper->associateLogoutCart();
            $cart = $this->CartHelper->getCart();
            $cart['shipping_options'] = array(
                'ground' => $this->ShippingService->getShippingAmount($cart['total_weight'], 'Ground'),
                'expedited' => $this->ShippingService->getShippingAmount($cart['total_weight'], 'Expedited')
            );
            $viewModel = new ViewModel($cart);
            $viewModel->setTemplate($viewTemplate);

            return $viewModel;
        }
        
        // Logged out state
        // Redirect to login
        $this->redirect()->toRoute('login', array(), array(
            'query' => array(
                'redir' => '/shipping'
            )
        ));
    }

    public function saveShippingAction()
    {
        $success = 0;
        $errors = array();

        if ($this->LoginService->checkLoginStatus()) {
            $data = $this->params()->fromPost();
            
            $this->ShippingFilter->setData($data);
            if ($this->ShippingFilter->isValid()) {
                $success = $this->CartHelper->saveShippingDetails($this->ShippingFilter->getValues());
            } else {
                $errors = $this->ShippingFilter->getMessages();
            }
        } else {
            $errors = array(
                'login' => "You are not logged in."
            );
        }

        return new JsonModel(array(
            'success' => $success,
            'errors' => $errors
        ));
    }
}




