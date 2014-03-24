<?php
/**
 * PEAR_Sniffs_Functions_ValidDefaultValueSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * PEAR_Sniffs_Functions_ValidDefaultValueSniff.
 *
 * A Sniff to ensure that parameters defined for a function that have a default
 * value come at the end of the function signature.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class PEAR_Sniffs_Functions_ValidDefaultValueSniff implements PHP_CodeSniffer_Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_FUNCTION);

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $argStart = $tokens[$stackPtr]['parenthesis_opener'];
        $argEnd   = $tokens[$stackPtr]['parenthesis_closer'];

        $nextArg = $argStart;
        $parameters = [];
        while (($nextArg = $phpcsFile->findNext(T_VARIABLE, ($nextArg + 1), $argEnd)) !== false) {
            $argDefault = self::_argGetDefault($phpcsFile, $nextArg);
            $argHasTypeHint = self::_argHasTypeHint($phpcsFile, $nextArg);
            $parameters[$nextArg] = ['null_hint' => $argDefault['code'] === T_NULL && $argHasTypeHint, 'default' => $argDefault['content']];
        }

        $parameters = array_reverse($parameters, true);
        $gap = false;
        $error  = 'Arguments with default values must be at the end of the argument list';
        foreach($parameters as $token => $param) {
            $nullHint = $param['null_hint'];
            $default = $param['default'];

            if ($gap  === true && $default && $nullHint === false) {
                $err = 'X';
                $phpcsFile->addError($error, $token, 'NotAtEnd');
            } else {
                $err =' ';
            }
            if (!$default) {
                $gap = true;
            }
        }
    }//end process()


    /**
     * Returns TOKEN_CODE if the passed argument has a default value or false.
     * 
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $argPtr    The position of the argument
     *                                        in the stack.
     *
     * @return bool
     */
    private static function _argGetDefault(PHP_CodeSniffer_File $phpcsFile, $argPtr)
    {
        $tokens    = $phpcsFile->getTokens();
        $nextToken = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, ($argPtr + 1), null, true);
        if ($tokens[$nextToken]['code'] !== T_EQUAL) {
            return false;
        }

        $defaultToken = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, ($nextToken + 1), null, true);
        return $tokens[$defaultToken];

    }//end _argGetDefault()

    /**
     * Returns true if the passed argument has a Type Hint.
     * 
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $argPtr    The position of the argument
     *                                        in the stack.
     *
     * @return bool
     */
    private static function _argHasTypeHint(PHP_CodeSniffer_File $phpcsFile, $argPtr)
    {
        $tokens    = $phpcsFile->getTokens();
        $nextToken = $phpcsFile->findPrevious(PHP_CodeSniffer_Tokens::$emptyTokens, ($argPtr - 1), null, true);
        if ($tokens[$nextToken]['code'] !== T_STRING) {
            return false;
        }

        return true;

    }//end _argHasTypeHint()


}//end class

