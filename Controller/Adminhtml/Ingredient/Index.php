<?php

namespace Dtn\ProductIngredient\Controller\Adminhtml\Ingredient;

class Index extends \Dtn\ProductIngredient\Controller\Adminhtml\Ingredient
{
	public function execute()
	{
		$resultPage = $this->_initAction();
		$resultPage->getConfig()->getTitle()->prepend(__('Ingredient'));
		return $resultPage;
	}
}