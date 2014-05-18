<?php
///////////////////////////////////////////////////
///                                              //
/// Neo                                          //
/// Framework                                    //
///                                              //
/// YouniS Bensalah <younis.bensalah@riseup.net> //
///                                              //
/// Released under the MIT License.              //
///                                              //
///////////////////////////////////////////////////


namespace Neo;


///
/// Bootstrap function
///
/// $config_dir : Custom config directory (with trailing slash)
///
function boot($config_dir = '../Config/')
{
    session_name('Neo');
    session_start();

    global $_NEO;

    $debug[] = 'Wake up, Neo...';

    // check config dir
    // set $_NEO['PATHS']['CONFIG_DIR']
    // include all config files
    file_exists($config_dir) || die('Config directory not found.');
    $_NEO['PATHS']['CONFIG_DIR'] = $config_dir;
    $ls = array_values(array_diff(scandir($config_dir), array('.', '..')));
    foreach ($ls as $file) {
        $debug[] = "Load config $file ($config_dir)";
        require $config_dir . $file;
    }

    // display all PHP errors
    if ($_NEO['GLOBAL']['DEBUG_MODE']) {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
    }

    // set PHP timezone
    date_default_timezone_set($_NEO['GLOBAL']['PHP_TIMEZONE']);

    // include Debugger class
    require_once $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Debugger/Debugger.php';

    // include misc functions
    require_once $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Misc/id.php';
    require_once $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Misc/message.php';
    require_once $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Misc/neo.php';
    require_once $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Misc/sql_datetime.php';
    require_once $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Misc/vardump.php';
    require_once $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Misc/array_crop.php';
    require_once $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Misc/blank.php';

    // append debug messages to journal
    foreach ($debug as $msg) neo($msg);

    // include Autoloader class
    // register its static method _load() as autoloader
    require_once $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Autoloader/Autoloader.php';
    spl_autoload_register('Neo\Autoloader::load');

    // source all classes etc.
    Autoloader::source('Neo\Neo', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Application/Neo.php')
        ->source('Neo\Router', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Router/Router.php')
        ->source('Neo\Controller', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Controller/Controller.php')
        ->source('Neo\Debugger', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Debugger/Debugger.php')
        ->source('Neo\Model', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Model/Model.php')
        ->source('Neo\Database', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Database/Database.php')
        ->source('Neo\Translator', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Translator/Translator.php')
        ->source('Neo\DialogWidget', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Widget/Dialog/DialogWidget.php')
        ->source('Neo\View', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/View/View.php')
        ->source('Neo\DocumentV', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/View/DocumentV.php')
        ->source('Neo\MarkdownW', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/View/MarkdownW.php')
        ->source('Neo\Marker', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/View/Marker.php')
        ->source('Neo\Markers', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Markers/Markers.php')
        ->source('Neo\Error', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Error/Error.php')
        ->source('Neo\NeoException', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/Exception/NeoException.php')
        ->source('Neo\LiLi', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/LinkedList/LiLi.php')
        ->source('Neo\Linkable', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Core/LinkedList/Linkable.php')

        ->source('Neo\Counter', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Shell/Counter/Counter.php')
        ->source('Neo\Widget', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Shell/Widget/Widget.php')
        ->source('Neo\Widget', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Shell/Widget/Widgets/MarkdownW.php')

        ->source('Neo\Parsedown', $_NEO['PATHS']['LIB_DIR'] . 'Neo/Vendor/Parsedown/Parsedown.php');

    neo('Neo booted with success.');
}
