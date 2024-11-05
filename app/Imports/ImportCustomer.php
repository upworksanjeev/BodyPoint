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
                $user = User::where('email', $row['email'])->first();
                if (!$user) {
                    $user = User::create(
                        [
                            'name' => $row['name'] ?? null,
                            'email' => $row['email'],
                            'payment_term_description' => $row['paymenttermdescription'] ?? null,
                            'default_customer_id' => $row['customernumber_syspro_account']
                        ]
                    );
                }
                $user->getUserDetails()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'primary_phone'        => $row['primaryphone'] ?? null,
                        'alternate_phone'        => $row['alternatephone'] ?? null,
                    ]
                );
                $user->associateCustomers()->create([
                    'customer_id' => $row['customernumber_syspro_account'],
                    'name' => $row['name'] ?? null,
                    'first_name' => $row['firstname'] ?? null,
                    'last_name' => $row['lastname'] ?? null,
                    'primary_phone' => $row['primaryphone'] ?? null,
                    'alternate_phone' => $row['alternatephone'] ?? null,
                    'account_id' => $row['account_id'] ?? null,
                    'telephone' => $row['telephone'] ?? null,
                    'contact' => $row['contact'] ?? null,
                    'last_login_date' => $row['lastlogindate'] ?? null,
                    'shipping_code' => $row['shipping_code'] ?? null,
                    'company_name' => $row['company_name'] ?? null,
                    'tax_status' => $row['taxstatus'] ?? null,
                    'tax_exemption_no' => $row['taxexemptionnum'] ?? null,
                    'class_id' => $row['class_id'] ?? null,
                    'user_field' => $row['userfield1'] ?? null,
                    'salesperson' => $row['salesperson'] ?? null,
                    'invoice_discount_code' => $row['invoicediscountcode'] ?? null,
                    'branch' => $row['branch'] ?? null,
                    'state_code' => $row['statecode'] ?? null,
                    'default_email' => $row['defaultemail'] ?? null,
                    'unit' => $row['unit'] ?? null,
                    'street_address' => $row['street_address'] ?? null,
                    'city' => $row['city'] ?? null,
                    'state' => $row['state'] ?? null,
                    'country' => $row['country'] ?? null,
                    'zip_code' => $row['zip_code'] ?? null
                ]);
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
