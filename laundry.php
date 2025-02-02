<?php include 'db_connect.php' ?>
<br>
<br>
<style>
    #results-here.modal-body{
        padding: 40px 20px !important;
    }

    .receipt-header img{
        display: block;
        width: 150px;
        height: 150px;
        margin: 0 auto;
    }

    .receipt-body div, .receipt-body div h6{
        font-family: sans-serif !important;
    }

    .receipt-body .col-12.table-bordered > tbody > tr > td, 
    .receipt-body .col-12.table-bordered > tbody > tr > th, 
    .receipt-body .col-12.table-bordered > tfoot > tr > td, 
    .receipt-body .col-12.table-bordered > tfoot > tr > th, 
    .receipt-body .col-12.table-bordered > thead > tr > td, 
    .receipt-body .col-12.table-bordered > thead > tr > th {
        border: 1px solid black; /* Adjusted for readability */
    }

    /* Responsive Table */
    .table-responsive {
        overflow-x: auto;
    }

    /* Modal Adjustments */
    #printModal .modal-dialog {
        max-width: 90%; /* Make modal width flexible */
    }

    #existingCustomer .modal-dialog {
        max-width: 768px; /* New width for existing customer modal */
    }
</style>

<div class="container-fluid">
    <div class="col-lg-12">    
        <div class="card">
            <div class="card-body">    
                <div class="row">
                    <div class="col-md-12">    
                    <button class="col-sm-3 float-center btn btn-info btn-md" type="button" id="new_laundry"><i class="fa fa-plus"></i> New Laundry</button>    
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="laundry-list">
                                <thead>
                                    <tr>
                                        <th class="text-center">Transaction No.</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">First Name</th>
                                        <th class="text-center">Last Name</th>
                                        <th class="text-center">Contact</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Machine No.</th>
                                        <th class="text-center">Status</th>
                                        <th colspan="2" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $list = $conn->query("SELECT * FROM laundry_list order by status asc, id asc ");
                                    while($row=$list->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php  echo "2022-000" .$row['queue'] ?></td>
                                        <td class=""><?php echo date("M d, Y",strtotime($row['date_created'])) ?></td>
                                        <td class=""><?php echo ucwords($row['first_name']) ?></td>
                                        <td class=""><?php echo ucwords($row['last_name']) ?></td>
                                        <td class="text-center"><?php echo $row['contact']?></td>
                                        <td class=""><?php echo ucwords($row['customer_address']) ?></td>
                                        <td class=""><?php echo ($row['washing_id']) ?>
                                        <?php if($row['status'] == 0): ?>
                                            <td class="text-center"><span class="badge badge-secondary">Pending</span></td>
                                        <?php elseif($row['status'] == 1): ?>
                                            <td class="text-center"><span class="badge badge-primary">Processing</span></td>
                                        <?php elseif($row['status'] == 2): ?>
                                            <td class="text-center"><span class="badge badge-info">Ready to be Claim</span></td>
                                        <?php elseif($row['status'] == 3): ?>
                                        <td class="text-center"><span class="badge badge-success">Claimed</span></td>
                                        <?php endif; ?>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm edit_laundry" data-id="<?php echo $row['id'] ?>">Edit</button>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-success btn-sm print_laundry" data-id="<?php echo $row['id'] ?>">Receipt</button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>    
</div>

<!-- Modal Result-->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Receipt Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="results-here" class="modal-body">
        <div class="receipt-header">
            <img src="./assets/img/BoomBoomWashLogo.png" class="img-fluid" alt="Logo">
            <h3 class="text-center">Boom-Boom Wash Laundry Shop</h3>
            <center><strong>61 Rizal Avenue, Tonsuya Malabon City</strong></center>
            <center><strong>Contact No. 09471691559</strong></center>
            <small id="datetime" class="d-block text-center"></small>
        </div> 
        <hr>
        <div id="receipt-body" class="receipt-body row justify-content-around align-items-center">
            
        </div>
      </div>
      <div class="modal-footer" style="padding: 15px 20px !important;">
        <button style="display: block; margin: 0 auto; min-width: 300px;" id="printreceipt" type="button" class="btn btn-primary">Print Receipt</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<script type="text/javascript">
    $(function(){

        $('#new_laundry').click(function(){
            $("#uni_modal .modal-footer").hide();
            uni_modal('New Laundry','manage_laundry.php','mid-large')
        })
        $('.edit_laundry').click(function(){
            $("#uni_modal .modal-footer").hide();
            uni_modal('Edit Laundry','manage_laundry.php?id='+$(this).attr('data-id'),'mid-large')
        })
        $('.delete_laundry').click(function(){
            _conf("Are you sure to remove this data from list?","delete_laundry",[$(this).attr('data-id')])
        })
        $(".print_laundry").on('click', function(e){
            e.preventDefault();
            const ID = $(this).attr('data-id')
            $.ajax({
                method: "POST",
                url: "getlaundry.php",
                data: { id: ID },
                dataType: "json",
                success: function(res){
                    if(res != null){
                        var strAppend = ``
                        const laundry = res[0];
                        jQuery('#receipt-body').html('');

                        strAppend += `
                        <div class="col-12 col-md-6">
                            <h6><strong>Customer Name:</strong> ${laundry.first_name} ${laundry.last_name}</h6>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6 class="text-right"><strong>Date Ordered:</strong> ${laundry.date_created}</h6>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6><strong>Contact:</strong> ${laundry.contact != '' ? laundry.contact : 'N/A'}</h6>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6 class="text-right"><strong>Address:</strong> ${(laundry.customer_address != '' && laundry.customer_address) ? laundry.customer_address : 'N/A'}</h6>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6><strong>Queue #:</strong> <label>2022-000</label>${laundry.queue}</h6>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6 class="text-right"><strong>Payment Status:</strong> ${(laundry.pay_status == 1 )? 'Paid' : 'Not Paid'}</h6>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6><strong>Washing Machine:</strong> ${laundry.washing_id != '' ? laundry.washing_id : 'N/A'}</h6>
                        </div>`
                        
                        var lStatus = '';
                        if(laundry.status == "0")
                            lStatus = 'Pending'
                        else if(laundry.status == "1")
                            lStatus = 'Processing'
                        else if(laundry.status == "2")
                            lStatus = 'Ready to Claim'
                        else if(laundry.status == "3")
                            lStatus = 'Claimed'
                        
                        
                        strAppend += `<div class="col-12 col-md-6">
                            <h6 class="text-right"><strong>Laundry Status:</strong>${lStatus}</h6>
                        </div>
                        <div class="col-12">
                            <h6><strong>Remarks:</strong> ${laundry.remarks != '' ? laundry.remarks : 'N/A'}</h6>
                        </div>`

                        // List of items
                        strAppend += 
                        `<div class="col-12">
                            <h4 class="text-center text-h2">List of Items</h4>
                        </div>`

                        strAppend += `
                        <div class="col-12">
                            <table class="table table-sm table-bordered table-hover border-dark" align="center">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>`

                        
                        $.ajax({
                            method: "GET",
                            url: "getlaundryitems.php?id="+ID,
                            dataType: "json",
                            success: function(res){
                                var laundryItems = res;
                                if(laundryItems.length > 0){
                                    $.each(laundryItems, function(idx, item){
                                        strAppend += `<tr>
                                                    <td>${item.categoryName}</td>
                                                    <td>${item.weight}</td>
                                                    <td>${item.unitPrice}</td>
                                                    <td>${item.amount}</td>
                                        </tr>`
                                    })
                                    
                                }
                                strAppend += `</tbody></table></div>`

                                strAppend += `
                                <div class="col-12">
                                    <h6 class="text-right"><strong>Total Amount:</strong> ${laundry.total_amount != '' && laundry.total_amount > 0 ? laundry.total_amount : '0'} PHP </h6>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-right"><strong>Amount Paid:</strong> ${laundry.amount_tendered != '' && laundry.amount_tendered > 0 ? laundry.amount_tendered : '0'} PHP </h6>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-right"><strong>Change:</strong> &nbsp; ${laundry.amount_change != '' && laundry.amount_change > 0 ? laundry.amount_change : '0'} PHP </h6>
                                </div>`
                                $('#receipt-body').append(strAppend);
                                $('#datetime').text('Date Printed: ' + new Date().toLocaleString())
                                $('#printModal').modal('show');
                            }
                        })
                    }
                }
            })
        })
        $('#printreceipt').on('click', function(){
            const pdfresult = document.getElementById("results-here");
                    var opt = {
                        margin: 0,
                        filename: 'result.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2 },
                        enableLinks: false,
                        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                    };

            html2pdf().from(pdfresult).set(opt).toPdf().get('pdf').then(function (pdf) {
                window.open(pdf.output('bloburl'), '_blank');
            });
        });
        
    })
</script>
