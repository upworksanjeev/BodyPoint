<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SysproService
{
    protected $apiUrl;
    protected $token;
    protected $session_id;
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

    public function placeQuoteWithOrder($url, $cartitems, $order_id = null, $straight_order = 'Y')
    {
        $user = Auth::user()->load(['getUserDetails']);
        if (!$order_id) {
            $order_id = rand(0, 9999999);
        }
        $order_data = [
            'CustomerAccountNumber' => auth()->user()->customer_id,
            'CustomerPoNumber' => $order_id,
            'StraightOrder' => $straight_order,
            'ShipAddressCode' => $user->getUserDetails->shipping_address_code ?? 'default_code',
            'ShipAddress1' => $user->getUserDetails->shipping_address ?? 'default_address1',
            'ShipAddress2' => $user->getUserDetails->shipping_city ?? '',
            'ShipAddress3' => $user->getUserDetails->shipping_state ?? '',
            'ShipAddress4' => $user->getUserDetails->ship_address4 ?? '',
            'ShipAddress5' => $user->getUserDetails->ship_address5 ?? '',
            'ShipPostalCode' => $user->getUserDetails->shipping_zip ?? 'default_postal',
        ];
        $items = [];
        foreach ($cartitems as $key => $item) {
            $items[$key] = [
                'StockCode' => $item->sku,
                'Qty' => $item->quantity,
                'Price' => $item->price,
            ];
        }
        $request = [
            'Order' => $order_data,
            'Lines' => $items,
        ];
        $response = $this->post($url, $request);
        return $this->returnResponse($response);
    }

    public function placeOrder($url, $order_number)
    {
        $request = [
            "OrderNumber" => $order_number
        ];
        $response = $this->post($url, $request);
        return $this->returnResponse($response);
    }

    public function getOrderDetails($url)
    {
        $response = $this->get($url);
        return $this->returnResponse($response);
    }

    public function getCustomerDetails($url)
    {
        $response = $this->get($url);
        return $this->returnResponse($response);
    }
}
