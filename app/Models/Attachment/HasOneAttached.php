<?php

namespace App\Models\Attachment;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class HasOneAttached implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        return new Relation($model, $key, Relation::HAS_ONE);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes)
    {
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            if ($this->preventMultipleCalls($model, $key, $value)) return [];

            $relation = new Relation($model, $key, Relation::HAS_ONE);
            $relation->attach($value);
        }

        return [];
    }

    /**
     * It seems that `set` gets called multiple times for complex types (objects). This function caches the
     * latest call value to prevent mutliple runs.
     * 
     * @see https://github.com/laravel/framework/discussions/31778
     * @return boolean
     */
    public function preventMultipleCalls($model, $key, $value)
    {
        $key = '_latest_set_call:' . $key;
        if ($model->cached($key) == $value) return true;
        $model->cached($key, $value);
    }
}
