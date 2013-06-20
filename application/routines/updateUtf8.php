<?

$con = mysql_connect('localhost','root','root');
$db = mysql_select_db('setop_taxi',$con);

$total = 400;

for($i=400;$i<=1348;$i++){

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


	// PERSON
	$sql_person = "
		SELECT
			name,
			army_issuer,
			info
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
			info='".utf8_encode($res_person[2])."'
		WHERE 
			id=$i
	";

	mysql_query($person);
	echo $person."\n";

}

?>