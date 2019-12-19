<?php

namespace Dtn\ProductIngredient\Model;

class Ingredient extends \Magento\Framework\Model\AbstractModel
{
	protected function _construct()
	{
		$this->_init('Dtn\ProductIngredient\Model\ResourceModel\Ingredient');
	}
}