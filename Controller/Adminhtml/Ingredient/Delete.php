<?php

namespace Dtn\ProductIngredient\Controller\Adminhtml\Ingredient;

use Dtn\ProductIngredient\Model\IngredientFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;

class Delete extends \Magento\Backend\App\Action  implements HttpPostActionInterface
{
    private $ingredientFactory;

    private $resultRedirect;

    public function __construct(
        Action\Context $context,
        IngredientFactory $ingredientFactory
    ) {
        $this->ingredientFactory = $ingredientFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $ingredient = $this->ingredientFactory->create()->load($id);
        $ingredient->delete();
        try {
            $this->messageManager->addSuccessMessage(__('You deleted the ingredient.'));
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while delete the ingredient.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');

    }
}