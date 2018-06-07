<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <h5 class="mb-1">Order Info</h5>
                        <div>
                            <small>Product Name</small>
                            <h4 id="orderProdName" class="mb-0"></h4>
                        </div>
                        <div>
                            <small>Order Quantity</small>
                            <h4 id="orderQuantity" class="mb-0"></h4>
                        </div>
                        <div>
                            <small>Total Price</small>
                            <h4 id="orderPrice"></h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5 class="mb-1">Delivery Details</h5>
                        <div>
                            <small>Recipient</small>
                            <h4 id="orderRecipient" class="mb-0"></h4>
                        </div>
                        <div>
                            <small>Contact Number</small>
                            <h4 id="orderContact" class="mb-0"></h4>
                        </div>
                        <div>
                            <small>Delivery Address</small>
                            <h4 id="orderAddress"></h4>
                        </div>
                    </div>
                </div>

                <div>
                    <div>
                        <small>Status</small>
                        <h4 id="orderStatus"></h4>
                    </div>
                    <div>
                        <small>Ordered On</small>
                        <h4 id="orderedOn"></h4>
                    </div>
                    <div id="orderArrivalDiv">
                        <small id="orderArrivalHeading"></small>
                        <h4 id="orderArrival"></h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <script>
        function getOrder(order_id) {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:'POST',
                url:'/orderinfo/'+order_id,
                data: {
                // _token: <?php echo csrf_token() ?>, // this is optional cause you already added it header
                },
                success:function(data){
                    order_obj = data.order;
                    
                    $("#orderModalLabel").html('Details for Order #' + order_obj[0].order_id);
                    $("#orderProdName").html(order_obj[0].name);
                    $("#orderQuantity").html(order_obj[0].quantity + ' piece/s');
                    $("#orderPrice").html('P ' + order_obj[0].price);
                    $("#orderRecipient").html(order_obj[0].contact_person);
                    $("#orderContact").html(order_obj[0].contact_number);
                    $("#orderAddress").html(order_obj[0].location);
                    $("#orderedOn").html(order_obj[0].added);

                    switch(order_obj[0].status) {
                        case "0":
                            $("#orderStatus").removeClass("text-danger");
                            $("#orderStatus").removeClass("text-success");
                            $("#orderStatus").addClass("text-primary");
                            $("#orderedOn").addClass("mb-0");
                            $("#orderStatus").html("On Transit");
                            $("#orderArrivalDiv").removeClass("d-none");
                            $("#orderArrivalDiv").addClass("d-block");
                            $("#orderArrivalHeading").html('Estimated Delivery Date');
                            $("#orderArrival").html(order_obj[0].arrival_date.substring(0, 10));
                            break;
                        case "1":
                            $("#orderStatus").removeClass("text-danger");
                            $("#orderStatus").removeClass("text-primary");
                            $("#orderStatus").addClass("text-success");
                            $("#orderedOn").addClass("mb-0");
                            $("#orderStatus").html("Delivered");
                            $("#orderStatus").removeClass("d-none");
                            $("#orderArrivalDiv").addClass("d-block");
                            $("#orderArrivalHeading").html('Delivered On');
                            $("#orderArrival").html(order_obj[0].arrival_date);
                            break;
                        case "2":
                            $("#orderStatus").removeClass("text-success");
                            $("#orderStatus").removeClass("text-primary");
                            $("#orderStatus").addClass("text-danger");
                            $("#orderStatus").html("Cancelled");
                            $("#orderArrivalDiv").removeClass("d-block");
                            $("#orderArrivalDiv").addClass("d-none");
                            break;
                    }
                }
            });
        }
    </script>