<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['path'];

    public function imageable()
    {
        $this->morphTo();
    }

    public function url()
    {
        return Storage::url($this->path);
    }

}
