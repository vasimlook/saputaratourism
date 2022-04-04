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

</body>

</html>