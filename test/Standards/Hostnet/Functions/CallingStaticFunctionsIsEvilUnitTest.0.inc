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
    $this->b();
    self::uhOh();
    a();
  }

  private static function uhOh()
  {
    return function() {
      Foo::bar();
    };
  }

  public function getMeh()
  {
    return $this->meh;
  }

}