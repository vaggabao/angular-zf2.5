<?php
namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Site\Service\ProductService;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $ProductService;

    public function __construct(ProductService $productService)
    {
        $this->ProductService = $productService;
    }

    public function indexAction()
    {
        $template = $this->params()->fromRoute('template', NULL);
        $viewTemplate = $this->params()->fromRoute('view_template', NULL);
        
        $this->layout($template);

        $viewModel = new ViewModel(array(
            'products' => $this->ProductService->getProductList(),
        ));
        $viewModel->setTemplate($viewTemplate);

        return $viewModel;
    }
}
