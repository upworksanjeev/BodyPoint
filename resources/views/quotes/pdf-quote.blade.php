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
    <div style="border: 1px solid rgba(23, 23, 23, 0.1); background-color: #fff;  box-shadow: 0px 0px 4px #e5e7eb; border-radius: 16px; max-width: 920px; margin: 0px auto 16px">
        <table style="width: 100%; border-collapse: collapse; border-spacing: 0px;">
            <tbody>
                <tr>
                    <td>
                        <div style="padding: 15px;">
                            <table style="width: 100%; border-collapse:collapse; border-spacing: 0px;">
                                <tbody>
                                    <tr style="width: 50%:">
                                        <td style="vertical-align: unset;">
                                            <img style="width: 194px;margin-bottom:8px;" src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('public/img/bp-logo-lg-new.png'))); ?>"><br>
                                            <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;text-align: left;">
                                                558 1st Avenue South Suite
                                            </span>
                                            <br />
                                            <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;text-align: left;">
                                                300 Seattle, WA 98104 USA
                                            </span>
                                            <br />
                                            <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;text-align: left;">
                                                (800) 547-5716 (Office)
                                            </span>
                                            <br />
                                            <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;text-align: left;">
                                                (206) 405-4556 (fax)
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td style="vertical-align: bottom;">
                        <div style="padding: 15px;">
                            <table style="width: 100%;  border-collapse: collapse; border-spacing: 0px;">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: bottom;">
                                            <span style="line-height: 22px; color: #000; font-size: 21px; font-weight: 400; min-width: 55px;">
                                                <b>Quote</b><br>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="background-color: #00838f; padding: 8px 16px;">
            <h4 style="color: #fff; font-size: 14px; font-weight: 400; line-height: 24px; margin: 0px;font-family: 'Avenir LT', Sans-serif; ">Quote Details:</h4>
        </div>
        <table style="width: 100%;border-collapse: collapse; border-spacing: 0px;padding: 15px;">
            <tr>
                <td style="vertical-align: top;width:50%;">
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Quote No.:</span>
                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{$cart->purchase_order_no ?? ''}}</span>
                    </div>
                    <div style="display: flex; gap: 20px; align-items: center; margin-top: 5px;">
                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Your Purchase Order No.:</span>
                        <span style="background-color: #31ba32; font-size: 14px; font-weight: 500; line-height: 20px; padding: 2px 20px; border-radius: 100px; color: #fff;">QUOTE</span>
                    </div>
                </td>
                <td style="vertical-align: top;width:50%;padding: 0 15px;">
                    <div style="display: flex; align-items: center; justify-content: end;">
                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Quote Date:</span>
                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; ">{{ date('m/d/Y') }}</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-top: 5px; justify-content: end;">
                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Invoice Terms:</span>
                        <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ session('customer_details')['PaymentTermDescription'] ?? 'Invoice-30' }}</span>
                    </div>
                </td>
            </tr>
        </table>
        <table style="width: 100%; border-collapse: collapse; border-spacing: 0px;">
            <tr>
                <td style="width: 50%;">
                    <div style="background-color: #00838f; padding: 8px 15px">
                        <h4 style="color: #fff; font-size: 14px; font-weight: 400; line-height: 24px; margin: 0px;">Ship To:</h4>
                    </div>
                </td>
                <td style="border-color: green;width: 50%;">
                    <div style="background-color: #00838f; padding: 8px 15px;">
                        <h4 style="color: #fff; font-size: 14px; font-weight: 400; line-height: 24px; margin: 0px;">Bill To:</h4>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%;padding: 15px;">
                    <table style="width: 100%; border-collapse: collapse; border-spacing: 0px; ver">
                        <tr>
                            <td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;vertical-align: top;">Name:</span></td>
                            <td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;vertical-align: top;">{{ $userDetail->first_name ?? auth()->user()->name }} {{ $userDetail->last_name ??'' }}</span></td>
                        </tr>
                        <tr>
                            <td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;vertical-align: top;">Address:</span></td>
                            <td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ session('customer_address')['AddressLine1'] ?? session('customer_details')['ShipToAddresses'][0]['AddressLine1'] }} <br>{{ session('customer_address')['AddressLine2'] ?? session('customer_details')['ShipToAddresses'][0]['AddressLine2'] }} {{ session('customer_address')['AddressLine3'] ?? session('customer_details')['ShipToAddresses'][0]['AddressLine3'] }} <br> {{ session('customer_address')['State'] ?? session('customer_details')['ShipToAddresses'][0]['State'] }} {{ session('customer_address')['PostalCode'] ?? session('customer_details')['ShipToAddresses'][0]['PostalCode'] }} {{ session('customer_address')['Country'] ?? session('customer_details')['ShipToAddresses'][0]['Country'] }}</span></td>
                        </tr>
                        <tr>
                            <td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;vertical-align: top;">Country:</span></td>
                            <td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;vertical-align: top;">{{ $userDetail->country??'' }}</span></td>
                        </tr>
                        <tr>
                            <td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;vertical-align: top;">Phone:</span></td>
                            <td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;vertical-align: top;">+1 {{ $userDetail->primary_phone ?? $user->getUserDetails->primary_phone }}</span></td>

                        </tr>
                    </table>
                </td>
                <td style="width: 50%;padding: 15px;">
                    <table style="width: 100%;  border-collapse: collapse; border-spacing: 0px;vertical-align: top;">
                        <tr>
                            <td>
                                <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;vertical-align: top;">Name:</span>
                            </td>
                            <td>
                                <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;vertical-align: top;">{{ $userDetail->first_name ?? auth()->user()->name }} {{ $userDetail->last_name??'' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;vertical-align: top;">Address:</span>
                            </td>
                            <td>
                                <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;vertical-align: top;">{{ session('customer_details')['billAddressLine2']??''  }} <br>{{ session('customer_details')['billAddressLine4'] ??'' }} {{ session('customer_details')['billAddressLine1'] ??'' }} {{ session('customer_details')['billAddressPostalCode'] ??''  }} {{ session('customer_details')['billAddressLine5'] ??'' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;vertical-align: top;">Country:</span>
                            </td>
                            <td>
                                <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;vertical-align: top;">{{ $userDetail->country??'' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;vertical-align: top;">Phone:</span>
                            </td>
                            <td>
                                <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;vertical-align: top;">+1 {{ $userDetail->primary_phone ?? $user->getUserDetails->primary_phone }}</span>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
        <div style="background-color: #00838f; padding: 8px 16px;">
            <h4 style="color: #fff; font-size: 14px; font-weight: 400; line-height: 24px; margin: 0px;">Items:</h4>
        </div>
        <div style="padding: 15px;">
            <div style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; margin-top: 5px;">Carrier:</div>
            <div style="line-height: 19px; color: #6b7280; font-size: 13px; font-weight: 400; margin-top: 10px;">Orders typically ship within 5 business days. Freight cost is calculated at time of shipping. For expedited shipping options please contact customer service at sales@bodypoint.com or
                <span>(206) 405-4555.</span></div>
        </div>
    </div>

    <div style="padding: 0px;padding-top: 0px;padding-bottom: 0px;">
        <div style="border-radius: 16px 16px 0px 0px;border: 1px solid rgb(104 104 104 / 28%);overflow: hidden;">
            <table style="border-collapse: collapse;width: 100%;" class="productDetail">
                <thead style="background-color: #00838f;">
                    <tr style="white-space:nowrap;border-bottom: 1px solid rgb(104 104 104 / 28%);">
                        <th scope="col" style="text-align: left;padding: 12px 15px; font-size: 10px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);width:10px;">
                            Product Name
                        </th>
                        <th scope="col" style="text-align: left;padding: 12px 12px; font-size: 10px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);width:10px;">
                            Stock Code
                        </th>
                        <th scope="col" style="text-align: left;padding: 12px 12px; font-size: 10px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);width:10px;">
                            Mark For
                        </th>
                        <th scope="col" style="text-align: left;padding: 12px 12px; font-size: 10px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);width:10px;">
                            MSRP
                        </th>
                        @if($priceOption == 'msrp_primary')
                            <th scope="col" style="text-align: left;padding: 12px 15px; font-size: 10px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);width:10px;">
                                Primary Discount
                            </th>
                        @elseif($priceOption == 'all_price')
                            <th scope="col" style="text-align: left;padding: 12px 15px; font-size: 10px; font-weight: 700; color: #fff; border: 1px solid rgb(104 104 104 / 28%);width:10px;">
                                Primary Discount
                            </th>
                            <th scope="col" style="text-align: left;padding: 12px 12px; font-size: 10px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);width:10px;">
                                After Secondary Discount
                            </th>
                        @endif
                            <th scope="col" style="text-align: left;padding: 12px 12px; font-size: 10px; font-weight: 700; color: #fff; border-right: 1px solid rgb(104 104 104 / 28%);width:10px;">
                                Qty.
                            </th>
                            <th scope="col" style="text-align: left;padding: 12px 12px; font-size: 10px; font-weight: 700; color: #fff;width:10px;">
                                Total
                            </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $subtotal = 0;
                    $tax = 0.00;
                    @endphp
                    @if(!empty($cart))
                    @foreach ($cart['orderItem'] as $cartitem)
                        <tr style="border-bottom: 1px solid rgb(104 104 104 / 28%);">
                            <td style="padding: 12px 15px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                {{ $cartitem->Product->name ?? '' }}
                            </td>
                            <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                {{ $cartitem->sku ?? '' }}
                            </td>
                            <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                {{ $cartitem->marked_for ?? '' }}
                            </td>
                            <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                ${{ $cartitem->msrp ? number_format($cartitem->msrp, 2, '.', ',') : 0 }}
                            </td>

                            @if($priceOption=='msrp_only')
                                <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    {{ $cartitem->quantity ?? '' }}
                                </td>

                                <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    ${{ $cartitem->msrp ? number_format($cartitem->msrp * $cartitem->quantity, 2, '.', ',') : 0 }}
                                </td>
                                @php
                                    $subtotal += $cartitem->msrp * $cartitem->quantity;
                                @endphp
                            @elseif($priceOption=='msrp_primary')
                                <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    ${{ $cartitem->price ? number_format($cartitem->price, 2, '.', ',') : 0 }}
                                </td>
                                <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    {{ $cartitem->quantity ?? '' }}
                                </td>
                                <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    ${{ $cartitem->price ? number_format($cartitem->price * $cartitem->quantity, 2, '.', ','):0 }}
                                </td>
                                @php
                                    $subtotal += $cartitem->price * $cartitem->quantity;
                                @endphp
                            @elseif($priceOption=='all_price')
                                <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    ${{ $cartitem->price ? number_format($cartitem->price, 2, '.', ',') : 0 }}
                                </td>
                                <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    ${{ $cartitem->discount_price ? number_format($cartitem->discount_price, 2, '.', ',') : 0 }}
                                </td>
                                <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border-right: 1px solid rgb(104 104 104 / 28%);">
                                    {{ $cartitem->quantity ?? '' }}
                                </td>

                                <td style="padding: 12px; font-size: 10px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
                                    ${{ $cartitem->discount_price ? number_format($cartitem->discount_price  *$cartitem->quantity, 2, '.', ',') : 0 }}
                                </td>
                                @php
                                    $subtotal += $cartitem->discount_price * $cartitem->quantity;
                                @endphp
                            @endif
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div style="padding: 0px;">
        <table style="width: 100%;border-collapse: collapse; border-spacing: 0px;">
            <tr>
                <td style="vertical-align: top;"></td>
                <td width="200">
                    <table style="width: 100%;border-collapse: collapse; border-spacing: 0px;">
                        <tr>
                            <td>
                                <div style="font-size: 14px; font-weight: 400; color: #000; font-weight: 700; line-height: 24px;">Total Before Freight: </div>
                            </td>
                            <td align="right">
                                <div style="font-size: 14px; font-weight: 400; color: #000; font-weight: 700; line-height: 24px;"> ${{ number_format($subtotal+$tax, 2, '.', ',') }}</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="font-size: 11px;font-weight: 400;color: #000;line-height: 1;text-align: center;border: 1px solid #ccc;padding: 6px 15px;border-radius: 10px;  margin-top: 25px;margin-bottom: 8px;">QUOTES EXPIRE AFTER 90 DAYS</div>
        @if($priceOption=='msrp_only')
            <div style="font-size: 11px;font-weight: 400;color: #000;line-height: 1.35; border: 1px solid #ccc; margin-top: 5px; padding: 6px 15px; border-radius: 10px; margin-bottom: 8px;">Past due invoices will incur finance charges at the rate of 1.5% per month. Bodypoint reserves the right to hold shipments or require prepayment for any delinquent account.</div>
            <div style="font-size: 11px;font-weight: 400;color: #000;line-height: 1.35; border: 1px solid #ccc; padding: 6px 15px; border-radius: 10px; margin-bottom: 8px; margin-top: 5px;">Freight and Tax Policy: Prices quoted do not include freight. Any taxes which may apply are the responsibility of the purchasing organization.</div>
            <div style="font-size: 11px;font-weight: 400;color: #000;line-height: 1.35;border: 1px solid #ccc;padding: 6px 15px;border-radius: 10px;margin-bottom: 8px;">Bodypoint, Inc. has prepared this MSRP Quote at the request of the customer identified above ("Customer"). The MSRP listed in this Quote is not the actual purchase price charged to or paid by Customer. The actual purchase price and applicable discounts are identified in other sales documentation
                (e.g., the invoice) issued by Bodypoint, Inc. to Customer. Customer acknowledges and agrees that, upon the request of a third-party payor, including,
                but not limited to any federal or state health care program, Customer must disclose such other sales documentation which reflects the actual purchase price
                and all discounts between Customer and Bodypoint, Inc.
            </div>
        @elseif($priceOption=='all_price')
            <div style="font-size: 11px;font-weight: 400;color: #000;line-height: 1.35; border: 1px solid #ccc; padding: 6px 15px; border-radius: 10px; margin-bottom: 8px; margin-top: 5px;">Freight and Tax Policy: Prices quoted do not include freight. Any taxes which may apply are the responsibility of the purchasing organization.</div>
            <div style="font-size: 11px;font-weight: 400;color: #000;line-height: 1.35;border: 1px solid #ccc;padding: 6px 15px;border-radius: 10px;margin-bottom: 8px;">The amount shown as TOTAL BEFORE FREIGHT is net of the Primary and any Secondary Discounts shown above . Other discounts may apply. All
                discounts known on the date of sale will be reflected on a customer invoice prepared in compliance with the "safe harbor" regulations for discounts found
                at 42 CFR 1001.952(h). Bodypoint, Inc. has prepared this quote at the request of the customer identified above ("Customer"). Customer understands and
                accepts that it is solely responsible for ensuring that this quote complies with the requirements of any state or federal health care program or private payer to which Customer submits claims for reimbursement.
            </div>
        @elseif($priceOption=='msrp_primary')
            <div style="font-size: 11px;font-weight: 400;color: #000;line-height: 1.35; border: 1px solid #ccc; padding: 6px 15px; border-radius: 10px; margin-bottom:8px; margin-top: 5px;">Freight and Tax Policy: Prices quoted do not include freight. Any taxes which may apply are the responsibility of the purchasing organization.</div>
            <div style="font-size: 11px;font-weight: 400;color: #000;line-height: 1.35;border: 1px solid #ccc;padding: 6px 15px;border-radius: 10px;margin-bottom: 8px;">The amount shown as TOTAL BEFORE FREIGHT is net of only the Primary Discount shown above . Other discounts may apply. All discounts known on the
                date of sale will be reflected on a customer invoice prepared in compliance with the "safe harbor" regulations for discounts found at 42 CFR 1001.952(h).
                Bodypoint, Inc. has prepared this quote at the request of the customer identified above ("Customer"). Customer understands and accepts that it is solely
                responsible for ensuring that this quote complies with the requirements of any state or federal health care program or private payer to which Customer
                submits claims for reimbursement.
            </div>
        @endif
    </div>

</body>
</html>
