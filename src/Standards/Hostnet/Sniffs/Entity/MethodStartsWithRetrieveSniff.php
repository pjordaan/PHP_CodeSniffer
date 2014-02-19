<?php

/**
 * Doctrine uses find, and findByXxx functions.
 *
 * In Propel this code style was retrieveByXxx.
 *
 * Practice has shown that programmers sometimes try to use retrieveByXxx in Doctrine as well.
 * @author Nico Schoenmaker <nschoenmaker@hostnet.nl>
 */
class Hostnet_Sniffs_Entity_MethodStartsWithRetrieveSniff implements \PHP_CodeSniffer_Sniff
{

  public function register()
  {
    return array(T_FUNCTION);
  }

  public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
  {
      $functionName = $phpcsFile->getDeclarationName($stackPtr);
      if ($functionName === null) {
        // Ignore closures.
        return;
      }

      if (strpos($functionName, 'retrieve') === 0) {
          $errorData = array($functionName);
          $error = 'Function name "%s" is invalid; start with findXxx in Doctrine.';
          $phpcsFile->addError($error, $stackPtr, 'MethodStartsWithRetrieve', $errorData);
      }

  }
}