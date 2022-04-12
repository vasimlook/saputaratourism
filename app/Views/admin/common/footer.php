<div class="nk-footer">
    <div class="container-fluid">
        <div class="nk-footer-wrap">
            <div class="nk-footer-copyright">
                <p class="text-soft">&copy; <?php echo date("Y"); ?> <?php echo APPNAME; ?> All Rights Reserved.</p>
            </div>
        </div>
    </div>
</div>
<!-- footer @e -->
</div>
<!-- wrap @e -->
</div>
<!-- main @e -->
</div>

<input class="ajax_csrfname" type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
<!-- app-root @e -->
<!-- JavaScript -->
<script type="text/javascript" nonce='S51U26wMQz' src="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>js/bundle.js"></script>
<script type="text/javascript" nonce='S51U26wMQz' src="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>js/scripts.js"></script>

<!--<link rel="stylesheet" href="<?php //echo EMPLOYEE_ASSETS_FOLDER; 
                                    ?>css/editors/summernote.css">
<script type="text/javascript" nonce='S51U26wMQz' src="<?php //echo EMPLOYEE_ASSETS_FOLDER; 
                                                        ?>js/libs/editors/summernote.js"></script>
<script type="text/javascript" nonce='S51U26wMQz' src="<?php //echo EMPLOYEE_ASSETS_FOLDER; 
                                                        ?>js/apps/messages.js"></script>-->
<?php //include 'assets/employee/js/editors.php'; 
?>

<script src="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>js/toastr.min.js" type="text/javascript" nonce='S51U26wMQz'></script>
<script src="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>js/charts/chart-ecommerce.js" type="text/javascript" nonce='S51U26wMQz'></script>

<!-- datatable start js  -->
<script nonce='S51U26wMQz' src="<?php echo CENTRAL_ASSETS_FOLDER; ?>datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<script nonce='S51U26wMQz' src="<?php echo CENTRAL_ASSETS_FOLDER; ?>datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo CENTRAL_ASSETS_FOLDER; ?>datatable/dataTables.responsive.min.js" type="text/javascript" nonce='S51U26wMQz'></script>
<script nonce='S51U26wMQz' src="<?php echo CENTRAL_ASSETS_FOLDER; ?>bootstrap/bootstrapValidator.min.js" type="text/javascript"></script>

<?php include(APPPATH . "Views/admin/common/notify.php"); ?>
<script type="text/javascript" nonce='S51U26wMQz'>
    $(document).ready(function() {
        $(".mobileno").keyup(function(e) {
            var str = $(this).val();
            for (var i = 0; i < str.length; i++) {
                var charCode = str.charAt(i).charCodeAt(0);
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    $(this).val('');
                    return false;
                }
            }
            return true;
        });
    });
</script>

<?php if ($title == VIEW_CATEGOIRES) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            fill_datatable1();

            function fill_datatable1() {
                $('#example').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },

                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }],
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "paginationType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        'type': 'POST',
                        'url': "<?php echo BASE_URL . '/DataTablesSrc-master/category_list.php' ?>",
                    },
                    "columns": [{
                            "data": "index"
                        },
                        {
                            "data": "category_id"
                        },
                        {
                            "data": "category_title"
                        },
                        {
                            "data": "is_active"
                        },
                        {
                            "data": "action"
                        }
                    ]
                });
            }

            $(document).on('change', '.category_status', function(res) {

                var category_status = 0;
                var category_id = $(this).attr('data-id');
                if ($(this).prop('checked') == true) {
                    category_status = 1;
                }

                var data = {
                    category_status,
                    category_id
                }

                $.ajax({
                    type: "POST",
                    url: "<?php echo ADMIN_UPDATE_CATEGORY_STATUS ?>",
                    data: data,
                    success: function(res) {
                        var res = $.parseJSON(res);

                        var message = (category_status == 1) ? 'Category activated' : 'Category deactivated';
                        if (res.success == 'success') {
                            alert(message);
                        }
                    }
                });
            });
        });
    </script>
<?php } ?>

