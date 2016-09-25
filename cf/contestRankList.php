<html>
	<head>
		<title> Codeforces Contest Ranklist for BSMRSTU </title>
	</head>
	<body>
		<?php
			
			echo"</br><h3>Codeforces Contest Ranklist for BSMRSTU</h3></br>";
			echo"<table cellspacing='15px' class='cf_contest_ranklist'> ";
			$fpid=fopen(__DIR__."/f/conid.txt","r");
			
			$fpnm=fopen(__DIR__."/f/conname.txt","r");
			$key=file_get_contents(__DIR__."/f/list.key");
			$id=1;
			$name="Name";
			while(($id=fgets($fpid))!=false)
			{
				$name=fgets($fpnm);
				echo"<tr><td class='conname'><a class='conname' href='http://codeforces.com/contest/".$id."/standings?list=".$key."'>".$name." </a></td></tr>";
			}
			
			echo"</table>";
			
		?>
	</body>
</html>
