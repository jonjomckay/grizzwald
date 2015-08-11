<?php
namespace Xenolope\Grizzwald\Iterator;

class ResultIterator implements \Iterator
{

    private $data;

    private $key;

    private $sendRequest;

    private $requestCount;

    private $nextToken;

    public function __construct($key, \Closure $sendRequest)
    {
        $this->key = $key;
        $this->sendRequest = $sendRequest;
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->data[$this->requestCount];
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->requestCount++;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->requestCount;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        $isFirstRequest = (!$this->nextToken && $this->requestCount === -1);
        $isLastResult = ($this->requestCount === count($this->data) -1 && $this->nextToken);

        // If this is the first request or if we've reached the last result in the dataset
        if ($isFirstRequest || $isLastResult) {
            $this->fetchData();

            return true;
        }

        // If we're still looping through the dataset
        if ($this->requestCount < count($this->data)) {
            return true;
        }

        return false;
    }

    private function fetchData()
    {
        // In PHP 7, this can change to $this->sendRequest->call()
        $function = $this->sendRequest;

        // Get the data from the API
        $data = $function($this->nextToken);

        if (array_key_exists('nextPageToken', $data)) {
            $this->nextToken = $data['nextPageToken'];
        } else {
            $this->nextToken = null;
        }

        $this->data = $data[$this->key];
        $this->requestCount = 0;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->requestCount = -1;
        $this->nextToken = null;
        $this->data = null;
    }
}
