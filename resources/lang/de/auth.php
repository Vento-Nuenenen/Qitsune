<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'   => 'Diese Daten stimmen nicht mit unseren Infos überein.',
    'throttle' => 'Das Passwort wurde zu oft falsch Eingegeben. Bitte probiere es in :secons Sekunden noch einmal.',

    // Activation items
    'successActivated' => 'Dein Konto wurde erfolgreich aktiviert.',
    'unsuccessful'     => 'Dein Konto konnte nicht aktiviert werden; Bitte probiere es erneut.',
    'notCreated'       => 'Dein Konto konnte nicht erstellt werden; Bitte probiere es erneut.',
    'tooManyEmails'    => 'Zu viele aktivierungs Mails wurden an die Adresse :email. <br />Bitte probiere es erneut in <span class="label label-danger">:hours Stunden</span>.',
    'regThanks'        => 'Danke für die Registrierung,',
    'alreadyActivated' => 'Bereits aktiviert.',

    // Labels
    'whoops'          => 'Hoppla! ',
    'someProblems'    => 'Es sind Probleme mit deinen Eingaben aufgetreten.',
    'password'        => 'Passwort',
    'rememberMe'      => ' Eingelogt bleiben',
    'login'           => 'Login',
    'forgot'          => 'Passwort vergessen?',
    'forgot_message'  => 'Passwort probleme?',
    'name'            => 'Pfadiname',
    'first_name'      => 'Vorname',
    'last_name'       => 'Nachname',
    'confirmPassword' => 'Passwort bestätigen',
    'register'        => 'Registrieren',

    // Placeholders
    'ph_name'          => 'Pfadiname',
    'ph_firstname'     => 'Vorname',
    'ph_lastname'      => 'Nachname',
    'ph_password'      => 'Passwort',
    'ph_password_conf' => 'Passwort bestätigen',

    // User flash messages
    'sendResetLink' => 'Sende einen Passwort Reset Link',
    'resetPassword' => 'Passwort zurücksetzen',
    'loggedIn'      => 'Du wurdest Eingelogt!',

    // email links
    'pleaseActivate'    => 'Bitte aktiviere dein Konto.',
    'clickHereReset'    => 'Klick hier um dein Passwort zurück zu setzen: ',
    'clickHereActivate' => 'Klick hier um dein Konto zu aktivieren: ',

    // Validators
    'scoutNameRequired' => 'Pfadiname ist notwendig',
    'fNameRequired'     => 'Vorname ist notwendig',
    'lNameRequired'     => 'Nachname ist notwendig',
    'passwordRequired'  => 'Passwort ist notwendig',
    'PasswordMin'       => 'Passwort muss mindestens sechs zeichen enthalten',
    'PasswordMax'       => 'Passwort darf höchstens 20 Zeichen enthalten',
    'roleRequired'      => 'Benutzer-Rolle ist notwendig.',
];
