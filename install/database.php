<?php
?>
<html>
	<body>
		Database config:
		<?php
		if(isset($_GET['error'])) {
			echo('<div style="color: red">Please fill in all the fields</div>');
		} else {
			echo('<br');
		}
		?>
		<br>
		<form action="database_submit.php" method="POST">
			Username:<br>
			<input type="text" name="user">
			<br>
			Password:<br>
			<input type="password" name="pass">
			<br>
			Address:<br>
			<input type="text" name="address">
			<br>
			Port:<br>
			<input type="text" name="port" value="3306">
			<br>
			Database name:<br>
			<input type="text" name="dbname">
			<br>
			Table prefix:<br>
			<input type="text" name="tblprefix" value="cas-">
			<br>
			<br>
			<input type="submit" value="Next">
		</form>
	</body>
</html>