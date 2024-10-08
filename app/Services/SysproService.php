<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SysproService
{
    // Static properties
    protected static $apiUrl;
    protected static $token;
    protected static $session_id;

    // Static method to initialize configuration settings
    protected static function initialize()
    {
        self::$apiUrl = config('services.syspro.api_url');
        self::$token = config('services.syspro.token');
        self::$session_id = config('services.syspro.session_id');
    }

    public static function returnResponse($response)
    {
        $statusCode   = $response->status() ?? null;
        $responseBody = $response->json() ?? [];
        $data  = [
            'code'     => $statusCode,
            'response' => $responseBody
        ];

        return $data;
    }

    public static function get($end_point, array $params = [])
    {
        self::initialize(); // Ensure that we have initialized the config
        $syspro_url = self::$apiUrl . '/' . $end_point;
        $headers   = [
            'Authorization' => 'Basic ' . self::$token,
            'Cookie' => 'ASP.NET_SessionId=' . self::$session_id,
        ];

        try {
            $response = Http::withHeaders($headers)->get($syspro_url, $params);
        } catch (Exception $e) {
            $response  =  $e->getMessage();
        }

        return $response;
    }

    public static function post($end_point, $request)
    {
        self::initialize(); // Ensure that we have initialized the config
        $syspro_url = self::$apiUrl . '/' . $end_point;
        $headers   = [
            'Authorization' => 'Basic ' . self::$token,
            'Cookie' => 'ASP.NET_SessionId=' . self::$session_id,
        ];

        try {
            $response = Http::withHeaders($headers)->post($syspro_url, $request);
        } catch (Exception $e) {
            $response  =  $e->getMessage();
        }

        return $response;
    }

    public static function placeQuoteWithOrder($url, $cartitems, $order_id = null, $straight_order = 'Y')
    {
        self::initialize();
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

        $response = self::post($url, $request);
        return self::returnResponse($response);
    }

    public static function placeOrder($url, $order_number)
    {
        $request = [
            "OrderNumber" => $order_number
        ];

        $response = self::post($url, $request);
        return self::returnResponse($response);
    }

    public static function getOrderDetails($url): array
    {
        $response = self::get(end_point: $url);
        return self::returnResponse($response);
    }

    public static function getCustomerDetails($url)
    {
        $sessionKey = 'customer_details';
        $customerDetails = session($sessionKey);
        try {
            $response = self::get($url);
            $get_response = self::returnResponse($response);
            if (!empty($get_response['response']['Customer'])) {
                $customerDetails = $get_response['response']['Customer'];
                session([$sessionKey => $customerDetails]);
            } else {
                $customerDetails = [];
                session([$sessionKey => $customerDetails]);
            }
        } catch (Exception $e) {
            Log::error('Error retrieving customer details: ' . $e->getMessage());
            $customerDetails = [];
        }
        return $customerDetails;
    }

    public static function listStock($url)
    {
        $sessionKey = 'stock_details';
        $stockDetails = session($sessionKey);
        try {
            $response = self::get($url);
            $get_response = self::returnResponse($response);
            if (!empty($get_response['response']['StockList'])) {
                $stockDetails = $get_response['response']['StockList'];
                session([$sessionKey => $stockDetails]);
            } else {
                $stockDetails = [];
                session([$sessionKey => $stockDetails]);
            }
        } catch (Exception $e) {
            Log::error('Error retrieving stock details: ' . $e->getMessage());
            $stockDetails = [];
        }
        return $stockDetails;
    }
}
