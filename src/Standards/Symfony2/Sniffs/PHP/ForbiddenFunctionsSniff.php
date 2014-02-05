<?php
/**
 * Generic_Sniffs_PHP_ForbiddenFunctionsSniff.
 *
 * Discourages the use of alias functions that are kept in PHP for compatibility
 * with older versions. Can be used to forbid the use of any function.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006-2011 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Symfony2_Sniffs_PHP_ForbiddenFunctionsSniff extends Squiz_Sniffs_PHP_ForbiddenFunctionsSniff
{

    /**
     * A list of forbidden functions with their alternatives.
     *
     * The value is NULL if no alternative exists. IE, the
     * function should just not be used.
     *
     * @var array(string => string|null)
     */
    protected $forbiddenFunctions = array(
        'sizeof'          => 'count',
        'delete'          => 'unset',
        'die'             => 'exit',
        'error_log'       => null,
        'print_r'         => null,
        'is_null'         => null,
        'create_function' => null,
        'print'           => null,
        'echo'            => null,
        'exit'            => null,
        'var_dump'        => null,
        'printf'          => null,
        'ord'             => null,
        'chr'             => null,
        'fprintf'         => null,
        'fopen'           => null,
        'fclose'          => null,
        'parse_str'       => null,
        'extract'         => null,
        'stripcslashes'   => null,
        'sscanf'          => null,
        'join'            => 'implode',
        'chop'            => 'explode',
        'ereg'            => 'preg_match',
        'eregi'           => 'preg_match',
        'ereg_replace'    => 'preg_replace',
        'split'           => 'preg_split',
        'spliti'          => 'preg_split',
        'sql_regcase'     => null,
        'mysql_connect'   => null,
        'mysql_query'     => null,
        'mysql_result'    => null,
    );

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        $tokens = parent::register();
        $tokens[] = T_ECHO;
        return $tokens;

    }//end register()

}

//end class

?>
