<?php

namespace Website\Controllers;

/**
 * Class HomeController
 *
 * Deze handelt de logica van de homepage af
 * Haalt gegevens uit de "model" laag van de website (de gegevens)
 * Geeft de gegevens aan de "view" laag (HTML template) om weer te geven
 *
 */
class RegistrationController {

	public function registrationForm() {

        // $users = getUsers();

		$template_engine = get_template_engine();
        echo $template_engine->render('register_form');
        // , ['users' => $users]

	}

	public function handleRegistrationForm() {

		$errors = [];

		$email		= filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL );
		$wachtwoord = trim( $_POST['wachtwoord'] );

		if ( $email === false ) {
			$errors['email'] = 'Geen geldige email ingevuld';
		}

		if ( strlen( $wachtwoord ) < 6 ) {
			$errors['wachtwoord'] = 'Geen geldige wachtwoord, minimaal 6 tekens!';
		}

		if ( count( $errors ) === 0 ) {
			$connection = dbConnect();
			$sql        = "SELECT * FROM `gebruikers` WHERE `email` = :email";
			$statement	= $connection->prepare( $sql );
			$statement->execute( [ 'email' => $email ] );
		}

		if ( $statement->rowCount() === 0  ) {
			$sql	   = "INSERT INTO `gebruikers` (`email`, `wachtwoord`) VALUES (:email, :wachtwoord)";
			$statement = $connection->prepare( $sql );
			$safe_password = password_hash( $wachtwoord, PASSWORD_DEFAULT );
			$params = [
				'email' => $email,
				'wachtwoord' => $safe_password
			];	
			$statement->execute( $params );

			$bedanktUrl = url('register.thankyou');
			redirect($bedanktUrl);


		} else {
			$errors['email'] = 'Dit account bestaat al';
		}

		$template_engine = get_template_engine();
        echo $template_engine->render('register_form', ['errors' => $errors]);

	}

	public function registrationThankYou() {

		$template_engine = get_template_engine();
		echo $template_engine->render("register_thankyou");

	}

}