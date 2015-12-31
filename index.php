<?php
error_reporting(0);
$is_wap = 0; 
if(strpos($_SERVER['HTTP_VIA'],"wap")>0){$is_wap = 1;}
  elseif(strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP") > 0 || strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"UC/") > 0){
  $is_wap = 1;}
  else { 
      $iUSER_AGENT=strtoupper(trim($_SERVER['HTTP_USER_AGENT']));
      if(strpos($iUSER_AGENT,"NOKIA")>0 || strpos($iUSER_AGENT,"WAP")>0 || strpos($iUSER_AGENT,"MIDP")>0 || 
strpos($iUSER_AGENT,"UCWEB")>0 )$is_wap == 1;
        }  
if($is_wap==1){header('Location:wap/index.php');exit;
}

include("list.php");
?>