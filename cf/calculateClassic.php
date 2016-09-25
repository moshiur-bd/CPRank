<html>
<body>
<?php
	
	include("../connection.php");
	$sql="SELECT * FROM `codeforces` ";
	$result=mysqli_query($conn,$sql);
	$date=new DateTime("-1 month -1 day");//considering contest only for last one month
	$minSize=7;//minimum allowed contest to get in ranklist
	
	$date=$date->getTimestamp();
	while($row=mysqli_fetch_array($result))
	{
		set_time_limit(30);
		again:
		$url="http://codeforces.com/api/user.rating?handle=";
		$handle=$row['handle'];
		$ch = curl_init($url.$handle);
		$fp = fopen("data.txt", "w");
		
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		$str=file_get_contents("data.txt");
		
		$data=json_decode($str);
		
		
		if($data->status!="OK") //if api request fails!!!!
		{
			if($data->comment=="Call limit exceeded"){
				$i=0;
				while($i<10000)
					$i++;
				goto again;
			}
			else die("Codeforces is Unreachable!");
			
		}
		
		$ar=$data->{"result"};	///get result object
		$size=count($ar);
		$stableRating=0;
		$active=0;
		if($size<$minSize) goto skip;
			
		$stableRating=$ar[$size-1]->newRating;
		//a users best rating count in last one month
		for($i=$size-1;$i>=0;$i--){
			if(($ar[$i]->ratingUpdateTimeSeconds)<$date){
				break;
			}
			$active=1;
			if($stableRating<$ar[$i]->newRating)$stableRating=$ar[$i]->newRating;
		}
		skip:// did not participate minimum contest!!!
		
		echo $handle." ".$stableRating."</br>";
		
		$sql="UPDATE `codeforces` SET `active` = '$active', `rating` = '$stableRating' WHERE `codeforces`.`handle` = '$handle' ";
		mysqli_query($conn,$sql);
		
	}

?>
</body>
</html>