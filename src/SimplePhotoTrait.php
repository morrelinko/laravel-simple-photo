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
            if (isset($this->photosHash[$key])) {
                return $this->photosHash[$key];
            }

            $sp = app('simple-photo');
            $parameters = $this->photos[$key];
            $photoData = null;

            if ($data instanceof SimplePhotoModel) {
                $data = $sp->build($data->toArray(), $parameters);
            } else if (isset($this->relations[$key]) && $data == null) {
                $data = $sp->build(null, $parameters);
            } else {
                $data = $sp->get($this->{$parameters['column']}, $parameters);
            }

            $this->photosHash[$key] = $data;
        }

        return $data;
    }
}
