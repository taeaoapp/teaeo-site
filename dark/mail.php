<?php
// Contact Message
if(isset($_POST['surename']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])  && isset($_POST['check'])){
	$surename=$_POST['surename'];
	$name= $_POST['name'];
	$email= $_POST['email'];
	$subject= $_POST['subject'];
	$message= $_POST['message'];
	$check= $_POST['check'];

	

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "
			<div class='alert alert-danger alert-dismissible fade show' role='alert'>
				<span>Email is Not Valid! Please try again. </span>
			</div>
		";
	}elseif($check == ''){
		echo "
			<div class='alert alert-danger alert-dismissible fade show' role='alert'>
				<span>Checkbox is required.</span>
			</div>
		";
	}else{

		//Email body
		$html="<table><tr><td>Surename</td><td>: $surename</td></tr><tr><td>Name</td><td>: $name</td></tr> <tr><td>Email</td><td>: $email</td></tr><tr><td>Subject</td><td>: $subject</td></tr><tr><td>Message</td><td>: $message</td></tr><tr><td>Check</td><td>: $check</td></tr></table>";	
		include('smtp/PHPMailerAutoload.php');
		
		//Create instance of PHPMailer
		$mail=new PHPMailer(true);

		//Set mailer to use smtp
		$mail->isSMTP();

		//Define smtp host
		$mail->Host="smtp.gmail.com";

		//Port to connect smtp
		$mail->Port=587;

		//Set smtp encryption type (ssl/tls)
		$mail->SMTPSecure="tls";
		
		//Enable smtp authentication
		$mail->SMTPAuth=true;

		//Set gmail username
		$mail->Username="rajan.pixner@gmail.com"; // Replace Company's Email Address (preferably currently used Domain Name)

		//Set gmail password
		$mail->Password="xhwgvvjjdozzxbag";  //Replace Your Gmail Password Here

		//Set sender email
		$mail->SetFrom("rajan.pixner@gmail.com"); // Replace Your Email Address

		//Add recipient
		$mail->addAddress("rajan.pixner@gmail.com"); // Replace Your Recipient Email Address
		
		//Enable HTML
		$mail->IsHTML(true);

		//Email subject
		$mail->Subject="Client"; //Replace Your Email subject 

		//Email body
		$mail->Body=$html;
		
		$mail->SMTPOptions=array('ssl'=>array(
			'verify_peer'=>false,
			'verify_peer_name'=>false,
			'allow_self_signed'=>false
		));

		if($mail->send()){
			$success = "
				<div class='conTop_25 alert alert-success alert-dismissible fade show' role='alert'>
					<span>Thank you for contacting us and will be in touch with you very soon.</span>
				</div>
			";
		}else{
			$fail = "
				<div class='alert alert-danger alert-dismissible fade show' role='alert'>
					<span>Please fill out all required fields.</span>
				</div>
			";
		}
		}
	}
	if (isset($success)) {
		echo $success;
	} 
	if (isset($fail)) {
		echo $fail;
	} 

?>