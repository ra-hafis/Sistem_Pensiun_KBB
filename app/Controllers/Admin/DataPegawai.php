<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DataPegawai extends BaseController
{
    protected $apiBaseUrl;
    protected $apiToken;

    public function __construct()
    {
        // Ambil URL dan Token dari file .env
        $this->apiBaseUrl = getenv('SIMPEG_API_URL');
        $this->apiToken = getenv('SIMPEG_API_TOKEN');
    }

    /**
     * Cek koneksi dasar ke API (uji route + fungsi)
     */
    public function index()
    {
        echo "Controller terhubung!<br>";

        // Coba panggil fungsi API sederhana
        $result = $this->getDataFromApi('pegawai/list');

        if ($result) {
            /*echo "✅ API terhubung dan berhasil mengambil data.<br><br>";
            echo "<pre>";
            print_r($result->pegawai);
            echo "</pre>";*/
            foreach ($result->pegawai as $b) {
                $tmtcpns = $b->tmtCpns;

                echo $tmtcpns . "<br>";
            }
            //var_dump($result->data);
        } else {
            echo "❌ Gagal menghubungkan ke API. Periksa token atau URL di file .env";
        }
    }

    /**
     * Fungsi umum untuk GET data dari API menggunakan token
     */
    protected function getDataFromApi($endpoint, $query = null)
    {
        $client = new Client();
        $url = $this->apiBaseUrl;
        try {
            $url = rtrim($this->apiBaseUrl, '/') . '/' . ltrim($endpoint, '/');

            $options = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiToken,//tambah form params
                    'Accept' => 'application/json',
                ],
                'verify' => false,
            ];

            if (!empty($query)) {
                $options['query'] = $query;
            }

            $response = $client->request('GET', $url, $options); //gantu POST

            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody()->getContents());
                return $body->data ?? $body;

            }

            return null;

        } catch (RequestException $e) {
            log_message('error', 'API RequestException: ' . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            log_message('error', 'API Exception: ' . $e->getMessage());
            return null;
        }
    }
}
