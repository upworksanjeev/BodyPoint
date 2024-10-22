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
            'CUS_Account' => new Sheet1Import(),
            'CUS_Customer' => new Sheet2Import(),
        ];
    }
}

class Sheet1Import implements WithHeadingRow, ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!empty($row['email']) && !empty($row['customer_id']) && $row['customer_id'] != -1) {
                User::updateOrCreate(
                    ['email' => $row['email']],
                    [
                        'name'                      => trim($row['firstname'] . ' ' . $row['lastname']),
                        'email'                     => strtolower($row['email']),
                        'payment_term_description'  => $row['paymenttermdescription'] ?? null,
                        'default_customer_id'       => $row['customer_id'],
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

class Sheet2Import implements WithHeadingRow, ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $users = User::where('default_customer_id', $row['customer_id'])->get();
            if (!empty($row['customer_id']) && $row['customer_id'] != -1) {
                foreach ($users as $user) {
                    $user->update([
                        'customer_id' => $row['customernumber'],
                        'created_at' => $row['createdate'],
                        'updated_at' => $row['modifydate']
                    ]);
                    $user->getUserDetails()->updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'primary_phone'        => $row['telephone'] ?? null,
                            'customer_number'      => $row['customernumber'],
                            'tax_status'           => $row['taxstatus'] ?? null,
                            'tax_exemption_no'     => $row['taxexemptionnum'] ?? null,
                            'credit_limit'         => $row['creditlimit'] ?? null,
                            'class_id'             => $row['class_id'] ?? null,
                            'invoice_term_code'    => $row['invoiceterm_code'] ?? null,
                            'user_field'           => $row['userfield1'] ?? null,
                            'salesperson'          => $row['salesperson'] ?? null,
                            'invoice_discount_code' => $row['invoicediscountcode'] ?? null,
                            'branch'               => $row['branch'] ?? null,
                            'line_discount_code'   => $row['linediscountcode'] ?? null,
                            'state_code'   => $row['statecode'] ?? null,
                            'default_email'   => $row['defaultemail'] ?? null
                        ]
                    );
                }
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
