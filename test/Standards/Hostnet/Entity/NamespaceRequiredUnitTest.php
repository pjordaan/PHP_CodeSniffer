<?php

/**
 *
 * @author Nico Schoenmaker <nschoenmaker@hostnet.nl>
 */
class Hostnet_Entity_NamespaceRequiredUnitTest extends AbstractSniffUnitTest
{
    public function getErrorList($testFile = '')
    {
        switch($testFile) {
            case 'NamespaceRequiredUnitTest.0.inc':
            case 'NamespaceRequiredUnitTest.1.inc':
            case 'NamespaceRequiredUnitTest.2.inc':
            case 'NamespaceRequiredUnitTest.3.inc':
                return [];
            case 'NamespaceRequiredUnitTest.4.inc':
                return [2 => 1];
            case 'NamespaceRequiredUnitTest.5.inc':
                return [6 => 1];
            case 'NamespaceRequiredUnitTest.6.inc':
                return [7 => 1];

        }
        return [];
    }

    public function getWarningList()
    {
        return [];
    }
}


