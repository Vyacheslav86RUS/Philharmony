<?php

namespace PhilHarmony\Http\Response;

use Exception;
use PhilHarmony\Http\HttpCode;
use PhilHarmony\Http\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface
{
    private $_protocolVersion = '1.1';
    private $_headers;
    private $_stream;
    private $_statusCode;

    private $_reasonPhrase;

    /**
     * Response constructor.
     * @param string|resource|StreamInterface $body
     * @param int $status
     * @param array $headers
     * @throws Exception
     */
    public function __construct($body = Stream::MEMORY, int $status = HttpCode::OK, array $headers = [])
    {
        $this->setStream($body);
        $this->_statusCode = $status;
        $this->_headers = $headers;
        $this->_reasonPhrase = HttpCode::$codes;
    }

    public function getProtocolVersion(): string
    {
        return $this->_protocolVersion;
    }

    public function withProtocolVersion($version): Response
    {
        $this->validateProtocolVersion($version);
        $new = clone $this;
        $new->_protocolVersion = $version;

        return $new;
    }

    public function getHeaders(): array
    {
        return $this->_headers;
    }

    public function hasHeader($name): bool
    {
        return isset($this->_headers[$name]);
    }

    public function getHeader($name)
    {
        if (!$this->hasHeader($name)) {
            throw new Exception(sprintf('Header "%s" not found', $name));
        }

        return $this->_headers[$name];
    }

    public function getHeaderLine($name): string
    {
        if (!$this->hasHeader($name)) {
            return '';
        }

        $value = $this->_headers[$name];

        if (is_array($value)) {
            return implode(',', $value);
        }

        return $value;
    }

    public function withHeader($name, $value): Response
    {
        $new = clone $this;

        if (!$new->hasHeader($name)) {
            $new->_headers[$name] = $value;
        }

        return $new;
    }

    public function withAddedHeader($name, $value): Response
    {
        $new = clone $this;

        if ($new->hasHeader($name)) {
            $values = $new->_headers[$name];
            $new->_headers[$name] = array_merge(
                is_array($values) ? $values : [$values],
                is_array($value) ? $value : [$value]
            );
        }

        return $new;
    }

    public function withoutHeader($name): Response
    {
        if (!$this->hasHeader($name)) {
            return clone $this;
        }

        $new = clone $this;

        if ($new->hasHeader($name)) {
            unset($new->_headers[$name]);
        }

        return $new;
    }

    public function getBody(): StreamInterface
    {
        return $this->_stream;
    }

    public function withBody(StreamInterface $body): Response
    {
        $new = clone $this;
        $new->_stream = $body;

        return $new;
    }

    public function getStatusCode(): int
    {
        return $this->_statusCode;
    }

    public function withStatus($code, $reasonPhrase = ''): Response
    {
        $new = clone $this;
        $new->_statusCode = (int) $code;

        if ($reasonPhrase && is_string($reasonPhrase) && isset($new->_reasonPhrase[$code])) {
            $new->_reasonPhrase[$code] = $reasonPhrase;
        }

        return $new;
    }

    public function getReasonPhrase(): string
    {
        return $this->_reasonPhrase[$this->_statusCode] ?? '';
    }

    private function validateProtocolVersion($version) : void
    {
        if (empty($version)) {
            throw new Exception(
                'HTTP protocol version can not be empty'
            );
        }
        if (!is_string($version)) {
            throw new Exception(sprintf(
                'Unsupported HTTP protocol version; must be a string, received %s',
                (is_object($version) ? get_class($version) : gettype($version))
            ));
        }

        if (!preg_match('#^(\d{1}|\d\.\d{1,1})$#', $version)) {
            throw new Exception(sprintf(
                'Unsupported HTTP protocol version "%s" provided',
                $version
            ));
        }
    }

    private function setStream($stream, string $mode = 'r+'): void
    {
        $this->_stream = new Stream($stream, $mode);
    }
}
