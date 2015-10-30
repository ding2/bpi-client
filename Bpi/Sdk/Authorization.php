<?php
namespace Bpi\Sdk;

/**
 * TODO please add a general description about the purpose of this class.
 */
class Authorization
{
    protected $agency_id;
    protected $public_key;
    protected $secret_key;
    protected $salt;
    protected $token;

    /**
     *
     * @param string $agency_id
     * @param string $public_key
     * @param string $secret_key
     * @param string $salt
     */
    public function __construct($agency_id, $public_key, $secret_key, $salt = '')
    {
        $this->agency_id = $agency_id;
        $this->public_key = $public_key;
        $this->secret_key = $secret_key;
        $this->salt = $salt;
        $this->generateToken();
    }

    /**
     * Generate authorization token
     */
    protected function generateToken()
    {
        $this->token = crypt($this->agency_id . $this->public_key . $this->secret_key, $this->salt);
    }

    /**
     * Represent as HTTP Authorization string.
     * Will return value part, e.g. Authorization: <value>
     *
     * @return string
     */
    public function toHTTPHeader()
    {
        return sprintf('BPI agency="%s", token="%s"', $this->agency_id, $this->token);
    }
}
