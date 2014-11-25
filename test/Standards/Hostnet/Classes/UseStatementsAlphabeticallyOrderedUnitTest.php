<?php

class Hostnet_Classes_UseStatementsAlphabeticallyOrderedUnitTest extends AbstractSniffUnitTest
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
        switch($filename) {
            case 'UseStatementsAlphabeticallyOrderedUnitTest.0.inc' :
                return [];
            case 'UseStatementsAlphabeticallyOrderedUnitTest.1.inc' :
                return array(16 => 1, 18 => 1);
            case 'UseStatementsAlphabeticallyOrderedUnitTest.2.inc' :
                return array(4 => 1, 11 => 2);
            case 'UseStatementsAlphabeticallyOrderedUnitTest.3.inc' :
                return array(16 => 1, 18 => 1);
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

    }
}
