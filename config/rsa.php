<?php
return [
    'keys' => [
        /*
         |--------------------------------------------------------------------------
         | Public Key
         |--------------------------------------------------------------------------
         |
         | 文件名，文件路径：file://path/to/storage/
         |
         | E.g. 'rsa-public.key'
         |
         */
        'public' => env('RSA_PUBLIC_KEY', 'rsa-public.key'),

        /*
         |--------------------------------------------------------------------------
         | Private Key
         |--------------------------------------------------------------------------
         |
         | 文件名，文件路径：file://path/to/storage/
         |
         | E.g. 'rsa-private.key'
         |
         */
        'private' => env('RSA_PRIVATE_KEY', 'rsa-private.key'),

        /*
         |--------------------------------------------------------------------------
         | Passphrase
         |--------------------------------------------------------------------------
         |
         | The passphrase for your private key. Can be null if none set.
         |
         */
        'passphrase' => env('RSA_PASSPHRASE'),
    ],

    /**
     * [1-OAEP, 2-PKCS1, 3-none]
     */
    'ENCRYPTION_MODE' => env('ENCRYPTION_MODE', 1),
];
