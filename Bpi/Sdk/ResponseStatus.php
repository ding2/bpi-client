<?php
namespace Bpi\Sdk;
/**
 * Class ResponseStatus check status of response got from WS.
 *
 * @package Bpi\Sdk
 */
class ResponseStatus
{
    /**
     * @var string status of response.
     */
    protected $status;

    /**
     * @param integer $status_code
     */
    public function __construct($status_code)
    {
        $this->status = (string) $status_code;

        if ($this->status <= 0)
            throw new \InvalidArgumentException('Incorrect HTTP status code [' . $status_code . ']');
    }

    public function __toString()
    {
        return (string) $this->status;
    }

    /**
     * Return status code of finished request.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->status;
    }

    /**
     * Check if request was successful.
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->status[0] == 2;
    }

    /**
     * Check if error code is client error.
     *
     * @return bool
     */
    public function isClientError()
    {
        return $this->status[0] == 4;
    }

    /**
     * Check if error code is server error.
     *
     * @return bool
     */
    public function isServerError()
    {
        return $this->status[0] == 5;
    }

    /**
     * Check if error response.
     *
     * @return bool
     */
    public function isError()
    {
        return $this->isClientError() || $this->isServerError();
    }
}
