<?php

class VS7_TrackInShipmentGrid_Adminhtml_Block_Sales_Shipment_Grid extends Mage_Adminhtml_Block_Sales_Shipment_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $trackTable = Mage::getSingleton('core/resource')->getTableName('sales/shipment_track');
        $collection->getSelect()
            ->joinLeft(
                array('track' => $trackTable),
                'main_table.entity_id = track.parent_id',
                array('track' => new Zend_Db_Expr('GROUP_CONCAT(track.track_number)'))
            )->group('main_table.entity_id');
        $collection->addFilterToMap('created_at', 'main_table.created_at', 'fields');
        $this->setCollection($collection);
        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumnAfter(
            'track',
                array(
                'header'    => Mage::helper('sales')->__('Track #'),
                'index'     => 'track',
                'type'      => 'text',
                'filter_condition_callback' => array($this, '_filterTrackCallback'),
            ),
            'increment_id'
        );

        return parent::_prepareColumns();
    }

    protected function _filterTrackCallback($collection, $column) {
        $filter = $column->getFilter()->getValue();
        $collection->getSelect()->where('track.track_number like \'%' . $filter . '%\'');
        return $collection;
    }
}