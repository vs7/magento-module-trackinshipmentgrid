<?php

class VS7_TrackInShipmentGrid_Model_Sales_Resource_Order_Shipment_Grid_Collection extends Mage_Sales_Model_Resource_Order_Shipment_Grid_Collection
{
    public function getSelectCountSql()
    {
        $this->_renderFilters();

        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $countSelect->reset(Zend_Db_Select::COLUMNS);

        $countSelect->resetJoinLeft();
        $countSelect->reset(Zend_Db_Select::GROUP);

        $countSelect->columns('COUNT(*)');

        return $countSelect;
    }
}