<?php if ($title == VIEW_PACKAGES) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            fill_datatable2();

            function fill_datatable2() {
                $('#package_details').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },

                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }],
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "paginationType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        'type': 'POST',
                        'url': "<?php echo BASE_URL . '/DataTablesSrc-master/package_list.php' ?>",
                    },
                    "columns": [{
                            "data": "index"
                        },
                        {
                            "data": "package_id"
                        },
                        {
                            "data": "category_id"
                        },
                        {
                            "data": "package_title"
                        },
                        {
                            "data": "package_duration"
                        },
                        {
                            "data": "package_price"
                        },
                        {
                            "data": "is_active"
                        },
                        {
                            "data": "action"
                        }
                    ]
                });
            }

            $(document).on('change', '.package_status', function(res) {

                var package_status = 0;
                var package_id = $(this).attr('data-id');
                if ($(this).prop('checked') == true) {
                    package_status = 1;
                }

                var data = {
                    package_status,
                    package_id
                }

                $.ajax({
                    type: "POST",
                    url: "<?php echo ADMIN_UPDATE_PACKAGES_STATUS ?>",
                    data: data,
                    success: function(res) {
                        var res = $.parseJSON(res);

                        var message = (package_status == 1) ? 'Package activated' : 'Package deactivated';
                        if (res.success == 'success') {
                            alert(message);
                        }
                    }
                });
            });
        });
    </script>
<?php } ?>

<?php if ($title == VIEW_ADS_PACKAGES) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            fill_datatable3();

            function fill_datatable3() {
                $('#package_ads_details').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },

                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }],
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "paginationType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        'type': 'POST',
                        'url': "<?php echo BASE_URL . '/DataTablesSrc-master/ads_package_list.php' ?>",
                    },
                    "columns": [{
                            "data": "index"
                        },
                        {
                            "data": "package_id"
                        },
                        {
                            "data": "package_title"
                        },
                        {
                            "data": "package_duration"
                        },
                        {
                            "data": "package_price"
                        },
                        {
                            "data": "is_active"
                        },
                        {
                            "data": "action"
                        }
                    ]
                });
            }

            $(document).on('change', '.package_status', function(res) {

                var package_status = 0;
                var package_id = $(this).attr('data-id');
                if ($(this).prop('checked') == true) {
                    package_status = 1;
                }

                var data = {
                    package_status,
                    package_id
                }

                $.ajax({
                    type: "POST",
                    url: "<?php echo ADMIN_UPDATE_ADS_PACKAGES_STATUS ?>",
                    data: data,
                    success: function(res) {
                        var res = $.parseJSON(res);

                        var message = (package_status == 1) ? 'Package activated' : 'Package deactivated';
                        if (res.success == 'success') {
                            alert(message);
                        }
                    }
                });
            });
        });
    </script>
<?php } ?>

<?php if ($title == VIEW_SLIDER) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            fill_datatable3();

            function fill_datatable3() {
                $('#slider_details').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },

                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }],
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "paginationType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        'type': 'POST',
                        'url': "<?php echo BASE_URL . '/DataTablesSrc-master/slider_list.php' ?>",
                    },
                    "columns": [{
                            "data": "index"
                        },
                        {
                            "data": "slider_id"
                        },
                        {
                            "data": "slider_title"
                        },
                        {
                            "data": "slider_image"
                        },
                        {
                            "data": "slider_position"
                        },
                        {
                            "data": "is_active"
                        },
                        {
                            "data": "action"
                        }
                    ]
                });
            }

            $(document).on('change', '.slider_status', function(res) {

                var slider_status = 0;
                var slider_id = $(this).attr('data-id');
                if ($(this).prop('checked') == true) {
                    slider_status = 1;
                }

                var data = {
                    slider_status,
                    slider_id
                }

                $.ajax({
                    type: "POST",
                    url: "<?php echo ADMIN_UPDATE_SLIDER_STATUS ?>",
                    data: data,
                    success: function(res) {
                        var res = $.parseJSON(res);

                        var message = (slider_status == 1) ? 'Slider activated' : 'Slider deactivated';
                        if (res.success == 'success') {
                            alert(message);
                        }
                    }
                });
            });
        });
    </script>
<?php } ?>

