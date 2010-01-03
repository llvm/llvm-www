<?php

  /*****************************************************
  ** Title........: Form field class
  ** Filename.....: form_fields.class.inc.php
  ** Author.......: Ralf Stadtaus
  ** Homepage.....: http://www.stadtaus.com/
  ** Contact......: http://www.stadtaus.com/forum/
  ** Version......: 0.4
  ** Notes........: Generates form fields
  ** Last changed.: 2004-01-22
  ** Last change..: 
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
  ** Define class
  *****************************************************/
          class Formfields
          {
              var $form_fields;
              var $templates;




              /*****************************************************
              ** Get form field templates
              *****************************************************/
                      function form_field_templates($data)
                      {
                          if (!empty($data)) {
                              $this->templates = $data;
                          }
                      }




              /*****************************************************
              ** Add new form field
              *****************************************************/
                      function generate_form_fields($data, $input = '')
                      {
                          if (!empty($data) and is_array($data)) {
                              while(list($key, $form_data) = each($data))
                              {
                                  $unset_array        = array();
                                  $new_form_field     = $this->templates[$form_data['type']];
                                  $form_data['value'] = stripslashes($form_data['value']);
                                  
                                  if (isset($input[$form_data['name']])) {
                                      $input[$form_data['name']] = stripslashes($input[$form_data['name']]);
                                  }




                                  /*****************************************************
                                  ** Add value to text area
                                  *****************************************************/
                                          if ($form_data['type'] == 'textarea') {
                                              
                                              if (isset($form_data['value'])) {
                                                  $textarea_value = $form_data['value'];
                                              }
                                              
                                              if (isset($input[$form_data['name']])) {
                                                  $textarea_value = $input[$form_data['name']];
                                              }
                                              
                                              if (isset($textarea_value)) {
                                                  $new_form_field = preg_replace("#>(.*?)</textarea>#i", '>' . "$1" . $textarea_value . '</textarea>', $new_form_field);
                                                  $unset_array[]  = 'value';
                                              }
                                              
                                          }




                                  /*****************************************************
                                  ** Generate select field option values
                                  *****************************************************/
                                          if ($form_data['type'] == 'select' and isset($form_data['value'])) {

                                              $option_template = $this->templates['option'];
                                              $option_values   = explode(',', $form_data['value']);
                                              
                                              
                                              if (isset($form_data['selected']) and !empty($form_data['selected'])) {
                                                  $select_value = $form_data['selected'];
                                              }
                                              
                                              if (isset($input[$form_data['name']]) and !empty($input[$form_data['name']])) {
                                                  $select_value = $input[$form_data['name']];
                                              }

                                              for($i = 0; $i < count($option_values); $i++)
                                              {
                                                  $option_content = $option_template;
                                                  $current_value  = trim($option_values[$i]);

                                                  if (isset($select_value) and $select_value == $current_value) {
                                                      $option_content = str_replace('{selected}', 'selected="selected"', $option_content);
                                                  } else {
                                                      $option_content = str_replace('{selected}', '', $option_content);
                                                  }

                                                  $option_code[]  = str_replace('{value}', $current_value, $option_content);
                                              }

                                              $new_form_field = preg_replace("#>(.*?)</select>#i", '>' . "$1" . join('', $option_code) . '</select>', $new_form_field);
                                              $unset_array[]  = 'value';
                                          }




                                  /*****************************************************
                                  ** Generate radio button fields
                                  *****************************************************/
                                          if (($form_data['type'] == 'radio' or $form_data['type'] == 'radio_image') and isset($form_data['value'])) {

                                              $radio_button_template = $this->templates[$form_data['type']];
                                              $radio_button_values   = explode(',', $form_data['value']);
                                              
                                              
                                              if (isset($form_data['selected']) and !empty($form_data['selected'])) {
                                                  $select_value = $form_data['selected'];
                                              }
                                              
                                              if (isset($input[$form_data['name']]) and !empty($input[$form_data['name']])) {
                                                  $select_value = $input[$form_data['name']];
                                              }
                                              

                                              for($i = 0; $i < count($radio_button_values); $i++)
                                              {
                                                  $radio_button_content = $radio_button_template;
                                                  $current_value        = trim($radio_button_values[$i]);
                                                  
                                                  if (isset($select_value) and $select_value == $current_value) {
                                                      $radio_button_content = str_replace('{selected}', 'checked="checked"', $radio_button_content);
                                                  } else {
                                                      $radio_button_content = str_replace('{selected}', '', $radio_button_content);
                                                  }

                                                  $radio_button_content  = str_replace('{label}', $current_value, $radio_button_content);
                                                  $radio_button_content  = str_replace('{field_name}', $form_data['name'], $radio_button_content);
                                                  $radio_button_content  = str_replace('{key}', $i, $radio_button_content);


                                                  $radio_button_code[]  = str_replace('{value}', $current_value, $radio_button_content);
                                              }

                                              $new_form_field = join('', $radio_button_code);
                                              $unset_array[]  = 'value';
                                          }




                                  /*****************************************************
                                  ** Apply pre-defined values (i.e. post data) to form fields
                                  *****************************************************/
                                          if (!empty($input) and isset($input[$form_data['name']])) {
                                              $form_data['value'] = $input[$form_data['name']];
                                          }




                                  /*****************************************************
                                  ** Unset control values
                                  *****************************************************/
                                          $unset_array = array_merge($unset_array, array('type', 'selected', 'required', 'label'));

                                          while(list($key, $val) = each($unset_array))
                                          {
                                              unset($form_data[$val]);
                                          }





                                  /*****************************************************
                                  ** Add attributes to form field
                                  *****************************************************/
                                          reset($form_data);

                                          while(list($attribute, $value) = each($form_data))
                                          {
                                              $new_form_field = str_replace('{attributes}', $attribute . '="' . $value . '" {attributes}', $new_form_field);
                                          }



                                  $this->form_fields[$form_data['name']] = str_replace('{attributes}', '', $new_form_field);
                              }
                          }
                      }




              /*****************************************************
              ** Parse new form fields into HTML template
              *****************************************************/
                      function parse_template($html, $form)
                      {
                          if (!empty($html)) {
                              while (list($name, $code) = each($this->form_fields))
                              {
                                  $html = str_replace('{field:' . $name . '}', $code, $html);
                              }

                              while (list($key, $val) = each($form))
                              {
                                  $html = str_replace('{label:' . $val['name'] . '}', $val['label'], $html);
                              }

                              return $html;
                          }
                      }




              /*****************************************************
              ** Check for required fields
              *****************************************************/
                      function required_fields($form)
                      {
                          if (!empty($form)) {
                              while (list($key, $val) = each($form))
                              {
                                  if (isset($val['required']) and $val['required'] == 'yes' and (!isset($_POST[$val['name']]) or empty($_POST[$val['name']]))) {
                                      $required_fields[] = $val['label'];
                                  }
                              }

                              if (isset($required_fields) and !empty($required_fields)) {
                                  return $required_fields;
                              }
                          }
                      }





          } // End class Formfields

?>