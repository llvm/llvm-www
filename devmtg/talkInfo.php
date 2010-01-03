<?
// Database details. 
include("connectDB.php");

mysql_connect("127.0.0.1", $user, $password) or die(mysql_error());
mysql_select_db($database);

virtual("../header.incl");
?>
<?
$id = (int)$_GET['id'];
$sql = "SELECT lastName, firstName, organization, title, summary from presenters WHERE id=$id";

$results = mysql_query($sql);
$count = 0;
while($row = mysql_fetch_array($results)) {
  print '<p><b>Speaker: </b>';
  print $row['firstName'];
  print ' ';
  print $row['lastName'];
  print ', <i>';
  print $row['organization'];
  print '</i></p><p><b>Title: </b>';
  print $row['title'];
  print '</p><p><b>Summary:</b></p><p>';
  print $row['summary'];
  print '</p>';
}
?>
<?
virtual("../footer.incl")
?>
