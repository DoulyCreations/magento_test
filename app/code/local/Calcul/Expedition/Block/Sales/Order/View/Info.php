<?php

class Calcul_Expedition_Block_Sales_Order_View_Info extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function __construct(array $args = array())
    {
        parent::__construct($args);
    }

    /**
     * @return null|string
     * @throws Exception
     *
     * Surcharge view admin méthode crado...
     * Je n'ai pas réussi à surcharger la vue...
     *
     * http://localhost/magento/index.php/admin/sales_order/view/order_id/1/key/ef3b6ac1b208b884ed2914d364a7073a/
     */
    public function getOrderStoreName()
    {
        $sParamOrderId = $this->getRequest()->getParam('order_id');

        $oModelExpedition = Mage::getModel('calcul_expedition/Expedition');

        $oExpedition = $oModelExpedition->load($sParamOrderId, 'order_id');
        $sDateExpedition = $oExpedition->getData('date_expedition');

        $sUrlAjax = $this->getUrl('expedition/index/updateDateExpedition');

        $sActionDate = " - <button type='button' class='scalable' onclick='editExpeditionDate(\"".$sUrlAjax."\", \"".$sParamOrderId."\", \"".$sDateExpedition."\");'>Add/Modify Expedition Date</button>";

        $sAddInfos = '</strong></td></tr>
            <tr>
            <td class="label">Expedition Date</td>
            <td class="value"><strong id="date_expedition_value">' . $sDateExpedition .'</strong>' . $sActionDate;

        // TODO : Voir pour ajouter dans le xml addJs...
        $sJs = '
            <script src="'.$this->getSkinUrl('js/jquery-3.3.1.min.js').'"></script>
            <script src="'.$this->getSkinUrl('js/expedition_backend.js').'"></script>
        ';

        return parent::getOrderStoreName() . $sAddInfos . $sJs;
    }
}
