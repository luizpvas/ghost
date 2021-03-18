<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentsController extends Controller
{
    /**
     * @param  string $id
     * @return Illuminate\Http\Response
     */
    function show($id)
    {
        $attachment = Attachment::findOrFail($id);
        return Storage::download($attachment->disk_path, $attachment->filename);
    }
}
