<?php

namespace Morrelinko\LaravelSimplePhoto;

use Closure;
use Illuminate\Config\Repository;
use Imagine\Exception\RuntimeException;
use SimplePhoto\Storage\LocalStorage;
use SimplePhoto\Storage\MemoryStorage;
use SimplePhoto\Storage\RemoteHostStorage;

/**
 * @author Laju Morrison <morrelinko@gmail.com>
 */
class StorageFactory
{
    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var array
     */
    protected $instances = [];

    /**
     * @var array
     */
    protected $extensions = [];

    /**
     * Constructor
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $name Storage Name
     * @param array $options
     * @return mixed
     */
    public function createStorage($name, $options = array())
    {
        $hash = md5($name . serialize($options));
        if (isset($this->instances[$hash])) {
            return $this->instances[$hash];
        }

        if (isset($this->extensions[$name])) {
            $storage = $this->extensions[$name]($options);
        } else {
            switch ($name) {
                case 'local':
                    $storage = $this->createLocalStorage($options);
                    break;
                case 'remoteHost':
                    $storage = $this->createRemoteHostStorage($options);
                    break;
                case 'memory':
                    $storage = $this->createMemoryStorage($options);
                    break;
                default:
                    $storage = null;
            }
        }

        return $this->instances[$hash] = $storage;
    }

    /**
     * @param array $options
     * @return LocalStorage
     */
    public function createLocalStorage($options = array())
    {
        return new LocalStorage($options);
    }

    /**
     * @param array $options
     * @return RemoteHostStorage
     */
    public function createRemoteHostStorage($options = array())
    {
        return new RemoteHostStorage($options);
    }

    /**
     * @param array $options
     * @return MemoryStorage
     */
    public function createMemoryStorage($options = array())
    {
        return new MemoryStorage($options);
    }

    public function createAwsS3Storage($options = array())
    {
        $client = S3Client::factory();
    }

    /**
     * @param string $name
     * @param callable $storageResolver
     */
    public function extend($name, Closure $storageResolver)
    {
        $this->extensions[$name] = $storageResolver;
    }
}
 