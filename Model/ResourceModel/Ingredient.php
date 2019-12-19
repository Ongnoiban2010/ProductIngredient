<?php

namespace Dtn\ProductIngredient\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Ingredient extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected function _construct()
	{
		$this->_init('dtn_catalog_ingredient', 'entity_id');
	}
}