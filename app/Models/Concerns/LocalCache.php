<?php

namespace App\Models\Concerns;

use Illuminate\Support\Arr;

trait LocalCache
{
    /**
     * Local cache hash.
     * 
     * @var array
     */
    protected $localCache = [];

    /**
     * Reads or updates the local cache.
     * 
     * @param  string     $key
     * @param  mixed|null $value
     * @return mixed
     */
    function cached($key, $value = null)
    {
        if ($value) {
            $this->localCache[$key] = $value;
        }

        return Arr::get($this->localCache, $key);
    }
}
