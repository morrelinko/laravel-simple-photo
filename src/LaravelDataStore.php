<?php

namespace Morrelinko\LaravelSimplePhoto;

use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use SimplePhoto\DataStore\DataStoreInterface;

/**
 * @author Laju Morrison <morrelinko@gmail.com>
 */
class LaravelDataStore implements DataStoreInterface
{
    /**
     * @var \Illuminate\Database\Connection
     */
    protected $connection;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param DatabaseManager $db
     * @param string $connection
     * @param array $options
     */
    public function __construct(DatabaseManager $db, $connection, array $options = [])
    {
        $this->options = array_merge(array(
            'photo_table' => 'photos'
        ), $options);

        $this->connection = $db->connection($connection);
    }

    /**
     * {@inheritDoc}
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * {@inheritDoc}
     */
    public function addPhoto(array $values)
    {
        return $this->connection
            ->table($this->options['photo_table'])
            ->insertGetId([
                'storage_name' => $values['storageName'],
                'file_name' => $values['fileName'],
                'file_path' => $values['filePath'],
                'file_extension' => $values['fileExtension'],
                'file_size' => $values['fileSize'],
                'file_mime' => $values['fileMime'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getPhoto($photoId)
    {
        $this->connection->setFetchMode(\PDO::FETCH_ASSOC);

        return $this->connection
            ->table($this->options['photo_table'])
            ->find($photoId);
    }

    /**
     * {@inheritDoc}
     */
    public function getPhotos(array $photoIds)
    {
        $this->connection->setFetchMode(\PDO::FETCH_ASSOC);

        return $this->connection
            ->table($this->options['photo_table'])
            ->whereIn('id', $photoIds)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function deletePhoto($photoId)
    {
        return $this->connection
            ->table($this->options['photo_table'])
            ->delete($photoId);
    }
}
