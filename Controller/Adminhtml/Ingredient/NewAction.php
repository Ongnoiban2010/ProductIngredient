<?php

namespace Dtn\ProductIngredient\Controller\Adminhtml\Ingredient;

use Dtn\ProductIngredient\Controller\Adminhtml\Ingredient;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends Ingredient
{
    public function execute()
    {
        $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultForward->forward('edit');
    }
}