<?php if ($title == VIEW_HOTEL_FACILITY) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            fill_datatable4();

            function fill_datatable4() {
                $('#hotel_facility_details').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },

                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }],
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "paginationType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        'type': 'POST',
                        'url': "<?php echo BASE_URL . '/DataTablesSrc-master/hotel_facility_list.php' ?>",
                    },
                    "columns": [{
                            "data": "index"
                        },
                        {
                            "data": "facility_id"
                        },
                        {
                            "data": "facility_title"
                        },
                        {
                            "data": "facility_descriptions"
                        },
                        {
                            "data": "icon"
                        },
                        {
                            "data": "is_active"
                        },
                        {
                            "data": "action"
                        }
                    ]
                });
            }

            $(document).on('change', '.hotel_facility_status', function(res) {

                var facility_status = 0;
                var facility_id = $(this).attr('data-id');
                if ($(this).prop('checked') == true) {
                    facility_status = 1;
                }

                var data = {
                    facility_status,
                    facility_id
                }

                $.ajax({
                    type: "POST",
                    url: "<?php echo ADMIN_UPDATE_HOTEL_FACILITY_STATUS ?>",
                    data: data,
                    success: function(res) {
                        var res = $.parseJSON(res);

                        var message = (facility_status == 1) ? 'Facility activated' : 'Facility deactivated';
                        if (res.success == 'success') {
                            alert(message);
                        }
                    }
                });
            });
        });
    </script>
<?php } ?>

<?php if ($title == VIEW_HOTEL) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            fill_datatable5();

            function fill_datatable5() {
                $('#hotel_details').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },

                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }],
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "paginationType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        'type': 'POST',
                        'url': "<?php echo BASE_URL . '/DataTablesSrc-master/hotel_list.php' ?>",
                    },
                    "columns": [{
                            "data": "index"
                        },
                        {
                            "data": "hotel_id"
                        },
                        {
                            "data": "client_id"
                        },
                        {
                            "data": "hotel_main_image"
                        },
                        {
                            "data": "hotel_title"
                        },
                        {
                            "data": "hotel_descriptions"
                        },
                        {
                            "data": "top_package_id"
                        },
                        {
                            "data": "ads_package_id"
                        },
                        {
                            "data": "is_active"
                        },
                        {
                            "data": "action"
                        }
                    ]
                });
            }

            $(document).on('change', '.hotel_status', function(res) {

                var hotel_status = 0;
                var hotel_id = $(this).attr('data-id');
                if ($(this).prop('checked') == true) {
                    hotel_status = 1;
                }

                var data = {
                    hotel_status,
                    hotel_id
                }

                $.ajax({
                    type: "POST",
                    url: "<?php echo ADMIN_UPDATE_HOTEL_STATUS ?>",
                    data: data,
                    success: function(res) {
                        var res = $.parseJSON(res);

                        var message = (hotel_status == 1) ? 'Hotel activated' : 'Hotel deactivated';
                        if (res.success == 'success') {
                            alert(message);
                        }
                    }
                });
            });
        });
    </script>
<?php } ?>

<?php if ($title == ADD_HOTEL || $title == ADMIN_EDIT_HOTEL_TITLE ) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            var edit_mode = "<?php echo $edit_hotel ?>";    
            var top_package_id = "<?php echo $top_package_id ?>"; 

            if(edit_mode){
                var cat_id = $("#main_category").val();
                load_packages(cat_id,function(){
                    
                    $("#top_package_id").val(top_package_id)
                });

                
                $(document).on('click', '.delete-image', function(e) {
                    e.preventDefault();

                    if(!confirm("Are you sure wants to delete this image?")) return;
                    var image_id = $(this).data('id');             
                    var this_ = $(this);
                    this_.attr('disabled', 'disabled');
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo ADMIN_DELETE_HOTEL_IMAGE ?>",
                        data: {
                            image_id
                        },
                        success: function(res) {
                            this_.removeAttr('disabled');
                            var data = $.parseJSON(res);
                            if (data.success == 'success') {                            
                                $("#img_" + image_id).remove();
                            }
                        }
                    });
                });
        
            }           
            

            $('#main_category').on('change', function() {
                var cat_id = $(this).val();        
                
                load_packages(cat_id,function(){

                });
               
            });

            function load_packages(cat_id,callback){
                $.ajax({
                    type: "POST",
                    url: "<?php echo ADMIN_LOAD_HOTEL_PACKAGE_LINK ?>",
                    data: {
                        'cat_id': cat_id,                        
                    },
                    success: function(res) {
                        var data = jQuery.parseJSON(res);
                        $("#top_package_id").empty();
                        $("#top_package_id").append(new Option("Select Top Package", 0));
                        $.each(data.package, function(index, value) {
                            $("#top_package_id").append(new Option(value.package_title, value.package_id));
                        });

                        callback();
                    }
                });
            }

        });
    </script>
