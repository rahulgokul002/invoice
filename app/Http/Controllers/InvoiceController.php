<?php

namespace App\Http\Controllers;
use App\Models\Invoice;

use Illuminate\Http\Request;
class InvoiceController extends Controller
{
    public function index()
    {
        return view('dashboard',['invs'=>Invoice::orderBy('id','DESC')->get()]);
    }
    public function edit(Invoice $inv)
    {
        return response()->json($inv);
    }
    public function store(Request $request)
    {
        $invoice = Invoice::updateOrCreate(
             ['id'=>$request->get('id')],
            ['name'=>$request->name],
            ['qty'=>$request->get('qty')],
            ['amount'=>$request->amt],
            ['total'=>$request->t_amt],
            ['tax'=>$request->tax_amt],
            ['net_amount'=>$request->net_amt],
            ['img_name'=>$request->file_upload]
        );
        print_r($invoice);die;

        return response()->json($invoice);
    }

    public function destroy(Invoice $inv)
    {
        $inv->delete();
        return response()->json('success');
    }
}

