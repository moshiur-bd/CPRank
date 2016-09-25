<?php
	function getName($handle){
		
		$url="http://codeforces.com/api/user.info?handles=";
		$ch = curl_init($url.$handle);
		$fp = fopen(__DIR__."/f/data.txt", "w");

		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		$str=file_get_contents(__DIR__."/f/data.txt");
		///die();/////////////
		$data=json_decode($str);
		
		

		if($data->status=="OK") //if api request fails!!!!
		{
			$res=$data->result[0];
			return $res->firstName." ". $res->lastName;
		}
		
		
		return "";
		
	}
?>



<?php

	include(__DIR__."/../connection.php");
	$date=new DateTime("-1 month -1 day");//considering contest only for last one month
	$minSize=7;//minimum allowed contest to get in ranklist
	$date=$date->getTimestamp();
	$fp=fopen(__DIR__."/f/users.txt","r");
	$handle=fgets($fp);
	fclose($fp);
	$handle=chop($handle);

	//var_dump($handle);

		again:
		$url="http://codeforces.com/api/user.rating?handle=";
		$ch = curl_init($url.$handle);
		$fp = fopen(__DIR__."/f/data.txt", "w");

		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		$str=file_get_contents(__DIR__."/f/data.txt");
		///die();/////////////
		$data=json_decode($str);
		$fp = fopen(__DIR__."/f/msg.txt", "w");

		if($data->status!="OK") //if api request fails!!!!
		{
			fwrite($fp,$data->status."\n");
			fwrite($fp,$data->comment."\n");
		}
		else fwrite($fp,"OK\n");
		fclose($fp);


		$ar=$data->{"result"};	///get result object
								//so, ar is RatingChange object array now
		$size=count($ar);
		$stableRating=0;
		$active=0;

		//get contest list segment
		$confpi=fopen(__DIR__."/f/ti.txt","w");
		$confpn=fopen(__DIR__."/f/tn.txt","w");
		for($i=0;$i<$size;$i++){
			fwrite($confpi,$ar[$i]->contestId."\n");
			fwrite($confpn,$ar[$i]->contestName."\n");
		}
		fclose($confpi);
		fclose($confpn);
		//////////////////////////////////


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

		echo $handle." ".$stableRating."\n";

		mysqli_query($conn,"INSERT INTO `codeforces` (`handle`)VALUES ('$handle')");
		$name=getName($handle);
		
		echo "\n\n$name\n\n";
		
		echo "fetched $handle"; 
		$sql="UPDATE `codeforces` SET `active` = '$active', `rating` = '$stableRating',`name`='$name' WHERE `codeforces`.`handle` = '$handle' ";
		mysqli_query($conn,$sql);


?>
