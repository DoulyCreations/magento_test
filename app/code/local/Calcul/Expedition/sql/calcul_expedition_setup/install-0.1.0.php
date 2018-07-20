<?php

/**
 * Ceci est un test
 * Ca n'a pas l'air de fonctionner...
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

/** @var Varien_Db_Ddl_Table $table */
$expedTable          = $installer->getTable('calcul_expedition');

$table      = $connection->newTable($expedTable);

try{
    $table->addColumn('expedition_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ));

    $table->addColumn('date_expedition', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        'nullable' => true,
    ));

    $table->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => true,
        'unsigned' => true,
    ));

    $table->addForeignKey(
        $installer->getFkName('FK_calcul_expedition_sales_flat_order', 'order_id', 'sales/order', 'entity_id'),
        'order_id',
        $installer->getTable('sales/order'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    );

    $connection->createTable($table);

} catch (\Exception $e) {
    echo $e->getMessage(); die;
}




/*
$connection->addColumn($this->getTable('sales/invoice'), 'created_by', [
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'size' => 255,
    'nullable' => false,
    'comment' => 'Invoice Admin Creator',
]);
*/

$installer->endSetup();
