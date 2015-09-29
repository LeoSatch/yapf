<?php
/**
 * Description of HelloIndex
 *
 * @author satch
 */
abstract class HelloIndex extends Action {

    public static function run( & $in_aConfiguration, & $out_aData = array(), & $in_aParameters = array() ) {
        $result = parent::run( $in_aConfiguration, $out_aData, $in_aParameters );
        
        return $result;
    }

}
