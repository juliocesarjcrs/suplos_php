<?php

namespace Core ;

use Core\DataBase;

class Container
{
  public static function newController($controller)
  {
    $controller = "App\\Controllers\\"."$controller";
    return new $controller;
  }
  public static function getModel($model)
  {
    $objModel = "App\\Models\\"."$model";
    return new $objModel(DataBase::getDatabase());
  }
}
