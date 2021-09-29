<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit88de3b40561302fac6c96e731286bb15
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

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit88de3b40561302fac6c96e731286bb15::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit88de3b40561302fac6c96e731286bb15::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit88de3b40561302fac6c96e731286bb15::$classMap;

        }, null, ClassLoader::class);
    }
}
