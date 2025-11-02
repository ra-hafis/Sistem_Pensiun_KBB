<?php

namespace App\Controllers;

class Api extends BaseController
{
    public function api()
    {
        echo "1";
        // $curl = curl_init();
        $api = "https://simpeg-api.rcode.my.id";
        $url = "auth";

        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $url, [

            'headers' => [
                //'Authorization' => 'Bearer ' . $auth
            ],
            //'proxy' => $this->proxy(),
        ]);

        //var_dump ($response);
        if ($response->getStatusCode() == 200) {
            $res = json_decode($response->getBody()->getContents());
            var_dump($res);
            exit();
            //return $res->data;

        }

    }
}
