<?php

namespace Rico\Bulky;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\ResponseTrait;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class BulkResponse extends Response
{

    /**
     * BulkResponse constructor.
     *
     * @param Response[] $responses
     */
    public function __construct(array $responses)
    {
        $content = $this->createContent($responses);
        $headers = $this->calculateHeaders($responses);
        $status = $this->calculateResponseStatus($responses);

        parent::__construct(json_encode($content), $status, $headers);
    }

    /**
     * @param Response[] $responses
     *
     * @return int
     */
    private function calculateResponseStatus(array $responses): int
    {
        $status = $responses[0]->getStatusCode();

        $statusSame = collect($responses)->every(function (BaseResponse $response) use ($status) {
            return $response->getStatusCode() === $status;
        });

        if ($statusSame)
        {
            return $status;
        }

        return Response::HTTP_MULTI_STATUS;
    }

    /**
     * @param ResponseTrait[] $responses
     *
     * @return mixed[]
     */
    private function createContent(array $responses): array
    {
        $contents = [];

        foreach ($responses as $response)
        {
            $contents[] = $response->getOriginalContent();
        }

        return $contents;
    }

    private function calculateHeaders(array $responses)
    {
        $headers = [];

        do
        {
            /** @var Response|JsonResponse|ResponseTrait $response */
            $response = array_pop($responses);

            $headers = array_merge_recursive($headers, $response->headers->all());
        } while (count($responses) > 0);

        return $headers;
    }
}