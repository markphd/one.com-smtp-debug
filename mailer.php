<!DOCTYPE html>
<html>
<head>
	<title>One.com SMTP debugger</title>
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	<script type="text/javascript">
		var request = new XMLHttpRequest();
		var headers = request.getAllResponseHeaders();
		console.log(headers);
	</script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<style type="text/css">
		body, input, label {
			font-family: 'Varela Round', sans-serif;
			text-align: center;
		}

		div.center {
			margin: 3% auto;
			width: 280px;
			text-align: left;
		}

		input {
			padding: 0.8em;
			display: block;
			min-width: 230px;
			margin: 1% 0;
		}

		label {
			font-weight: 800;
			padding: 20px 0;
		}

		input[type="submit"] {
			padding: 0.6em;
			margin-top: 2em;
			background-color: #191919;
			color: #7d7d7d;
			font-size: 20px;
			box-sizing: content-box;
			border: none;
			box-shadow: 1px 2px 4px #ccc;
			text-transform: uppercase;
		}

		.result{
			width: 60%;
			font-family: monospace;
			text-align: left;
    		margin: 0 auto;
		}
		.success {
			color: green;
		}
		.fail {
			color: #c33030;
		}

	</style>
</head>
<body>
	<h1>One.com SMTP Tester</h1>
	<p>Test SMTP protocol via PHP script.</p>
	<div class="result">

<?php
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require './src/PHPMailerAutoload.php';

// Username
$username = $_POST["email"];
$password = $_POST["password"];
$recipient = $_POST["recipient"];
$host = $_POST["server"];
$port = $_POST["portNumber"];
$protocol = $_POST["smtpSecure"];

var_dump($protocol);
echo "<br>";
var_dump($port);
echo "<br>";

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = $host;
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = $port;
//Set TLS / SSL
$mail->SMTPSecure = $protocol;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = $username;
//Password to use for SMTP authentication
$mail->Password = $password;
//Set who the message is to be sent from
$mail->setFrom($username, 'Test');
//Set an alternative reply-to address
$mail->addReplyTo($username, 'Test');
//Set who the message is to be sent to
$mail->addAddress($recipient, 'Receiver');
//Set the subject line
$mail->Subject = 'SMTP test via PHP';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("<h1>One.com</h1><pre>SMTP Mail test: OK</pre>");
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//send the message, check for errors
if (!$mail->send()) {
    echo '<p class="fail">Mailer Error: ' . $mail->ErrorInfo . '</p>';
} else {
    echo '<p class="success">Message sent!</p>';
}

?>

</div>