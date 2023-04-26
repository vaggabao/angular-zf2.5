<?php
namespace Site\Controller;

use Site\Service\LoginService;
use Site\Service\OrderService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OrderController extends AbstractActionController
{
    protected $LoginService;
    protected $OrderService;

    public function __construct(
        LoginService $loginService,
        OrderService $orderService
    ) {
        $this->LoginService = $loginService;
        $this->OrderService = $orderService;
    }

    public function displayAction()
    {
        if ($this->LoginService->checkLoginStatus()) {
            $template = $this->params()->fromRoute('template', NULL);
            $viewTemplate = $this->params()->fromRoute('view_template', NULL);
            $jobOrderId = $this->params()->fromRoute('id');

            $this->layout($template);

            $jobOrder = $this->OrderService->getJobOrder($jobOrderId);
            if ($jobOrder) {
                $viewModel = new ViewModel(array(
                    'order' => $jobOrder->getArrayCopy(),
                    'items' => $this->OrderService->getJobOrderItems($jobOrderId)
                ));
                $viewModel->setTemplate($viewTemplate);
    
                return $viewModel;
            }

            // Job Order not found
            $this->redirect()->toRoute('home');
        }

        // Logged out state
        $this->redirect()->toRoute('home');
    }
}
