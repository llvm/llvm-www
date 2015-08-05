 <?

// Database details. 
include("connectDB.php");
mysql_connect("127.0.0.1", $user, $password) or die(mysql_error());
mysql_select_db($database);

virtual("../header.incl");

function notify() {

$to = "lattner@apple.com,clattner@apple.com";
$subject = "LLVM Dev Meeting Session Proposal";

$body = '<html><body>';

$body .= '<p>Name: ' . $_POST['first'] . ' ' . $_POST['last'] . '</p>';
$body .= '<p>Organization: ' . $_POST['org'] . '</p>';
$body .= '<p>Email: ' . $_POST['email'] . '</p>';
$body .= '<p>Phone: ' . $_POST['phone'] . '</p>';
$body .= '<p>Title: ' . $_POST['title'] . '</p>';
$body .= "<p>Summary: " . $_POST['summary'] . '</p>';

if($_POST['talkType'] == 1)
$talkType = "Talk";
else if($_POST['talkType'] == 2)
$talkType = "BOF";
else if($_POST['talkType'] == 3)
$talkType = "Poster";

$body .= '<p>Type: ' . $talkType . '</p>';

if($_POST['min'] == 1)
$min =20;
else if ($_POST['min'] == 2)
$min = 30;
else if($_POST['min'] == 3)
$min = 45;
else if($_POST['min'] == 4)
$min = 60;

$body .= '<p>Min Length: ' . $min . ' minutes</p>';

if($_POST['max'] == 1)
$max =20;
else if ($_POST['max'] == 2)
$max = 30;
else if($_POST['max'] == 3)
$max = 45;
else if($_POST['max'] == 4)
$max = 60;

$body .= '<p>Max Length: ' . $max . ' minutes</p>';

$body .= '</body></html>';

$headers = 'From: lattner@apple.com' . "\r\n";
$headers .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
mail($to, $subject, $body, $headers);

}


function my_escape_string(&$item, $key) {
  $item = mysql_real_escape_string($item);
}

function processForm() {
  array_walk($_POST, 'my_escape_string');
  $sql = "INSERT into presenters (lastName, firstName, organization, email, phone, title, summary, minLength, maxLength,talkType) VALUES('$_POST[last]', '$_POST[first]', '$_POST[org]', '$_POST[email]', '$_POST[phone]', '$_POST[title]', '$_POST[summary]','$_POST[min]', '$_POST[max]', '$_POST[talkType]')";
  mysql_query($sql) or die(mysql_error());
print 'Congratulations! Your talk proposal for the LLVM Developers\' Meeting has been submitted. We will contact you once the agenda has been finalized (~October 1, 2012). <p>Please sign up for the <a href="http://lists.llvm.org/mailman/listinfo/llvm-devmeeting">LLVM Developers\' Meeting mailing list</a> to receive announcements about the event.</p>';
 notify();
}

function validateForm() {
  $errors = array();
  
  // First name must be set.
  if ($_POST['first'] == "")
     array_push($errors, "First name must be provided");

  if ($_POST['last'] == "") {
     array_push($errors, "Last name must be provided");
   }
   if ($_POST['email'] == "")
     array_push($errors, "Email must be provided");

   if ($_POST['org'] == "")
     array_push($errors, "Organization must be provided");

   if ($_POST['phone']=="")
     array_push($errors, "Phone number must be provided");

   if ($_POST['talkType'] == "")
     array_push($errors, "Please select Talk, BOF, or Poster");

   if ($_POST['title'] == "")
     array_push($errors, "Please provide talk title");

   if ($_POST['summary'] == "")
     array_push($errors, "Please provide talk summary");


  return $errors; 
}

// Print single line text box.
function inputText($element_name, $size, $maxLength, $values) {
     print '<input type="text" size=' . $size . '" maxlength="' . $maxlength . '" name="' . $element_name .'" value="';
     print htmlentities($values[$element_name]) . '">';
}

// Print text area.
function inputTextarea($element_name, $row, $column, $values) {
     print '<textarea name="' . $element_name . '" rows="' . $row . '" cols="' . $column . '">';
     print htmlentities($values[$element_name]) . '</textarea>';
}

// Print radio box.
function inputRadiocheck($element_name,
                         $values, $element_value) {
     print '<input type="radio" name="' .
           $element_name .'" value="' . $element_value . '" ';
     if ($element_value == $values[$element_name]) {
         print ' checked="checked"';
     }
     print '/>';
}

// Specific to our length drop down list.
function inputList($name, $values) {
  print '<select name="' . $name . '" >';
  
  if($values[$name] == 1) 
     print '<option value="1" selected>20</option>';
  else {
     print '<option value="1">20</option>';
  }
  if($values[$name] == 2)
     print '<option value="2" selected>30</option>';
  else
     print '<option value="2">30</option>';

if($values[$name] == 3)
     print '<option value="3" selected>40</option>';
  else
     print '<option value="3">40</option>';

if($values[$name] == 4)
     print '<option value="4" selected>60</option>';
  else
     print '<option value="4">60</option>';
  print '</select>';
}

function showForm($errors) {

if($errors) {
print '<font color=red>';
print '<p>Errors: </p>';
print'</font><ul>';
foreach ($errors as $i) {
   print '<li>';
   print $i;
   print '</li>'; 
}
print '</ul>';
}

print '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
print '<table border=0 width=700>';
print '<tr>';
print '<td><b>First Name:</b> </td> <td>';
inputText("first", 50, 50, $_POST);
print '</td>';
print '</tr>';
print '<tr>';
print '<td><b>Last Name:</b> </td> <td>';
inputText("last", 50, 50, $_POST);
print'</td>';
print '</tr><tr>';
print '<td><b>Email:</b> </td><td>';
inputText("email", 50, 75, $_POST);
print '</td>';
print '</tr><tr>';
print '<td><b>Organization:</b> </td><td>';
inputText("org", 50, 100, $_POST);
print '</td>';
print '</tr><tr>';
print '<td><b>Phone:</b> </td><td>';
inputText("phone", 50, 100, $_POST);
print '</td>';
print '</tr>';
print '</table>';
print '<p>Select Talk, BOF, or Poster:</p> ';
inputRadioCheck("talkType", $_POST, 1);
print ' Talk ';
inputRadioCheck("talkType", $_POST, 2);
print ' BOF ';
inputRadioCheck("talkType", $_POST, 3);
print ' Poster ';
inputRadioCheck("talkType", $_POST, 4);
print '<p>Mininum talk length: ';
inputList('min', $_POST);
print '</p><p>Maximum talk length: ';
inputList('max', $_POST);
print '<p>Talk/BOF/Poster Title: </p>';
print '<p>';
inputTextArea("title", 5, 60, $_POST);
print '</p>';
print '<p>Summary: </p>';
print '<p>';
inputTextArea("summary", 10, 60, $_POST);
print '</p>';
print '<p><input type="submit" name="Submit"></p>';
print '<input type="hidden" name="verify" value="1"/>';
print '</form>';
}
?>

<div class="www_sectiontitle">LLVM Developers' Meeting - Session Proposal</div>

<?
print 'The deadline for submitting proposals has passed!';
exit();

if (isset($_POST['verify'])) {
  $formErrors = validateForm($_POST);
  if(!empty($formErrors)) {
     showForm($formErrors);
   }
  else {
    processForm();
  }

}
else {
   $formErrors = '';
   showForm($formErrors);
}
?>

<?virtual("../footer.incl")
?>