<?php } ?>

<?php if ($title == ADMIN_EDIT_HOTEL_ROOM_TITLE ) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            var edit_mode = "<?php echo $edit_hotel_room ?>";   
           

            if(edit_mode){
                
                $(document).on('click', '.delete-image', function(e) {
                    e.preventDefault();

                    if(!confirm("Are you sure wants to delete this image?")) return;
                    var image_id = $(this).data('id');             
                    var this_ = $(this);
                    this_.attr('disabled', 'disabled');
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo ADMIN_DELETE_HOTEL_ROOM_IMAGE ?>",
                        data: {
                            image_id
                        },
                        success: function(res) {
                            this_.removeAttr('disabled');
                            var data = $.parseJSON(res);
                            if (data.success == 'success') {                            
                                $("#img_" + image_id).remove();
                            }
                        }
                    });
                });
        
            }
        });
    </script>
<?php } ?>

<?php if ($title == VIEW_HOTEL_ROOM) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            fill_datatable6();

            function fill_datatable6() {
                $('#hotel_room_details').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },

                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }],
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "paginationType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        'type': 'POST',
                        'url': "<?php echo BASE_URL . '/DataTablesSrc-master/hotel_room_list.php' ?>",
                    },
                    "columns": [{
                            "data": "index"
                        },
                        {
                            "data": "room_id"
                        },
                        {
                            "data": "hotel_id"
                        },
                        {
                            "data": "room_title"
                        },
                        {
                            "data": "room_type"
                        },
                        {
                            "data": "room_description"
                        },
                        {
                            "data": "is_active"
                        },
                        {
                            "data": "action"
                        }
                    ]
                });
            }

            $(document).on('change', '.hotel_room_status', function(res) {

                var hotel_room_status = 0;
                var hotel_room_id = $(this).attr('data-id');
                if ($(this).prop('checked') == true) {
                    hotel_status = 1;
                }

                var data = {
                    hotel_room_status,
                    hotel_room_id
                }

                $.ajax({
                    type: "POST",
                    url: "<?php echo ADMIN_UPDATE_HOTEL_ROOM_STATUS ?>",
                    data: data,
                    success: function(res) {
                        var res = $.parseJSON(res);

                        var message = (hotel_room_status == 1) ? 'Room activated' : 'Room deactivated';
                        if (res.success == 'success') {
                            alert(message);
                        }
                    }
                });
            });
        });
    </script>
<?php } ?>

<?php if ($title == VIEW_TOP_PACKAGE_PAYMENT) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            fill_datatable7();

            function fill_datatable7() {
                $('#hotel_payment_details').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },

                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }],
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "paginationType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        'type': 'POST',
                        'url': "<?php echo BASE_URL . '/DataTablesSrc-master/hotel_top_package_payment_list.php' ?>",
                    },
                    "columns": [{
                            "data": "index"
                        },
                        {
                            "data": "payment_id"
                        },
                        {
                            "data": "module_id"
                        },
                        {
                            "data": "package_id"
                        },
                        {
                            "data": "total_price"
                        },
                        {
                            "data": "action"
                        }
                    ]
                });
            }          
        });
    </script>
<?php } ?>

