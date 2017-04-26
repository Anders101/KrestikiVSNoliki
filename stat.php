<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Крестики-нолики.</title>
  <link rel="stylesheet" type="text/css" href="" />
</head>
<body>
<p align="center">
<?php
  $user1 = $_POST['pname1'];
  $user2 = $_POST['pname2'];
  $score1 = 0;
  $score2 = 0;
  
  echo ' '. $user1 . ' ' . $score1 . ':' . $score2 . ' ' . $user2;
  
  
 ?>
 </p>
 
 <table bordercolor="red" border=2 align="center" >
 <tr><td height="30" width="30" align= "center">?</td><td height="30" width="30" align= "center">?</td><td height="30" width="30" align= "center">?</td></tr>
 <tr><td height="30" width="30" align= "center">?</td><td height="30" width="30" align= "center">?</td><td height="30" width="30" align= "center">?</td></tr>
 <tr><td height="30" width="30" align= "center">?</td><td height="30" width="30" align= "center">?</td><td height="30" width="30" align= "center">?</td></tr>
 </table>
 
 <table bordercolor="blue" border=2 align="center" >
 <tr><td height="30" width="30" align= "center"><input type="submit" name="submit" value="0" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="0" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="0" /></td></tr>
 <tr><td height="30" width="30" align= "center"><input type="submit" name="submit" value="0" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="0" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="0" /></td></tr>
 <tr><td height="30" width="30" align= "center"><input type="submit" name="submit" value="0" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="0" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="0" /></td></tr>
 </table>
 
  <table bordercolor="green" border=2 align="center" >
 <tr><td height="30" width="30" align= "center"><input type="submit" name="submit" value="X" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="X" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="X" /></td></tr>
 <tr><td height="30" width="30" align= "center"><input type="submit" name="submit" value="X" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="X" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="X" /></td></tr>
 <tr><td height="30" width="30" align= "center"><input type="submit" name="submit" value="X" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="X" /></td><td height="30" width="30" align= "center"><input type="submit" name="submit" value="X" /></td></tr>
 </table>
 </body>
</html>