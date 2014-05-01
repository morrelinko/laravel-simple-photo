<?php

namespace Morrelinko\LaravelSimplePhoto;

/**
 * @author Laju Morrison <morrelinko@gmail.com>
 */
trait SimplePhotoTrait
{
    protected $photosHash = [];

    public function getPhotoForParameter($param)
    {
        $photoId = $this->{$this->photos[$param]['column']};
        unset($this->photos[$param]['column']);
        $options = $this->photos[$param];

        return app('simple-photo')->get($photoId, $options);
    }

    public function __get($property)
    {
        if (array_key_exists($property, $this->photos)) {
            if (isset($this->photosHash[$property])) {
                return $this->photosHash[$property];
            }

            return $this->photosHash[$property] = $this->getPhotoForParameter($property);
        }

        return parent::__get($property);
    }
}
