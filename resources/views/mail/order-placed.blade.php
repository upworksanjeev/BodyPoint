<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Place Mail</title>
</head>

<body style="background:#f6f6f6;">
    <div style="max-width: 600px; width: 100%; margin: 0px auto ; padding-top: 35px;">
        <img style="text-align: center; margin: 0 auto 35px; width:200px; display:block;" src="{{ asset('img/bp-logo-lg-new.png') }}">
        <section style="background-color: #F6F6F6; padding-top: 2.25rem; padding-bottom: 2.25rem;">
            <div style="max-width: 1280px; margin-left: auto; margin-right: auto;">
                <div style="max-width: 1280px; margin-left: auto; margin-right: auto;">
                    <div>
                        <h2 style="font-weight: bold; color: #00707B; margin-bottom: 1.25rem; text-align: center;">Thank You For Your Purchase!</h2>
                        {{-- <h5 style="font-weight: bold; color: #00707B; margin-bottom: 1.25rem; text-align: center;">Estimated Ship Date: {{ date('F j, Y',strtotime($order['created_at'])) }} </h5> --}}
                        <div>
                            <div style="background-color: white; border: 1px solid #E5E7EB; border-radius: 1rem; box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1), 0px 4px 6px -4px rgba(0, 0, 0, 0.1); position: relative; overflow: hidden;">
                                <table style="padding: 10px; width: 100%; background-color: #00838f;">
                                    <tr>
                                        <th>
                                            <h4 style="color: #fff; text-align: left; font-weight: 400; font-size: 13px; margin: 0px;">Order Date: {{ date('F j, Y',strtotime($order['created_at'])) }}</h4>
                                        </th>
                                        <th>
                                            <h4 style="color: #fff; text-align: center; font-weight: 400; font-size: 13px; margin: 0px;">Order Details</h4>
                                        </th>
                                        <th>
                                            <h4 style="color: #fff; text-align: right; font-weight: 400; font-size: 13px; margin: 0px;">Order No: {{ $order['purchase_order_no'] }}</h4>
                                        </th>
                                        <th>
                                            <h4 style="color: #fff; text-align: right; font-weight: 400; font-size: 13px; margin: 0px;">Customer PO No: {{ $order['customer_po_number'] ?? '' }}</h4>
                                        </th>
                                    </tr>
                                </table>
                                <div>
                                    <div style="position: relative; overflow-x: auto;">
                                        <table style="width: 100%; font-size: 0.875rem; text-align: left; color: #6B7280;">
                                            <tbody>
                                                <?php $subtotal = 0; ?>
                                                @if(isset($order))
                                                @foreach ($order['OrderItem'] as $cartitem)
                                                <tr style="background-color: #fff;">
                                                    <td style="font-size: 12px; color: #000; padding: 10px; border-bottom: 1px solid #E5E7EB;">
                                                        <div style="display: flex; align-items: center; gap: 10px;">
                                                            <div style="margin-right: 10px;">
                                                                <img src="<?php if (isset($cartitem['Product']['Media'][0]['id'])) {
                                                                                echo url('storage/' . $cartitem['Product']['Media'][0]['id'] . '/' . $cartitem['Product']['Media'][0]['file_name']);
                                                                            } else {
                                                                                echo '/img/standard-img.png';
                                                                            } ?>" alt="product-img" style="width: 60px; height: 60px; object-fit: cover;" />
                                                            </div>
                                                            <div style="flex: 1;">
                                                                <p style="font-size: 12px; margin: 0px 0px 5px 0px;"><a style="color: #000;" href="{{ route('product',$cartitem['Product']['slug']??$cartitem['Product']['name']) }}" target="_blank">{{ $cartitem['Product']['name'] }}</a></p>
                                                                <span style="background-color: #E4E4E4; color: #000000; font-size: 10px; padding-left: 10px; padding-right: 11px;padding-top: 4px;padding-bottom: 4px;border-radius: 20px;display: inline-block;line-height: 1.5em;">Qty:{{ $cartitem['quantity'] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="font-size: 12px; color: #000; padding: 10px; text-align: right; border-bottom: 1px solid #E5E7EB;">
                                                        ${{ $cartitem['discount_price']?number_format($cartitem['discount_price']*$cartitem['quantity'], 3, '.', ','):0 }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <?php $subtotal += $cartitem['discount_price'] * $cartitem['quantity']; ?>
                                                @endforeach
                                                @endif
                                                <tr style="background-color: #fff;">
                                                    <td style="font-size: 12px; color: #000; padding: 10px 10px 20px 10px;" colspan="2">
                                                        <div style="text-align: right;">
                                                            <h3 style="font-size: 24px; font-weight: normal; color: #000; margin: 0px;"><span style="font-weight: bold;">Subtotal:</span> ${{ number_format($subtotal, 3, '.', ',') }}</h3>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>