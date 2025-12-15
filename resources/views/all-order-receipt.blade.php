<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bodypoint</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @font-face {
            font-family: "Avenir LT", Sans-serif !important;
            src: url("/resources/fonts/AvenirLTStd-Roman.woff2") format("woff2"),
                url("/resources/fonts/AvenirLTStd-Roman.woff") format("woff");
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Avenir LT", Sans-serif !important;
            src: url("/resources/fonts/Avenir-Black.woff2") format("woff2"),
                url("/resources/fonts/Avenir-Black.woff") format("woff");
            font-weight: 800;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Avenir LT", Sans-serif !important;
            src: url("/resources/fonts/AvenirLTStd-Black.woff2") format("woff2"),
                url("/resources/fonts/AvenirLTStd-Black.woff") format("woff");
            font-weight: 900;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Avenir LT", Sans-serif !important;
            src: url("/resources/fonts/AvenirLTStd-Book.woff2") format("woff2"),
                url("/resources/fonts/AvenirLTStd-Book.woff") format("woff");
            font-weight: 300;
            font-style: normal;
            font-display: swap;
        }

        body {
            font-family: "Avenir LT", Sans-serif !important;
            font-weight: normal;
        }

        .productDetail>tbody>tr:last-child {
            border-bottom: unset !important;
        }
    </style>
</head>

