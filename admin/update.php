<?php require_once('../Connections/con_wdimserver.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE national_geographic SET title=%s, sub_title=%s, sort_menu=%s, body_content=%s, date_created=%s, date_modified=%s, publish=%s WHERE id=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['sub_title'], "text"),
                       GetSQLValueString($_POST['sort_menu'], "int"),
                       GetSQLValueString($_POST['body_content'], "text"),
                       GetSQLValueString($_POST['date_created'], "date"),
                       GetSQLValueString($_POST['date_modified'], "date"),
                       GetSQLValueString($_POST['publish'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_con_wdimserver, $con_wdimserver);
  $Result1 = mysql_query($updateSQL, $con_wdimserver) or die(mysql_error());

  $updateGoTo = "listing.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_con_wdimserver, $con_wdimserver);
$query_rs_update = "SELECT * FROM national_geographic ORDER BY id ASC";
$rs_update = mysql_query($query_rs_update, $con_wdimserver) or die(mysql_error());
$row_rs_update = mysql_fetch_assoc($rs_update);
$totalRows_rs_update = mysql_num_rows($rs_update);
?>
<?php require('admin_header.php');?>
<div id="header"><div id="logo"></div>
<h1>Update a record</h1>
<p>Fill out the form to edit a record in the table.</p>
</div>
<hr />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Title:</td>
      <td><input type="text" name="title" value="<?php echo htmlentities($row_rs_update['title'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Sub_title:</td>
      <td><input type="text" name="sub_title" value="<?php echo htmlentities($row_rs_update['sub_title'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Sort_menu:</td>
      <td><input type="text" name="sort_menu" value="<?php echo htmlentities($row_rs_update['sort_menu'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Body_content:</td>
      <td><textarea name="body_content" cols="50" rows="5"><?php echo htmlentities($row_rs_update['body_content'], ENT_COMPAT, 'UTF-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date_created:</td>
      <td><input type="text" name="date_created" value="<?php echo htmlentities($row_rs_update['date_created'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date_modified:</td>
      <td><input type="text" name="date_modified" value="<?php echo htmlentities($row_rs_update['date_modified'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Publish:</td>
      <td><input type="text" name="publish" value="<?php echo htmlentities($row_rs_update['publish'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="id" value="<?php echo $row_rs_update['id']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_rs_update['id']; ?>" />
</form>
<p>&nbsp;</p>
<?php require('admin_footer.php');?>
       <?php
mysql_free_result($rs_update);
?>
