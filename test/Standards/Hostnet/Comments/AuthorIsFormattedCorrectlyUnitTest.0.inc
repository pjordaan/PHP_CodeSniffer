<?php

/**
 * @author wrong
 */
class MyClass
{
    /**
     * @author not good
     */
    private $bar;

    /**
     * @author Someone <javascript@confuses.nu>
     */
    protected $foo;

    public $public_variable;

    /**
     * @author Someone <php@confuses.nu>
     * @return number
     */
    public function find()
    {
      $a_variable = 1;
      return $a_variable;
    }

    /**
     * @author Hmmm <comments>
     */
    protected function huh()
    {
    }

    protected $bleh;

    const COMPLICATED = 'public';
}