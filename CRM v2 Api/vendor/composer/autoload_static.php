<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb1573b292e9426b80c2ce861c79553c4
{
    public static $prefixLengthsPsr4 = array (
        'z' => 
        array (
            'zcrmsdk\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'zcrmsdk\\' => 
        array (
            0 => __DIR__ . '/..' . '/zohocrm/php-sdk/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb1573b292e9426b80c2ce861c79553c4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb1573b292e9426b80c2ce861c79553c4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
