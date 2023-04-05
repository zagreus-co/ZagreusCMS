<?php

namespace App\Foundation\Performance;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Measurement
{
    public float|int $start_time;

    public function __construct()
    {
        $this->start_time = app('start_time');
    }

    /**
     * Modify the response and inject the debugbar (or data in headers)
     *
     * @param  \Symfony\Component\HttpFoundation\Request $request
     * @param  \Symfony\Component\HttpFoundation\Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifyResponse(Request $request, Response $response): Response
    {
        if ($this->isNotInjectable($request, $response)) return $response;

        $content = $response->getContent();

        $widget = $this->widget();
        // Try to put the widget at the end, directly before the </body>
        $pos = strripos($content, '</body>');
        if (false !== $pos) {
            $content = substr($content, 0, $pos) . $widget . substr($content, $pos);
        } else {
            $content = $content . $widget;
        }

        $response->setContent($content);
        $response->headers->remove('Content-Length');

        return $response;
    }

    protected function widget()
    {
        return '
        <div
            style="display: flex; justify-content: space-between; position: fixed; bottom: 0; padding: 10px; width: 100%; z-index: 100; background: rgb(31 41 55); color: white;"
            >
            <div>
                <strong>Zagreus Measurement:</strong>
                <span style="background-color: rgb(107 114 128); border-radius: 5px; padding: 2px 4px 2px 4px;" class="bg-gray-500">
                    Memory: ' . round(memory_get_usage() / 1024 / 1204, 2) . ' MB
                </span>
                <span style="margin-left: 4px;background-color: rgb(107 114 128); border-radius: 5px; padding: 2px 4px 2px 4px;" class="bg-gray-500">
                    Response: ' . round((microtime(true) - $this->start_time) * 1000, 4) * 1000 . 'ms
                </span>
            </div>
            <button onclick="this.parentElement.remove()">X</button>
        </div>
        ';
    }

    protected function isNotInjectable(Request $request, Response $response)
    {
        return ($response->headers->has('Content-Type') && strpos($response->headers->get('Content-Type'), 'html') === false)
            || $request->getRequestFormat() !== 'html'
            || $response->getContent() === false
            || $this->isJsonRequest($request);
    }

    protected function isJsonRequest(Request $request)
    {
        // If XmlHttpRequest or Live, return true
        if ($request->isXmlHttpRequest() || $request->headers->get('X-Livewire')) {
            return true;
        }

        // Check if the request wants Json
        $acceptable = $request->getAcceptableContentTypes();
        return (isset($acceptable[0]) && $acceptable[0] == 'application/json');
    }
}
