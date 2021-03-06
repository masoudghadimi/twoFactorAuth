<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd3e5289d5a3ee52c5950a46a20fb50f9
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Masoud\\Twofactorauth\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Masoud\\Twofactorauth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd3e5289d5a3ee52c5950a46a20fb50f9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd3e5289d5a3ee52c5950a46a20fb50f9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd3e5289d5a3ee52c5950a46a20fb50f9::$classMap;

        }, null, ClassLoader::class);
    }
}
