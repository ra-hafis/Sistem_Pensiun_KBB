<?php
namespace App\Libraries\Eks;

use Config\Services;

class Client
{
    protected $client;
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = rtrim(getenv('SIMPEG_URL') ?: 'https://simpeg-api2.rcode.my.id', '/') . '/';
        $this->token = preg_replace('/^Bearer\s+/i', '', trim(
            getenv('SIMPEG_TOKEN') ?: getenv('EKS_API_TOKEN') ?: ''
        ));

        $this->client = Services::curlrequest([
            'baseURI' => $this->baseUrl,
            'headers' => [
                'Authorization' => $this->token ? 'Bearer ' . $this->token : '',
                'Accept' => 'application/json',
            ],
            'http_errors' => false,
            'timeout' => 30,
        ]);
    }

    public function getPegawai($id = 'A8ACA73DB3EC3912E040640A040269BB')
    {
        $resp = $this->client->get('pegawai/list?id=' . urlencode($id));
        $code = $resp->getStatusCode();
        $body = (string) $resp->getBody();

        if ($code !== 200) {
            return ['ok' => false, 'status' => $code, 'body' => $body];
        }
        return ['ok' => true, 'data' => json_decode($body, true)];
    }
}
