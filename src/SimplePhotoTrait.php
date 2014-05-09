<?php

namespace Morrelinko\LaravelSimplePhoto;

/**
 * @property-read $photos array
 * @property-read $relations array
 * @author Laju Morrison <morrelinko@gmail.com>
 */
trait SimplePhotoTrait
{
    protected $photosHash = [];

    public function getAttribute($key)
    {
        $data = parent::getAttribute($key);

        if (array_key_exists($key, $this->photos)) {
            $id = $this->getKey();
            if (isset($this->photosHash[$id][$key])) {
                return $this->photosHash[$id][$key];
            }

            $sp = app('simple-photo');
            $parameters = $this->photos[$key];

            if ($data instanceof Photo) {
                $data = $sp->build($data->toArray(), $parameters);
            } else if (array_key_exists($key, $this->relations)) {
                if ($data == null) {
                    $data = $sp->build(null, $parameters);
                }
            } else {
                $data = $sp->get($this->getKey(), $parameters);
            }

            $this->photosHash[$id][$key] = $data;
        }

        return $data;
    }
}
