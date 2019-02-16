<?php

if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] === 'GET') {
	echo '<form action="" method="POST"><input name="id" /><button type="submit">Search</button></form>';exit();
} else {
	if (!isset($_POST['id'])) {
		$_POST['id'] = '';
	}
	$_POST['id'] = str_replace(['\\', '/', '.'], '', $_POST['id']);
	if (file_exists('C:/WebRoot/neonapi/api/accounts/v3/global/'.$_POST['id'].'.txt')) {
		if (time() - filemtime('C:/WebRoot/neonapi/api/accounts/v3/global/'.$_POST['id'].'.txt') > 3600) {
			echo 'NOT EXISTS<br /><form action="" method="POST"><input name="id" /><button type="submit">Search</button></form>';exit();
		}
		$data = file_get_contents('C:/WebRoot/neonapi/api/accounts/v3/global/'.$_POST['id'].'.txt');
		if (!$data) {
			echo 'NOT EXISTS<br /><form action="" method="POST"><input name="id" /><button type="submit">Search</button></form>';exit();
		}
		$data = json_decode($data);
		$data = $data[0]->result;
		for ($i = 0; $i < count($data); $i++) {
			unset($data[$i]->guid);
		}
		$data = json_encode($data);
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="result.json"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . strlen($data));
		echo($data);
		exit;
	} else {
		echo 'NOT EXISTS<br /><form action="" method="POST"><input name="id" /><button type="submit">Search</button></form>';exit();
	}
}