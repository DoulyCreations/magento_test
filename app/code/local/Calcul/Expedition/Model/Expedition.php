<?php

class Calcul_Expedition_Model_Expedition extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('calcul_expedition/expedition');
    }

    /*
     * Afficher le contenu d'un message enregistré
     * en retirant les tags HTML.
     */
    public function getEscapedMessage()
    {
        return strip_tags($this->getData('message'));
    }
}