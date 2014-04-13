<?php

namespace Morrelinko\LaravelSimplePhoto;

use Illuminate\Support\ServiceProvider;
use SimplePhoto\SimplePhoto;
use SimplePhoto\StorageManager;

/**
 * @author Laju Morrison <morrelinko@gmail.com>
 */
class SimplePhotoServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();

        $this->registerDataStore();

        $this->registerStorageFactory();

        $this->registerStorageManager();

        $this->registerSimplePhoto();
    }

    protected function registerConfig()
    {
        $this->app['config']->package(
            'morrelinko/laravel-simple-photo',
            __DIR__ . '/config',
            'morrelinko/laravel-simple-photo'
        );
    }

    protected function registerDataStore()
    {
        $this->app['simple-photo.data-store'] = $this->app->share(function ($app) {
            return new LaravelDataStore(
                $app['db'],
                $app['config']['morrelinko/laravel-simple-photo::connection'],
                $app['config']['morrelinko/laravel-simple-photo::data_store_options']
            );
        });
    }

    protected function registerStorageFactory()
    {
        $this->app['simple-photo.storage-factory'] = $this->app->share(function ($app) {
            return new StorageFactory($app['config']);
        });
    }

    protected function registerStorageManager()
    {
        $this->app['simple-photo.storage-manager'] = $this->app->share(function ($app) {
            $storageManager = new StorageManager();
            $storageLocations = $app['config']['morrelinko/laravel-simple-photo::storage_locations'];

            foreach ($storageLocations as $storageName => $storageLocation) {
                $storageManager->add(
                    $storageName,
                    $app['simple-photo.storage-factory']->createStorage(
                        $storageLocation['storage'],
                        $storageLocation['options']
                    )
                );
            }

            $storageManager->setDefault($app['config']['morrelinko/laravel-simple-photo::default_storage']);
            $fallbackStorage = $app['config']['morrelinko/laravel-simple-photo::fallback_storage'];

            if ($fallbackStorage) {
                $storageManager->setFallback($storageManager->get($fallbackStorage));
            }

            return $storageManager;
        });
    }

    protected function registerSimplePhoto()
    {
        $this->app['simple-photo'] = $this->app->share(function ($app) {
            return new SimplePhoto(
                $app['simple-photo.storage-manager'],
                $app['simple-photo.data-store']
            );
        });
    }

    public function provides()
    {
        return array(
            'simple-photo.data-store',
            'simple-photo.storage-manager',
            'simple-photo'
        );
    }
}
