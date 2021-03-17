<?php

namespace App\Models;

use App\Models\Concerns\Html;
use App\Models\Concerns\LocalCache;
use Illuminate\Database\Eloquent\Model;

class ApplicationModel extends Model
{
    use LocalCache, Html;
}
