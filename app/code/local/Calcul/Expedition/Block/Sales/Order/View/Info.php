<?php

class Calcul_Expedition_Block_Sales_Order_View_Info extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function __construct(array $args = array())
    {
        $this->setTemplate('expedition/sales_order_view_info.phtml');

        parent::__construct($args);
    }

    /**
     * @return null|string
     *
     * Surcharge view admin méthode crado...
     *
     * http://localhost/magento/index.php/admin/sales_order/view/order_id/1/key/ef3b6ac1b208b884ed2914d364a7073a/
     */
    public function getOrderStoreName()
    {
        $sAddInfos = '</strong></td></tr>
            <tr>
            <td class="label">DATE EXPEDITION</td>
            <td class="value"><strong>01/01/2000</strong>';

        return parent::getOrderStoreName().$sAddInfos;
    }
}
