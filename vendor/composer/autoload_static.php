<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3a9b091272fbf0e2655f81f9167f5038
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3a9b091272fbf0e2655f81f9167f5038::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3a9b091272fbf0e2655f81f9167f5038::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3a9b091272fbf0e2655f81f9167f5038::$classMap;

        }, null, ClassLoader::class);
    }
}
