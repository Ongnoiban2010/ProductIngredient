<?php

namespace Dtn\ProductIngredient\Model\ResourceModel\Ingredient;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'entity_id';

	protected function _construct()
	{
		$this->_init('Dtn\ProductIngredient\Model\Ingredient', 'Dtn\ProductIngredient\Model\ResourceModel\Ingredient');
	}
}