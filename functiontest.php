<?php


	
function authenticate($u, $p, &$DBpin){
	global $db;
	$auth = "select * from users where ucid = '$u' AND pass = '$p' ";
	//print ($auth);
	$t = mysqli_query($db,$auth) or die (mysqli_error ($db));
	$nm = mysqli_num_rows ($t);
	print($nm);
	
	if ($nm == 0){
		return false;
	}
	$r = mysqli_fetch_array($t, MYSQLI_ASSOC);
	$DBpin = $r ["pin"];
	
	return true;
	
	
}

function see( $u, $account  ){


	global $db;
	
	$s = "select * from transactions where ucid = '$u' AND account = '$account' " ;
	//print "<br>SQL is: $s" ;

	$t = mysqli_query ( $db, $s) ;
	
	$num = mysqli_num_rows ($t) ;

	print "<br>Number of rows recieved: $num" ;

	while( $r = mysqli_fetch_array($t, MYSQLI_ASSOC) ){
	
	
	
		$timestamp = $r [ "timestamp" ] ;
		$amount = $r ["amount"] ;
		print "<br>TimeStamp is :$timestamp 
			   <br>Amount is :$amount";
	
    }

}

function transact( $u, $account, $amount, $db  ){


	global $db;
	
	$s = "INSERT INTO transactions ( ucid, account, amount, timestamp, mail) VALUES ('$u','$account', '$amount', NOW(), 'N') " ;
	//print "<br>SQL is: $s" ;
	
	$t = mysqli_query ( $db, $s) ;
	
	$s = "select * from transactions where ucid = '$u' AND account = '$account' " ;
	print "<br>SQL is: $s" ;

	$t = mysqli_query ( $db, $s) ;
	
	$num = mysqli_num_rows ($t) ;
	
	while( $r = mysqli_fetch_array($t, MYSQLI_ASSOC) ){
	
	
	
		$timestamp = $r [ "timestamp" ] ;
		$amount = $r ["amount"] ;
		print "<br>TimeStamp is :$timestamp 
			   <br>Amount is :$amount";
	
    }

}
function randomPin () {

	Global $db, $u ; 

	$newpin= mt_rand ( 1000, 9999); 
	$s = "Update users set pin = '$newpin' where ucid = '$u' ";
	echo "<br>s is $s <br> " ;
	($t = mysqli_query ( $db , $s )) or die ( mysqli_error($db) ) ;
	mymail( $newpin) ;
	return $newpin ; 
}

function mymail ($newpin) {
	
	$to = "lih2@njit.edu";	
	$subj = "PIN";
	$msg = $newpin; 
	mail ($to, $subj, $msg);
	
}
function super_auth($u,$p, &$state, &$newpin)
{
	if (!authenticate ($u, $p, $DBpin))
	{
	$state = 0;
	print("<br>superauth failed becus of reg auth");
	return false;
	}
	else
	{
		if( !isset($_GET["pin"])    || ($_GET["pin"] == 0) || ($_GET["pin"] != $DBpin) )
		{
			$newpin = randomPin();
			print ($newpin);
			
			$state = 1;
			
			return false;
			
		}
		else
		{
			
			return true;
			
			
		}
	}
	
	
}



?>