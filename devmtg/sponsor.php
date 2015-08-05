 <?
 
// Database details. 
include("connectDB.php");

mysql_connect("127.0.0.1", $user, $password) or die(mysql_error());
mysql_select_db($database);

virtual("../header.incl");

function notify() {

$to = "lattner@apple.com,clattner@apple.com,dkipping@qualcomm.com";
$subject = "LLVM Dev Meeting Student, Presenter, and Active Contributor Funding Request";

$body = '<html><body>';

$body .= '<p>Name: ' . $_POST['first'] . ' ' . $_POST['last'] . '</p>';
$body .= '<p>School/Organization: ' . $_POST['school'] . '</p>';
$body .= '<p>Email: ' . $_POST['email'] . '</p>';
$body .= '<p>Location: ' . $_POST['location'] . '</p>';

if($_POST['level'] == 1)
$level = "Undergraduate";
else if($_POST['level'] == 2)
$level = "Graduate";
else
$level = "Not a student";

$body .= '<p>Level: ' . $level . '</p>';

if($_POST['type'] == 1)
$type = "Partial";
else
$type = "Full";


$body .= "<p>Funding Level: " . $type . '</p>';

$body .= '<p>Estimated airfare cost: ' . $_POST['airfare'] . '</p>';
$body .= '<p>Estimated loding cost: ' . $_POST['lodging'] . '</p>';
$body .= '<p>Estimated other costs: ' . $_POST['other'] . '</p>';
$body .= '<p>Reasons for needing funding: ' . $_POST['comments'] . '</p>';

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
  $sql = "INSERT into students (lastName, firstName, school, email, level, location, airfare, lodging, other, type, comments) VALUES('$_POST[last]', '$_POST[first]', '$_POST[school]', '$_POST[email]', '$_POST[level]', '$_POST[location]','$_POST[airfare]', '$_POST[lodging]', '$_POST[other]', '$_POST[type]', '$_POST[comments]')";
  mysql_query($sql) or die(mysql_error());
print 'Your request for funding to attend the LLVM Developers\' Meeting has been submitted. We will contact you once funds have been allocated. <p>Please sign up for the <a href="http://lists.llvm.org/mailman/listinfo/llvm-devmeeting">LLVM Developers\' Meeting mailing list</a> to receive announcements about the event.</p>';
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

   if ($_POST['school'] == "")
     array_push($errors, "School/Organization must be provided");

   if ($_POST['location']=="")
     array_push($errors, "Location must be provided");

   if ($_POST['airfare'] == "")
     array_push($errors, "Estimate airfare expense must be provided");
   else {
   if ($_POST['airfare'] != strval(intval($_POST['airfare']))) {
      array_push($errors, "Estimate airfare expense must be an integer"); 
    } 
    }


   if ($_POST['lodging'] == "")
     array_push($errors, "Estimate lodging expense must be provided");
   else {
      if ($_POST['lodging'] != strval(intval($_POST['lodging']))) { 
      array_push($errors, "Estimate lodging expense must be an integer");
       }
    }

   if ($_POST['other'] == "")
     array_push($errors, "Estimate other expense must be provided");
   else {
   if ($_POST['other'] != strval(intval($_POST['other']))) { 
      array_push($errors, "Estimate other expense must be an integer");
    }
    }

   if ($_POST['comments'] == "")
     array_push($errors, "Please provide reasons for needing funding");

   if ($_POST['level'] == "")
     array_push($errors, "Please select type of student");

   if ($_POST['type'] == "")
     array_push($errors, "Please select type of support");

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
print '<table border=0>';
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
print '<td><b>School/Organization:</b> </td><td>';
inputText("school", 50, 100, $_POST);
print '</td>';
print '</tr><tr>';
print '<td><b>Location:</b> </td><td>';
inputText("location", 50, 100, $_POST);
print '</td>';
print '</tr><tr>';
print '<td><b>Estimated airfare:</b> </td><td>';
inputText("airfare", 50, 100, $_POST);
print '</td>';
print '</tr><tr>';
print '<td><b>Estimated lodging:</b> </td><td>';
inputText("lodging", 50, 100, $_POST);
print '</td>';
print '</tr><tr>';
print '<td><b>Estimated other expenses:</b> </td><td>';
inputText("other", 50, 100, $_POST);
print '</td>';
print '</tr>';
print '</table>';
print '<p>Type of student: ';
inputRadioCheck("level", $_POST, 1);
print ' Undergraduate ';
inputRadioCheck("level", $_POST, 2);
print ' Graduate ';
inputRadioCheck("level", $_POST, 3);
print ' Not a student</p>';
print '<p>Amount of funding : ';
inputRadioCheck("type", $_POST, 1);
print ' Partial ';
inputRadioCheck("type", $_POST, 2);
print ' Full</p>';

print '<p>Reasons for needing funding: </p>';
print '<p>';
inputTextArea("comments", 10, 60, $_POST);
print '</p>';
print '<p><input type="submit" name="Submit"></p>';
print '<input type="hidden" name="verify" value="1"/>';
print '</form>';
}
?>

<div class="www_sectiontitle">LLVM Developers' Meeting - Student & Active Contributor Funding Request</div>
<?

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
   showForm('');
}
?>

<?virtual("../footer.incl")
?>
