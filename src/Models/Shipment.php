<?php
class Shipment
{
    private $trackingNumber;
    private $method;

    public function __construct($trackingNumber = "", $method = "")
    {
        $this->trackingNumber = $trackingNumber;
        $this->method = $method;
    }

    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber($trackingNumber)
    {
        $this->trackingNumber = $trackingNumber;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function toArray()
    {
        return [
            'trackingNumber' => $this->trackingNumber,
            'method' => $this->method
        ];
    }
}
?>