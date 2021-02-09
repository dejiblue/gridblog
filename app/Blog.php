<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

/**
 * Class Blog
 * @package App
 */
class Blog extends Model
{
    use Rateable;

    /**
     * Get the author that wrote the posts.
     */
    public function writer()
    {
       return $this->belongsTo('App\User', 'author', 'id');
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
