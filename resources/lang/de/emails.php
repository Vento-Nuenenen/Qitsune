<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Emails Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for various emails that
    | we need to display to the user. You are free to modify these
    | language lines according to your application's requirements.
    |
    */

    /*
     * Activate new user account email.
     *
     */

    'activationSubject'  => 'Aktivierung notwendig',
    'activationGreeting' => 'Wilkommen!',
    'activationMessage'  => 'Du muss die Aktivierung in der Email starten, befor u alle Dienste nutzen kannst.',
    'activationButton'   => 'Aktivieren',
    'activationThanks'   => 'Danke, dass du diese Applikation nutzt!',

    /*
     * Goobye email.
     *
     */
    'goodbyeSubject'    => 'Schade, dass du gehst...',
    'goodbyeGreeting'   => 'Hallo :username,',
    'goodbyeMessage'    => 'Wir finden es schade, dich gehen zu sehen. Dein Konto wurde gelöscht. Du kannst innerhalb von '.config('settings.restoreUserCutoff').' Tagen dein Konto wiederherzustellen.',
    'goodbyeButton'     => 'Konto wiederherstellen',
    'goodbyeThanks'     => 'Wir hoffen, dass wir dich wieder sehen werden!',

];
