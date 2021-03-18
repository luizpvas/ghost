<?php

namespace App\Models\Attachment;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Relation
{
    const HAS_ONE = 'one';
    const HAS_MANY = 'many';

    /**
     * Model that has attachments.
     * 
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Name of the attachment relation (e.g. avatar).
     * 
     * @var string
     */
    protected $name;

    /**
     * Cardinality, either one or many.
     * 
     * @var string
     */
    protected $relation;

    /**
     * Builds the attachment relation that can be either one or many.
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $name
     * @param string $relation
     */
    function __construct($model, $name, $relation)
    {
        $this->model = $model;
        $this->name = $name;
        $this->relation = $relation;
    }

    /**
     * Attaches the given file.
     * If the relation is `one` the previous attachment is deleted.
     * 
     * @param  mixed $file
     */
    function attach($file)
    {
        if ($file instanceof UploadedFile) {
            if ($this->relation === self::HAS_ONE) {
                $this->deleteExistingAttachment();
            }

            $path = $file->store('attachments');

            $attachment = Attachment::create([
                'attachable_type' => $this->model->getMorphClass(),
                'attachable_id' => $this->model->id,
                'name' => $this->name,
                'variation_digest' => null,
                'filename' => $file->getClientOriginalName(),
                'mime' => $file->getClientMimeType(),
                'disk' => 'public',
                'disk_path' => $path,
                'byte_size' => $file->getSize()
            ]);

            if ($this->relation === self::HAS_ONE) {
                $this->model->cached($this->cacheKey(), collect([$attachment]));
            }
        }
    }

    /**
     * Deletes existing attachments.
     * 
     * @return void
     */
    function purge()
    {
        return $this->deleteExistingAttachment();
    }

    /**
     * Deletes the attachment record and the associated file and variants.
     * 
     * @return void
     */
    function deleteExistingAttachment()
    {
        $attachments = Attachment::where([
            'attachable_type' => $this->model->getMorphClass(),
            'attachable_id' => $this->model->id,
            'name' => $this->name
        ])->get();

        foreach ($attachments as $attachment) {
            Storage::delete($attachment->disk_path);
            $attachment->delete();
        }

        $this->model->cached($this->cacheKey(), collect());
    }

    /**
     * Checks if the attachment relation exists.
     * 
     * @return boolean
     */
    function attached()
    {
        return $this->attachments()->isNotEmpty();
    }

    /**
     * URL of the attachment.
     * 
     * @return string|null
     */
    function url()
    {
        return $this->attachments()->first() ? route('attachments.show', $this->attachments()->first()->id) : null;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    function attachments()
    {
        if ($attachments = $this->model->cached($this->cacheKey())) {
            return $attachments;
        }

        $attachments = Attachment::where([
            'attachable_type' => $this->model->getMorphClass(),
            'attachable_id' => $this->model->id,
            'name' => $this->name
        ])->get();

        $this->model->cached($this->cacheKey(), $attachments);

        return $attachments;
    }

    /**
     * @return string
     */
    function cacheKey()
    {
        return 'attachment:' . $this->name;
    }
}
