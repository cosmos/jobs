<?php
/**
 * Import Woocommerce plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMWC;

if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

class Plugin{
    private static $instance = null;
    private static $string = 'com.smackcoders.smackcsv';

    public static function getInstance() {
        if (Plugin::$instance == null) {
            Plugin::$instance = new Plugin;
           
            return Plugin::$instance;
        }
        return Plugin::$instance;
    }

    public function getPluginSlug(){
        return Plugin::$string;
    }
}