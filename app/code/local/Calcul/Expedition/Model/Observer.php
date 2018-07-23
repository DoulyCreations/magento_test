<?php

class Calcul_Expedition_Model_Observer extends Varien_Event_Observer
{
    public function __construct()
    {
    }

    public function sendEmail($observer)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);


        $sDateNow = Mage::getModel('core/date')->date('Y-m-d H:i:s');
        file_put_contents(__DIR__ . '/../../../../../../var/log/cronjob_benoit_test.log', $sDateNow);

        $recipients = [
            'benoit.decoster@lematelas.fr'
        ];

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
                    $recipients,
                    null,
                    [
                        'subject' => 'Cet email fonctionne'
                    ]
                );
        } catch (Exception $e) {
            Mage::log('Unable to send mail: '.$e->getMessage(), Zend_Log::CRIT, 'errormailer.log');
        }

    }
}
