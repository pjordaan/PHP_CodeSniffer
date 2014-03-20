<?php

class Hostnet_Sniffs_Commenting_AuthorIsFormattedCorrectlySniff implements PHP_CodeSniffer_Sniff
{

  public function register()
  {
    // TODO: Auto-generated method stub
    return PHP_CodeSniffer_Tokens::$commentTokens;
  }

  public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
  {

    $tokens = $phpcsFile->getTokens();

    $content = $tokens[$stackPtr]['content'];

    $matches = array();
    if(preg_match('/[*]?[\s]* @author (.*)/', $content, $matches) !== 0) {
        if(preg_match('/([\D]+[\s|-])+([<]{1}[\w]+[@]{1}[\w]+[.]{1}[\w]+[>]{1}){1}$/', $matches[1]) === 0) {

          $type        = 'CommentFound';
          $comment_msg = trim($matches[1]);
          $error       = 'Comment refers to Author annotation: Format is incorrect';
          $data        = array($comment_msg);
          if ($comment_msg !== '') {
            $type   = 'CommentFound';
            $error .= '  "%s"';
          }
          $phpcsFile->addError($error, $stackPtr, $type, $data);
        } else {
          if(stristr($matches[1], 'Nico')){
            $phpcsFile->addWarning("Let Op!! Nico is breaking something", $stackPtr);
          }
        }


    }

  }

}
