<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TodoTask
 *
 * @author satch
 */
class TodoTask {

    protected $_aData = array();
    protected $_sName;
    protected $_sCreationDate;
    protected $_sStartDate;
    protected $_sEndDate;
    protected $_sAccomplished;

    /**
     *
     */
    public function __construct() {

    }

    public function setData( array $in_aTaskData = array() ) {
        // clean data first
        $this->cleanData();

        // set data then
        $this->_bSetData( $in_aTaskData );
    }

    public function cleanData() {
        $this->_aData = array(
            'name'         => '',
            'creationDate' => '',
            'startDate'    => '',
            'endDate'      => '',
            'accomplished' => 0.0
        );
    }

    /**
     *
     * @param array $in_aTaskData
     */
    public function _bSetData( array $in_aTaskData = array() ) {
        foreach ( array( 'name', 'creationDate', 'startDate', 'endDate', 'accomplished' ) as $name ) {
            if ( array_key_exists( $name, $in_aTaskData ) ) {
                $this->{'_s' . ucfirst( $name )} = $in_aTaskData[ $name ];
            }
        }
    }

}
