<?php
include('config.php');
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>GrailsUY - &Uacute;nete a nuestro Slack!</title>
	<link href='http://fonts.googleapis.com/css?family=Lato:400,400italic' rel='stylesheet' type='text/css'>
	<link href="styles.css" rel="stylesheet" type="text/css" />	
<body>
	<div class="bg">
		<div class="bg-inner">
			<div class="main"><img class="logo" src="logo.jpg" height="200" width="200"/>
			<div class="info"><br>GrailsUY - &Uacute;nete a nuestro <a href="http://slack.com" target="_blank">Slack</a>!<br/></div>
			<form action="register.php" method="POST">
			<input class="email" type="text" placeholder="Email" name="email"><input class="button" type="submit" name="submit" value="Join">
			</form>
			<div class="info-bottom">S&iacute;genos en <a href="<?php echo $GLOBALS['meetupUrl']; ?>">Meetup</a>.
				</div>
			</div>
		</div>
	</div>
</body>
</html>