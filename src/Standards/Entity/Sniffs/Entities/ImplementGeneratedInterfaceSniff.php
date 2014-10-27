<?php

/**
 * Interfaces are automatically generated for entities. This code sniffer checks whether all the
 * entities implement their generated interface.
 *
 * @author Eddy Pouw <epouw@hostnet.nl>
 */
class Entity_Sniffs_Entities_ImplementGeneratedInterfaceSniff implements \PHP_CodeSniffer_Sniff
{

    /**
     * @see PHP_CodeSniffer_Sniff::register()
     */
    public function register()
    {
        return [T_CLASS];
    }

    /**
     * @see PHP_CodeSniffer_Sniff::process()
     */
    public function process(PHP_CodeSniffer_File $phpcs_file, $stack_ptr)
    {
        $class                = $phpcs_file->getDeclarationName($stack_ptr);
        $namespace_pointer    = $phpcs_file->findPrevious([T_NAMESPACE], $stack_ptr);
        $implements_interface = $phpcs_file->findNext([T_IMPLEMENTS], $stack_ptr);
        $paths                = $this->getFullQualifiedPath($phpcs_file, $namespace_pointer);

      //  Check if there are any interfaces implemented
        if (!$implements_interface) {
            $error = 'The entity does not implement an interface at all, while at least the generated interface should be implemented.';
            $phpcs_file->addError($error, $stack_ptr, 'ImplementGeneratedInterface', $implements_interface);
            return;
        }

        $interface_name        = $phpcs_file->findNext(T_STRING, $implements_interface);
        $generated_implemented = false;

        // Go through every interface that is implemented and compare with the expected path
        // While loop will stop when a Curly Bracket is opened or when the end of the file is reached
        while ($interface_name !== false) {

            $new_content               = $phpcs_file->getTokensAsString($interface_name, 1);
            $content                   = "";
            $last_content              = "";
            $use_statement_declaration = "Namespace";

            // Merge the different strings of the interfaces to one string
            while (true) {
                $last_content   = $content;
                $content        = $content . $new_content;
                $interface_name = $phpcs_file->findNext([T_STRING, T_COMMA, T_NS_SEPARATOR, T_CURLY_OPEN, T_WHITESPACE], $interface_name+1);
                $code           = $phpcs_file->getTokens()[$interface_name]['code'];
                if (!in_array($code, [T_STRING, T_NS_SEPARATOR])) {
                    break;
                }
                if ($code !== T_NS_SEPARATOR) {
                    $use_statement_declaration = $last_content;
                }
                $new_content = $phpcs_file->getTokensAsString($interface_name, 1);
            }

            // Check if the interface uses one of the use statements
            if (array_key_exists($use_statement_declaration, $paths)) {
                $interface_path = $paths[$use_statement_declaration] . "\\" . $new_content;
            } else {
                $interface_path = $paths['Namespace'] . "\\" . $content;
            }
            $class_path = $paths['Namespace'] . "\\Generated\\" . $class . 'Interface';

            // Compare the interface path with the expected, generated interface path
            // Return if the expected path is the same as the current path
            if (!substr_compare($interface_path, $class_path, 0)) {
                return;
            }

            $stack_ptr      = $interface_name;
            $interface_name = $phpcs_file->findNext(T_STRING, $stack_ptr+1);
        }

        $error = 'None of the implemented interfaces in the class is the generated class. Make sure you use the generated interface too.';
        $phpcs_file->addError($error, $stack_ptr, 'ImplementGeneratedInterface');
    }

    /**
     *
     * @param PHP_CodeSniffer_File $phpcs_file Code sniffer file
     * @param number $namespace_pointer Indicates where the namespace is in the token stack
     * @return array An array that contains both the namespace and all the use statements
     */
    private function getFullQualifiedPath(PHP_CodeSniffer_File $phpcs_file, $namespace_pointer = 0)
    {
        // Get the namespace if it's not false
        $tokens    = $phpcs_file->getTokens();
        $namespace = "";

        if ($namespace_pointer !== false) {
            $new_content = "";

            // Merge strings and NS Separators to one string, forming the full path
            while (true) {
                $namespace         = $namespace . $new_content;
                $namespace_pointer = $phpcs_file->findNext([T_STRING, T_SEMICOLON, T_NS_SEPARATOR], $namespace_pointer+1);
                $code              = $tokens[$namespace_pointer]['code'];
                if (!in_array($code, [T_STRING, T_NS_SEPARATOR])) {
                    break;
                }
                $new_content = $phpcs_file->getTokensAsString($namespace_pointer, 1);
            }
        }
        $return_array              = $this->retrieveUseStatements($phpcs_file);
        $return_array['Namespace'] = $namespace;
        return $return_array;
    }

    /**
     *
     * @param PHP_CodeSniffer_File $phpcs_file Code sniffer file
     * @return array containing all use statements before the class definition
     */
    private function retrieveUseStatements(PHP_CodeSniffer_File $phpcs_file)
    {
        $stack_pointer     = 0;
        $use_statements    = [];
        $statement_pointer = [];

        // Find the pointers to where the use statements start
        while ($stack_pointer !== false) {
            $stack_pointer = $phpcs_file->findNext([T_USE, T_CLASS], $stack_pointer+1);
            $code          = $phpcs_file->getTokens()[$stack_pointer]['code'];
            if (in_array($code, [T_CLASS])) {
                break;
            }
            array_push($statement_pointer, $stack_pointer);
        }

        // Get the full paths of the use statements
        foreach ($statement_pointer as $stack_pointer) {
            $tokens        = $phpcs_file->getTokens();
            $ignore_string = false;
            $statement     = "";
            $new_content   = "";

            // Merge all strings and NS Separators to one string, which represents the full path
            // Stop merging when a semicolon is found
            while (true) {
                if (!$ignore_string) {
                    $statement = $statement . $new_content;
                }
                $stack_pointer = $phpcs_file->findNext([T_STRING, T_SEMICOLON, T_NS_SEPARATOR, T_AS], $stack_pointer+1);
                $index         = $new_content;
                $new_content   = $phpcs_file->getTokensAsString($stack_pointer, 1);

                $code = $tokens[$stack_pointer]['code'];
                if ($code === T_SEMICOLON) {
                    $use_statements[$index] = $statement;
                    break;
                }
                if ($tokens[$stack_pointer]['code'] === T_AS) {
                    $index         = $phpcs_file->findNext(T_STRING, $stack_pointer);
                    $ignore_string = true;
                }
            }
        }
        return $use_statements;
    }
}
