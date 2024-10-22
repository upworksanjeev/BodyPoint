<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\ImportCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function indexImportCustomer(){
        return view('upload-csv');
    }
    public function importCustomers(Request $request) {
        try {
            DB::beginTransaction();
            Excel::import(new ImportCustomer, $request->file('file'));
            DB::commit();
            return redirect()->back()->with('success', 'Customer imported successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to import customers: ' . $e->getMessage());
        }
    }
}
