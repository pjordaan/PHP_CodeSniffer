<?php

// No args.
function myFunction()
{
}

// No default args.
function myFunction($arg1)
{
}

// Valid
function myFunction($arg1, $arg2='hello')
{
}

// Valid with lots of args
function myFunction($arg1, $arg2, $arg3, $arg4='hello', $arg5=array(), $arg6='hello')
{
}

// Valid type hints
function myFunction(array $arg1, array $arg2=array())
{
}

// Invalid
function myFunction($arg2='hello', $arg1)
{
}

// Invalid with lots of args
function myFunction($arg1, $arg2, $arg3, $arg4='hello', $arg5, $arg6='hello')
{
}

// Invalid type hints
function myFunction(array $arg2=array(), array $arg1)
{
}

class myClass()
{
    // No args.
    function myFunction()
    {
    }

    // No default args.
    function myFunction($arg1)
    {
    }

    // Valid
    function myFunction($arg1, $arg2='hello')
    {
    }

    // Valid with lots of args
    function myFunction($arg1, $arg2, $arg3, $arg4='hello', $arg5=array(), $arg6='hello')
    {
    }

    // Valid type hints
    function myFunction(array $arg1, array $arg2=array())
    {
    }

    // Invalid
    function myFunction(
        $arg2='hello',
        $arg1
    )
    {
    }

    // Invalid with lots of args
    function myFunction($arg1, $arg2, $arg3, $arg4='hello', $arg5, $arg6='hello')
    {
    }

    // Invalid type hints
    function myFunction(array $arg2=array(), array $arg1)
    {
    }

    // Valid type hints for object with null to allow null values to be passed explicitly
    function myFunction(
        $arg1,
        myClass $arg2=null,
        $arg2
    ) {}

    // Valid type hints for object with null to allow null values to be passed explicitly
    // Invalid other params, and multi line
    public function myFunction(
        $arg1 = 'broken',
        $arg2 = null,
        myClass $arg3,
        myClass $arg4 = null,
        $arg5 = 'broken', $arg6 = null,
        $arg7   =
        'n00b',
        $arg8 = 16,
        $arg9 = 17.0,
        $arg10
    ) {
    }

    public function myFunction(
        $arg1,
        $arg2 = 'def',
        $arg3,
        $arg4 = 16.00
        $arg5,
        $arg6 = -9
    ) {
    }

    public function myFunction(
        $arg1 = 16, $arg2 = 17,
        $arg3,
        $arg4
    ) {
    }

    public function myFunction(MyClass $arg1 = null, $arg2) {}
    public function myFunction($arg1, $arg2 = 0, MyClass $arg3 = null) {}
}
