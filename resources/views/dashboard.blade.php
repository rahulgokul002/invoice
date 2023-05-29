<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<style>
.error-message {
    color: red;
    display: none;
  }</style>
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
                          <!-- Display the error messages -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
                                        <form id="addinv_form" action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                            <div class="row">
                                                
                                                <span id="invoiceError" class="error-message"></span>
                                            <input type="hidden" name="id" id="id">
                                            <div class="col-md-6">
                                            <label for="qty" class="form-label">Quantity</label>
                                            <input type="text" class="form-control" name="qty" id="qty">
                                            @if ($errors->has('qty'))
                                            <span class="text-danger">{{ $errors->first('qty') }}</span>
                                        @endif                                            </div>
                                            <div class="col-md-6">
                                            <label for="amt" class="form-label">Amount</label>
                                            <input type="text" class="form-control" name="amount" id="amount">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="t_amt" class="form-label">Total Amount</label>
                                                <input type="text" class="form-control" name="total" id="total">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tax_amt" class="form-label">Tax Amount</label>
                                                <input type="text" class="form-control" name="tax" id="tax">
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="net_amt" class="form-label">Net Amount</label>
                                                <input type="text" class="form-control" name="net_amount" id="net_amount">
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
                                                <div class="col-md-6">
                                                    <label for="image" class="form-label">Image</label>
                                                    <input type="file" class="form-control" name="image" id="image">
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
    $('#qty').on('input', function() {
    var value = $(this).val();
    var errorMessage = $('#invoiceError');
    
    if (isNaN(value)) {
      errorMessage.text('Please enter a valid numeric value for quantity.');
      errorMessage.show();
      $(this).val('');
    } else {
      errorMessage.hide();
    }
  });
  $('#amount').on('input', function() {
    var value = $(this).val();
    var errorMessage = $('#invoiceError');
    
    if (isNaN(value)) {
      errorMessage.text('Please enter a valid numeric value for quantity.');
      errorMessage.show();
      $(this).val('');
    } else {
      errorMessage.hide();
    }
  });
  $('#name').on('input', function() {
    var value = $(this).val();
    var errorMessage = $('#invoiceError');
    
    if (!/^[a-zA-Z]+$/.test(value)) {
      errorMessage.text('Please enter a valid name using only alphabetic characters.');
      errorMessage.show();
    } else {
      errorMessage.hide();
    }
  });
  $('#image').on('change', function() {
    var file = $(this).prop('files')[0];
    var errorMessage = $('#invoiceError');
    
    if (file) {
      var fileSize = file.size / 1024 / 1024; // Convert to MB

      if (fileSize > 3) {
        errorMessage.text('Please upload a file with a maximum size of 3 MB.');
        errorMessage.show();
        $(this).val('');
        return;
      }

      var fileType = file.type;
      if (fileType !== 'image/jpg' && fileType !== 'image/jpeg' && fileType !== 'image/png'  && fileType !== 'image/pdf') {
        errorMessage.text('Please upload a JPG PDF or PNG image file.');
        errorMessage.show();
        $(this).val('');
        return;
      }
    }

    errorMessage.hide();
  });

                $('#qty, #amount').on('input', function() {
    calculateTotal();
    $('#total, #tax').on('input', function() {
    calculateNetAmount();
  });

  function calculateNetAmount() {
    // Get the values of total and tax fields
    var total = parseFloat($('#total').val()) || 0;
    var tax = parseFloat($('#tax').val()) || 0;

    // Calculate the net amount
    var netAmount = total + tax;

    // Update the net amount field
    $('#net_amount').val(netAmount);
  }
  });

  function calculateTotal() {
    // Get the values of quantity and amount fields
    var qty = parseFloat($('#qty').val()) || 0;
    var amount = parseFloat($('#amount').val()) || 0;

    // Calculate the total
    var total = qty * amount;

    // Update the total field
    $('#total').val(total);
  }
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
                    $("#amount").val(res.amount);
                    $("#total").val(res.total);
                    $("#net_amount").val(res.net_amount);
                    $("#tax").val(res.tax);
                    $("#image" ).val(res.img_name);
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
            
            $("addinv_form").on('submit',function(e){
                e.preventDefault();
                // var data=$("#addinv_form").serialize();
                // let form = document.getElementById('addinv_form');
                // let formData = new FormData(form);
                
                let form = $(this)[0]; // Get the DOM element of the form
                let formData = new FormData(form);
                alert(data);
                $.ajax({
                    url:"invoice/store",
                    data: formData, //$("#addinv_form").serialize(),
                    method:'POST'
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