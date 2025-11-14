<?php
require './config/PHPMailer-master/src/PHPMailer.php';
require './config/PHPMailer-master/src/SMTP.php';
require './config/PHPMailer-master/src/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailService {
    public function envoyerEmailCandidature($email, $nom, $titreOffre, $statut) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'andriahasiniainafiderana@gmail.com'; // Ton email
            $mail->Password   = 'zuzwjsbrjduafvao'; // Mot de passe d'application Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('andriahasiniainafiderana@gmail.com', 'Service Recrutement');
            $mail->addAddress($email, $nom);

            $mail->isHTML(true);
            $mail->Subject = "Mise à jour de votre candidature";
            $mail->Body    = "
                Bonjour <b>$nom</b>,<br><br>
                Le statut de votre candidature pour l'offre <b>$titreOffre</b> a été changé en 
                <b style='color:blue;'>".strtoupper($statut)."</b>.<br><br>
                Merci de votre intérêt et bonne continuation.<br>
                <i>Service Recrutement</i>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur envoi email : {$mail->ErrorInfo}");
        }
    }
}
