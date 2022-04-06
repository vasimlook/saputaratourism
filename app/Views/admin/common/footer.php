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

                        var message  = (category_status == 1) ? 'Category activated' : 'Category deactivated';
                        if (res.success == 'success' ) {
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

                        var message  = (package_status == 1) ? 'Package activated' : 'Package deactivated';
                        if (res.success == 'success' ) {
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

                        var message  = (package_status == 1) ? 'Package activated' : 'Package deactivated';
                        if (res.success == 'success' ) {
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

                        var message  = (slider_status == 1) ? 'Slider activated' : 'Slider deactivated';
                        if (res.success == 'success' ) {
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

                        var message  = (facility_status == 1) ? 'Facility activated' : 'Facility deactivated';
                        if (res.success == 'success' ) {
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

                        var message  = (hotel_status == 1) ? 'Hotel activated' : 'Hotel deactivated';
                        if (res.success == 'success' ) {
                            alert(message);
                        }
                    }
                });
            });
        });
    </script>
<?php } ?>

</body>

</html>