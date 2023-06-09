<?php

/** @noinspection PhpComposerExtensionStubsInspection */

declare(strict_types=1);

namespace WPRestClient\Core;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Throwable;

class ApiResponseException extends Exception
{
    protected string $type = 'unknown type';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return ApiResponseException
     */
    public function setType(string $type): ApiResponseException
    {
        $this->type = $type;
        return $this;
    }

    public static function fromClientException(ClientException $clientException): ApiResponseException
    {
        $contents = $clientException->getResponse()->getBody()->getContents();
        var_dump($contents);
        $responseBody = json_decode($contents);
        $exception = new self($responseBody->message, $responseBody->data->status, $clientException);
        $exception->setType($responseBody->code);
        return $exception;
    }
}
