<?php require_once('../connections/con_wdimserver.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_con_wdimserver, $con_wdimserver);
$query_rs_listing = "SELECT * FROM national_geographic ORDER BY id ASC";
$rs_listing = mysql_query($query_rs_listing, $con_wdimserver) or die(mysql_error());
$row_rs_listing = mysql_fetch_assoc($rs_listing);
$totalRows_rs_listing = mysql_num_rows($rs_listing);
?>
<?php require ('admin_header.php');?>
<div id="header"><div id="logo"></div>
<h1>Master Database Table Listing</h1>
<p>Below is a listing of all records in the national_geographic table.</p>
<p><a href="insert.php">Click here</a> to insert a new record into the database.</p>
</div>
<hr />
<table border="0" cellpadding="5" cellspacing="2">
  <tr>
    <td>Modify</td>
    <td>title</td>
    <td>sub-title</td>
    <td>sort_menu</td>
    <td>body_content</td>
    <td>date-created</td>
    <td>date-modified</td>
    <td>publish</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="update.php">edit</a> | <a href="delete_confirm.php?id=<?php echo $row_rs_listing['id'];?>">delete</a></td>
      <td><?php echo $row_rs_listing['title']; ?></td>
      <td><?php echo $row_rs_listing['sub_title']; ?></td>
      <td><?php echo $row_rs_listing['sort_menu']; ?></td>
      <td><?php echo $row_rs_listing['body_content']; ?></td>
      <td><?php echo $row_rs_listing['date_created']; ?></td>
      <td><?php echo $row_rs_listing['date_modified']; ?></td>
      <td><?php echo $row_rs_listing['publish']; ?></td>
    </tr>
    <?php } while ($row_rs_listing = mysql_fetch_assoc($rs_listing)); ?>
</table>
<hr />
<?php require('admin_footer.php');?>
<?php
mysql_free_result($rs_listing);
?>
