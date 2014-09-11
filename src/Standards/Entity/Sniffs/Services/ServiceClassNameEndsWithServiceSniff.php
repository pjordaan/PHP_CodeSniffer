<?php
class Entity_Sniffs_Services_ServiceClassNameEndsWithServiceSniff implements PHP_CodeSniffer_Sniff
{
    /**
     *
     * @see PHP_CodeSniffer_Sniff::register()
     */
    public function register()
    {
        return [
            T_NAMESPACE
        ];
    }

    /**
     *
     * @see PHP_CodeSniffer_Sniff::process()
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $is_service_filename = preg_match('/.*Service(\.inc|\.php)$/', $phpcsFile->getFilename()) === 1;
        $is_service_namespace = false;
        $is_service_class = false;
        $is_service_extends = false;
        $class_found = false;

        $tokens = $phpcsFile->getTokens();
        $namespace_line = $tokens[$stackPtr]['line'];
        $stackPtr++;
        while($stackPtr < count($tokens)) {
            if($tokens[$stackPtr]['code'] == T_SEMICOLON) {
                break;
            } elseif($tokens[$stackPtr]['code'] == T_STRING) {
                $is_service_namespace = $is_service_namespace || strtolower($tokens[$stackPtr]['content']) == "service";
            }
            $stackPtr++;
        }

        $start = $stackPtr;
        while ($t_class_pointer = $phpcsFile->findNext([T_CLASS], $start))
        {
            $start = $t_class_pointer + 1;
            $class_found = true;

            $extends_class = $phpcsFile->findExtendedClassName($t_class_pointer);
            if($extends_class == "\PHPUnit_Framework_TestCase" || $extends_class == "\Exception") {
                continue;
            }

            $token = $phpcsFile->findNext([T_STRING], $t_class_pointer);
            $name  = $tokens[$token]['content'];

            if(preg_match('/.*Service$/', $name) !== 1) {
                $phpcsFile->addError("Service class '{$name}' does not end with 'Service'.", $token);
            }
            if(!$extends_class == "EntityRepository") {
                $phpcsFile->addError("Service '{$name}' should extend EntityRepository.", $token);
            }
        }

        if(!$is_service_filename) {
             $phpcsFile->addError("Filename '{$phpcsFile->getFilename()}' does not end with 'Service'.", 0);
        }

        if(!$is_service_namespace) {
            $phpcsFile->addError("Namespace doesn not contain 'Service'.", $namespace_line);
        }

        if(!$class_found) {
            $phpcsFile->addError("Filename '{$phpcsFile->getFilename()}' does not contain class.", 0);
        }
    }
}
