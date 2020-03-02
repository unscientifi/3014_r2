<?php 

// php mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

function createUser($fname, $username, $password, $email){
    $pdo = Database::getInstance()->getConnection();
    
    //TODO: finish the below so that it can run a SQL query
    // to create a new user with provided data
    $create_user_query = 'INSERT INTO tbl_user(user_fname, user_name, user_pass, user_email, user_ip)';
    $create_user_query .= ' VALUES(:fname, :username, :password, :email, "no" )';

    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $newPassword = newString($string, 8);

    // create password
    $randompw = password_hash($newPassword, PASSWORD_DEFAULT);


    $create_user_set = $pdo->prepare($create_user_query);
    $create_user_result = $create_user_set->execute(
        array(
            ':fname'=>$fname,
            ':username'=>$username,
            ':password'=>$randompw,
            ':email'=>$email,
        )
    );
     //TODO: redirect to index.php if creat user successfully
    // otherwise, return a error message
    if($create_user_result){
        // redirect_to('index.php');
    
        // Instantiation
        $mail = new PHPMailer(true);
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp1.example.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'user@example.com';                     // SMTP username
            $mail->Password   = 'secret';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to
        
            //Recipients
            $mail->setFrom('ryansun1111@gmail.com', 'Mailer'); 
            $mail->addAddress('ryansun1111@gmail.com');               
            $mail->addReplyTo('ryansun1111@gmail.com', 'Information');

        
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Mailer';
            $mail->Body    = '<h1>Welcome! <b>NEW USER!</b> </h1>
                                <h2></h2>' . $username .
                                '<h2>Your password is: </h2>' . $randompw .
                                '<h3>URL: http://localhost:8888/movies_cms/admin/admin_login.php</h3>';
        
     $mail->send();

}else {
    return 'The user did not go through';
}

}