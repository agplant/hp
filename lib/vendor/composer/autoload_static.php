<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfe748c206113a9306871c6784a993d8b
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfe748c206113a9306871c6784a993d8b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfe748c206113a9306871c6784a993d8b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
