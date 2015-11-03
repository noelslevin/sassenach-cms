<?php

$year = $_GET['year'];
if (isset($_GET['month'])) {

	$month = $_GET['month'];
	if (isset($_GET['date'])) {

		$date = $_GET['date'];
		include $backend.'styles/'.$style.'date.php';
		}

	else {
		include $backend.'styles/'.$style.'month.php';
		}
	}

else {
	include $backend.'styles/'.$style.'year.php';
	}

?>
