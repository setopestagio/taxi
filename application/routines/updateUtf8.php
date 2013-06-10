<?

$con = mysql_connect('localhost','root','root');
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

	$rs = mysql_query($sql_address);
	$res = mysql_fetch_row($rs);

	$address = "
		UPDATE 
			address
		SET
			address='".utf8_encode($res[0])."',
			neighborhood='".utf8_encode($res[1])."'
		WHERE 
			id=$i
	";

	mysql_query($address);
	echo $address."\n";
}

?>