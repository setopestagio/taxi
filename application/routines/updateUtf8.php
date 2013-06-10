<?

$con = mysql_connect('localhost','root','[=abis]mysql');
$db = mysql_select_db('setop_taxi',$con);

$total = 399;

for($i=1;$i<=399;$i++){

	// ADDRESS
	$sql_address = "
		SELECT
			address,
			neighborhood
		FROM
			address
		WHERE
			id=$i
	";

	$rs_address = mysql_query($sql_address);
	$res_address = mysql_fetch_row($rs_address);

	$address = "
		UPDATE 
			address
		SET
			address='".utf8_encode($res_address[0])."',
			neighborhood='".utf8_encode($res_address[1])."'
		WHERE 
			id=$i
	";

	mysql_query($address);
	echo $address."\n";



	// GRANTEE
	$sql_grantee = "
		SELECT
			info
		FROM
			grantee
		WHERE
			id=$i
	";

	$rs_grantee = mysql_query($sql_grantee);
	$res_grantee = mysql_fetch_row($rs_grantee);

	$grantee = "
		UPDATE 
			grantee
		SET
			info='".utf8_encode($res_grantee[0])."'
		WHERE 
			id=$i
	";

	mysql_query($grantee);
	echo $grantee."\n";


	// PERSON
	$sql_person = "
		SELECT
			name,
			army_issuer
		FROM
			person
		WHERE
			id=$i
	";

	$rs_person = mysql_query($sql_person);
	$res_person = mysql_fetch_row($rs_person);

	$person = "
		UPDATE 
			person
		SET
			name='".utf8_encode($res_person[0])."',
			army_issuer='".utf8_encode($res_person[1])."',
		WHERE 
			id=$i
	";

	mysql_query($person);
	echo $person."\n";

}

?>