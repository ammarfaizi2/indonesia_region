<?php

require __DIR__."/../config.php";

/**
 * @param string $className
 * @return void
 */
function classAutoloader($className)
{
  if (file_exists(
    $f = BASEPATH."/src/classes/".str_replace("\\", "/", $className).".php")) {
    require $f;
  }
}

spl_autoload_register("classAutoloader");
