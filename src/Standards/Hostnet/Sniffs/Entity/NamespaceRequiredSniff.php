<?php
/**
 * All classes, traits and interfaces should be namespaced.
 * @author Nico Schoenmaker <nschoenmaker@hostnet.nl>
 */
class Hostnet_Sniffs_Entity_NamespaceRequiredSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Registers the tokens that this sniff wants to listen for.
     *
     * @return array(integer)
     */
    public function register()
    {
        return array(T_OPEN_TAG);
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $findTokens = array(T_NAMESPACE,
                       T_CLASS,
                       T_INTERFACE,
                       T_TRAIT);

        $stackPtr = $phpcsFile->findNext($findTokens, ($stackPtr + 1));

        if (in_array($tokens[$stackPtr]['code'], [T_OPEN_TAG, T_CLOSE_TAG])) {
            // We can stop here. The sniff will continue from the next open
            // tag when PHPCS reaches that token, if there is one.
            return;
        } elseif ($tokens[$stackPtr]['code'] === T_NAMESPACE) {
            // We found a namespace, it's ok!
            return;
        }

        // This is a class, an interface or a trait.
        $nameToken = $phpcsFile->findNext(T_STRING, $stackPtr);

        $name = $tokens[$nameToken]['content'];
        $type = strtolower($tokens[$stackPtr]['content']);
        $file = $phpcsFile->getFilename();
        $line = $tokens[$stackPtr]['line'];
        $error = 'The %s named "%s" does not have a namespace in %s on line %s';
        $data  = array(
             $type,
             $name,
             $file,
             $line,
        );
        $phpcsFile->addError($error, $stackPtr, 'Found', $data);
    }
}


