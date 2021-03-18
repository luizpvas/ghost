<?php

namespace App\Http;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\URL;

class Reflinks implements Responsable
{
    /**
     * List of changes that needs to be applied by the client.
     * 
     * @var array
     */
    protected $directives = [];

    /**
     * Appends a redirect to the directives list.
     * 
     * @param  string $name
     * @param  array  $params
     * @return $this
     */
    function redirect($name, $params = [])
    {
        $this->directives[] = ['redirect' => route($name, $params)];
        return $this;
    }

    /**
     * Similar to `redirect`, but signs the URL with a hash that ensures it has not been modified.
     * 
     * @see https://laravel.com/docs/8.x/urls#signed-urls
     * @param  string $name
     * @param  array  $params
     * @return $this
     */
    function redirectSigned($name, $params)
    {
        $this->directives[] = ['redirect' => URL::signedRoute($name, $params)];
        return $this;
    }

    /**
     * Shows a toast that fades after a while.
     * 
     * @param  string $type
     * @param  string $message
     * @return $this
     */
    function toast($type, $message)
    {
        return $this->append('toast-container', 'components.toast.' . $type, ['slot' => $message]);
    }

    /**
     * Appends the given template in the target.
     * 
     * @param  string $targetId
     * @param  string $viewName
     * @param  array  $params
     * @return $this
     */
    function append($targetId, $viewName, $params = [])
    {
        $this->directives[] = ['action' => 'append', 'target' => $targetId, 'html' => view($viewName, $params)->render()];
        return $this;
    }

    /**
     * Builds a response object.
     * 
     * @return Illuminate\Http\Request
     */
    function toResponse($request)
    {
        return response()->json(['directives' => $this->directives]);
    }
}
