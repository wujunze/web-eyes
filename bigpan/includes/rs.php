<?php
/*
*
@GANGBAN 20121230
*
*/
 $data=fopen(ROOT."includes/rs.txt",'r+');
$b=fread($data,88888);
 fclose($data);
$data=$b;
if($data==""){
$data='0,0,0';}

$data=explode(",",$data);
$z=$data[0];
$t=$data[1];
$g=$data[2];
 $date=date("Ymd");
 if($date!=$g){
 $g=$date;
 $t=0;}
$t=$t+1;
$z=$z+1;
$data=$z.','.$t.','.$g;
 $d=fopen(ROOT."includes/rs.txt",'w');
 fwrite($d,$data);
 fclose($d);
echo '你是今天第'.$t.'位访问者  总第'.$z.'位访问者';


 ?>