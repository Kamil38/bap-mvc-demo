<?php

namespace Registration\Controllers;

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
        echo $template_engine->render('homepage');
        // , ['users' => $users]

	}

	public function handleRegistrationForm() {

        // $users = getUsers();

		$template_engine = get_template_engine();
		echo $template_engine->render('homepage');
        // , ['users' => $users]
	}

}