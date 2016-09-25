
<?php



	//include(__DIR__."/LaunchBgProcess.php");
	include(__DIR__."/../connection.php");
	LaunchBackgroundProcess(__DIR__."/calc.exe");
	$dt=new DateTime('+1 day');
	$dt->modify('+10 day +1 month');
	$sql="SELECT * FROM `codeforces` ORDER BY `codeforces`.`rating` DESC";
	
	$result=mysqli_query($conn,$sql);
	
	echo"<table cellspacing='0' class='rank-active'></br>";
	echo "<tr class='rank-heading'>";
			echo"<th class='id' >#</th>";
			echo"<th class='photo'>photo</th>";
			echo"<th class='name'>Name </th>";
			echo"<th class='handle'>Handle </th>";
			echo"<th class='rating'>rating </th>";
		echo "</tr>";
	for($rank=1;$row=mysqli_fetch_array($result);$rank++){
		$handle=$row['handle'];
		$rating=$row['rating'];
		$name=$row['name'];
		$title=getTitle($rating);

		echo "<tr class='rank-row' >";
			echo"<td class='id'>$rank </td>";
			echo"<th class='photo'><img class='photo' src='http://codeforces.com/userphoto/title/$handle/photo.jpg' alt='no image'></img></th>";
			echo"<td class='name' title='$title $name'>$name </td>";
			echo"<td class='handle' title='$title $handle'><a class='$title' href='http://codeforces.com/profile/$handle'>$handle</a> </td>";
			echo"<td class='rating'>$rating </td>";
		echo "</tr>";
		
	}
	
	echo"</table></br>";
?>
