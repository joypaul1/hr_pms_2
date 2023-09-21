<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
// if (!checkPermission('concern-offboarding-create')) {
//     echo "<script> window.location.href = '$basePath/index.php?logout=true'; </script>";
// }
$emp_session_id = $_SESSION['HR']['emp_id_hr'];


?>



<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- <div class="card col-lg-12">
        
        <form action="<?php echo $basePath ?>/pms_module/action/hr_panel.php" method="POST">
            <div class="card-body row justify-content-center">
                <input type="hidden" name='actionType' value='year_create'>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label" for="pms_name">PMS Name</label>
                        <input required="" placeholder="Name here.." id="pms_name" name="pms_name" class="form-control cust-control" type='text' />
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="start_date">Select Start Date*</label>
                    <input required="" type="date" name="start_date" class="form-control  cust-control" id="start_date" value="">

                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="end_date">Select End Date*</label>
                    <input required="" type="date" name="end_date" class="form-control  cust-control" id="end_date" value="">

                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Create Data">
                    </div>
                </div>
            </div>
        </form>
    </div> -->

    <div class="card mt-2">
        <!-- End table  header -->
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between" style="padding: 1.0% 1rem">
                <div href="#" style="font-size: 20px;font-weight:700">
                    <i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i> Year List
                </div>
                <div>
                    <a href="<?php echo $basePath ?>/pms_module/view/hr_panel/year_create.php" class="btn btn-sm btn-info">
                        <i class="menu-icon tf-icons bx bx-message-alt-add" style="margin:0;"></i>Year Create</a>
                </div>
            </div>
        </div>
        <!-- table header -->

        <div class="row card-body ">


            <div class="col-lg-12">

                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered text-center" border="1" cellspacing="0" cellpadding="0">
                        <thead style="background: beige;">
                            <tr class="text-center">
                                <th class="text-center">Sl</th>
                                <th scope="col">Action</th>
                                <th scope="col">Title</th>
                                <th scope="col">Active Status</th>
                                <th scope="col">Step Status</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $allDataSQL  = oci_parse(
                                $objConnect,
                                "SELECT  ID, PMS_NAME, CREATED_BY, START_DATE, IS_ACTIVE,  END_DATE, TABLE_REMARKS, ACHIVEMENT_OPEN_STATUS,STEP_1_STATUS, STEP_2_STATUS, STEP_3_STATUS
                                FROM HR_PMS_LIST"
                            );

                            oci_execute($allDataSQL);
                            $number = 0;
                            while ($row = oci_fetch_assoc($allDataSQL)) {
                                $number++;
                                if ($row['IS_ACTIVE'] == 1) {
                                    $status = '<button class="btn btn-sm rounded btn-success"> Active </button>';
                                } else {
                                    $status = '<button class="btn btn-sm rounded btn-warning "> Deactive </button>';
                                }

                                echo "<tr>";

                                echo "<td>" . $number . "</td>";
                                echo '<td><a href="' . $basePath . '/pms_module/view/hr_panel/year_edit.php?id=' . $row['ID'] . '&amp;&amp;actionType=edit" class="btn btn-sm btn-info flo~at-right"> <i class="bx bx-edit-alt me-1"></i></a> </td>';
                                echo "<td>" . htmlspecialchars($row['PMS_NAME']) . "</td>";
                                echo "<td>" . $status . "</td>";
                                echo "<td>";
                                if ($row['STEP_1_STATUS']) {
                                    echo ' <span>Step 1 : <i class="text-success bx bxs-badge-check"></i>  </span>';
                                } else {
                                    echo ' <span>Step 1 : <i class="text-danger bx bxs-comment-x"></i>  </span>';
                                }
                                echo '</br>';
                                if ($row['STEP_2_STATUS']) {
                                    echo ' <span>Step 2 : <i class="text-success bx bxs-badge-check"></i>  </span>';
                                } else {
                                    echo ' <span>Step 2 : <i class="text-danger bx bxs-comment-x"></i>  </span>';
                                }
                                echo '</br>';

                                if ($row['STEP_3_STATUS']) {
                                    echo ' <span>Step 3 : <i class="text-success bx bxs-badge-check"></i>  </span>';
                                } else {
                                    echo ' <span>Step 3 : <i class="text-danger bx bxs-comment-x"></i>  </span>';
                                }


                                echo "</td>";

                                echo "<td>" . $row['START_DATE'] . "</td>";
                                echo "<td>" . $row['END_DATE'] . "</td>";
                            }

                            ?>

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>



</div>

<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>

<script>
    //delete data processing

    $(document).on('click', '.delete_check', function() {
        var id = $(this).data('id');
        let url = $(this).data('href');
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            deleteID: id
                        },
                        dataType: 'json'
                    })
                    .done(function(response) {
                        console.log(response);
                        swal.fire('Deleted!', response.message, response.status);
                        location.reload(); // Reload the page
                    })
                    .fail(function() {
                        swal.fire('Oops...', 'Something went wrong!', 'error');
                    });

            }

        })

    });
</script>