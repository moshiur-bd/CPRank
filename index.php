<!doctype html>
<html>
	<head>
	
	<link href="css/design.css" rel='stylesheet' type="text/css">
		<title>Codeforces of BSMRSTU</title>
		
	</head>
	
	<body>
		<div id='body'>
		<h1>Codeforces of BSMRSTU</h1>
		<div id="header">
			
		</div>
		
		<div id="sidebar">
			<p>Codeforces stable ranklist lies below.</br> codeforces current ranklist is <a href='http://codeforces.com/ratings/organization/3403'>here</a></p>
			
			<div  id="codeforces_rank_a">
			<h3>Codeforces Active Rank</h3>
				<?php
					include(__DIR__."/cf/rank_10.php");
				?>
			</div>
			
			<div id="codeforces_rank">
				<h3>Codeforces Rank</h3>
				<?php
					include(__DIR__."/cf/rank.php");
				?>
			</div>
			
		</div>
		
		<div  id="codeforces_contest">
			<?php
				include(__DIR__ ."/cf/contestRanklist.php");
			?>
		</div>
		
		
		
		
		
		<div id="footer">
		</div>
		</div>

	
	</body>


</html>
