<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class SysproAudit
{
    /**
     * Minimal-call audit logger for Syspro interactions.
     *
     * Expected keys:
     * - event_type, trace_id, endpoint, request_payload, parsed_response
     * Optional keys:
     * - order_id, syspro_order_no, customer_number, meta
     */
    public static function logSyspro(array $data): void
    {
        $eventType = (string) ($data['event_type'] ?? 'unknown');
        $traceId = (string) ($data['trace_id'] ?? '');
        $endpoint = $data['endpoint'] ?? null;
        $requestPayload = is_array($data['request_payload'] ?? null) ? $data['request_payload'] : [];
        $parsedResponse = is_array($data['parsed_response'] ?? null) ? $data['parsed_response'] : [];
        $resolvedOrderId = self::resolveLocalOrderId($data, $requestPayload, $parsedResponse);

        try {
            AuditLog::create([
                'trace_id' => $traceId,
                'source' => 'syspro',
                'event_type' => $eventType,
                'order_id' => $resolvedOrderId,
                'syspro_order_no' => $data['syspro_order_no'] ?? null,
                'customer_number' => $data['customer_number'] ?? null,
                'http_status' => $parsedResponse['code'] ?? null,
                'success' => empty($parsedResponse['response']['Error']),
                'error_message' => $parsedResponse['response']['Message'] ?? null,
                'request_payload' => [
                    'endpoint' => $endpoint,
                    'payload' => $requestPayload,
                ],
                'response_payload' => $parsedResponse,
                'meta' => $data['meta'] ?? null,
            ]);
        } catch (\Throwable $e) {
            Log::warning('[AuditLog] Failed to write syspro audit log', [
                'error' => $e->getMessage(),
                'event_type' => $eventType,
                'trace_id' => $traceId,
            ]);
        }
    }

    private static function resolveLocalOrderId(array $data, array $requestPayload, array $parsedResponse): ?int
    {
        try {
            // If caller already knows the local id, trust it.
            if (!empty($data['order_id']) && is_numeric($data['order_id'])) {
                return (int) $data['order_id'];
            }

            // Prefer Syspro order number mapping (purchase_order_no).
            $sysproOrderNo =
                $data['syspro_order_no']
                ?? ($parsedResponse['response']['OrderNumber'] ?? null)
                ?? ($requestPayload['Order']['OrderNumber'] ?? null)
                ?? ($requestPayload['OrderNumber'] ?? null);

            if (!empty($sysproOrderNo)) {
                $id = Order::where('purchase_order_no', (string) $sysproOrderNo)->value('id');
                if (!empty($id)) {
                    return (int) $id;
                }
            }

            // Fallback: map from customer PO number (orders.customer_po_number).
            $customerPo =
                $data['customer_po_number']
                ?? ($data['meta']['customer_po_number'] ?? null)
                ?? ($requestPayload['Order']['CustomerPoNumber'] ?? null)
                ?? ($requestPayload['NewCustomerPoNumber'] ?? null);

            if (!empty($customerPo)) {
                if (is_numeric($customerPo)) {
                    $id = Order::where('id', (int) $customerPo)->value('id');
                    if (!empty($id)) {
                        return (int) $id;
                    }
                }
                $id = Order::where('customer_po_number', (string) $customerPo)->value('id');
                if (!empty($id)) {
                    return (int) $id;
                }
            }
        } catch (\Throwable $e) {
            // never block the request because of audit resolution
        }

        return null;
    }
}

