<?php

  /*****************************************************
  ** Title........: Function Collection
  ** Filename.....: functions.inc.php
  ** Author.......: Ralf Stadtaus
  ** Homepage.....: http://www.stadtaus.com/
  ** Contact......: http://www.stadtaus.com/forum/
  ** Version......: 1.7
  ** Notes........:
  ** Last changed.: 2004-03-18
  ** Last change..: get_ip()
  *****************************************************/

  /*****************************************************
  **
  ** THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY
  ** OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT
  ** LIMITED   TO  THE WARRANTIES  OF  MERCHANTABILITY,
  ** FITNESS    FOR    A    PARTICULAR    PURPOSE   AND
  ** NONINFRINGEMENT.  IN NO EVENT SHALL THE AUTHORS OR
  ** COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES
  ** OR  OTHER  LIABILITY,  WHETHER  IN  AN  ACTION  OF
  ** CONTRACT,  TORT OR OTHERWISE, ARISING FROM, OUT OF
  ** OR  IN  CONNECTION WITH THE SOFTWARE OR THE USE OR
  ** OTHER DEALINGS IN THE SOFTWARE.
  **
  *****************************************************/




  /*****************************************************
  ** Prevent direct call
  *****************************************************/
          if (!defined('IN_SCRIPT')) {
              die();
          }




  /*****************************************************
  ** Print debug messages
  *****************************************************/
          function debug_mode($msg, $desc = '') {
              global $debug_mode;

              if ($debug_mode == 'on' and !empty($msg)) {
                  if (!is_array($msg)) {
                      $msg = (array) $msg;
                  }

                  for($i = 0; $i < count($msg); $i++)
                  {
                      echo '<pre><strong>' . $desc . '</strong>' . "\n\n" . htmlspecialchars($msg[$i]) . '</pre>.............................................................................<br />';
                  }
              }
          }



  /*****************************************************
  ** Show server info for the admin
  *****************************************************/
          function get_phpinfo($msg = '')
          {
              if (isset ($_GET['ap']) and $_GET['ap'] == 'phpinfo') {
                  $additional_content = '';
                  if (!empty($msg)) {
                      if (!is_array($msg)) {
                          $msg = (array) $msg;
                      }

                      while(list($key, $val) = each($msg))
                      {
                          $dots = '';

                          for($i = 1; $i <= 35 - strlen($key); $i++)
                          {
                              $dots .= '.';
                          }
                          $additional_content .= $key . $dots . $val . "\n";
                      }
                  }

                  ob_start();
                  phpinfo ();
                  $php_information = ob_get_contents();
                  ob_end_clean();
                  echo preg_replace("/<body(.*?)>/i", '<body' . "$1" . '><pre style="color:#CFCFCF;">' . $additional_content . '</pre><br /><br />', $php_information);

                  exit;
              }
          }




  /*****************************************************
  ** Output script runtime
  *****************************************************/
          function script_runtime($runtime_start)
          {
              $runtime_end = explode (' ', microtime ());
              $runtime_difference = $runtime_end[1]     - $runtime_start[1];
              $runtime_summe      = $runtime_difference + $runtime_end[0];
              $runtime            = $runtime_summe      - $runtime_start[0];

              return $runtime;
          }




  /*****************************************************
  ** Print Array
  *****************************************************/
          function print_a($ar)
          {
              echo '<pre>';

              print_r($ar);

              echo '</pre>';
          }




  /*****************************************************
  ** Error HTML content
  *****************************************************/
          function load_error_template()
          {
              $error_template = '<html>
                                          <head>
                                            <title>{txt_script_name} {txt_script_version}</title>
                                            <meta http-equiv="Content-Type" content="text/html; {txt_charset}" />
                                          </head>

                                          <style type="text/css">
                                          <!--
                                            h4 {
                                                font-family:Courier New,Sans-serif;
                                                }

                                            p, td, br, form, div, span, blockquote {
                                                font-family:Courier New,Sans-serif;
                                                font-size:9.5pt;
                                                }

                                            .code {
                                                font-family:Courier New,Sans-serif;
                                                }

                                            .code strong {
                                                color:#FF9F00;
                                                }

                                            #poweredby {
                                                text-align:center;
                                                }

                                            #poweredby span {
                                                font-family:Arial,Helvetica,Sans-serif;
                                                }


                                          -->
                                          </style>

                                          <body>

                                          <p class="code"><strong>{txt_system_message}</strong></p>
                                          <LOOP NAME="system_message">
                                            <p class="code">{message}<br><br><br></p>
                                          </LOOP NAME="system_message">



                                          <p>&nbsp;</p>
                                          <p>&nbsp;</p>


                                        </body>
                                        </html>

                                  ';

              return $error_template;
          }




          /*****************************************************
          ** Get environment variables
          *****************************************************/
                  function date_elements($date)
                  {
                      $elements = explode(' ', date("Y m d H i s", $date));

                      $environment = array(

                                              'year'           => $elements[0]
                                             ,'month'          => $elements[1]
                                             ,'day'            => $elements[2]
                                             ,'hour'           => $elements[3]
                                             ,'minute'         => $elements[4]
                                             ,'second'         => $elements[5]

                                             ,'iso_date'       => $elements[0] . '-' . $elements[1] . '-' . $elements[2] . ' (' . $elements[3] . ':' . $elements[4] . ':' . $elements[5] . ')'


                                           );

                      return $environment;
                  }




          /*****************************************************
          ** Get real user ip - taken from php.net user
          ** contribution.
          *****************************************************/
                  function get_ip() 
                  {
                      if (isset($_SERVER) and !empty($_SERVER)) {
                          if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                              $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                          } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                              $ip = $_SERVER['HTTP_CLIENT_IP'];
                          } else {
                              $ip = $_SERVER['REMOTE_ADDR'];
                          }                    
                      } else {
                          if (getenv('HTTP_X_FORWARDED_FOR')) {
                              $ip = getenv('HTTP_X_FORWARDED_FOR');
                          } else if (getenv('HTTP_CLIENT_IP')) {
                              $ip = getenv('HTTP_CLIENT_IP');
                          } else {
                              $ip = getenv('REMOTE_ADDR');
                          }
                      }
                
                      return $ip;
                  }

?>