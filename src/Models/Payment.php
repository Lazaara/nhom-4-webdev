<?php
class Payment
{
    private $transactionId;
    private $method;
    private $status;

    public function __construct($transactionId = "", $method = "", $status = "")
    {
        $this->transactionId = $transactionId;
        $this->method = $method;
        $this->status = $status;
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function toArray()
    {
        return [
            'transactionId' => $this->transactionId,
            'method' => $this->method,
            'status' => $this->status
        ];
    }
}
?>