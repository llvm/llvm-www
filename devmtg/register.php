<?

// Database details. 
include("connectDB.php");

mysql_connect("127.0.0.1", $user, $password) or die(mysql_error());
mysql_select_db($database);

virtual("../header.incl");

function notify() {

$to = "llvm-devmtg-admin@nondot.org";
$subject = "LLVM Dev Meeting Registration";

$body = '<html><body>';

$body .= '<p>Name: ' . $_POST['first'] . ' ' . $_POST['last'] . '</p>';
$body .= '<p>Organization: ' . $_POST['org'] . '</p>'; 
$body .= '<p>Email: ' . $_POST['email'] . '</p>';

if($_POST['attendBefore'] == 0)
$attendBefore = 'No';
else
$attendBefore = 'Yes';

$body .= '<p>Attended Before: ' . $attendBefore . '</p>';

if($_POST['friday'] == 0)
$friday = 'No';
else
$friday = 'Yes';
  
$body .= '<p>Attend dinner?: ' . $friday . '</p>';


if($_POST['meal'] == 0)
$meal = 'No';
else
$meal = 'Yes';

$body .= '<p>Vegetarian Meal: ' . $meal . '</p>';


$body .= "<p>Interests: " . $_POST['comments'] . '</p>'; 
$body .= '</body></html>';

$headers = 'From: tonic@nondot.org' . "\r\n";
$headers .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
mail($to, $subject, $body, $headers);

}


function my_escape_string(&$item, $key) {
  $item = mysql_real_escape_string($item);
}

function processForm() {
  array_walk($_POST, 'my_escape_string');

  if($_POST['attendBefore'] == 0)
     $attend = 2;
  else
     $attend = 1;

  if ($_POST['friday'] == 0)
     $friday = 2;
  else
     $friday = 1;

  if ($_POST['meal'] == 0)
     $meal = 2;
  else
     $meal = 1;

  $sql = "INSERT into attendees (lastName, firstName, organization, email, location, attendBefore, fridayDinner, mealVeg, comments) VALUES('$_POST[last]', '$_POST[first]', '$_POST[org]', '$_POST[email]', '$_POST[location]','$attend', '$friday', '$meal', '$_POST[comments]')";
  mysql_query($sql) or die(mysql_error());
print 'Congratulations! You are now registered for the 2009 LLVM Developers\' Meeting.<p>Please sign up for the <a href="http://lists.llvm.org/mailman/listinfo/llvm-devmeeting">LLVM Developers\' Meeting mailing list</a> to receive announcements about the event.</p>';
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

   if ($_POST['location']=="")
     array_push($errors, "Location name must be provided");

   if ($_POST['comments'] == "")
     array_push($errors, "Please specify interests.");

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
print '<td><b>Where are you located? (City/State/Country):</b> </td><td>';
inputText("location", 50, 100, $_POST);
print '</td>';
print '</tr>';
print '</table>';
print '<p>Require vegetarian meals: ';
inputRadioCheck("meal", $_POST, 0);
print ' No ';
inputRadioCheck("meal", $_POST, 1);
print ' Yes</p>';
print '<p>Would you attend a group dinner afterwards?';
inputRadioCheck("friday", $_POST, 0);
print ' No ';
inputRadioCheck("friday", $_POST, 1);
print ' Yes</p>';
print '<p>Have you attended a LLVM developers\' meeting before?';
inputRadioCheck("attendBefore", $_POST, 0);
print ' No ';
inputRadioCheck("attendBefore", $_POST, 1);
print ' Yes</p>';
print '<p>What are you most interested in learning at the LLVM developers\' meeting? ';
print '(i.e. general optimizations, llvm internals, clang, backend, not sure, etc)</p>';
print '<p>';
inputTextArea("comments", 5, 60, $_POST);
print '</p>';
print '<p><input type="submit" name="Register"></p>';
print '<input type="hidden" name="verify" value="1"/>';
print '</form>';
}
?>

<div class="www_sectiontitle">LLVM Developers' Meeting - Registration</div>
<?
$sql = "SELECT lastName from attendees";
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows >= 190){
print '<p>Registration is now closed.</p>';
exit;
}
?>
<!-- <p>Registration is now closed.</p> -->
<?
//exit;

if (array_key_exists('verify', $_POST)) {
  $formErrors = validateForm($_POST);
  if(!empty($formErrors)) {
     showForm($formErrors);
   }
  else {
    processForm();
  }

}
else {
   showForm();
}
?>

<?virtual("../footer.incl")
?>
