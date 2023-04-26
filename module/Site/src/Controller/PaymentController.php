<?php
namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Site\Service\LoginService;
use Site\Helper\PaymentHelper;
use Site\Helper\CartHelper;
use Zend\View\Model\ViewModel;

class PaymentController extends AbstractActionController
{
    protected $LoginService;
    protected $CartHelper;
    protected $PaymentHelper;

    public function __construct(
        LoginService $loginService,
        PaymentHelper $paymentHelper,
        CartHelper $cartHelper
    ) {
        $this->LoginService = $loginService;
        $this->PaymentHelper = $paymentHelper;
        $this->CartHelper = $cartHelper;
    }

    public function displayAction()
    {
        if ($this->LoginService->checkLoginStatus()) {
            $template = $this->params()->fromRoute('template', NULL);
            $viewTemplate = $this->params()->fromRoute('view_template', NULL);

            $this->layout($template);

            $cart = $this->CartHelper->getCart();
            $viewModel = new ViewModel($cart);
            $viewModel->setTemplate($viewTemplate);

            return $viewModel;
        }
        
        // Logged out state
        // Redirect to home page
        $this->redirect()->toRoute('home');
    }

    public function checkoutAction()
    {
        if ($this->LoginService->checkLoginStatus()) {
            $jobOrderId = $this->PaymentHelper->createJobOrder();
            // var_dump("<pre>", $jobOrderId);exit;
        
            $this->redirect()->toRoute('order', array(
                'id' => $jobOrderId
            ));
        } else {
            // Logged out state
            // Redirect to home page
            $this->redirect()->toRoute('home');
        }
        
    }
}
