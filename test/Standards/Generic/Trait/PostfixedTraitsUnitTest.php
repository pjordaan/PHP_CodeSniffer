<?php

class Generic_Trait_PostfixedTraitsUnitTest extends AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getErrorList($filename = null)
    {
        // The trait tests will only work in PHP version where traits exist and
        // will throw errors in earlier versions.
        if (version_compare(PHP_VERSION, '5.4.0') < 0) {
            return array();
        }

        switch($filename) {
            case 'PostfixedTraitsUnitTest.0.inc':
                return array();
            case 'PostfixedTraitsUnitTest.1.inc':
                return array(3 => 1);
        }
    }//end getErrorList()


    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getWarningList()
    {
        return array();

    }//end getWarningList()


}//end class


