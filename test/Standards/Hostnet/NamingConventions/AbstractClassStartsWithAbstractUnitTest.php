<?php

/**
 * Unit test for AbstractClassStartsWithAbstract
 * @author Nico Schoenmaker <nschoenmaker@hostnet.nl>
 */
class Hostnet_NamingConventions_AbstractClassStartsWithAbstractUnitTest extends AbstractSniffUnitTest
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
          case 'AbstractClassStartsWithAbstractUnitTest.0.inc':
            return array(3 => 1);
          case 'AbstractClassStartsWithAbstractUnitTest.1.inc':
            return array();
          case 'AbstractClassStartsWithAbstractUnitTest.2.inc':
            return array(3 => 1);
          case 'AbstractClassStartsWithAbstractUnitTest.3.inc':
            return array();
          case 'AbstractClassStartsWithAbstractUnitTest.4.inc':
            return array(3 => 1);
        }
        return array();
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


