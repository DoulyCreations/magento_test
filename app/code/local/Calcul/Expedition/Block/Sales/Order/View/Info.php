<?php

class Calcul_Expedition_Block_Sales_Order_View_Info extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function __construct(array $args = array())
    {
        //$this->setTemplate('expedition/sales_order_view_info.phtml');

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
        $sParamOrderId = $this->getRequest()->getParam('order_id');

        $oModelExpedition = Mage::getModel('calcul_expedition/Expedition');

        $oExpedition = $oModelExpedition->load($sParamOrderId, 'order_id');
        $sDateExpedition = $oExpedition->getData('date_expedition');

        $sUrlAjax = $this->getUrl('expedition/index/updateDateExpedition');

        $sActionDate = " - <button type='button' class='scalable' onclick='editExpeditionDate();'>Add/Modify Expedition Date</button>";

        $sAddInfos = '</strong></td></tr>
            <tr>
            <td class="label">Expedition Date</td>
            <td class="value"><strong id="date_expedition_value">' . $sDateExpedition . $sActionDate . '</strong>';

        $sJs = '
            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
            <script type="text/javascript">
                var $j = jQuery.noConflict();
            
                function editExpeditionDate () {
                    var dateExpedition = prompt("Expedition Date:", "' . $sDateExpedition . '");
                    
                    if (dateExpedition == null || dateExpedition === "") {
                        // Cancel, Do Nothing...
                    } else {
                        $j.ajax({
                            url: "'.$sUrlAjax.'",
                            type: "POST",
                            data: "date="+dateExpedition+"&order_id='.$sParamOrderId.'",
                            success: function(data) {
                                $j("#date_expedition_value").html(dateExpedition+" (<span style=\"color:green;\">update with success</span>)'.$sActionDate.'")
                            }
                        });
                        
                    }
                }
            </script>
        ';

        return parent::getOrderStoreName() . $sAddInfos . $sJs;
    }
}
