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

    public function placeQuoteWithOrder($url,$cartitems,$order_id)
    {
        $customer_id = auth()->user()->customer_id;
        $items[] = [];
        foreach($cartitems as $key=>$item){
            $items[$key]['StockCode'] = $item->sku;
            $items[$key]['Qty'] = $item->quantity;
            $items[$key]['Price'] = $item->price;
        }
        $request = [
            'Order' => [
                'CustomerAccountNumber' => $customer_id,
                'CustomerPoNumber' => $order_id,
                'StraightOrder' => 'Y',
                'ShipAddressCode' => 'sample string 4',
                'ShipAddress1' => 'sample string 5',
                'ShipAddress2' => 'sample string 6',
                'ShipAddress3' => 'sample string 7',
                'ShipAddress4' => 'sample string 8',
                'ShipAddress5' => 'sample string 9',
                'ShipPostalCode' => 'string 10',
            ],
            'Lines' => $items
        ];
        $response = $this->post($url, $request);
        return $this->returnResponse($response);
    }

    public function placeQuoteWithOutOrder($url,$cartitems,$cart_id)
    {
        $customer_id = auth()->user()->customer_id;
        $items[] = [];
        foreach($cartitems as $key=>$item){
            $items[$key]['StockCode'] = $item->sku;
            $items[$key]['Qty'] = $item->quantity;
            $items[$key]['Price'] = $item->price;
        }
        $request = [
            'Order' => [
                'CustomerAccountNumber' => $customer_id,
                'CustomerPoNumber' => rand(0,9999999999),
                'StraightOrder' => 'N',
                'ShipAddressCode' => 'sample string 4',
                'ShipAddress1' => 'sample string 5',
                'ShipAddress2' => 'sample string 6',
                'ShipAddress3' => 'sample string 7',
                'ShipAddress4' => 'sample string 8',
                'ShipAddress5' => 'sample string 9',
                'ShipPostalCode' => 'string 10',
            ],
            'Lines' => $items
        ];
        $response = $this->post($url, $request);
        return $this->returnResponse($response);
    }

    public function placeOrder($url,$order_number)
    {
        $request = [
            "OrderNumber" => $order_number
        ];
        $response = $this->post($url, $request);
        return $this->returnResponse($response);
    }

    public function getOrderDetails($url){
        $response = $this->get($url);
        return $this->returnResponse($response);
    }

    public function getCustomerDetails($url){
        $response = $this->get($url);
        return $this->returnResponse($response);
    }
}
