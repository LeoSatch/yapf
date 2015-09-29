<?php
namespace Symacopee\YAPF\Lib;

/**
 * le but de cette classe est degérer l'accès au site en décortiquant l'URL
 */

use RuntimeException;
use Symacopee\YAPF\core\ParametersSettings;
use YAPFLogger;

/**
 * Description of Controller
 *
 * @author satch
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
        
        if ( false !== strpos( $_SERVER['REQUEST_URI'], '?' )) {
            // le path et les parametres 
            list( $path, $params) = explode('?', $_SERVER[ 'REQUEST_URI' ]);
        } else {
            $params = '';
            $path = $_SERVER['REQUEST_URI'];
        }
        
        if ( '/' == $path ) {
            $path='index';
        }
        
        $args = array_slice( explode( '/', $path ), 1 );
        
        $nb = count( $args );
        YAPFLogger::log( LOG_INFO, 'argument number : ' . $nb );

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

        // check if GET parameters are added
        if ( false !== strpos( self::$_module, '?' ) ) {
            list( self::$_module, $extraParameters ) = explode( '?', self::$_module, 2 );
        }

        // adding POST data to parameters
        self::$_parameters += $_POST;

        YAPFLogger::log( LOG_INFO, 'application = ' . self::$_application );
        YAPFLogger::log( LOG_INFO, 'module = ' . self::$_module );
        YAPFLogger::log( LOG_INFO, 'parameters : ' );
        YAPFLogger::log( LOG_INFO, self::$_parameters );

        define( '_APP_DIR', realpath( '../app' ) . DIRECTORY_SEPARATOR . ucfirst( self::$_application ) . DIRECTORY_SEPARATOR );
        define( '_APP_LIB_DIR', _APP_DIR . 'lib' . DIRECTORY_SEPARATOR );
        define( '_APP_CONF_DIR', _APP_DIR . 'config' . DIRECTORY_SEPARATOR );
        define( '_APP_TPL_DIR', _APP_DIR . 'tpl' . DIRECTORY_SEPARATOR );
        define( '_APP_ACIONS_DIR', _APP_DIR . 'actions' . DIRECTORY_SEPARATOR );
        define( '_APP_NAMESPACE', 'app\\' . ucfirst( self::$_application ));
        define( '_APP_NAMESPACE_ACTIONS', _APP_NAMESPACE . '\\actions\\');
        define( '_APP_NAMESPACE_VIEWS', _APP_NAMESPACE . '\\views\\');
        
        define( '_CORE_DIR', realpath( '../core' ) . DIRECTORY_SEPARATOR );

        //self::_setAutoloader();

        self::_loadConfiguration();
        

        if ( ParametersSettings::needsAuth() ) {
            self::$_application = 'Authenticator';
            self::$_module = 'index';
        }
        self::_loadApplication();
        $l_sResult = self::_runApplication();

        if ( !$l_sResult ) {
            YAPFLogger::log( LOG_ALERT, 'retour null apres run du module' );
        }

        self::_showView( $l_sResult );

        $l_nEnd = microtime( true );
        YAPFLogger::log( LOG_INFO, 'temps: ' . ($l_nEnd - $l_nStart) );
    }

    /**
     *
     */
    protected static function _setAutoloader() {
        YAPFLogger::log( LOG_DEBUG, 'registering autoloader' );
        spl_autoload_register( array( 'Controller', '_autoloader' ) );
    }

    /**
     *
     * @param string $in_sClassName
     * @throws RuntimeException
     */
    protected static function _autoloader( $in_sClassName ) {
        // check dans app puis dans core
        $l_bFound = false;
        foreach ( array( _APP_DIR, _APP_LIB_DIR, _CORE_DIR ) as $l_sDir ) {
            echo "<hr>", $l_sDir . $in_sClassName . _CLASS_SUFFIXE, "<hr>";
            if ( file_exists( $l_sDir . $in_sClassName . _CLASS_SUFFIXE ) ) {
                require $l_sDir . $in_sClassName . _CLASS_SUFFIXE;
                $l_bFound = true;
                break;
            }
        }

        if ( !$l_bFound ) {
            YAPFLogger::log( LOG_DEBUG, 'Autoloader : cannot find calsse ' . $in_sClassName );
            throw new RuntimeException( 'cannot find class ' . $in_sClassName );
        }
    }

    /**
     *
     */
    protected static function _loadConfiguration() {
        require '../etc/controller.conf.php';
        ParametersSettings::init( self::$_application );
        //require '../app/' . ucfirst( self::$_application ) . '/config/configuration.php';
        //self::$_configuration = $config;
    }

    /**
     *
     * @throws RuntimeException
     */
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

    /**
     *
     * @return string
     */
    protected static function _runApplication() {
        $sTmpClassName = ucfirst( self::$_application ) . ucfirst( self::$_module );
        require_once _APP_ACIONS_DIR . $sTmpClassName . '.php';
        $sApp = _APP_NAMESPACE_ACTIONS . $sTmpClassName;
        YAPFLogger::log( LOG_DEBUG, 'running ' . $sTmpClassName . '.php' );
        $l_sResult = $sApp::run( self::$_configuration, self::$_aData, self::$_parameters );

        return $l_sResult;
    }

    /**
     *
     * @param string $in_sResult
     */
    protected static function _showView( $in_sResult = 'Index' ) {
        // chargement du template
        YAPFLogger::log( LOG_DEBUG, 'view: ' . _APP_TPL . $in_sResult . '.tpl.php' );
        require _APP_TPL . $in_sResult . '.tpl.php';

        echo $sPage;
    }

}
