<?php
  /*****************************************************
  ** Script configuration - for the documentation of
  ** following variables please take a look at the
  ** documentation file in folder 'docu'.
  *****************************************************/
  $vote_title       = 'First Content Choice';
  $vote_text        = 'What is your first choice for conference content?';
  $vote_option[]    = 'Paper/presentation on LLVM';
  $vote_option[]    = 'Paper/presentation on compiler technology';
  $vote_option[]    = 'Paper/Presentation on using LLVM';
  $vote_option[]    = 'Other paper/Presentation';
  $vote_option[]    = 'Tutorial on using LLVM';
  $vote_option[]    = 'Tutorial on developing LLVM (extension or maintenance)';
  $vote_option[]    = 'Tutorial on compiler optimization';
  $vote_option[]    = 'Other tutorial';
  $vote_option[]    = 'LLVM help session';
  $vote_option[]    = 'LLVM workshop (plan LLVM future)';
  $vote_option[]    = 'LLVM workshop (resolve current issues)';
  $vote_option[]    = 'Other (send your ideas to llvm-dev mailing list)';
  $intern_vote_name = 'content1';
  $next_page        = 'content2.php';
  $next_question    = 'Second Content Choice';
  include('./vote.details.php');
?>
