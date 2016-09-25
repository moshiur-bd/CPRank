<?php









$tm=time();
//echo $tm;
$str="apiKey=b3b04654d71dcb0fdee999eb87a2c5ee6d87d6c3&time=$tm";
$hstr="123456/user.friends?apiKey=b3b04654d71dcb0fdee999eb87a2c5ee6d87d6c3&onlyOnline=false&time=$tm#8e7cd67958be4987afcee72cfa41bb22b6544d82";
$hs= hash("sha512",$hstr);
$val=$str."&apiSig=123456$hs";





$url="http://codeforces.com/api/user.friends?onlyOnline=false&$val";
		$ch = curl_init($url);
		$fp = fopen(__DIR__."/f/data.txt", "w");

		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		$str=file_get_contents(__DIR__."/f/data.txt");
		///die();/////////////
		$data=json_decode($str);
		$fp = fopen(__DIR__."/f/users.txt", "w");
		if($data->status=='OK'){
			$usr=$data->result;
			$len=count($usr);
			for($i=0;$i<$len;$i++)
			{
				fwrite($fp,$usr[$i]."\n");
			}
			
		}
		fclose($fp);
		

?>
