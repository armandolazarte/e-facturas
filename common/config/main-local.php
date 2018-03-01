<?php
return [
    'components' => [
	'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=10.132.79.151;dbname=fe',
            'username' => 'fe',
            'password' => 'pastatuti',
            'charset' => 'utf8',
        ],        
    'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                //'username' => 'no-reply@airtech-it.com.ar',
                'username' => 'airtech.notificacion.fe@gmail.com',
                'password' => 'gangrela1234',
                //'port' => '465',
                'port' => '587',
                'encryption' => 'tls',
                //'encryption' => 'ssl',
            ],
        ],
    // 'urlManager' =>[
    //         'enablePrettyUrl' => true,
    //         'showScriptName' => false,
    //     ],
    ],
];
