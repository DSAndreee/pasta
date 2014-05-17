<?php
///
/// Neo
/// Framework
/// 
/// YouniS Bensalah <younis.bensalah@riseup.net>
/// 
/// Released under the MIT License.
///


namespace Neo;


$_NEO['PATHS'] = array_merge(isset($_NEO['PATHS']) ? $_NEO['PATHS'] : array(), array(


    ///
    /// Absolute path to the library directory "Lib/" with trailing slash
    ///
    'LIB_DIR' => __DIR__ . '/../Lib/',


    ///
    /// Absolute path to the application directory "App/" with trailing slash
    ///
    'APP_DIR' => __DIR__ . '/../App/',


    ///
    /// Absolute path to the logs directory "Logs/" with trailing slash
    /// Make sure that your server has read and write access on it.
    /// 
    'LOG_DIR' => __DIR__ . '/../Logs/',


    ///
    /// Relative path to the templates directory "Templates/"
    /// from within the application directory, with trailing slash.
    ///
    'TEMPLATES_DIR' => 'Templates/',


    ///
    /// Relative path to the style directory "Style/"
    /// from the project's root directory, with trailing slash.
    ///
    'STYLE_DIR' => 'App/Style/',


    ///
    /// Relative path to the i18n directory "I18n/"
    /// from within the application directory, with trailing slash.
    ///
    'I18N_DIR' => 'I18n/',


    ///
    /// Subdirectory from web server's root with trailing slash
    ///
    'SUB_DIR' => '/',


));
