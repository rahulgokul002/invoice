<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-24">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <!-- Trigger the modal with a button -->
                        <button style="color: blue;" type="button" class="btn btn-info" id="add_inv" data-toggle="modal" data-target="">Add Invoice</button>

                        <table class="table table-bordered mt-3">
                            <thead>
                                <th>Sr.no</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Total</th>
                                <th>Tax</th>
                                <th>Net Amount</th>
                                <th>Name</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="list_todo">
                                @foreach($invs as $inv)
                                  <tr id="row_inv_{{ $inv->id}}">
                                      <td>{{ $inv->id}}</td>
                                      <td>{{ $inv->qty}}</td>
                                      <td>{{ $inv->amount}}</td>
                                      <td>{{ $inv->total}}</td>
                                      <td>{{ $inv->tax}}</td>
                                      <td>{{ $inv->net_amount}}</td>
                                      <td>{{ $inv->name}}</td>

                                      <td width="150">
                                          <button style="color: blue;" type="button" id="edit_inv" data-id="{{ $inv->id }}" class="btn btn-sm btn-info ml-1">Edit</button>
                                          <button style="color: blue;" type="button" id="delete_inv" data-id="{{ $inv->id }}" class="btn btn-sm btn-danger ml-1">Delete</button>
                                      </td>
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Modal -->
                        <div class="modal fade" id="addinv" role="dialog">
                            <div class="modal-dialog">
                                
                                    <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" id="modal_title"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form enctype="multipart/form-data"	id="addinv_form" action=" " method="POST">
                                        @csrf
                                            <div class="row">
                                            <input type="hidden" name="id" id="id">
                                            <div class="col-md-6">
                                            <label for="qty" class="form-label">Quantity</label>
                                            <input type="text" class="form-control" name="qty" id="qty">
                                            </div>
                                            <div class="col-md-6">
                                            <label for="amt" class="form-label">Amount</label>
                                            <input type="text" class="form-control" name="amt" id="amt">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="t_amt" class="form-label">Total Amount</label>
                                                <input type="text" class="form-control" name="t_amt" id="t_amt">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tax_amt" class="form-label">Tax Amount</label>
                                                <input type="text" class="form-control" name="tax_amt" id="tax_amt">
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="net_amt" class="form-label">Net Amount</label>
                                                <input type="text" class="form-control" name="net_amt" id="net_amt">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name" id="name">
                                            </div>
                                        </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="date" class="form-label">Date</label>
                                                    <input type="date" class="date form-control" name="idate" id="idate">
                                            	</div>
                                            	<div class="col-6">
                                            		<label for="file_upload" class="form-label">Upload File</label>
	                                            	<input type="file" name="file_upload">
    	                                        </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" >Add Data</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </form>

                                </div>
                            </div>
                        </div>                   
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script type="text/javascript">
 $(document).ready(function(){
                $.ajaxSetup({
                    headers:{
                        'x-csrf-token' : $('meta[name="csrf-token"]').attr('content')
                    }
                });
                           });

$("#add_inv").on('click',function(){
    // $("#addinv_form").trigger('reset');
    $("#modal_title").html('Add Invoice');
    $("#addinv").modal('show');
    $("#id").val("");
});
$("body").on('click','#edit_inv',function(){
                var id = $(this).data('id');
                $.get('invoice/'+id+'/edit',function(res){
                    $("#modal_title").html('Edit inv');
                    $("#id").val(res.id);
                    $("#name").val(res.name);
                    $("#qty").val(res.qty);
                    $("#amt").val(res.amount);
                    $("#t_amt").val(res.total);
                    $("#net_amt").val(res.net_amount);
                    $("#tax_amt").val(res.tax);
                    $("#file_upload").val(res.img_name);
                    $("#idate").val(res.created_at);
                    $("#addinv").modal('show');
                });
            });
  // Delete Todo 
  $("body").on('click','#delete_inv',function(){
                var id = $(this).data('id');
                confirm('Are you sure want to delete !');
                $.ajax({
                    type:'DELETE',
                    url: "invoice/destroy/" + id
                }).done(function(res){
                    $("#row_inv_" + id).remove();
                });
            });
            //save data 
            
            $("form").on('submit',function(e){
                e.preventDefault();
                $.ajax({
                    url:"invoice/store",
                    data: $("#addinv_form").serialize(),
                    type:'POST'
                }).done(function(res){
                    var row = '<tr id="row_inv_'+ res.id + '">';
                        row += '<td>' + res.id + '</td>';
                        row += '<td>' + res.qty + '</td>';
                        row += '<td>' + res.amount + '</td>';
                        row += '<td>' + res.total + '</td>';
                        row += '<td>' + res.tax + '</td>';
                        row += '<td>' + res.net_amount + '</td>';
                    row += '<td>' + res.name + '</td>';
                    row += '<td width="150">' + '<button type="button" id="edit_inv" data-id="' + res.id +'" class="btn btn-info btn-sm mr-1" style="color: blue;">Edit</button>' + '<button style="color: blue;" type="button" id="delete_inv" data-id="' + res.id +'" class="btn btn-danger btn-sm">Delete</button>' + '</td>';
                    if($("#id").val()){
                        $("#row_inv_" + res.id).replaceWith(row);
                    }else{
                        $("#list_todo").prepend(row);
                    }
                    $("#addinv_form").trigger('reset');
                    $("#addinv").modal('hide');
                });
            });


</script>