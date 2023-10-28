<?php
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');

?>
<script type="text/javascript">
    function do_this() {

        var checkboxes = document.getElementsByName('check_list[]');
        var button = document.getElementById('toggle');

        if (button.value == 'Select All') {
            for (var i in checkboxes) {
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'Deselect All'
        } else {
            for (var i in checkboxes) {
                checkboxes[i].checked = '';
            }
            button.value = 'Select All';
        }
    }
</script>


<!-- / Content -->

<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="">
        <div class="card">
            <div class=" card-body">
                <form id="Form1" action="" method="post"></form>
                <form id="Form2" action="" method="post"></form>
                <form id="Form3" action="" method="post"></form>

                <div class="row justify-content-center">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="title">RML ID:</label>
                            <input name="rml_id" form="Form1" class="form-control cust-control" type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' >
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="title">Select Company:</label>
                        <select name="r_concern" class="form-control text-center cust-control" onchange="onChangeCompany(this.value)" form="Form1">
                            <option hidden value=""><-- company --></option>
                            <?php
                            $strSQL = oci_parse(
                                $objConnect,
                                "select distinct(R_CONCERN) R_CONCERN from RML_HR_APPS_USER 
														where R_CONCERN is not null  and is_active=1 
														order by R_CONCERN"
                            );
                            oci_execute($strSQL);
                            while ($row = oci_fetch_assoc($strSQL)) {
                            ?>
                                <option value="<?php echo $row['R_CONCERN']; ?>" <?php echo (isset($_POST['r_concern']) && $_POST['r_concern'] == $row['R_CONCERN']) ? 'selected="selected"' : ''; ?>><?php echo $row['R_CONCERN']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="title">Select Department:</label>
                            <div id="branch_name">
                                <select name="department_name" required="" class="form-control text-center  cust-control" id="department_name" form="Form1">
                                    <option hidden value="<? echo null ?>"><-- department--></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label for="title"><br></label>
                        <input class="form-control btn btn-sm  btn-primary cust-control" type="submit" value="Search Data" form="Form1">
                    </div>
                </div>


                <script>
                    function onChangeCompany(company_name) {
                        if (window.XMLHttpRequest) {
                            xmlhttp = new XMLHttpRequest();
                        } else {
                            xmlhttp = new ActiveXObject("Migrosoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById('department_name').innerHTML = this.responseText;
                            }
                        };
                        xmlhttp.open("GET", "populate_comp_to_dept.php?company_name=" + company_name, true);
                        xmlhttp.send();
                    }
                </script>


            </div>
        </div>
        <div class="card mt-3">
        <h5 class="card-header"><b>Roster Create</b></h5>

            <div class="col-lg-12 card-body  ">
                <form id="Form1" action="" method="post">
                    <div class="row justify-content-center">
                        <div class="col-sm-3">
                            <label for="title">Roster Day Name:</label>
                            <select required="" name="day_name" class="form-control text-center cust-control">
                                <option hidden value="<? echo null ?>"><-- day--></option>
                                <option value="SATURDAY">Saturday</option>
                                <option value="SUNDAY">Sunday</option>
                                <option value="MONDAY">Monday</option>  
                                <option value="TUESDAY">Tuesday</option>
                                <option value="WEDNESDAY">Wednesday</option>
                                <option value="THURSDAY">Thursday</option>
                            </select>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>From Date:</label>
                            <input required="" type="date" name="start_date" class="form-control cust-control" id="title" value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' >

                        </div>
                        <div class="col-sm-3">
                            <label>To Date:</label>
                            <input required="" type="date" name="end_date" class="form-control cust-control" id="title" value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' >
                        </div>
                    </div>
                    <br>
                    <div class="md-form">
                        <div class="resume-item d-flex flex-column flex-md-row">
                            <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">
                                <thead style="background-color: #0e024efa;">
                                    <tr class="text-center">
                                        <th scope="col">Sl</th>
                                        <th scope="col">
                                            <center><input type="button" id="toggle" value="Select All" onClick="do_this()" ></center>
                                        </th>
                                        <th scope="col">
                                            <center>User ID</center>
                                        </th>
                                        <th scope="col">
                                            <center>Concern Name</center>
                                        </th>
                                        <th scope="col">
                                            <center>Department</center>
                                        </th>
                                        <th scope="col">
                                            <center>Branch</center>
                                        </th>
                                        <th scope="col">
                                            <center>Designation</center>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $emp_session_id = $_SESSION['HR']['emp_id_hr'];


                                    if (isset($_POST['rml_id'])) {
                                        $rml_id            = $_REQUEST['rml_id'];
                                        $v_r_compnay       = $_REQUEST['r_concern'];
                                        $v_department_name = $_REQUEST['department_name'];
                                        $strSQL            = oci_parse(
                                            $objConnect,
                                            "SELECT 
										   RML_ID, 
										   EMP_NAME,
										   R_CONCERN,
									       BRANCH_NAME,
										   DEPT_NAME,
									       DESIGNATION
									FROM RML_HR_APPS_USER
									       where IS_ACTIVE=1
										   and ('$rml_id' IS NULL OR RML_ID='$rml_id')
										   and ('$v_r_compnay' IS NULL OR R_CONCERN='$v_r_compnay')
										   and ('$v_department_name' IS NULL OR DEPT_NAME='$v_department_name')"
                                        );


                                        oci_execute($strSQL);
                                        $number = 0;

                                        while ($row = oci_fetch_assoc($strSQL)) {
                                            $number++;
                                    ?>
                                            <tr>
                                                <td>
                                                    <?php echo $number; ?>
                                                </td>
                                                <td align="center">
                                                    <input type="checkbox" name="check_list[]" value="<?php echo $row['RML_ID']; ?>" style="text-align: center; vertical-align: middle;horiz-align: middle;">
                                                </td>
                                                <td>
                                                    <?php echo '<i style="color:red;"><b>' . $row['RML_ID'] . '</b></i> '; ?>
                                                </td>
                                                <td>
                                                    <?php echo '<i style="color:red;"><b>' . $row['R_CONCERN'] . '</b></i> '; ?>
                                                </td>
                                                <td>
                                                    <?php echo '<i style="color:red;"><b>' . $row['DEPT_NAME'] . '</b></i> '; ?>
                                                </td>
                                                <td>
                                                    <?php echo '<i style="color:red;"><b>' . $row['BRANCH_NAME'] . '</b></i> '; ?>
                                                </td>
                                                <td>
                                                    <?php echo '<b>' . $row['DESIGNATION'] . '</b>'; ?>
                                                </td>
                                            </tr>
                                        <?php
                                        } ?>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Create Roster" >
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        </tr>
                                        <?php
                                    } else {

                                        $allDataSQL = oci_parse($objConnect, "SELECT 
                                            RML_ID, 
                                            EMP_NAME,
                                            R_CONCERN,
                                            BRANCH_NAME,
                                            DEPT_NAME,
                                            DESIGNATION
                                            FROM RML_HR_APPS_USER
                                            where IS_ACTIVE=10");

                                        oci_execute($allDataSQL);
                                        $number = 0;

                                        while ($row = oci_fetch_assoc($allDataSQL)) {
                                            $number++;
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $number; ?>
                                                </td>
                                                <td align="center">
                                                    <input type="checkbox" name="check_list[]" value="<?php echo $row['RML_ID']; ?>" style="text-align: center; vertical-align: middle;horiz-align: middle;">
                                                </td>
                                                <td>
                                                    <?php echo '<i style="color:red;"><b>' . $row['RML_ID'] . '</b></i> '; ?>
                                                </td>
                                                <td>
                                                    <?php echo '<i style="color:red;"><b>' . $row['R_CONCERN'] . '</b></i> '; ?>
                                                </td>
                                                <td>
                                                    <?php echo '<i style="color:red;"><b>' . $row['DEPT_NAME'] . '</b></i> '; ?>
                                                </td>
                                                <td>
                                                    <?php echo '<i style="color:red;"><b>' . $row['BRANCH_NAME'] . '</b></i> '; ?>
                                                </td>
                                                <td>
                                                    <?php echo '<b>' . $row['DESIGNATION'] . '</b>'; ?>
                                                </td>
                                            </tr>
                                        <?php

                                        }
                                        if ($number > 0) {
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Create Roster" >
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            </tr>



                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <!-- </div> -->
        <?php

        if (isset($_POST['submit_approval'])) {
            // $emp_session_id    = $_SESSION['emp_id'];
            $emp_session_id = $_SESSION['HR']['emp_id_hr'];

            $roster_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
            $roster_end_date   = date("d/m/Y", strtotime($_REQUEST['end_date']));
            $v_day_name        = $_REQUEST['day_name'];


            if (!empty($_POST['check_list'])) {
                // Loop to store and display values of individual checked checkbox.
                foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {
                    $strSQL = oci_parse(
                        $objConnect,
                        "INSERT INTO RML_HR_EMP_ROSTER (
											   RML_ID, 
											   START_DATE, 
											   END_DATE, 
											   DAY_NAME, 
											   ENTRY_DATE, 
											   ENTRY_BY, 
											   REMARKS, 
											   STATUS
											   ) 
											VALUES ( 
											 '$TT_ID_SELECTTED',
											 TO_DATE('$roster_start_date','DD/MM/YYYY'),
											 TO_DATE('$roster_end_date','DD/MM/YYYY'),
											 '$v_day_name',
											 SYSDATE,
											 '$emp_session_id',
											 '',
											 0
											 )"
                    );

                    oci_execute($strSQL);

                    echo $htmlHeader;
                    while ($stuff) {
                        echo $stuff;
                    }
                    echo "<script>window.location = 'http://202.40.181.98:9090/rHR/roster.php'</script>";
                }
            } else {
                echo 'Sorry! You have not select any ID Code.';
            }
        }


        ?>
    </div>




</div>

<!-- / Content -->
<!-- / Content -->

<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>