<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;

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
        // request()->validate([
        //     'qty'=>'required|numeric',
        //     'name'=>'required|alpha',
        //     'image' => 'file|mimes:pdf,jpg,png|max:3072'
        // ]);
        //dd($request->file('image'));

        if ($request->hasFile('image')) {
            // dd($request->file('image'));
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
        }
        $invoiceId=$request->id;
        if($invoiceId){
            $invoice = Invoice::find($invoiceId);
            $invoice->qty = $request->qty;
            $invoice->amount = $request->get("amount");
            $invoice->total = $request->total;
            $invoice->tax = $request->tax;
            $invoice->net_amount = $request->net_amount;
            $invoice->img_name = $request->image;
            $invoice->created_at = $request->idate;
            $invoice->save();
            return response()->json($invoice);
        }else{
            $invoice = Invoice::create([
                'name' => $request->name,
                'qty' => $request->qty,
                'amount' => $request->get("amount"),
                'total' => $request->total,
                'tax' => $request->tax,
                'net_amount' => $request->net_amount,
                'img_name' => $request->image,
                'created_at' => $request->idate
            ]);
        return response()->json($invoice);
    }
}

    public function destroy(Invoice $inv)
    {
        $inv->delete();
        return response()->json('success');
    }
}

