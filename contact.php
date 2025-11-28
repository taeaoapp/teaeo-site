<?php
$name = $_POST['name']; 
$email = $_POST['email'];
$subject = $_POST['subject'];
$surename = $_POST['surename'];
$phone = $_POST['phone'];
$message = $_POST['message'];
$check = $_POST['check'] ?? '';

include('smtp/PHPMailerAutoload.php');

//Destination mailbox (override with env var)
$to = getenv('MAIL_TO') ?: 'zac.oge@gmail.com';
$from = 'zac.oge@gmail.com';

//SMTP credentials (override with env vars)
$smtpHost = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
$smtpPort = getenv('SMTP_PORT') ?: 587;
$smtpUser = getenv('SMTP_USER') ?: 'zac.oge@gmail.com';
$smtpPass = getenv('SMTP_PASS') ?: 'eyvptsxocpbmfzdk';
$smtpSecure = getenv('SMTP_SECURE') ?: 'tls';

try {
	if($name && $email && $surename && $phone && $message) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo 'Email is not valid. Please try again.';
			exit;
		}

		$html="<table>
			<tr><td>Company</td><td>: $surename</td></tr>
			<tr><td>Name</td><td>: $name</td></tr>
			<tr><td>Email</td><td>: $email</td></tr>
			<tr><td>Phone</td><td>: $phone</td></tr>
			<tr><td>Subject</td><td>: $subject</td></tr>
			<tr><td>Message</td><td>: $message</td></tr>
			<tr><td>Marketing Opt-in</td><td>: $check</td></tr>
		</table>";

		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->SMTPDebug = SMTP::DEBUG_OFF;
		$mail->Timeout = 15;
		$mail->Host = $smtpHost;
		$mail->Port = $smtpPort;
		$mail->SMTPSecure = $smtpSecure;
		$mail->SMTPAuth = true;
		$mail->Username = $smtpUser;
		$mail->Password = $smtpPass;
		$mail->setFrom($smtpUser);
		$mail->addAddress($to);
		$mail->addReplyTo($email, $name);
		$mail->isHTML(true);
		$mail->Subject = $subject ?: 'Contact request';
		$mail->Body = $html;
		$mail->SMTPOptions=array('ssl'=>array(
			'verify_peer'=>false,
			'verify_peer_name'=>false,
			'allow_self_signed'=>false
		));

		if($mail->send()){
			echo 'Your Message has been sent successfully!'; 
		} else {
			error_log('Contact form mail send failed: '.$mail->ErrorInfo);
			echo 'Something went wrong, Please Try Again.'; 
		}
	} else {
		echo 'All Fields are Required.';
	}
} catch (phpmailerException $e) {
    error_log('Contact form mailer exception: ' . $e->getMessage());
    echo 'Something went wrong, Please Try Again.';
}
