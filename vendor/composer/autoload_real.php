<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitadddfb3a79515b1c33ce09ff8d1720ba
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitadddfb3a79515b1c33ce09ff8d1720ba', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitadddfb3a79515b1c33ce09ff8d1720ba', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitadddfb3a79515b1c33ce09ff8d1720ba::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}