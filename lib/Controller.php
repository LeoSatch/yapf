<?php
/**
 * le but de cette classe est degérer l'aacès au site en décortiquant l'URL
 */

//namespace YAPF\Controller;

require __DIR__ . DIRECTORY_SEPARATOR . 'Action.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'YAPFLogger.php';

/**
 * Description of Controller
 *
 * @author satchrequire __DIR__ . DIRECTORY
 * _SEPARATOR . 'Action.php';
 */
abstract class Controller {
    /**
     *
     * @var type
     */
    protected static $_application;

    /**
     *
     * @var type
     */
    protected static $_module;

    /**
     *
     * @var type
     */
    protected static $_parameters;

    /**
     *
     * @var type
     */
    protected static $_classname;

    /**
     *
     * @var type 
     */
    protected static $_configuration;

    /**
     *
     * @var type 
     */
    protected static $_aData;

    /**
     *
     */
    public static function run() {
        $l_nStart = microtime( true );

        // start logger
        YAPFLogger::log( LOG_DEBUG, 'starting controller' );
        $args = func_get_args();
        $args = $args[ 0 ];
        print_r( func_get_args() );
        print_r( $_POST );
        $nb = count( $args );
        YAPFLogger::log( LOG_DEBUG, 'argument number : ' . $nb );

        switch ( $nb ) {
            case 0:
                self::$_application = 'index';
                self::$_module = 'index';
                self::$_parameters = array();

                break;

            case 1:
                self::$_application = $args[ 0 ];
                self::$_module = 'index';
                self::$_parameters = array();

                break;
            case 2:
                self::$_application = $args[ 0 ];
                self::$_module = $args[ 1 ];
                self::$_parameters = array();

                break;
            default:
                self::$_application = $args[ 0 ];
                self::$_module = $args[ 1 ];
                self::$_parameters = array_slice( $args, 2 );

                break;
        }

        // adding POST data to parameters
        self::$_parameters += $_POST;

        YAPFLogger::log( LOG_DEBUG, 'application = ' . self::$_application );
        YAPFLogger::log( LOG_DEBUG, 'module = ' . self::$_module );
        YAPFLogger::log( LOG_DEBUG, 'parameters : ' );
        YAPFLogger::log( LOG_DEBUG, self::$_parameters );

        define( '_APP_DIR', realpath( '../app' ) . DIRECTORY_SEPARATOR );
        define( '_CORE_DIR', realpath( '../core' ) . DIRECTORY_SEPARATOR );

        self::_setAutoloader();

        self::_loadConfiguration();
        

        if ( array_key_exists( 'authNeeded', self::$_configuration ) && self::$_configuration[ 'authNeeded' ] ) {
            self::$_application = 'Authenticator';
            self::$_module = 'index';
        }
        self::_loadApplication();
        $l_sResult = self::_runApplication();

        self::_showView( $l_sResult );

        $l_nEnd = microtime( true );

        echo "<h2>", ($l_nEnd - $l_nStart);
    }

    protected static function _setAutoloader() {
        YAPFLogger::log( LOG_DEBUG, 'registering autoloader' );
        spl_autoload_register( array( 'Controller', '_autoloader' ) );
    }

    protected static function _autoloader( $in_sClassName ) {
        // check dans app puis dans core
        $l_bFound = false;
        foreach ( array( _APP_DIR, _CORE_DIR ) as $l_sDir ) {
            if ( file_exists( $l_sDir . $in_sClassName . _CLASS_SUFFIXE ) ) {
                require $l_sDir . $in_sClassName . _CLASS_SUFFIXE;
                $l_bFound = true;
            }
        }

        if ( !$l_bFound ) {
            YAPFLogger::log( LOG_DEBUG, 'Autoloader : cannot find calsse ' . $in_sClassName );
            throw new RuntimeException( 'cannot find class ' . $in_sClassName );
        }
    }

    protected static function _loadConfiguration() {
        require '../etc/controller.conf.php';
        require '../app/' . ucfirst( self::$_application ) . '/config/configuration.php';
        self::$_configuration = $config;
    }

    protected static function _loadApplication() {
        self::$_classname = ucfirst( self::$_application ) . ucfirst( self::$_module ) . _CLASS_SUFFIXE;
        $sTmp = '../app/' . ucfirst( self::$_application ) . '/actions/' . self::$_classname;

        if ( !file_exists( $sTmp ) ) {
            throw new RuntimeException( 'cannot fin d class ' . $sTmp );
        }
        
        define( '_APP_TPL', '../app/' . ucfirst( self::$_application ) . '/tpl/' );
        YAPFLogger::log( LOG_DEBUG, 'tpl dir = ' . _APP_TPL );
        require $sTmp;

        
    }

    protected static function _runApplication() {
        $sTmpClassName = ucfirst( self::$_application ) . ucfirst( self::$_module );
        YAPFLogger::log( LOG_DEBUG, 'running ' . $sTmpClassName );
        $l_sResult = $sTmpClassName::run( self::$_configuration, self::$_aData, self::$_parameters );

        return $l_sResult;
    }

    protected static function _showView( $in_sResult ) {
        // chargement du template
        YAPFLogger::log( LOG_DEBUG, 'view: ' . _APP_TPL . $in_sResult . '.tpl.php' );
        require _APP_TPL . $in_sResult . '.tpl.php';

        echo $sPage;
    }

}
