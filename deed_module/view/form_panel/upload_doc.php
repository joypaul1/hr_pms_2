<?php

$dynamic_link_css = 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css';
$dynamic_link_js = 'https://code.jquery.com/ui/1.13.2/jquery-ui.js';
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
$basePath =  $_SESSION['basePath'];
// if (!checkPermission('car-deed-form')) {
// echo "<script> window.location.href ='$basePath/index.php?logout=true'; </script>";
// }
// $emp_session_id = $_SESSION['HR']['emp_id_hr'];

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body ">
        <form action="" method="post">
            <div class="row justify-content-center">
                <input required name="emp_id" type='hidden' value='<?php echo $emp_session_id; ?>' />
                <div class="col-sm-2">
                    <label class="form-label" for="basic-default-fullname">Select Start Date*</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                        <input required="" type="date" value="<?php echo date('Y-m-d') ?>" name="start_date" class="form-control  cust-control" id="title" ">
                    </div>
                </div>
                <div class=" col-sm-2">
                        <label class="form-label" for="basic-default-fullname">Select End Date*</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar">
                                </i>
                            </div>
                            <input required="" type="date" name="end_date" class="form-control  cust-control" id="title" value="<?php echo date('Y-m-d') ?>">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="form-label" for="basic-default-fullname">&nbsp;</label>
                            <input class="form-control  btn btn-sm btn-primary" type="submit" value="Search Data">
                        </div>
                    </div>


                </div>

        </form>
    </div>




    <!-- Bordered Table -->
    <div class="card mt-2">
        <!-- <h5 class="card-header "><b>Leave Taken List</b></h5> -->
        <!-- table header -->
        <?php
        $leftSideName  = 'Deed List';
        // if (checkPermission('self-leave-create')) {
        $rightSideName = 'Deed Create';
        $routePath     = 'deed_module/view/form_panel/create.php';
        // }

        include('../../../layouts/_tableHeader.php');

        ?>
        <!-- End table  header -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">


                <?php

                if (isset($_REQUEST['start_date'])) {
                    $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                } else {
                    $v_start_date = date('d/m/Y');
                }
                if (isset($_REQUEST['end_date'])) {
                    $v_end_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                } else {
                    $v_end_date = date('d/m/Y');
                }
               
                $SQLQUERY = "SELECT TRUNC(ENTRY_DATE) AS DATE_ONLY, COUNT(*) AS RECORD_COUNT
                            FROM DEED_INFO
                            WHERE TRUNC(ENTRY_DATE) >= TO_DATE('$v_start_date', 'DD/MM/YYYY')
                            AND TRUNC(ENTRY_DATE) <= TO_DATE('$v_end_date', 'DD/MM/YYYY')
                            GROUP BY TRUNC(ENTRY_DATE)
                            ORDER BY DATE_ONLY DESC";

                $dateWiseSQL  = oci_parse($objConnect, $SQLQUERY);
                oci_execute($dateWiseSQL);
                while ($dateWiserow = oci_fetch_assoc($dateWiseSQL)) {
                ?>

                    <table class="table  table-bordered">
                        <thead style="background: beige;">
                            <tr class="text-center">
                                <th>Sl</th>
                                <th>Invoice Number</th>
                                <th colspan="2"> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <th colspan="4">Date : <?php echo $dateWiserow['DATE_ONLY'] ?> | Created Unit Record : <span class="badge badge-center rounded-pill bg-info"><?php echo $dateWiserow['RECORD_COUNT'] ?></span></th>
                            </tr>
                            <?php
                            $dateOnly = date("d/m/Y", strtotime($dateWiserow['DATE_ONLY']));

                            $allDataSql = "WITH RecordCounts
                                            AS (SELECT INVOICE_NO, COUNT (*) AS RECORD_COUNT
                                                FROM DEED_INFO
                                                WHERE TRUNC (ENTRY_DATE) = TO_DATE ('$dateOnly', 'DD/MM/YYYY')
                                                GROUP BY INVOICE_NO)
                                            SELECT D.INVOICE_NO,RC.RECORD_COUNT, 
                                            LISTAGG (D.ID, ', ') WITHIN GROUP (ORDER BY D.ID) AS ID_LIST
                                            FROM DEED_INFO D
                                                    LEFT JOIN RecordCounts RC ON D.INVOICE_NO = RC.INVOICE_NO
                                            WHERE TRUNC (D.ENTRY_DATE) = TO_DATE ('$dateOnly', 'DD/MM/YYYY')
                                            GROUP BY D.INVOICE_NO, RC.RECORD_COUNT";
                            // echo $allDataSql;
                            $dataSQL  = oci_parse($objConnect, $allDataSql);
                            oci_execute($dataSQL);
                            // print_r(oci_fetch_assoc($dataSQL));
                            $number = 0;
                            while ($row = oci_fetch_assoc($dataSQL)) {
                                $number++;
                            ?>
                                <tr class="text-center">
                                    <td> <?php echo  str_pad($number, 2, '0', STR_PAD_LEFT) ?></td>
                                    <td> <?php echo $row['INVOICE_NO'] ?></td>
                                    <td>
                                        <a target="_blank" href="<?php echo $basePath . '/deed_module/view/form_panel/car_deed_print_form.php?inserted_id=' . $row['ID_LIST'] ?>" class="btn btn-sm btn-outline-primary">View Deed <i class='bx bx-right-arrow'></i></a>
                                    </td>
                                    <td>
                                        <a target="_blank" href="<?php echo $basePath . '/deed_module/view/form_panel/upload.php?invoice_no=' . $row['INVOICE_NO'] ?>" class="btn btn-sm btn-outline-info">Upload Document <i class='bx bx-right-arrow'></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php
                }

                ?>



                <!-- </tbody>
                </table> -->
            </div>
        </div>
    </div>
    <!--/ Bordered Table -->



</div>


<!-- / Content -->

<?php require_once('../../../layouts/footer_info.php'); ?>
<?php require_once('../../../layouts/footer.php'); ?>