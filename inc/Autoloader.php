<?php
/**
 *
 */

namespace YAPF\Controller;



function YAPFAutoloader( $in_sClassName ) {
    // on définit l'autoloader
    // on cherche dans tous les path définis si la classe existe
    global $autoloadPathes;

    // le nom de la classe à chercher
    $l_sTmpClassName = $in_sClassName . _CLASS_SUFFIXE;

    $l_bFound = false;


    foreach ( $autoloadPathes as $l_sTmpDir ) {
        if ( file_exists( $l_sTmpClassName ) ) {
            // load it
            require_once $l_sTmpClassName;

            // exit the loop
            $l_bFound = true;
            break;
        }
    }

    if ( !$l_bFound ) {
        throw new \RuntimeException( 'cannot find class"' . $l_sTmpClassName . '"' );
    }
}

spl_autoload_register( 'YAPFAutoloader' );


