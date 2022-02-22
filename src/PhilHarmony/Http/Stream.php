<?php

namespace PhilHarmony\Http;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    public const INPUT = 'php://input';
    public const MEMORY = 'php://memory';
    public const TEMP = 'php://temp';

    public const STDIN = 'php://stdin';
    public const STDOUT = 'php://stdout';
    public const STDERR = 'php://stderr';

    public const OUTPUT = 'php://output';

    /**
     * @var string|resource
     */
    private $_stream;

    /**
     * Stream constructor.
     * @param string|resource $stream
     * @param string $mode
     * @throws \Exception
     */
    public function __construct($stream, string $mode = 'r')
    {
        $this->setStream($stream, $mode);
    }

    public function __toString(): string
    {
        return $this->getContents();
    }

    public function close(): void
    {
        if (isset($this->_stream)) {
            if (is_resource($this->_stream)) {
                fclose($this->_stream);
            }
            $this->detach();
        }
    }

    public function detach()
    {
        if (!isset($this->_stream)) {
            return null;
        }

        $result = $this->_stream;
        unset($this->_stream);

        return $result;
    }

    public function getSize()
    {
    }

    public function tell()
    {
    }

    public function eof()
    {
    }

    public function isSeekable()
    {
    }

    public function seek($offset, $whence = SEEK_SET)
    {
    }

    public function rewind()
    {
    }

    public function isWritable()
    {
    }

    public function write($string)
    {
    }

    public function isReadable()
    {
    }

    public function read($length)
    {
    }

    public function getContents()
    {
        return stream_get_contents($this->_stream);
    }

    public function getMetadata($key = null)
    {
        $meta = stream_get_meta_data($this->_stream);

        return $meta[$key] ?? null;
    }

    private function setStream($stream, string $mode): void
    {
        if (is_string($stream)) {
            $this->_stream = fopen($stream, $mode);
            return;
        }

        if (is_resource($stream)) {
            $this->_stream = $stream;
            return;
        }

        throw new \Exception(sprintf('Stream must be a string or resource'));
    }
}
