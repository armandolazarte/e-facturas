<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FacturaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $css = [
    	'css/modal.css',
    	'css/event.css',
    	'css/site.css',
        'css/diseno-2A.css',
        'css/diseno-2B.css',
        'css/diseno-2M.css',                
        'css/diseno-3A.css',
        'css/diseno-3B.css',
        'css/diseno-3M.css',
        'css/diseno-4A.css',
        'css/diseno-4B.css',
        'css/diseno-4M.css',
        'css/productos.css',
    ];
    public $js = [
    	'js/event.js',
    	'js/modal.js',
    	'js/jquery-min.js',
        'js/JsBarcode.all.min.js',
    ];
    /*public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];*/
}