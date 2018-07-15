<?php

class Calcul_Expedition_Block_Sales_Order_Info extends Mage_Sales_Block_Order_Info
{
    public function __construct(array $args = array())
    {
        parent::__construct($args);
        $this->setTemplate('expedition/sales_order_info.phtml');
    }

    /**
     * @param Mage_Sales_Model_Order $order
     * @return mixed
     */
    public function getExpeditionDate($order)
    {
        $sOrderId = $order->getId();

        $oModelExpedition = Mage::getModel('calcul_expedition/Expedition');

        $oExpedition = $oModelExpedition->load($sOrderId, 'order_id');
        $sDateExpedition = $oExpedition->getData('date_expedition');

        return $sDateExpedition;
    }
}
