<?php

return array(
    /*
    |--------------------------------------------------------------------------
    | Data Store connection
    |--------------------------------------------------------------------------
    |
    | Set data store connection
    |
    */

    'connection' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Data Store Options
    |--------------------------------------------------------------------------
    |
    | Set data store options
    |
    */

    'data_store_options' => array(),

    /*
    |--------------------------------------------------------------------------
    | Default Storage
    |--------------------------------------------------------------------------
    |
    |  Set the storage that will be used if no storage is specified
    |  when uploading of photo
    |
    */

    'default_storage' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Fallback Storage
    |--------------------------------------------------------------------------
    |
    |  Set the storage that will be used to retrieve fallback photos
    |
    */

    'fallback_storage' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Storage Locations
    |--------------------------------------------------------------------------
    |
    | Here are all storage locations setup for your application.
    |
    */

    'storage_locations' => array(
        'local' => array(
            'storage' => 'local',
            'options' => array(
                'root' => public_path(),
                'path' => 'files/photos'
            )
        ),
        'default' => array(
            'storage' => 'local',
            'options' => array(
                'root' => public_path(),
                'path' => 'files/defaults'
            )
        ),
        'remote' => array(
            'storage' => 'remoteHost',
            'options' => array(
                'host' => '127.0.0.1',
                'port' => 21,
                'path' => 'photos',
                'username' => 'username',
                'password' => 'pa$$word'
            )
        )
    )
);
