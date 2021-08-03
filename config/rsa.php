<?php
return [
    /**
     * 默认客户端
     */
    'client' => env('RSA_CLIENT', 'default'),

    /**
     * 客户端
     */
    'clients' => [

        'default' => [
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

            /**
             * [1-OPENSSL_PKCS1_PADDING, 2-OPENSSL_SSLV23_PADDING, 3-OPENSSL_NO_PADDING]
             */
            'encryptionMode' => env('RSA_ENCRYPTION_MODE', 1),

            /**
             * [1-OPENSSL_ALGO_SHA1, 2-OPENSSL_ALGO_MD5]
             */
            'signatureMode' => env('RSA_SIGNATURE_MODE', 1),
        ]

        // 更多客户端
    ],
];
