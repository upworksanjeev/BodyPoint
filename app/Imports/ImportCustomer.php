<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportCustomer implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection  $rows)
    {
        foreach ($rows as $row) {
            User::create([
                'customer_id' => $row['customeraccountnumber'],
                'name' => $row['customername'],
                'email' => $row['email'],
                'payment_term_description' => $row['paymenttermdescription'],
            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            '*.customeraccountnumber' => ['required', 'max:255'],
            '*.customername' => ['required', 'max:255'],
            '*.email' => ['required', 'email', 'unique:users,email'],
            '*.paymenttermdescription' => ['nullable', 'max:255'],
        ];
    }

}
