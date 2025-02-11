<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita12c4ec8492e685fd013b92725e94c98
{
    public static $files = array (
        'decc78cc4436b1292c6c0d151b19445c' => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpseclib3\\' => 11,
        ),
        'P' => 
        array (
            'ParagonIE\\ConstantTime\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpseclib3\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
        ),
        'ParagonIE\\ConstantTime\\' => 
        array (
            0 => __DIR__ . '/..' . '/paragonie/constant_time_encoding/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita12c4ec8492e685fd013b92725e94c98::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita12c4ec8492e685fd013b92725e94c98::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita12c4ec8492e685fd013b92725e94c98::$classMap;

        }, null, ClassLoader::class);
    }
}
