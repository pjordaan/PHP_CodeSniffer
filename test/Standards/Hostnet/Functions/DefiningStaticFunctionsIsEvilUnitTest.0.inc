<?php

function a()
{
}

abstract class MyClass
{
  private $meh;

  abstract function b();

  public final static function thisSucks()
  {
  }

  private static function uhOh()
  {
    return function() {
    };
  }

  public function getMeh()
  {
    return $this->meh;
  }

}