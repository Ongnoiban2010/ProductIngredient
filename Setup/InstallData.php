<?php

namespace Dtn\ProductIngredient\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
 
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
 
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'ingredient_attribute',
            [
                'label' => 'Ingredient Attribute',
                'type'  => 'varchar',
                'input' => 'multiselect',
                'source' => 'Dtn\ProductIngredient\Model\Config\Source\Multiselect',
                'required' => false,
                'sort_order' => 30,
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_STORE,
                'used_in_product_listing' => true,
                'backend' => 'Dtn\ProductIngredient\Model\Ingredient\Attribute\Backend',
                'visible_on_front' => false
            ]
        );       
        $setup->endSetup();
    }
}
