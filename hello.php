<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors' , 1);

include ("account.php");
include ("functiontest.php");

$state = -2;
$dataOK = true;

$db = mysqli_connect($hostname, $username, $password, $project);

if (mysqli_connect_errno())
  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
  }
print "Successfully connected to MySQL.<br><br><br>";

mysqli_select_db($db, $project );
 

$u = $_GET ['u'] ;
//print "<br>UCID is: $u" ;

if ($u == "")
{
	$state = -1;
}

$p = $_GET ['p'];
//print "<br>Pass is: $p" ;

if ($p == "")
{
	$state = -1;
}

$account = $_GET ['account'] ;
//print "<br>Account is: $account" ;

if ($account == "")
{
	$state = -1;
}
$amount = $_GET ['amount'] ;
$choice = $_GET ['choice'] ;

if ($state == -1 )
{
	$dataOK = false;
}


//$dataOK && 
//print ( "<br> $u <br> $p ");
if( $dataOK && super_auth($u, $p, $state, $newpin)){
	

	if ($choice == "see") 
	{
		see ($u, $account);
	}
	if ($choice == "transact") 
	{
		transact ($u, $account, $amount, $db);
	}
	//exit();
}
else
{
	print "<br> Super Authentication failed...";
	
}
?>

<?php if ($state == -1) { print "<br><h2> Bad input. </h2> <br>";} ?>
<?php if ($state == 0) { print "<br><h2> Bad credentials. </h2> <br>";} ?>
<?php if ($state == 1) { print "<br><h2> Bad pin. </h2> <br>";} ?>

<form action = "hello.php">
<input type = text name="u">UCID <br><br> 
<input type = text name="p">PASSWORD <br><br> 
<input type = text name="account">ACCOUNT <br><br> 
<input type = text name="amount">AMOUNT <br><br> 

<input type = text name="pin"> PIN <br><br>


<select name="choice">
	<option value="0"> choose </option>
	<option value="see"> see </option>
	<option value="transact"> transact </option>
</select>

<input type = submit>
</form>