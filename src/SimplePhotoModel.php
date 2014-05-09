<?php

namespace Morrelinko\LaravelSimplePhoto;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Laju Morrison <morrelinko@gmail.com>
 */
class SimplePhotoModel extends Model
{
    protected $table = 'photos';

    public function getId()
    {
        return $this->getKey();
    }
}
