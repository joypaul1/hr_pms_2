<?php
require_once('../../helper/2step_com_conn.php');
require_once('../../inc/connoracle.php');

?>


<!-- / Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="">
        <div class="row card">
            <div class="col-lg-12  card-body">
                <form action="" method="post">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="title">RML-ID:</label>
                                <input name="rml_id" class="form-control cust-control" type='text' value='<?php echo isset($_POST['rml_id']) ? $_POST['rml_id'] : ''; ?>' >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label>From Date:</label>
                            <input required="" class="form-control cust-control" name="start_date" type="date" >
                           
                        </div>
                        <div class="col-sm-3">
                            <label>To Date:</label>
                            <input required="" class="form-control cust-control" id="date" name="end_date" type="date" >

                        </div>


                        <div class="col-sm-3">
                            <label for="title">Day Name:</label>
                            <select name="day_name" class="form-control cust-control">
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



                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="title"> <br></label>
                                <input class="form-control btn btn-sm btn-primary cust-control" type="submit" value="Search Data">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="row card mt-2">
        <h5 class="card-header"><b>Roster List</b></h5>
            <div class="col-lg-12 card-body">
                <div class="">
                    <div class="resume-item d-flex flex-column flex-md-row">
                        <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">
                            <thead style="background-color: #b8860b;">
                                <tr class="text-center">
                                    <th scope="col">Sl</th>
                                    <th scope="col">
                                        <center>RML-ID</center>
                                    </th>
                                    <th scope="col">
                                        <center>Emp-Name</center>
                                    </th>
                                    <th scope="col">
                                        <center>Department</center>
                                    </th>
                                    <th scope="col">
                                        <center>Day-Name</center>
                                    </th>
                                    <th scope="col">
                                        <center>Start- Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>End-Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>Created Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>Created BY</center>
                                    </th>
                                    <th scope="col">
                                        <center>Status</center>
                                    </th>
                                    <!-- <th scope="col"><center>Action</center></th>  -->
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $emp_session_id = $_SESSION['HR_APPS']['emp_id_hr'];


                                if (isset($_POST['rml_id'])) {
                                    $rml_id = $_REQUEST['rml_id'];
                                    $day_name = trim($_REQUEST['day_name']);
                                    $attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                    $attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));

                                    $strSQL  = oci_parse($objConnect, "select a.ID,a.RML_ID,b.EMP_NAME,a.START_DATE,a.END_DATE,a.DAY_NAME,a.ENTRY_DATE,a.ENTRY_BY,a.STATUS,b.DEPT_NAME
															   from RML_HR_EMP_ROSTER a,RML_HR_APPS_USER b
															   where A.RML_ID=B.RML_ID
															   and ('$rml_id' is null or A.RML_ID ='$rml_id')
															   and ('$day_name' is null or A.DAY_NAME ='$day_name')
															   AND a.START_DATE BETWEEN to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
															   ");

                                    oci_execute($strSQL);
                                    $number = 0;

                                    while ($row = oci_fetch_assoc($strSQL)) {
                                        $number++;
                                ?>
                                        <tr>
                                            <td><?php echo $number; ?></td>
                                            <td><?php echo $row['RML_ID']; ?></td>
                                            <td><?php echo $row['EMP_NAME']; ?></td>
                                            <td><?php echo $row['DEPT_NAME']; ?></td>
                                            <td><?php echo $row['DAY_NAME']; ?></td>
                                            <td><?php echo $row['START_DATE']; ?></td>
                                            <td><?php echo $row['END_DATE']; ?></td>
                                            <td><?php echo $row['ENTRY_DATE']; ?></td>
                                            <td><?php echo $row['ENTRY_BY']; ?></td>
                                            <td>
                                                <?php if ($row['STATUS'] == '1')
                                                    echo 'Roster Closed';
                                                else
                                                    echo 'Roster Open';
                                                ?>
                                            </td>
                                            <!--
							<td align="center">
							    <a target="_blank" href="roster_edit.php?roster_id=<?php echo $row['ID'] ?>">
								<?php
                                        //if($row['STATUS']=='0')
                                        //  echo '<button class="roster_edit">update</button>';
                                ?>
								</a>
							</td>
							-->
                                        </tr>
                                    <?php
                                    }
                                } else {

                                    $allDataSQL  = oci_parse($objConnect, "SELECT ROWNUM,
																			   ID,
																			   RML_ID,
																			   EMP_NAME,
																			   START_DATE,
																			   END_DATE,
																			   DAY_NAME,
																			   ENTRY_DATE,
																			   ENTRY_BY,
																			   STATUS,DEPT_NAME
																		  FROM (  SELECT a.ID,
																						 a.RML_ID,
																						 b.EMP_NAME,
																						 a.START_DATE,
																						 a.END_DATE,
																						 a.DAY_NAME,
																						 a.ENTRY_DATE,
																						 a.ENTRY_BY,
																						 a.STATUS,b.DEPT_NAME
																					FROM RML_HR_EMP_ROSTER a, RML_HR_APPS_USER b
																				   WHERE A.RML_ID = B.RML_ID
																				   AND a.START_DATE>TO_DATE('31/12/2021','DD/MM/YYYY')
																				ORDER BY ID DESC)
																				WHERE ROWNUM<=10");

                                    oci_execute($allDataSQL);
                                    $number = 0;

                                    while ($row = oci_fetch_assoc($allDataSQL)) {
                                        $number++;
                                    ?>
                                        <tr>
                                            <td><?php echo $number; ?></td>
                                            <td><?php echo $row['RML_ID']; ?></td>
                                            <td><?php echo $row['EMP_NAME']; ?></td>
                                            <td><?php echo $row['DEPT_NAME']; ?></td>
                                            <td><?php echo $row['DAY_NAME']; ?></td>
                                            <td><?php echo $row['START_DATE']; ?></td>
                                            <td><?php echo $row['END_DATE']; ?></td>
                                            <td><?php echo $row['ENTRY_DATE']; ?></td>
                                            <td><?php echo $row['ENTRY_BY']; ?></td>
                                            <td>
                                                <?php if ($row['STATUS'] == '1')
                                                    echo 'Roster Closed';
                                                else
                                                    echo 'Roster Open';
                                                ?>
                                            </td>


                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>


        </div>
    </div>


</div>

<!-- / Content -->



<?php require_once('../../layouts/footer_info.php'); ?>
<?php require_once('../../layouts/footer.php'); ?>