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

    <div class="card col-lg-12">
        <form action="#" method="post">
            <div class="card-body row justify-content-center">
                <!-- <div class="col-sm-2"></div> -->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">Title</label>
                        <input required="" placeholder="title here.." name="title" class="form-control cust-control" type='text' value='<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>' />
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Select Start Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" type="date" name="start_date" class="form-control  cust-control" id="title" value="">
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="basic-default-fullname">Select End Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" type="date" name="end_date" class="form-control  cust-control" id="title" value="">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                        <input class="form-control btn btn-sm btn-primary" type="submit" value="Create Data">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card mt-2">
        <div class="card-header d-flex align-items-center justify-content-between" style="padding: 1.0% 1rem">
            <div href="#" style="font-size: 20px;font-weight:700">
                <i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i> Year Create Report
            </div>

        </div>
        <div class="row card-body ">


            <div class="col-lg-12">
                <div class="md-form mt-2">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" border="1" cellspacing="0" cellpadding="0">
                            <thead style="background: beige;">
                                <tr class="text-center">
                                    <th class="text-center">Sl</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>





            </div>
        </div>
    </div>



</div>

<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>