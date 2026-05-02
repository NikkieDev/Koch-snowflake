<?php
$_GET['iterations'] = isset($_GET['iterations']) ? $_GET['iterations'] : 0;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Iteration: <?= $_GET['iterations']; ?></title>
</head>
<body>
	<img height="1200" width="1200" src="koch.php?iterations=<?= $_GET['iterations'] ?? 2 ?>"><br>
	<a href="?iterations=<?= ((int) $_GET['iterations'])+1 ?>">Next iteration</a>
	<a href="?iterations=<?= ((int) $_GET['iterations'])-1 ?>">Prev iteration</a>
</body>
</html>
