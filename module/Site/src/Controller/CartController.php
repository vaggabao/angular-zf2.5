<?php
namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Site\Helper\CartHelper;
use Site\Filter\AddToCartFilter;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class CartController extends AbstractActionController
{
    protected $CartHelper;
    protected $AddToCartFilter;

    public function __construct(
        CartHelper $cartHelper,
        AddToCartFilter $addToCartFilter
    ) {
        $this->CartHelper = $cartHelper;
        $this->AddToCartFilter = $addToCartFilter;
    }

    public function displayAction()
    {
        $template = $this->params()->fromRoute('template', NULL);
        $viewTemplate = $this->params()->fromRoute('view_template', NULL);

        $this->layout($template);

        $cart = $this->CartHelper->getCart();
        $viewModel = new ViewModel($cart);
        $viewModel->setTemplate($viewTemplate);

        return $viewModel;
    }

    public function addToCartAction()
    {
        $data = $this->params()->fromPost();
        
        $this->AddToCartFilter->setData($data);
        if ($this->AddToCartFilter->isValid()) {
            $addToCart = $this->CartHelper->addToCart($data['product_id'], $data['qty']);
            return new JsonModel(array(
                'success' => $addToCart
            ));
        }

        return new JsonModel(array(
            'success' => 0,
            'errors' => $this->AddToCartFilter->getMessages()
        ));
    }
}
