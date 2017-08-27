<?php

return [

    'pdf' => [
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
    'image' => [
        'enabled' => true,
        'binary'  => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltoimg-amd64'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

];
