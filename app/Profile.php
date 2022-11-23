<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function Author()
    {
        return $this->belongsTo(Author::class);
    }
}
