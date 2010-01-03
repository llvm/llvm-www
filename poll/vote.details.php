<?
  $form_field_type        = 'radio';    // (radio, select, readio_image)
  $bar_image_name         = 'blue.gif';
  $max_bar_width          = '300';      // (pixel)
  $check_ip_address       = 'yes';       // (yes/no)
  $check_cookie           = 'yes';
  $language               = 'en';       // See folder "languages"
  $path['templates']      = './';
  $path['logfiles']       = './logs/';
  $tmpl['layout']         = 'voting.tpl.html';
  $log['logfile']         = "$intern_vote_name.txt";
  $show_error_messages    = 'yes';

  /*****************************************************
  ** Add here further words, text, variables and stuff
  ** that you want to appear in the template.
  *****************************************************/
  $add_text = array(
    'txt_additional'    => 'Additional',  //  {txt_additional}
    'txt_more'          => 'More',        //  {txt_more}
    'txt_script_name'   => 'Voting Script',
    'txt_next_page'     => "$next_page",
    'txt_next_question' => "$next_question"
  );

  /*****************************************************
  ** Send safety signal to included files
  *****************************************************/
  define('IN_SCRIPT', 'true');                            

  /*****************************************************
  ** Include script code
  *****************************************************/
  $script_root = './';
  include($script_root . 'inc/core.inc.php');
?>
