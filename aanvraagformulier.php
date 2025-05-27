<?php
require 'vendor/autoload.php'; // Autoload de SendGrid bibliotheek

use SendGrid;
use SendGrid\Mail\Mail;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Haal de gegevens van het formulier op
    $naam = htmlspecialchars($_POST['naam']);
    $email = htmlspecialchars($_POST['email']);
    $telefoon = htmlspecialchars($_POST['telefoon']);
    $verzekering = htmlspecialchars($_POST['verzekering']);
    $ingangsdatum = htmlspecialchars($_POST['ingangsdatum']);
    $kenteken = htmlspecialchars($_POST['kenteken']);
    $merk = htmlspecialchars($_POST['merk']);
    $betalingstermijn = htmlspecialchars($_POST['betalingstermijn']);
    $iban = htmlspecialchars($_POST['iban']);
    $schadeErvaring = htmlspecialchars($_POST['schadeErvaring']);
    $schadevrijeJaren = htmlspecialchars($_POST['schadevrijeJaren']);
    $bericht = htmlspecialchars($_POST['bericht']);
    $opzegservice = htmlspecialchars($_POST['opzegservice']);

    // Maak een nieuwe SendGrid-mail
    $mail = new Mail();
    $mail->setFrom('info@klaasvis.nl', 'Dekker Autoverzekering'); // Vervang door je afzender email
    $mail->setSubject('Nieuwe aanvraag van ' . $naam);
    $mail->addTo('rbuijs@klaasvis.nl', 'Ontvanger'); // Vervang door jouw e-mailadres
    $mail->addContent("text/html", "
        <html>
        <head>
            <title>Aanvraagformulier Dekker Autoverzekering</title>
        </head>
        <body>
            <h2>Aanvraagformulier Informatie</h2>
            <p><strong>Naam:</strong> $naam</p>
            <p><strong>E-mail:</strong> $email</p>
            <p><strong>Telefoonnummer:</strong> $telefoon</p>
            <p><strong>Kenteken:</strong> $kenteken</p>
            <p><strong>Merk:</strong> $merk</p>
            <p><strong>Verzekeringstype:</strong> $verzekering</p>
            <p><strong>Ingangsdatum:</strong> $ingangsdatum</p>
            <p><strong>IBAN:</strong> $iban</p>
            <p><strong>Betalingstermijn:</strong> $betalingstermijn</p>
            <p><strong>Heeft schade-ervaring:</strong> $schadeErvaring</p>
            <p><strong>Aantal schadevrije jaren:</strong> $schadevrijeJaren</p>
            <p><strong>Bericht:</strong></p>
            <p>" . nl2br($bericht) . "</p>
            <p><strong>Wenst gebruik te maken van opzegservice:</strong> $opzegservice</p>
        </body>
        </html>
    ");

    // Verstuur de e-mail via SendGrid
    $sendgrid = new SendGrid('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
'); // Vervang met je eigen SendGrid API-sleutel

    try {
        $response = $sendgrid->send($mail);
        echo 'E-mail verzonden! Status code: ' . $response->statusCode();
    } catch (Exception $e) {
        echo 'E-mail kon niet worden verzonden. Fout: ' . $e->getMessage();
    }
}
?>
