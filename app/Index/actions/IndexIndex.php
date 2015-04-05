<?php
/**
 * Description of HelloIndex
 *
 * @author satch
 */
abstract class IndexIndex extends Action {

    public static function run(& $in_aConfiguration, & $out_aData = array(), & $in_aParameters = array()) {
        $result = parent::run( $in_aConfiguration, $out_aData, $in_aParameters );
        
        // on charge la liste des applications disponibles
        foreach( new DirectoryIterator( realpath( __DIR__ . '/../../')) as $sDir ) {
            if ( ! $sDir->isDot() && $sDir->isDir() ) {
                $out_aData['apps'][] = $sDir->getFilename();
            }
        }
        
        return $result;
    }

}
