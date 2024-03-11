<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bodypoint</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

    <div style="border: 1px solid rgba(23, 23, 23, 0.1); background-color: #fff;  box-shadow: 0px 0px 4px #e5e7eb; border-radius: 16px; max-width: 920px; margin: 0px auto">
        <div style="background-color: #2f2f2f; padding: 8px 24px; border-radius: 16px 16px 0px 0px;">
          <h4 style="color: #fff; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px; ">Order Information</h4>
        </div>
        <div style="padding: 24px;">
            <div style="display: flex; gap: 20px; align-items: center;">
              <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Account</span>
              <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ $user->email }}</span>
            </div>
            <div style="display: flex; gap: 20px; align-items: center; margin-top: 20px;">
              <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Purchase Order #:</span>
              <span style="background-color: #31ba32; font-size: 14px; font-weight: 500; line-height: 20px; padding: 2px 20px; border-radius: 100px; color: #fff;">Quote</span>
            </div>
        </div>
     
		
		<table style="width: 100%; border-collapse: collapse; border-spacing: 0px;">
        <tr>
            <td><div style="background-color: #2f2f2f; padding: 8px 24px">
                <h4 style="color: #fff; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px;">Ship to information:</h4>
            </div></td>
            <td style="border-color: green;"><div style="background-color: #2f2f2f; padding: 8px 24px;">
                <h4 style="color: #fff; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px;">Bill to information:</h4>
            </div></td>
        </tr>
        <tr>
            <td>
			   <div style="padding: 24px;">
				<table style="width: 100%; border-collapse: collapse; border-spacing: 0px;">
					<tr>
						<td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Name:</span></td>
						<td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ $userDetail->shipping_user_name }} {{ $userDetail->shipping_last_name }}</span></td>
					</tr>
					<tr>
						<td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Address:</span></td>
						<td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ $userDetail->shipping_address }}, <br>{{ $userDetail->shipping_city }}, {{ $userDetail->shipping_state }} {{ $userDetail->shipping_zip }} {{ $userDetail->shipping_country }}</span></td>
					</tr>
					<tr>
						<td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Country</span></td>
						<td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ $userDetail->shipping_country }}</span></td>
					</tr>
					<tr>
						 <td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Phone</span></td>
						 <td><span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">+1 {{ $userDetail->shipping_phone }}</span></td>
					</tr>
				</table>
				</div>
			</td>
            <td>
            <div style="padding: 24px;">
                <table style="width: 100%;  border-collapse: collapse; border-spacing: 0px;">
				<tr><td>
                  <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Name:</span></td>
                  <td>
                  <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ $userDetail->billing_user_name }} {{ $userDetail->billing_last_name }}</span></td>
                </tr>
                <tr>
                    <td>
                  <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Address:</span></td>
                  <td>
                  <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ $userDetail->billing_address  }} <br>{{ $userDetail->billing_city }}, {{ $userDetail->billing_state }} {{ $userDetail->billing_zip  }} {{ $userDetail->billing_country }}</span>
                  </td>
                  </tr>
                <tr>
                    <td>
                  <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Country</span></td>
                  <td>
                  <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">{{ $userDetail->billing_country }}</span></td>
                </tr>
                <tr>
                    <td>
                  <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; min-width: 55px;">Phone</span></td>
                  <td>
                  <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">+1 {{ $userDetail->billing_phone }}</span></td>
                </tr>
                
            </table>
           </div>
        </td>
          </tr>
        </table>
		
		
        <div style="background-color: #2f2f2f; padding: 8px 24px;">
          <h4 style="color: #fff; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px;">Payment Method</h4>
        </div>
        <div style="padding: 24px;">
              <span style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Invoice -30</span>
        </div>
        <div style="background-color: #2f2f2f; padding: 8px 24px;">
          <h4 style="color: #fff; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px;">Shipping options</h4>
        </div>
        <div style="padding: 24px;">
           
              <div style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400;">Special <br>instruction:</div>
           
              <div style="line-height: 17px; color: #000; font-size: 14px; font-weight: 400; margin-top: 20px;">Carrier:</div>

              <div style="line-height: 19px; color: #6b7280; font-size: 13px; font-weight: 400; margin-top: 20px;">All orders placed will ship within 5 business days. Freight cost is calculated at time of shipping. For expedited shipping options please contact customer service at sales@bodybpoint.com or 206.405.4555</div>
            
        </div>
          <div style="padding: 24px;">
            <div style="    border-radius: 20px 20px 0px 0px;
            overflow: hidden;">
          <table style="border-radius: 20px 20px 0px 0px;
          border: 1px solid rgb(104 104 104 / 28%); border-collapse: collapse;">
          <thead style="background-color: #008c99;">
                <tr style="whitespace-nowrap">
                  <th scope="col" style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: #fff; border: 1px solid rgb(104 104 104 / 28%);">
                    Product name 
                  </th>
                  <th scope="col" style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: #fff; border: 1px solid rgb(104 104 104 / 28%);">
                    Stock Code
                  </th>
				 
					  <th scope="col" style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: #fff; border: 1px solid rgb(104 104 104 / 28%);">
						MSRP
					  </th>
				   @if($priceOption=='msrp_primary')
					  <th scope="col" style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: #fff; border: 1px solid rgb(104 104 104 / 28%);">
						Primary Discount
					  </th>
					 					  
				   @elseif($priceOption=='all_price')
				     <th scope="col" style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: #fff; border: 1px solid rgb(104 104 104 / 28%);">
						Primary Discount
					  </th>
					   <th scope="col" style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: #fff; border: 1px solid rgb(104 104 104 / 28%);">
						Net price <br> after secondary discount
					  </th>
					  
				  @endif
                
                 
                 
                 
				   <th scope="col" style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: #fff; border: 1px solid rgb(104 104 104 / 28%);">
						Qty.
					  </th>
                  <th scope="col" style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: #fff; border: 1px solid rgb(104 104 104 / 28%);">
                    Unit
                  </th>
                  <th scope="col" style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: #fff; border: 1px solid rgb(104 104 104 / 28%);">
                    Total
                  </th>
                </tr>
              </thead>
              <tbody>
			  <?php $subtotal=0; $tax=0.00; ?>
					@if(isset($cart[0]))
					  @foreach ($cart[0]['CartItem'] as $cartitem)
                <tr style="">
                  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #3e3e3e; border: 1px solid rgb(104 104 104 / 28%);">
                     {{ $cartitem['Product']['name'] }}
                  </td>
                  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
                   {{ $cartitem['Product']['sku'] }}
                  </td>
                  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
                     ${{ $cartitem['Product']['msrp']?number_format($cartitem['Product']['msrp'], 2, '.', ','):0 }}
                  </td>
				   @if($priceOption=='msrp_only') 
						   <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
							{{ $cartitem['quantity'] }}
						  </td>
						  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
							EA
						  </td>
						  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
							${{ $cartitem['Product']['msrp']?number_format($cartitem['Product']['msrp']*$cartitem['quantity'], 2, '.', ','):0 }}
						  </td>
							<?php $subtotal+=$cartitem['Product']['msrp']*$cartitem['quantity']; ?>
				   @elseif($priceOption=='msrp_primary')
						   <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
						   ${{ $cartitem['price']?number_format($cartitem['price'], 2, '.', ','):0 }}
						  </td> 
						  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
							{{ $cartitem['quantity'] }}
						  </td>
						  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
							EA
						  </td>
						  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
							${{ $cartitem['price']?number_format($cartitem['price']*$cartitem['quantity'], 2, '.', ','):0 }}
						  </td>
						 <?php $subtotal+=$cartitem['price']*$cartitem['quantity']; ?>			  
				   @elseif($priceOption=='all_price')
						   <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
						   ${{ $cartitem['price']?number_format($cartitem['price'], 2, '.', ','):0 }}
						  </td> 
						   <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
							${{ $cartitem['discount_price']?number_format($cartitem['discount_price'], 2, '.', ','):0 }}
						  </td>
						 
						  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
							{{ $cartitem['quantity'] }}
						  </td>
						  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
							EA
						  </td>
						  <td style="padding: 16px; font-size: 14px; font-weight: 400; color: #000; border: 1px solid rgb(104 104 104 / 28%);">
							${{ $cartitem['discount_price']?number_format($cartitem['discount_price']*$cartitem['quantity'], 2, '.', ','):0 }}
						  </td>
						   <?php $subtotal+=$cartitem['discount_price']*$cartitem['quantity']; ?>
				  @endif
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

                <table style="width: 100%;
                border-collapse: collapse; border-spacing: 0px;">
                <tr>
                    <td>
        
                <div style="font-size: 14px; font-weight: 400; color: #000; line-height: 24px;">Sub Total: </div>
                <div style="font-size: 14px; font-weight: 400; color: #000; line-height: 24px;">Tax: </div>
                <div style="font-size: 14px; font-weight: 400; color: #000; line-height: 24px;">Shipping: </div>
                <div style="font-size: 14px; font-weight: 400; color: #000; font-weight: 700; line-height: 24px;">Total: </div>
         
        </td>
        <td align="right">
           
                <div style="font-size: 14px; font-weight: 400; color: #000; font-weight: 700; line-height: 24px;">${{ number_format($subtotal, 2, '.', ',') }}</div>
                <div style="font-size: 14px; font-weight: 400; color: #000; line-height: 24px;">${{ $tax }}</div>
                <div style="font-size: 14px; font-weight: 400; color: #000; line-height: 24px;">TBD </div>
                <div style="font-size: 14px; font-weight: 400; color: #000; font-weight: 700; line-height: 24px;"> ${{ number_format($subtotal+$tax, 2, '.', ',') }}</div>
           
        </td>
        </tr>
        </table>


    </td>
    </tr>
    </table>
        
    </table>
        </div>        
       
      </div>

</body>
</html>
