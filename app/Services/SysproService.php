<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class SysproService
{
    private $apiUrl;
    private $token;
    private $session_id;
    public function __construct()
    {
        $this->apiUrl = config('services.syspro.api_url');
        $this->token = config('services.syspro.token');
        $this->session_id = config('services.syspro.session_id');
    }

    public function returnResponse($response)
    {
        $statusCode   = $response->status() ?? null;
        $responseBody = $response->json() ?? [];
        $data  = [
            'code'     => $statusCode,
            'response' => $responseBody
        ];

        return $data;
    }

    public function get($end_point, array $params = [])
    {
        $syspro_url = $this->apiUrl . '/' . $end_point;
        $headers   = [
            'Authorization' => 'Basic ' . $this->getToken(),
            'Cookie' => 'ASP.NET_SessionId=' . $this->getSessionId(),
        ];
        try {
            $response = Http::withHeaders($headers)->get($syspro_url, $params);
        } catch (Exception $e) {
            $response  =  $e->getMessage();
        }

        return $response;
    }

    public function post($end_point, $request)
    {
        $syspro_url = $this->apiUrl . '/' . $end_point;
        $headers   = [
            'Authorization' => 'Basic ' . $this->getToken(),
            'Cookie' => 'ASP.NET_SessionId=' . $this->getSessionId(),
        ];

        try {
            $response = Http::withHeaders($headers)->post($syspro_url, $request);
        } catch (Exception $e) {
            $response  =  $e->getMessage();
        }

        return $response;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getSessionId()
    {
        return $this->session_id;
    }

    public function ListStock($url)
    {
        $response = $this->get($url);
        return $this->returnResponse($response);
    }

    public function placeQuote($url)
    {
        $request = [
            'Order' => [
                'CustomerAccountNumber' => '100008',
                'CustomerPoNumber' => 'Z800004',
                'StraightOrder' => 'Y',
                'ShipAddressCode' => 'sample string 4',
                'ShipAddress1' => 'sample string 5',
                'ShipAddress2' => 'sample string 6',
                'ShipAddress3' => 'sample string 7',
                'ShipAddress4' => 'sample string 8',
                'ShipAddress5' => 'sample string 9',
                'ShipPostalCode' => 'string 10',
            ],
            'Lines' => [
                [
                    'StockCode' => 'HW320-30-50',
                    'Qty' => 1,
                    'Price' => 3.0,
                ],
            ],
        ];
        $response = $this->post($url, $request);
        return $this->returnResponse($response);
    }
}
