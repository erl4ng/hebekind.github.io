<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitccbaef25734a85f33f0fc6af7a84b24f
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Embera\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Embera\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Embera',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitccbaef25734a85f33f0fc6af7a84b24f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitccbaef25734a85f33f0fc6af7a84b24f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}