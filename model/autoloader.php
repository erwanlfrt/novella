<?php


namespace model;

/**
 * Cette classe permet d'auto-charger les classes quand on utilise le namespace juste
 *
 * @class Autoloader
 *
 */

class Autoloader{

    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($class)
    {
      $nameSpace = explode('\\', $class);
      $i = count($nameSpace) - 1;
      $nameSpace[$i] = ucfirst($nameSpace[$i]);      
      $class = implode('/', $nameSpace);
      require ROOT . '\..\\' . $class.'.php';
    }

}