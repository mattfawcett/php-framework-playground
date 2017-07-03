<?php
namespace Framework\Http;

/**
 * An object representing an HTTP Response.
 *
 * Call serve() to output the headers/status code and echo the body
 */
class Response
{
    /**
     * The HTTP status code
     */
    public $statusCode = 200;

    /**
     * The body of the response, typically some HTML or JSON
     */
    public $body;

    /**
     * HTTP response headers. For example Set-Cookie
     */
    public $headers = [];

    /**
     * Build a response object.
     * @param string $body - The body of the response, for example html or json
     */
    public function __construct(string $body)
    {
        $this->body = $body;
    }

    /**
     * Add an HTTP header to this response. Example:
     * $response->addHeader('Location', 'http://google.com');
     *
     * @param string $headerName - The name of the HTTP header
     * @param mixed $value - The value of HTTP header
     */
    public function addHeader(string $headerName, $value)
    {
        $this->headers[$headerName] = $value;
    }

    /**
     * Set the HTTP status code
     *
     * @param int $statusCode
     * @return void
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Serve this HTTP response
     *
     * @return void
     */
    public function serve()
    {
        foreach ($this->headers as $headerName => $value) {
            header($headerName . ': ' . $value);
        }
        http_response_code($this->statusCode);

        echo $this->body;
    }
}
