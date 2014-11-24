<?php

 $servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



define("PASSWORD_HASH_LENGTH",20);
define("PASSWORD_ITERATIONS",    25);
define("PASSWORD_ALG",     "sha256");
define("PASSWORD_SALT_POSITION", 0);
define("PASSWORD_HASH_POSITION", 1);
define("PASSWORD_ITERATIONS_POSITION", 2);
define("PASSWORD_ALG_POSITION", 3);

$valid=validate_password($conn, 'admin@s.com','roots'); 
echo "Correct Password: 'roots' Entered password: 'roots' valid: ".$valid.'<br />'; 
$valid=validate_password($conn, 'tests2@gmail.com','12345'); 
echo "Correct Password: '12345' Entered password: '12345' valid: ".$valid.'<br />'; 
$valid=validate_password($conn, 'asdf@asf.com','asdfg'); 
echo "Correct Password: 'asdfg' Entered password: 'asdfg' valid: ".$valid.'<br />'; 
$valid=validate_password($conn, 'yousuck@haha.com','12345'); 
echo "Correct Password: '12345' Entered password: '12345' valid: ".$valid.'<br />'; 
$valid=validate_password($conn, 'mjvaugh2@asu.edu','password'); 
echo "Correct Password: 'password' Entered password: 'password' valid: ".$valid.'<br />'; 
$valid=validate_password($conn, 'Maguti13@asu.edu','mayrag'); 
echo "Correct Password: 'mayrag' Entered password: 'mayrag' valid: ".$valid.'<br />'; 
$valid=validate_password($conn, 'not-in-database@test.com','mayrag'); 
echo "Correct Password: none. This user does not exist Entered password: 'password' valid: ".$valid.'<br />'; 
$valid=validate_password($conn, 'admin@s.com','password'); 
echo "Correct Password: 'roots'  Entered password: 'password' valid: ".$valid.'<br />'; 


mysqli_close($conn);

function create_pass_tutorial($alg,$length,$password,$iterations)
 {
 
	 $salt=openssl_random_pseudo_bytes($length); 
	 $hex = bin2hex($salt); 
	 $saltedPasswordHash=hash_pbkdf2($alg, $password, $hex, $iterations, $length); 
	 $hash[PASSWORD_SALT_POSITION]=$hex;
	 $hash[PASSWORD_HASH_POSITION]=$saltedPasswordHash;
	 $hash[PASSWORD_ITERATIONS_POSITION]=$iterations; 
	 $hash[PASSWORD_ALG_POSITION]=$alg; 
	 $forDatabase=$hash[0].'-'.$hash[1].'-'.$hash[2].'-'.$hash[3]; 
	 return $forDatabase; 
 }
 
 function validate_password($dbc, $user, $entered)
{
	//Get stored password from database
	$sql="SELECT hashedPassword FROM users WHERE email_address='".$user."'"; 
		$result = mysqli_query($dbc, $sql);
		
		if (mysqli_num_rows($result) > 0) {
				// output data of each row
				while($row = mysqli_fetch_assoc($result)) 
				{
					$password=$row['hashedPassword']; 
				}
			} 
			else {
						echo "no such user.";
						return 1===0; 
					}
	//End Get stored password from database
	$database=explode('-',$password); 
	
	$salt =$database[PASSWORD_SALT_POSITION]; 
	$hash=$database[PASSWORD_HASH_POSITION];
	$iterations=$database[PASSWORD_ITERATIONS_POSITION];
	$alg=$database[PASSWORD_ALG_POSITION];
	$length = strlen($hash); 
	//End get info from database
	$hashedEntered=hash_pbkdf2($alg, $entered, $salt, $iterations, $length);
	
	//Replace with slow equals 
	return slow_equal($hashedEntered, $hash); 
	
 
}
function slow_equal($a, $b)
{
	$diff = strlen($a) ^ strlen($b);
	$lengthA=strlen($a); 
	$lengthB=strlen($b); 
	$a = str_split($a);
	$b=str_split($b); 

	for($i = 0; $i < max($lengthA, $lengthB); $i++)
	{
		$diff |= ord($a[$i]) ^ ord($b[$i]); 
	}
	return $diff ===0; 
}


function convert_passwords($dbc, $table, $oldPass, $newPass)
{
		$sql='SELECT user_id, '.$oldPass.' FROM '.$table;
		echo $sql;
		
		$result = mysqli_query($dbc, $sql);

		if (mysqli_num_rows($result) > 0) {
				// output data of each row
				while($row = mysqli_fetch_assoc($result)) 
				{
				
					$sql="UPDATE ".$table." SET ".$newPass."='".create_pass_tutorial(PASSWORD_ALG,PASSWORD_HASH_LENGTH,$row[$oldPass], PASSWORD_ITERATIONS)."' WHERE user_id=".$row['user_id'];
				
					if (mysqli_query($dbc, $sql)) 
					{
					echo "Record updated successfully";
					} 
					else 
					{
						echo "Error updating record: " . mysqli_error($dbc);
					}
				
				}
			} 
			else {
						echo "0 results";
					}
}  
 ?>