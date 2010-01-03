<?php
  /*****************************************************
  ** Script configuration - for the documentation of
  ** following variables please take a look at the
  ** documentation file in folder 'docu'.
  *****************************************************/
  $vote_title       = 'Primary Benefit';
  $vote_text        = 'What would be your primary benefit for this conference?';
  $vote_option[]    = 'Meeting LLVM people';
  $vote_option[]    = 'Understanding the science of compiler optimization';
  $vote_option[]    = 'Exchanging ideas with colleagues';
  $vote_option[]    = 'Discovering new ways to use LLVM';
  $vote_option[]    = 'Learning LLVM better';
  $vote_option[]    = 'Making business contacts';
  $vote_option[]    = 'Other';
  $intern_vote_name = 'benefit1';
  $next_page        = 'benefit2.php';
  $next_question    = 'Secondary Benefit';
  include('./vote.details.php');
?>
