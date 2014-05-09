<?php

namespace Morrelinko\LaravelSimplePhoto;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Laju Morrison <morrelinko@gmail.com>
 */
class Photo extends Model
{
    protected $table = 'photos';

    public function getId()
    {
        return $this->getKey();
    }
}
