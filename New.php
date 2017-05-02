<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Крестики VS Нолики</title>
  <link rel="stylesheet" type="text/css" href="" />
</head>
<body>
<?php

//session_start();

//$_SESSION['c1'] = $c1;


 $c1 = 0;
 $c2 = " ";
 $c3 = " ";
 $c4 = " ";
 $c5 = " ";
 $c6 = " ";
 $c7 = " ";
 $c8 = " ";
 $c9 = " ";
 $hod = 'x';
 $choose = $_GET['c1'];
 ?>

 <table bordercolor="red" border=2 align="center" >
 
 <tr>
 
 <td height="30" width="30" align= "center">
 
 <?php 
   if ((empty($c1)) && $hod == 'x')
   {
	   echo '<a href="New.php?c1=x">/x</a>';
	   $hod = 0;
   }
   else
   {
	  if ((empty($c1)) && $hod == '0')
	  {
		  echo '<a href="New.php?c1=O">/0</a>';
	  }	
      else
	  {
		  if (!empty($c1))
		  {
			  echo $choose;
		  }
	  }	  
   }
   


?>

</td>

 <td height="30" width="30" align= "center">?</td>
 <td height="30" width="30" align= "center">?</td></tr>
 <tr><td height="30" width="30" align= "center">?</td>
 <td height="30" width="30" align= "center">?</td>
 <td height="30" width="30" align= "center">?</td></tr>
 <tr><td height="30" width="30" align= "center">?</td>
 <td height="30" width="30" align= "center">?</td>
 <td height="30" width="30" align= "center">?</td></tr>
 </table>