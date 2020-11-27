<?php

namespace Rico\Bulky;

use Illuminate\Http\Request;

class BulkController
{

    public function handle(BulkKernel $kernel, Request $request)
    {
        $responses = [];

        foreach ($request->all() as $slug => $_)
        {
            $responses[] = $kernel->handle($this->makeRequestForSlug($slug, $request));
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