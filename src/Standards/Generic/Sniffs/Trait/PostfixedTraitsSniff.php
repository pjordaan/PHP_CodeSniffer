<?php

/**
 * Traits need to be postfixed Trait.
 * @author Nico Schoenmaker <nschoenmaker@hostnet.nl>
 */
class Generic_Sniffs_Trait_PostfixedTraitsSniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
                T_TRAIT
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $nameToken = $phpcsFile->findNext(T_STRING, $stackPtr);
        $name = $tokens[$nameToken]['content'];
        if(substr($name, -1 * strlen('Trait')) !== 'Trait') {
            $error = 'Trait "%s" should be postfixed with Trait';
            $phpcsFile->addError($error, $stackPtr);
        }
    }
}
