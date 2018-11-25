<?php
if (!isset($_GET['access_token'])) {
?><!DOCTYPE html>
<html style="background-color: #000000;">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1 style="color: #FFFFFF;">dmtq 私服討論 qq群 659850829</h1>
    </body>
</html>
<?php
	exit();
}
list($puid) = explode('|', urldecode($_GET['access_token']));
$handle = new SQLite3('C:\WebRoot\dmtq\_info\dmtq.db3');
$query = $handle->query("SELECT guid FROM Member WHERE puid = '".$puid."'");
if (($queryData = $query->fetchArray(SQLITE3_NUM))) {
    list($guid) = $queryData;
	$code = 0x135798642;
	$userId = strrev(strtoupper(dechex($guid ^ $code)));
	header('Location: ../djmaxQ/index?userId='.$userId);
	exit();
?>
<!DOCTYPE html>
<html style="background-color: #000000;">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
		<h1 style="color: #FFFFFF;">你的成積看分網 <?php echo 'https://icentral.konmai.co/djmaxQ?userId='.$userId;?></h1>
        <h1 style="color: #FFFFFF;">dmtq 私服討論 qq群 659850829</h1>
    </body>
</html>
<?php
} else {
?>
<!DOCTYPE html>
<html style="background-color: #000000;">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1 style="color: #FFFFFF;">dmtq 私服討論 qq群 659850829</h1>
    </body>
</html>
<?php
}
$handle->close();