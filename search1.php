<?php
###########################################################
/*
GuestBook Script
Copyright (C) 2012 StivaSoft ltd. All rights Reserved.


This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/gpl-3.0.html.

For further information visit:
http://www.phpjabbers.com/
info@phpjabbers.com

Version:  1.0
Released: 2012-03-18
*/
###########################################################

error_reporting(0);
include("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MySQL table search</title>
<!--
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
-->
<link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>
<style>
BODY, TD {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
</style>
</head>


<body>
<nav>
	<ul>
		<li><a href="search.php">Home</a></li>
		<li><a href="search1.php">Side2</a></li>
	</ul>
</nav>
<form id="form1" name="form1" method="post" action="search1.php">
 <label>Name or Email:</label>
<input type="text" name="string" id="string" value="<?php echo stripcslashes($_REQUEST["string"]); ?>" />
<label>City</label>
<select name="city">
<option value="">--</option>
<?php
	$sql = "SELECT * FROM ".$SETTINGS["data_table"]." GROUP BY city ORDER BY city";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	while ($row = mysql_fetch_assoc($sql_result)) {
		echo "<option value='".$row["city"]."'".($row["city"]==$_REQUEST["city"] ? " selected" : "").">".$row["city"]."</option>";
	}
?>
</select>
<input type="submit" name="button" id="button" value="Filter" />
  </label>
  <a href="search1.php"> 
  reset</a>
</form>
<br /><br />

<table width="700" border="1" cellspacing="0" cellpadding="4">
  <tr>
    <td width="159" bgcolor="#CCCCCC"><strong>Name</strong></td>
    <td width="191" bgcolor="#CCCCCC"><strong>Email</strong></td>
    <td width="113" bgcolor="#CCCCCC"><strong>City</strong></td>
  </tr>
  
<?php
if ($_REQUEST["string"]<>'') {
	$search_string = " AND (full_name LIKE '%".mysql_real_escape_string($_REQUEST["string"])."%' OR email LIKE '%".mysql_real_escape_string($_REQUEST["string"])."%')";	
}
if ($_REQUEST["city"]<>'') {
	$search_city = " AND city='".mysql_real_escape_string($_REQUEST["city"])."'";	
} 

if ($_REQUEST["string"]<>'' and $_REQUEST["city"]<>'') {
	$sql = "SELECT * FROM ".$SETTINGS["data_table"]." WHERE id>0".$search_string.$search_city;
} else {
	$sql = "SELECT * FROM ".$SETTINGS["data_table"]." WHERE id>0".$search_string.$search_city;
}

$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
if (mysql_num_rows($sql_result)>0) {
	while ($row = mysql_fetch_assoc($sql_result)) {
?>


<tr>
    <td><?php echo $row["full_name"]; ?></td>
    <td><?php echo $row["email"]; ?></td>
    <td><?php echo $row["city"]; ?></td>
  </tr>

<?php
	}
} else {
?>
<tr><td colspan="5">No results found.</td>
<?php	
}
?>
</table>

<script src="./jquery.js"></script>
<script src="build/jquery.datetimepicker.full.js"></script>
<script>
jQuery(function(){
 jQuery('#from').datetimepicker({
  format:'Y-m-d H:i',
  onShow:function( ct ){
   this.setOptions({
    maxDate:jQuery('#to').val()?jQuery('#to').val():false
   })
  },
  step:10,
  timepicker:true
  
 });
 jQuery('#to').datetimepicker({
  format:'Y-m-d H:i',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#from').val()?jQuery('#from').val():false
   })
  },
  step:10,	
  timepicker:true
 });
 
});
</script>

</body>
</html>