<?php
namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Site\Service\ProductService;
use Zend\View\Model\ViewModel;

class ProductController extends AbstractActionController
{
    protected $ProductService;

    public function __construct(ProductService $productService)
    {
        $this->ProductService = $productService;
    }

    public function displayAction()
    {
        $template = $this->params()->fromRoute('template', NULL);
        $viewTemplate = $this->params()->fromRoute('view_template', NULL);
        $productId = $this->params()->fromRoute('id');

        $this->layout($template);

        $product = $this->ProductService->getProduct($productId);
        $viewModel = new ViewModel($product);
        $viewModel->setTemplate($viewTemplate);

        return $viewModel;
    }
}
