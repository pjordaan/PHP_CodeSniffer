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

        $t_class_pointer = false;
        for($i = 0; $i < count($tokens); $i++) {
            if($tokens[$i]['code'] == T_CLASS) {
                $t_class_pointer = $i;
                break;
            }
        }

        $class_name_token = [];
        if($t_class_pointer) {
            $class_name_token = $this->findNextTStringContent($tokens, $t_class_pointer);

            $is_service_class = preg_match('/.*Service$/', $class_name_token['content']) === 1;
            $is_service_extends = $phpcsFile->findExtendedClassName($t_class_pointer) == "EntityRepository";
        }

        if($is_service_filename || $is_service_namespace || $is_service_class || $is_service_extends) {
            if(!$is_service_filename) {
                $phpcsFile->addError("Filename '{$phpcsFile->getFilename()}' does not end with 'Service'.", 0);
            }
            if(!$is_service_namespace) {
                $phpcsFile->addError("Namespace doesn not contain 'Service'.", $namespace_line);
            }
            if($t_class_pointer) {
                if(!$is_service_class) {
                    $phpcsFile->addError("Service class '{$class_name_token['content']}' does not end with 'Service'.", $tokens[$t_class_pointer]['line']);
                }
                if(!$is_service_extends) {
                    $phpcsFile->addError("Service '{$class_name_token['content']}' should extend EntityRepository.", $tokens[$t_class_pointer]['line']);
                }
            } else {
                $phpcsFile->addError("Filename '{$phpcsFile->getFilename()}' does not contain class.", 0);
            }
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