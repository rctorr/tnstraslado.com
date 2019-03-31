<?php
    if(isset($_POST['email'])) {

        include 'formsettings.php';

        function died($error) {
            echo json_encode($error);
            die();
        }

        if(!isset($_POST['nombre']) ||
            !isset($_POST['email']) ||
            !isset($_POST['mensaje'])
            ) {
            died('Error: Parece que hay un error con el envío de los datos');		
        }

        $nombre = $_POST['nombre']; // required
        $email = $_POST['email']; // required
        $msg = $_POST['mensaje']; // required

        $error_message = "";

        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
      if(preg_match($email_exp,$email)==0) {
        $error_message .= 'Error: El email proporcionado parece no ser válido';
      }
      if(strlen($nombre) < 2) {
        $error_message .= 'Error: El nombre parece no ser válido';
      }
      if(strlen($msg) < 2) {
        $error_message .= 'Error: El comentario parece no ser válido';
      }

      if(strlen($error_message) > 0) {
        died($error_message);
      }
        $email_message = "El detalle de mensajea continuación.\r\n";

        function clean_string($string) {
          $bad = array("content-type","bcc:","to:","cc:");
          return str_replace($bad,"",$string);
        }

        $email_message .= "Nombre: ".clean_string($nombre)."\r\n";
        $email_message .= "Email: ".clean_string($email)."\r\n";
        $email_message .= "Message: \r\n".clean_string($msg)."\r\n\r\n";
        $email_message .= base64_decode($base)."\r\n";

        $headers = 'From: '.$email."\r\n".
        'Reply-To: '.$email."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        mail(base64_decode($email_to), $email_subject, $email_message, $headers);

        echo json_encode(True);
    } else {
        die(json_encode("Error: Email no proporcionado"));
    }
?>