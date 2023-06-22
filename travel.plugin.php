<?php
/**
 * Plugin Name: Travel Template
 * Plugin URI: https://github.com/drajathasan/slims-travel
 * Description: A new SLiMS Template
 * Version: 1.0.0
 * Author: Drajat Hasan
 * Author URI: https://github.com/drajathasan
 */

use SLiMS\DB;
use SLiMS\Plugins;

// Theme
$templateDir = function() {
    $templateName = array_filter(scandir(__DIR__), fn($item) => preg_match('/build/i', $item));
    rsort($templateName);
    return ($templateName ? $templateName[0] : '') . '/travel';
};

Plugins::hook(Plugins::CONTENT_BEFORE_LOAD, function($opac) use($templateDir) {
    if (!in_array(($_GET['p']??''), ['login','visitor']))
    {
        $conf = [
            'dir' => SB . 'plugins' . DS . basename(__DIR__) . DS . 'theme',
            'theme' => $templateDir(),
            'classic_popular_collection_item' => 5,
        ];

        define('TRAVEL_BASE', basename(dirname(__DIR__)) . '/'. basename(__DIR__) . '/');
        define('TRAVEL_THEME', TRAVEL_BASE . 'theme' . $templateDir());
        
        define('TRAVEL_ASSETS', TRAVEL_BASE . 'dist/assets/');
        $opac->mutateConf('template', $conf);
    }
});