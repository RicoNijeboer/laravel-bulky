<?php

namespace Rico\Bulky;

use Closure;
use Illuminate\Http\Request;

class BulkMiddleware
{

    /** @var BulkKernel */
    private $kernel;

    public function __construct(BulkKernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function handle(Request $request, Closure $next)
    {
        $responses = [];

        foreach ($request->all() as $slug => $_)
        {
            $responses[] = $this->kernel->handle($this->makeRequestForSlug($slug, $request));
        }

        return new BulkResponse($responses);
    }

    private function makeRequestForSlug(string $slug, Request $request): Request
    {
        $serverData = $request->server->all();

        $serverData['REQUEST_URI'] = $slug;
        $serverData['PATH_INFO'] = $slug;

        return new Request(
            $request->query->all(),
            $request->request->get($slug) ?? [],
            $request->attributes->get($slug) ?? [],
            $request->cookies->all(),
            $request->files->get($slug) ?? [],
            $serverData,
            json_encode($request->request->get($slug) ?? [])
        );
    }
}