<?php
include(__DIR__ ."/../connection.php");
$tm=time();
//echo $tm;
$str="apiKey=b3b04654d71dcb0fdee999eb87a2c5ee6d87d6c3&time=$tm";
$hstr="123456/user.friends?apiKey=b3b04654d71dcb0fdee999eb87a2c5ee6d87d6c3&onlyOnline=false&time=$tm#8e7cd67958be4987afcee72cfa41bb22b6544d82";
$hs= hash("sha512",$hstr);
$val=$str."&apiSig=123456$hs";
echo "<a href='http://codeforces.com/api/user.friends?onlyOnline=false&$val'>get</a>"


?>
