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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO national_geographic (title, sub-title, sort_menu, body_content, date-created, date-modified, publish) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['subtitle'], "text"),
                       GetSQLValueString($_POST['sort_menu'], "int"),
                       GetSQLValueString($_POST['body_content'], "text"),
                       GetSQLValueString($_POST['datecreated'], "date"),
                       GetSQLValueString($_POST['datemodified'], "date"),
                       GetSQLValueString($_POST['publish'], "text"));

  mysql_select_db($database_con_wdimserver, $con_wdimserver);
  $Result1 = mysql_query($insertSQL, $con_wdimserver) or die(mysql_error());

  $insertGoTo = "listing.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rs_delete_confirm = "-1";
if (isset($_GET['id'])) {
  $colname_rs_delete_confirm = $_GET['id'];
}
mysql_select_db($database_con_wdimserver, $con_wdimserver);
$query_rs_delete_confirm = sprintf("SELECT * FROM national_geographic WHERE id = %s", GetSQLValueString($colname_rs_delete_confirm, "int"));
$rs_delete_confirm = mysql_query($query_rs_delete_confirm, $con_wdimserver) or die(mysql_error());
$row_rs_delete_confirm = mysql_fetch_assoc($rs_delete_confirm);
$totalRows_rs_delete_confirm = mysql_num_rows($rs_delete_confirm);
?>
<?php require('admin_header.php');?>
<div id="delete_notice"><div id="logo"></div>
<h1>Do you wish to delete this record?</h1>
<p>By clicking delete your record will be permanently deleted from the database.</p>
<p><strong><em>This operation can not be undone!</em></strong></p>
</div>
<hr />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Title:</td>
      <td><?php echo $row_rs_delete_confirm['title']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Sub-title:</td>
      <td><?php echo $row_rs_delete_confirm['sub-title']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Sort_menu:</td>
      <td><?php echo $row_rs_delete_confirm['sort_menu']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Body_content:</td>
      <td><?php echo $row_rs_delete_confirm['body_content']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date-created:</td>
      <td><?php echo $row_rs_delete_confirm['date-created']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date-modified:</td>
      <td><?php echo $row_rs_delete_confirm['date-modified']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Publish:</td>
      <td><?php echo $row_rs_delete_confirm['publish']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><a href="delete.php?id=<?php echo $row_rs_delete_confirm['id'];?>">Yes, I want to delete this record</a> | <a href="listing.php">No, I do not want to delete this record</a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php require('admin_footer.php');?>
       <?php
mysql_free_result($rs_delete_confirm);
?>
