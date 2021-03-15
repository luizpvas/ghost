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
            $relation = new Relation($model, $key, Relation::HAS_ONE);
            $relation->attach($value);
        }

        return [];
    }
}