<body>
    @if (isset($orders[0]))
    @foreach ($orders as $order)
    <div style="margin-bottom:50px;">
        <div
            style="border: 1px solid rgba(23, 23, 23, 0.1); background-color: #fff;  box-shadow: 0px 0px 4px #e5e7eb; border-radius: 16px; max-width: 920px; margin: 0px auto">
            <div style="background-color: #00838f; padding: 8px 24px; border-radius: 16px 16px 0px 0px;">
                <h4
                    style="color: #fff; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px;font-family: 'Avenir LT', Sans-serif; ">
                    Order Information</h4>
            </div>
            <div style="padding: 24px;">
                <div style="display: flex; gap: 20px; align-items: center;">
                    <span
                        style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Account</span>
                    <span
                        style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ $user->email }}</span>
                </div>
                <div style="display: flex; gap: 20px; align-items: center; margin-top: 20px;">
                    <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Order No
                        #:</span>
                    <span
                        style="background-color: #31ba32; font-size: 14px; font-weight: 500; line-height: 20px; padding: 2px 20px; border-radius: 100px; color: #fff;">{{ $order['purchase_order_no'] }}</span>
                </div>
                <div style="display: flex; gap: 20px; align-items: center; margin-top: 20px;">
                    <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Customer PO
                        No:</span>
                    <span
                        style="background-color: #31ba32; font-size: 14px; font-weight: 500; line-height: 20px; padding: 2px 20px; border-radius: 100px; color: #fff;">{{ $order['customer_po_number'] ?? '' }}</span>
                </div>
                <div style="display: flex; gap: 20px; align-items: center; margin-top: 20px;">
                    <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Order
                        Date:</span>
                    <span
                        style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ date('F j, Y', strtotime($order['created_at'])) }}</span>
                </div>
                <div style="display: flex; gap: 20px; align-items: center; margin-top: 20px;">
                    <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">BP
                        Number:</span>
                    <span
                        style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">12345</span>
                </div>
            </div>


            <table style="width: 100%; border-collapse: collapse; border-spacing: 0px;">
                <tr>
                    <td>
                        <div style="background-color: #00838f; padding: 8px 24px">
                            <h4
                                style="color: #fff; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px;">
                                Ship to information</h4>
                        </div>
                    </td>
                    <td style="border-color: green;">
                        <div style="background-color: #00838f; padding: 8px 24px;">
                            <h4
                                style="color: #fff; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px;">
                                Bill to information</h4>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="padding: 24px;">
                            <table style="width: 100%; border-collapse: collapse; border-spacing: 0px;">
                                <tr>

                                    <td><span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Name:</span>
                                    </td>
                                    <td><span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ session()->get('customer_details') ? session()->get('customer_details')['CustomerName'] : "" }}</span></td>
                                </tr>
                                <tr>
                                    <td><span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Address:</span>
                                    </td>
                                    <td style="padding-top:10px"><span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">
                                            {{ !empty(session('customer_address')['AddressLine2']) ? session('customer_address')['AddressLine2'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine2'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine2'] . ',': '') }}
                                            {{ !empty(session('customer_address')['AddressLine1']) ? session('customer_address')['AddressLine1'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine1'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine1'] . ',': '') }}
                                            <br>
                                            {{ !empty(session('customer_address')['AddressLine3']) ? session('customer_address')['AddressLine3'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine3'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine3'] . ',': '') }}
                                            {{ !empty(session('customer_address')['AddressLine4']) ? session('customer_address')['AddressLine4'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine4'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine4'] . ',' :'')  }}
                                            {{ session('customer_address')['PostalCode'] ?? session('customer_details')['ShipToAddresses'][0]['PostalCode'] }},
                                            {{ session('customer_address')['AddressLine5'] ?? session('customer_details')['ShipToAddresses'][0]['AddressLine5'] }}
                                        </span></td>
                                </tr>
                                <tr>
                                    <td><span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Country:</span>
                                    </td>
                                    <td><span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ $userDetail->country ?? session('customer_address')['AddressLine5'] }}</span>
                                    </td>
                                </tr>
                                @php
                                $phone = $userDetail->primary_phone ?? $user->getUserDetails->primary_phone;
                                @endphp

                                @if(!empty($phone))
                                <tr>
                                    <td>
                                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">
                                            Phone:
                                        </span>
                                    </td>
                                    <td>
                                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">
                                            +1 {{ $phone }}
                                        </span>
                                    </td>
                                </tr>
                                @endif

                            </table>
                        </div>
                    </td>
                    <td>
                        <div style="padding: 24px;">
                            <table style="width: 100%;  border-collapse: collapse; border-spacing: 0px;">
                                <tr>
                                    <td style="vertical-align: top; padding: 3px 5px;">
                                        <span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Name:</span>
                                    </td>

                                    <td>
                                        <span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ session()->get('customer_details') ? session()->get('customer_details')['CustomerName'] : "" }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Address:</span>
                                    </td>

                                    <td style="padding-top:10px">
                                        <span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">
                                            {{ !empty(session('customer_details')['billAddressLine2']) ? session('customer_details')['billAddressLine2'] . ',' : '' }}
                                            <br>
                                            {{ !empty(session('customer_details')['billAddressLine4']) ? session('customer_details')['billAddressLine4'] . ',' : '' }}
                                            {{ !empty(session('customer_details')['billAddressLine1']) ? session('customer_details')['billAddressLine1'] . ',' : '' }}
                                            @if (session('customer_details')['billAddressLine5'] || !empty(session('customer_details')['billAddressLine5']))
                                            {{ !empty(session('customer_details')['billAddressPostalCode']) ? session('customer_details')['billAddressPostalCode'] . ',' : '' }}
                                            @else
                                            {{ !empty(session('customer_details')['billAddressPostalCode']) ? session('customer_details')['billAddressPostalCode'] : '' }}
                                            @endif
                                            {{ session('customer_details')['billAddressLine5'] ?? '' }}
                                        </span>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top; padding: 3px 5px;">
                                        <span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Country:</span>
                                    </td>

                                    <td>
                                        <span
                                            style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ $userDetail->country ?? session('customer_address')['AddressLine5'] }}</span>

                                    </td>
                                </tr>
                                @php
                                $phone = $userDetail->primary_phone ?? $user->getUserDetails->primary_phone;
                                @endphp

                                @if(!empty($phone))
                                <tr>
                                    <td>
                                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">
                                            Phone:
                                        </span>
                                    </td>
                                    <td>
                                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">
                                            +1 {{ $phone }}
                                        </span>
                                    </td>
                                </tr>
                                @endif


                            </table>
                        </div>
                    </td>
                </tr>
            </table>



            <div style="background-color: #00838f; padding: 8px 24px;">
                <h4 style="color: #fff; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px;">
                    Payment Method</h4>
            </div>
            <div style="padding: 24px;">
                <span
                    style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ session('customer_details')['PaymentTermDescription'] ?? 'Invoice-30' }}</span>
            </div>
            <div style="background-color: #00838f; padding: 8px 24px;">
                <h4 style="color: #fff; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px;">
                    Shipping</h4>
            </div>
            <div style="padding: 24px;">

                <div style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Special
                    Instructions:</div>

                <div
                    style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; margin-top: 20px;">
                    Carrier:</div>

                <div
                    style="line-height: 19px; color: #6b7280; font-size: 13px; font-weight: 400; margin-top: 20px;">
                    All orders ship within 5 business days after your order is processed. Freight charges are calculated when your order ships. For expedited shipping options, please contact Customer Support at Sales@bodypoint.com or 206.405.4555.</div>

            </div>
            <div style="padding: 24px;">
                <div
                    style="border-radius: 16px 16px 0px 0px;border: 1px solid rgb(104 104 104 / 28%);overflow: hidden;">
                    <table style="border-collapse: collapse;width: 100%;" class="productDetail">
                        <thead style="background-color: #00838f;">
                            <tr style="white-space:nowrap;border-bottom: 1px solid rgb(104 104 104 / 28%);">
                                <th scope="col"
                                    style="text-align: left;padding: 12px 12px; font-size: 14px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    Product name
                                </th>
                                <th scope="col"
                                    style="text-align: left;padding: 12px 12px; font-size: 14px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    Stock Code
                                </th>
                                <th scope="col"
                                    style="text-align: left;padding: 12px 12px; font-size: 14px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    Net Price
                                </th>
                                <th scope="col"
                                    style="text-align: left;padding: 12px 12px; font-size: 14px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    Qty.
                                </th>
                                <th scope="col"
                                    style="text-align: left;padding: 12px 12px; font-size: 14px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    Unit
                                </th>
                                <th scope="col"
                                    style="text-align: left;padding: 12px 12px; font-size: 14px; font-weight: 700; color: #fff;">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $subtotal = 0;
                            $tax = 0.0; ?>
                            @if (isset($order))
                            @foreach ($order['OrderItem'] as $cartitem)
                            <tr style="border-bottom: 1px solid rgb(104 104 104 / 28%);">

                                <td
                                    style="padding: 12px; font-size: 14px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    {{ $cartitem['Product']['name'] ?? '' }}
                                </td>
                                <td
                                    style="padding: 12px; font-size: 14px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    {{ $cartitem['sku'] ?? '' }}
                                </td>

                                <td
                                    style="padding: 12px; font-size: 14px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    ${{ $cartitem['discount_price'] ? number_format($cartitem['discount_price'], 2, '.', ',') : 0 }}
                                </td>

                                <td
                                    style="padding: 12px; font-size: 14px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    {{ $cartitem['quantity'] ?? '' }}
                                </td>
                                <td
                                    style="padding: 12px; font-size: 14px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    EA
                                </td>
                                @php

                                $discount_price = $cartitem['discount_price'] ? number_format($cartitem['discount_price'], 2, '.', ',') : 0;
                                @endphp
                                <td
                                    style="padding: 12px; font-size: 14px; font-weight: 400; color: #000;">
                                    ${{ $discount_price ? number_format($discount_price * $cartitem->quantity, 2, '.', ',') : 0 }}
                                </td>
                                @php
                                $subtotal += $discount_price * $cartitem->quantity;
                                @endphp

                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="padding: 24px;">
                <table style="width: 100%;
            border-collapse: collapse; border-spacing: 0px;">
                    <tr>
                        <td style="vertical-align: top;">
                            <span style="font-size: 14px; font-weight: 400; color: #000;">Mark For:</span>
                        </td>
                        <td width="200">

                            <table
                                style="width: 100%;
                border-collapse: collapse; border-spacing: 0px;">
                                <tr>
                                    <td>


                                        <div
                                            style="font-size: 14px; font-weight: 400; color: #000; line-height: 24px;">
                                            Sub Total: </div>
                                        <div
                                            style="font-size: 14px; font-weight: 400; color: #000; line-height: 24px;">
                                            Tax: </div>
                                        <div
                                            style="font-size: 14px; font-weight: 400; color: #000; line-height: 24px;">
                                            Shipping: </div>
                                        <div
                                            style="font-size: 14px; font-weight: 400; color: #000; font-weight: 700; line-height: 24px;">
                                            Total: </div>


                                    </td>
                                    <td align="right">


                                        <div
                                            style="font-size: 14px; font-weight: 400; color: #000; font-weight: 700; line-height: 24px;">
                                            ${{ number_format($subtotal, 2, '.', ',') }}</div>
                                        <div
                                            style="font-size: 14px; font-weight: 400; color: #000; line-height: 24px;">
                                            ${{ $tax }}</div>
                                        <div
                                            style="font-size: 14px; font-weight: 400; color: #000; line-height: 24px;">
                                            TBD </div>
                                        <div
                                            style="font-size: 14px; font-weight: 400; color: #000; font-weight: 700; line-height: 24px;">
                                            ${{ number_format($subtotal + $tax, 2, '.', ',') }}</div>


                                    </td>
                                </tr>
                            </table>


                        </td>
                    </tr>
                </table>

                </table>

            </div>

        </div>
    </div>
    @endforeach
    @endif
</body>

</html>