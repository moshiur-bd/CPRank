
<?php

	include(__DIR__."/../connection.php");
	//include("../connection.php");

	$sql="SELECT * FROM `codeforces` ";
	$result=mysqli_query($conn,$sql);
	$date=new DateTime("-1 month -1 day");//considering contest only for last one month
	$minSize=7;//minimum allowed contest to get in ranklist

	$date=$date->getTimestamp();
	$fp=fopen(__DIR__."/f/users.txt","w");
	//$fp=fopen("users.txt","w");
	while($row=mysqli_fetch_array($result))
	{
		fwrite($fp,$row['handle']."\n");
	}
	fclose($fp);


	echo "User-List generated!!";

?>
