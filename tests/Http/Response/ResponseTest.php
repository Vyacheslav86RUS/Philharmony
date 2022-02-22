<?php

namespace Http\Response;

use PhilHarmony\Http\HttpCode;
use PhilHarmony\Http\Response\Response;
use PhilHarmony\Http\Stream;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseTest extends TestCase
{
    private $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response();
    }

    public function testRequest(): void
    {
        $this->assertInstanceOf(Response::class, $this->response);
        $this->assertInstanceOf(ResponseInterface::class, $this->response);
        $this->assertIsArray($this->response->getHeaders());
        $this->assertInstanceOf(Stream::class, $this->response->getBody());
        $this->assertInstanceOf(StreamInterface::class, $this->response->getBody());
        $this->assertIsInt($this->response->getStatusCode());
    }

    /**
     * @dataProvider getResponseStatusDataProvider
     *
     * @param int $code
     */
    public function testRequestStatus(int $code): void
    {
        $response = $this->response->withStatus($code);
        $this->assertEquals($code, $response->getStatusCode());
    }

    /**
     * @dataProvider getResponseStatusDataProvider
     * @param int $code
     */
    public function testReasonPhrase(int $code): void
    {
        $reasonPhrase = HttpCode::$codes;
        $response = $this->response->withStatus($code);
        $responseReasonPhrase = $response->getReasonPhrase();

        $this->assertEquals($reasonPhrase[$code], $responseReasonPhrase);
    }

    public function getResponseStatusDataProvider(): array
    {
        return [
            [
                'code' => HttpCode::OK
            ],
            [
                'code' => HttpCode::NOT_FOUND
            ],
            [
                'code' => HttpCode::INTERNAL_SERVER_ERROR
            ]
        ];
    }

    /**
     * @dataProvider getHeaderDataProvider
     * @param string $headerName
     * @param string|string[] $headerData
     * @param string|null $addHeaderData
     */
    public function testHeader(string $headerName, $headerData, ?string $addHeaderData): void
    {
        $this->withoutHeaderTest($headerName);
        $this->withHeaderTest($headerName, $headerData);
        if (!empty($addHeaderData)) {
            $this->withAddedHeaderTest($headerName, $headerData, $addHeaderData);
        }
    }

    private function withoutHeaderTest(string $header): void
    {
        $response = $this->response->withoutHeader($header);
        $headers = $response->getHeaders();
        $this->assertArrayNotHasKey($header, $headers);
    }

    private function withHeaderTest(string $header, $data): void
    {
        $response = $this->response->withHeader($header, $data);
        $headerData = $response->getHeader($header);
        $this->assertNotEmpty($response->getHeaders());
        $this->assertArrayHasKey($header, $response->getHeaders());
        $this->assertEquals($headerData, $response->getHeader($header));
    }

    private function withAddedHeaderTest(string $headerName, $headerData, $addHeaderData): void
    {
        $response = $this->response
            ->withHeader($headerName, $headerData)
            ->withAddedHeader($headerName, $addHeaderData);

        $responseHeaderData = $response->getHeader($headerName);
        var_dump($responseHeaderData);
        $this->assertArrayHasKey($headerName, $response->getHeaders());
    }

    public function getHeaderDataProvider(): array
    {
        return [
            [
                'headerName' => 'Accept',
                'headerData' => ['*/*', 'text/plain'],
                'addHeaderData' => 'application/json'
            ],
            [
                'headerName' => 'Authorization',
                'headerData' => 'Basic YWxhZGRpbjpvcGVuc2VzYW1l',
                'addHeaderData' => null
            ],
        ];
    }
}
