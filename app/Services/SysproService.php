<?php

namespace App\Services;

use App\Models\OrderItem;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SysproService
{
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

    public static function placeQuoteWithOrder($url, $cartitems, $order_id = null, $straight_order = 'Y', $isDuplicate = 'N',$creditCardData = null)
    {
        self::initialize();
        if (!$order_id) {
            $order_id = rand(0, 9999999);
        }
        $address =  session()->get('customer_address');
        $customer_id = getCustomerId();
        $order_data = [
            'CustomerAccountNumber' => $customer_id,
            'CustomerPoNumber' => $order_id,
            'StraightOrder' => $straight_order,
            'AllowDuplicatePO' => $isDuplicate,
            'ShipAddressCode' => $address['PostalCode'] ?? 'default_code',
            'ShipAddress1' =>  $address['AddressLine1'] ?? 'default_address1',
            'ShipAddress2' => $address['AddressLine2'] ?? '',
            'ShipAddress3' => $address['AddressLine3']  ?? '',
            'ShipAddress4' => $address['AddressLine4']  ?? '',
            'ShipAddress5' => $address['AddressLine5']  ?? '',
            'ShipPostalCode' => $address['PostalCode'] ?? 'default_postal',
        ];

        // Add credit card information to order data if provided
        if ($creditCardData && is_array($creditCardData)) {
            // Log incoming credit card data structure for debugging
            Log::info('[Syspro] Incoming credit card data structure:', [
                'creditCardData_keys' => array_keys($creditCardData),
                'creditCardData' => $creditCardData,
            ]);
            
            // Handle both field name variations: CreditCardLastFourDigit and CreditCardLast4Digit
            $lastFourDigit = null;
            if (isset($creditCardData['CreditCardLastFourDigit'])) {
                $lastFourDigit = $creditCardData['CreditCardLastFourDigit'];
            } elseif (isset($creditCardData['CreditCardLast4Digit'])) {
                $lastFourDigit = $creditCardData['CreditCardLast4Digit'];
            } elseif (isset($creditCardData['LastFourDigit'])) {
                $lastFourDigit = $creditCardData['LastFourDigit'];
            } elseif (isset($creditCardData['Last4Digit'])) {
                $lastFourDigit = $creditCardData['Last4Digit'];
            }
            
            if ($lastFourDigit) {
                $order_data['CreditCardLast4Digit'] = $lastFourDigit;
            }
            
            if (isset($creditCardData['ExpiredDate'])) {
                $order_data['CreditCardExpiryDate'] = $creditCardData['ExpiredDate'];
            }
            if (isset($creditCardData['CardType'])) {
                $order_data['CreditCardType'] = $creditCardData['CardType'];
            }
            if (isset($creditCardData['CardHolderName'])) {
                $order_data['CreditCardHolderName'] = $creditCardData['CardHolderName'];
            }
            
            // Log credit card addition
            Log::info('[Syspro] Credit card data added to order:', [
                'has_card_data' => true,
                'last_four_digit' => $lastFourDigit,
                'card_fields_added' => array_keys(array_filter([
                    'CreditCardLast4Digit' => $order_data['CreditCardLast4Digit'] ?? null,
                    'CreditCardExpiryDate' => $order_data['CreditCardExpiryDate'] ?? null,
                    'CreditCardType' => $order_data['CreditCardType'] ?? null,
                    'CreditCardHolderName' => $order_data['CreditCardHolderName'] ?? null,
                ])),
                'endpoint' => $url,
            ]);
        } else {
            Log::info('[Syspro] No credit card data provided for order', [
                'creditCardData_type' => gettype($creditCardData),
                'creditCardData_is_array' => is_array($creditCardData),
                'creditCardData_value' => $creditCardData,
            ]);
        }

        $items = [];
        foreach ($cartitems as $key => $item) {
            $items[$key] = [
                'StockCode' => $item->sku,
                'Qty' => $item->quantity,
                'Price' => ($item->discount > 0) ? $item->discount_price : $item->price,
                "MakeForLine" => $item->marked_for ?? '',
            ];
        }

        $request = [
            'Order' => $order_data,
            'Lines' => $items,
        ];
        // Log the complete request payload before sending
        Log::info('[Syspro] API Request Payload:', [
            'endpoint' => $url,
            'request_data' => $request,
            'has_credit_card' => !empty($creditCardData),
        ]);
        $response = self::post($url, $request);
        return self::returnResponse($response);
    }

    public static function updateQuote($order_no, $url, $cartitems, $order_id = null, $straight_order = 'Y', $isDuplicate = 'N',$creditCardData = null)
    {
        self::initialize();
        if (!$order_id) {
            $order_id = rand(0, 9999999);
        }
        $address =  session()->get('customer_address');
        $customer_id = getCustomerId();
        $maxLine = OrderItem::where('order_id', $order_no)->max('line_number') ?? 0;

        $items = [];
        foreach ($cartitems as $key => $item) {
            // If the item doesn't have a SalesOrderLine, increment the max and assign it
            if (empty($item->line_number)) {
                $maxLine++;
                $item->line_number = $maxLine;
            }
        }
        $order_data = [
            'OrderNumber' => $order_no,
            "AllowDuplicatePO" => "Y",
            'ShipAddressCode' => $address['PostalCode'] ?? 'default_code',
            'ShipAddress1' =>  $address['AddressLine1'] ?? 'default_address1',
            'ShipAddress2' => $address['AddressLine2'] ?? '',
            'ShipAddress3' => $address['AddressLine3']  ?? '',
            'ShipAddress4' => $address['AddressLine4']  ?? '',
            'ShipAddress5' => $address['AddressLine5']  ?? '',
            'ShipPostalCode' => $address['PostalCode'] ?? 'default_postal',
        ];

        // Add credit card information if provided
        if ($creditCardData && is_array($creditCardData)) {
            // Handle both field name variations: CreditCardLastFourDigit and CreditCardLast4Digit
            $lastFourDigit = null;
            if (isset($creditCardData['CreditCardLastFourDigit'])) {
                $lastFourDigit = $creditCardData['CreditCardLastFourDigit'];
            } elseif (isset($creditCardData['CreditCardLast4Digit'])) {
                $lastFourDigit = $creditCardData['CreditCardLast4Digit'];
            } elseif (isset($creditCardData['LastFourDigit'])) {
                $lastFourDigit = $creditCardData['LastFourDigit'];
            } elseif (isset($creditCardData['Last4Digit'])) {
                $lastFourDigit = $creditCardData['Last4Digit'];
            }
            
            if ($lastFourDigit) {
                $order_data['CreditCardLast4Digit'] = $lastFourDigit;
            }
            
            if (isset($creditCardData['ExpiredDate'])) {
                $order_data['CreditCardExpiryDate'] = $creditCardData['ExpiredDate'];
            }
            if (isset($creditCardData['CardType'])) {
                $order_data['CreditCardType'] = $creditCardData['CardType'];
            }
            if (isset($creditCardData['CardHolderName'])) {
                $order_data['CreditCardHolderName'] = $creditCardData['CardHolderName'];
            }
            
            // Log credit card addition
            Log::info('[Syspro] Credit card data added to quote update:', [
                'has_card_data' => true,
                'last_four_digit' => $lastFourDigit,
                'card_fields_added' => array_keys(array_filter([
                    'CreditCardLast4Digit' => $order_data['CreditCardLast4Digit'] ?? null,
                    'CreditCardExpiryDate' => $order_data['CreditCardExpiryDate'] ?? null,
                    'CreditCardType' => $order_data['CreditCardType'] ?? null,
                    'CreditCardHolderName' => $order_data['CreditCardHolderName'] ?? null,
                ])),
                'endpoint' => $url,
            ]);
        }

        $items = [];
        foreach ($cartitems as $key => $item) {
            $items[$key] = [
                "LineNumber" => $item->line_number,
                "Action" => $item->action ?? 'N',
                'StockCode' => $item->sku,
                'Qty' => $item->quantity,
                'Price' => ($item->discount > 0) ? $item->discount_price : $item->price,
                "MakeForLine" => $item->marked_for
            ];
        }

        $request = [
            'Order' => $order_data,
            'Lines' => $items,
        ];
        $response = self::post($url, $request);
        return self::returnResponse($response);
    }

    public static function placeOrder($url, $order_number, $CustomerPoNumber, $AllowDuplicatePO = 'N')
    {
        $request = [
            "OrderNumber" => $order_number,
            "NewCustomerPoNumber" => $CustomerPoNumber,
            "AllowDuplicatePO" => $AllowDuplicatePO
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

    public static function orderHistory($url, $toDate, $fromDate, $customer = null)
    {
        $request = [
            "DateFrom" => $fromDate,
            "DateTo" => $toDate,
            "Customer" => $customer
        ];

        $response = self::postCron($url, $request);
        return self::returnResponseCron($response);
    }

    public static function postCron($end_point, $request)
    {
        self::initialize();
        $syspro_url = self::$apiUrl . '/' . $end_point;
        $headers = [
            'Authorization' => 'Basic ' . self::$token,
            'Cookie'        => 'ASP.NET_SessionId=' . self::$session_id,
        ];

        try {
            $response = Http::withHeaders($headers)->timeout(300)->retry(3, 5000)->post($syspro_url, $request);
        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }

        return $response;
    }

    public static function returnResponseCron($response)
    {
        if (!is_object($response) || !method_exists($response, 'status')) {
            // Invalid or error response
            return [
                'code'     => 500,
                'response' => [
                    'error'   => true,
                    'message' => is_string($response) ? $response : 'Unexpected response format.'
                ]
            ];
        }

        $statusCode   = $response->status() ?? null;
        $responseBody = $response->json() ?? [];

        return [
            'code'     => $statusCode,
            'response' => $responseBody
        ];
    }
}
