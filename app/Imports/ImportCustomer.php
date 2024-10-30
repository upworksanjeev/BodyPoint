<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportCustomer implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Sheet1' => new Sheet1Import(),
        ];
    }
}

class Sheet1Import implements WithHeadingRow, ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!empty($row['email'])) {
                $user = User::updateOrCreate(
                    ['email' => $row['email']],
                    [
                        'name' => $row['customername'] ?? null,
                        'first_name' => $row['firstname'] ?? null,
                        'last_name' => $row['lastname'] ?? null,
                        'email' => strtolower($row['email']),
                        'telephone' => $row['telephone'] ?? null,
                        'contact' => $row['contact'] ?? null,
                        'payment_term_description' => $row['paymenttermdescription'] ?? null,
                        'default_customer_id' => $row['customer_id'] ?? null,
                        'customer_id' => $row['customernumber'],
                        'customeronhold' => $row['customeronhold'] ?? null,
                        'last_login_date' => $row['lastlogindate'] ?? null,
                        'shipping_code' => $row['shippingcode'] ?? null,
                        'created_at' => $row['createdate'] ?? now()
                    ]
                );
                $user->getUserDetails()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'primary_phone'        => $row['primaryphone'] ?? null,
                        'alternate_phone'        => $row['alternatephone'] ?? null,
                        'customer_number'      => $row['customernumber'] ?? null,
                        'tax_status'           => $row['taxstatus'] ?? null,
                        'tax_exemption_no'     => $row['taxexemptionnum'] ?? null,
                        'credit_limit'         => $row['creditlimit'] ?? null,
                        'class_id'             => $row['class_id'] ?? null,
                        'invoice_term_code'    => $row['invoiceterm_code'] ?? null,
                        'user_field'           => $row['userfield1'] ?? null,
                        'salesperson'          => $row['salesperson3'] ?? null,
                        'invoice_discount_code' => $row['invoicediscountcode'] ?? null,
                        'branch'               => $row['branch'] ?? null,
                        'line_discount_code'   => $row['linediscountcode'] ?? null,
                        'state_code'   => $row['statecode'] ?? null,
                        'default_email'   => $row['defaultemail'] ?? null,
                        'pricecode_id' => $row['pricecode_id'] ?? null,
                        'company_name' => $row['company_name'] ?? null,
                    ]
                );
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
