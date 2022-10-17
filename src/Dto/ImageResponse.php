<?php

namespace Mobizel\Bundle\MarkdownDocsBundle\Dto;

use Symfony\Component\HttpFoundation\Response;

class ImageResponse extends Response
{
    public function __construct(?string $content = '', int $status = 200, array $headers = [])
    {
        $headers = array_merge($headers,
            [
                "Content-Type"=>"image/jpeg"
            ]
        );
        parent::__construct($content, $status, $headers);
    }
}