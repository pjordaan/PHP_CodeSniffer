<?php
class Entity_Sniffs_Services_ServicePersistOrFlushNotAllowedSniff implements PHP_CodeSniffer_Sniff
{

    /**
     *
     * @see PHP_CodeSniffer_Sniff::register()
     */
    public function register()
    {
        return [
                T_OBJECT_OPERATOR,
                T_FUNCTION
        ];
    }

    /**
     *
     * @see PHP_CodeSniffer_Sniff::process()
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $this->findNextTStringContent($tokens, $stackPtr + 1);

        if($tokens[$stackPtr]["code"] == T_OBJECT_OPERATOR && in_array($token['content'], [
                "flush",
                "persist"
        ])) {
            $phpcsFile->addError("Calling a {$token['content']} is not allowed in the service in {$phpcsFile->getFilename()} at line {$token['line']}.", $stackPtr + 1);
        } elseif($tokens[$stackPtr]["code"] == T_FUNCTION && in_array($token['content'], [
                "flush",
                "persist"
        ])) {
            $phpcsFile->addError(ucfirst($token['content']) . " should not be defined as one of the class methods in {$phpcsFile->getFilename()} at line {$token['line']}.", $stackPtr + 1);
        }
    }

    private function findNextTStringContent(array $tokens, $strackPrt)
    {
        while($strackPrt < count($tokens)) {
            if($tokens[$strackPrt]['code'] == T_STRING) {
                return $tokens[$strackPrt];
            }
            $strackPrt++;
        }

        throw new \RuntimeException("Could not find token.");
    }
}