<?php if ($title == VIEW_ADS_PACKAGE_PAYMENT) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            fill_datatable7();

            function fill_datatable7() {
                $('#hotel_payment_details').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },

                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }],
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 10,
                    "paginationType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "ajax": {
                        'type': 'POST',
                        'url': "<?php echo BASE_URL . '/DataTablesSrc-master/hotel_ads_package_payment_list.php' ?>",
                    },
                    "columns": [{
                            "data": "index"
                        },
                        {
                            "data": "payment_id"
                        },
                        {
                            "data": "module_id"
                        },
                        {
                            "data": "package_id"
                        },
                        {
                            "data": "total_price"
                        },
                        {
                            "data": "action"
                        }
                    ]
                });
            }  

            
            $(document).on('click','.make-ads-package-payments',function(){
                var payments_id = $(this).attr('data-payment-id');
                var this_ = $(this);

                if(!confirm('Are you sure wants to make payments?')) return;

                var data = {
                    payments_id
                }

                $.ajax({
                    type : 'POST',
                    url : '<?php echo ADMIN_MAKE_ADS_PACKAGE_PAYMENT_LINK ?>',
                    data : data,
                    success : function(res){
                        var res = $.parseJSON(res);                       
                        if (res.success == 'success') {
                            this_.toggleClass('btn btn-xs btn-success');
                            this_.text('Completed');                            
                            alert('Payments has been succesfully applied');
                        }else{
                            alert('Something went wrong while making a payments')
                        }
                    }
                });               
            });
        });
    </script>
<?php } ?>

<?php if ($title == VIEW_ADS_PACKAGE_PAYMENT || $title == VIEW_TOP_PACKAGE_PAYMENT || $title == VIEW_HOTEL) {
?>
    <script nonce='S51U26wMQz' type="text/javascript">
        $(document).ready(function() {
            
            $(document).on('click','.make-ads-package-payments',function(){
                var payments_id = $(this).attr('data-payment-id');
                var this_ = $(this);

                if(!confirm('Are you sure wants to make payments?')) return;

                var data = {
                    payments_id
                }

                $.ajax({
                    type : 'POST',
                    url : '<?php echo ADMIN_MAKE_ADS_PACKAGE_PAYMENT_LINK ?>',
                    data : data,
                    success : function(res){
                        var res = $.parseJSON(res);                       
                        if (res.success == 'success') {
                            this_.toggleClass('btn btn-xs btn-success');
                            this_.text('Completed');                            
                            alert('Payments has been succesfully applied');
                        }else{
                            alert('Something went wrong while making a payments')
                        }
                    }
                });               
            });

            $(document).on('click','.make-top-package-payments',function(){
                var payments_id = $(this).attr('data-payment-id');
                var this_ = $(this);

                if(!confirm('Are you sure wants to make payments?')) return;

                var data = {
                    payments_id
                }

                $.ajax({
                    type : 'POST',
                    url : '<?php echo ADMIN_MAKE_TOP_PACKAGE_PAYMENT_LINK ?>',
                    data : data,
                    success : function(res){
                        var res = $.parseJSON(res);                       
                        if (res.success == 'success') {
                            this_.toggleClass('btn btn-xs btn-success');
                            this_.text('Completed');                            
                            alert('Payments has been succesfully applied');
                        }else{
                            alert('Something went wrong while making a payments')
                        }
                    }
                });               
            });

            $(document).on('click','.renew-hotel-top-package',function(){
                var hotel_id = $(this).attr('data-hotel-id');
                var top_package_id = $(this).attr('data-package-id');

                if(!confirm('Are you sure wants to renew top package?')) return false;

                var data = {
                    hotel_id,
                    top_package_id
                }

                $.ajax({
                    type :'POST',
                    url : '<?php echo ADMIN_RENEW_HOTEL_TOP_PACKAGE_LINK ?>',
                    data:data,
                    success:function(res){
                        var res = $.parseJSON(res);                       
                        if (res.success == 'success') {
                            alert("Top package renewed");
                            location.reload();
                        }
                    }
                });
            });

            $(document).on('click','.renew-hotel-ads-package',function(){
                var hotel_id = $(this).attr('data-hotel-id');
                var ads_package_id = $(this).attr('data-ads-package-id');

                if(!confirm('Are you sure wants to renew top package?')) return false;

                var data = {
                    hotel_id,
                    ads_package_id
                }

                $.ajax({
                    type :'POST',
                    url : '<?php echo ADMIN_RENEW_HOTEL_ADS_PACKAGE_LINK ?>',
                    data:data,
                    success:function(res){
                        var res = $.parseJSON(res);                       
                        if (res.success == 'success') {
                            alert("Ads package renewed");
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
<?php } ?>

</body>

</html>