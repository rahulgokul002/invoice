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
        $validator = Validator::make($request->all(), [
            'qty' => 'required|numeric',
            'name' => 'required|alpha',
            'image' => 'file|mimes:pdf,jpg,png|max:3072'
        ], [
            'qty.required' => 'Quantity is required.',
            'qty.numeric' => 'Quantity must be a numeric value.',
            'name.required' => 'Name is required.',
            'name.alpha' => 'Name must contain only alphabetic characters.',
            'image.file' => 'Invalid file format for the image.',
            'image.mimes' => 'Only PDF, JPG, and PNG files are allowed for the image.',
            'image.max' => 'The image size must not exceed 3 MB.',
        ]);   
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        if ($request->hasFile('image')) {
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
            if($request->hasFile('image')){
                $invoice->img_name = $fileName;
            }
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
                'img_name' => $fileName,
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

