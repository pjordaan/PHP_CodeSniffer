<?php
/**
 * Checks if there is vertical whitespace between use statements
 *
 * @author Nikos Savvidis
 */
class Hostnet_Sniffs_Classes_NoVerticalWhitespaceBetweenUseStatementsSniff implements PHP_CodeSniffer_Sniff
{
  /**
   * Returns the token types that this sniff is interested in.
   *
   * @return array(int)
   */
  public function register()
  {
    return array(T_USE);
  } // register

  /**
   * Processes the tokens that this sniff is interested in.
   *
   * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
   * @param int $stackPtr The position in the stack where the token was found.
   *
   * @return void
   */
  public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
  {
    // only check for use statements that are before the first class declaration
    // classes can have use statements for traits, for which we are not interested in this sniff
    $first_class_occurence = $phpcsFile->findPrevious([T_CLASS], $stackPtr);
    if ($first_class_occurence > 0 && $stackPtr > $first_class_occurence) {
        return;
    }

    $tokens     = $phpcsFile->getTokens();

    // Reach the end of the current statement
    $stackPtr = $phpcsFile->findNext([T_SEMICOLON], ($stackPtr + 1));

    // Find the next newline character (to skip trailing whitespace or inline comments after the semicolon)
    $stackPtr = $phpcsFile->findNext([T_WHITESPACE], ($stackPtr + 1) , null , false , "\n");

    // if there is another 'use' statement, it should be at $stackPtr + 1
    $next_use = $phpcsFile->findNext([T_USE] , ($stackPtr + 1));
    $next_class = $phpcsFile->findNext([T_CLASS], ($stackPtr + 1));
    if ($next_class === false || $next_class > 0 && $next_use < $next_class) { // to make sure the next use is not regarding a Trait
        $stackPtr += 1;
        if ($tokens[$stackPtr]['code'] == T_WHITESPACE && strcmp($tokens[$stackPtr]['content'] , "\n") != 0) {
            $stackPtr += 1; // there is blank whitespace before the next token
        }
        if ($next_use > ($stackPtr)) { // there is either a newline, or a comment in between the 'use' statements
            $this->checkForNewlineOrComments($phpcsFile, $stackPtr);
        }
    }
  } // process

  private function checkForNewlineOrComments (PHP_CodeSniffer_File $phpcsFile, $stackPtr)
  {
    $tokens = $phpcsFile->getTokens();
    if ($tokens[$stackPtr]['code'] == T_COMMENT) {
        $error = "There shouldn't be anything between 'use' statements.";
        $phpcsFile->addError($error, $stackPtr, 'VerticalWhitespace');
    } elseif (strcmp($tokens[$stackPtr]['content'] , "\n") == 0) {
        $error = "Newline should not be present here ";
        $phpcsFile->addError($error, $stackPtr, 'VerticalWhitespace');
    }
  }

} // Hostnet_Sniffs_Classes_NoVerticalWhitespaceBetweenUseStatementsSniff
