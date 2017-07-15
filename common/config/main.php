<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
	'assetManager' => [
        //'linkAssets' => true,
            'appendTimestamp' => true,
		//'forceCopy' => true,

        ],

    ],
];
