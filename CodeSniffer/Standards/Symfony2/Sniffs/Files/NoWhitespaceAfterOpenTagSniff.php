<?php
/**
 * PSR2_Sniffs_Files_EndFileWhitespaceSniff.
 *
 * Checks that there is a single blank line at the end of PHP files.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2011 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Symfony2_Sniffs_Files_NoWhitespaceAfterOpenTagSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_OPEN_TAG);
    }

    //end register()

    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        // We are only interested if this is the first open tag.
        if ($stackPtr !== 0) {
            if ($phpcsFile->findPrevious(T_OPEN_TAG, ($stackPtr - 1)) !== false) {
                return;
            }
        }

        // Skip to the end of the file.
        $tokens     = $phpcsFile->getTokens();
        $blankLines = 0;
        $stackPtr   = 0;

        while ($tokens[++$stackPtr]['code'] === T_WHITESPACE) {
            $blankLines++;
        }

        if ($blankLines) {
            $error = 'Expected 0 blank after open tag; "%s" found';
            $data  = array($blankLines);
            $phpcsFile->addError($error, $stackPtr, 'Found', $data);
        }
    }
    //end process()

}

//end class

?>