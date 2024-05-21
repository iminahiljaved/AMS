<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3e7f015600df09d562c491c59b757ab1
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'AgileBM\\ZKLib\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'AgileBM\\ZKLib\\' => 
        array (
            0 => __DIR__ . '/..' . '/agile-bm/zk-lib/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3e7f015600df09d562c491c59b757ab1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3e7f015600df09d562c491c59b757ab1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3e7f015600df09d562c491c59b757ab1::$classMap;

        }, null, ClassLoader::class);
    }
}
