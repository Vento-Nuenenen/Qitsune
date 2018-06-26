<?php

return [

    'projectId'     => env('AIRBRAKE_ID','0'),
    'projectKey'    => env('AIRBRAKE_KEY','0'),
    'environment'   => env('APP_ENV', 'production'),

    //leave the following options empty to use defaults

    'appVersion'    => '',
    'host'          => env('AIRBRAKE_HOST','localhost'),
    'rootDirectory' => '',
    'httpClient'    => '',

];
