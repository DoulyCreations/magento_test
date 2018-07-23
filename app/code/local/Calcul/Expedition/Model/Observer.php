<?php

class Calcul_Expedition_Model_Observer extends Varien_Event_Observer
{
    public function __construct()
    {
    }

    public function sendEmail($observer)
    {
        //error_reporting(E_ALL);
        //ini_set('display_errors', 1);

        //$sDateNow = Mage::getModel('core/date')->date('Y-m-d H:i:s');
        //file_put_contents(__DIR__ . '/../../../../../../var/log/cronjob_benoit_test.log', $sDateNow);

        // TODO : Pour eviter la répétition d'envoi d'email, on peut :
        // 1. modifier la syntaxe cron, une fois par jour
        // 2. aller voir dans la table des envois d'email (queue) si le client a déjà été averti

        /**
         * Bon, je ne sais pas trop pourquoi je ne reçoit pas les emails...
         * Les emails rentrent bien dans la table et sont traités par la tache d'envoi de mail...
         */

        //$sState = Mage_Sales_Model_Order::STATE_PROCESSING;
        $sState = Mage_Sales_Model_Order::STATE_CANCELED;

        /** @var Mage_Sales_Model_Order $oOrder */
        $oModelOrder = Mage::getModel('sales/order');

        try{
            /** @var Mage_Sales_Model_Resource_Order_Collection $oOrders */
            $oOrders = $oModelOrder->getCollection();
            $oOrders
                ->addFilter('state', $sState)
                ->join(
                    ['ce' => 'calcul_expedition/expedition'],
                    'ce.order_id = main_table.entity_id'
                )
                ->addAttributeToFilter('ce.date_expedition', array('lt' => date('Y-m-d')))
                ->distinct(true);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

        $aDatas = $oOrders->getData();

        foreach ($aDatas as $aData) {
            //var_dump($aData['date_expedition'], $aData['increment_id']);
            $this->sendEmailToCustomer($aData['customer_email'], $aData['increment_id']);
        }

    }

    /**
     * @param $sCustomerEmail string
     * @param $sIdOrder string
     */
    private function sendEmailToCustomer($sCustomerEmail, $sIdOrder)
    {
        // TODO : Lier a la config globale
        $sender = [
            'name' => 'Devs',
            'email' => 'devs@lematelas.fr',
        ];

        try {
            /** @var Mage_Core_Model_Email_Queue $queue */
            $queue = Mage::getModel('core/email_queue');
            /** @var Mage_Core_Model_Email_Template $oEmailTemplate */
            $oEmailTemplate = Mage::getModel('core/email_template');
            $queue->setEventType('error_mail');
            $oEmailTemplate
                ->setQueue($queue)
                ->sendTransactional(
                    'testmailer_template',
                    $sender,
                    $sCustomerEmail,
                    null,
                    [
                        'subject' => 'Retard Expedition',
                        'id_order' => $sIdOrder
                    ]
                );
        } catch (Exception $e) {
            Mage::log('Unable to send mail: '.$e->getMessage(), Zend_Log::CRIT, 'errormailer.log');
        }
    }
}
