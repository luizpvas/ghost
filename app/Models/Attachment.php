<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends ApplicationModel
{
    use HasFactory;

    /**
     * Disable mass assignment exception.
     * 
     * @var array
     */
    protected $guarded = [];
}
