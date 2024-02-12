<?php
require_once('../../../helper/3step_com_conn.php');
require_once('../../../inc/connoracle.php');
require_once('../../../inc/connresaleoracle.php');

$basePath = $_SESSION['basePath'];

?>
<div class="container-xxl flex-grow-1 container-p-y">
	<div class="row">
		<div class="col-lg-12 ">
			<div class=" card card-title p-2">
				<marquee>Welcome to our Resale Dashboard. If you face any problem please, inform us [IT & ERP Dept.]</marquee>
			</div>
		</div>
		 <div class="col-lg-12 mb-2 order-0">
			<div class="card mt-1">
				<div class="card-body">
					<h5 class="card-title text-primary">Product Bid Information</h5>
					<div class="table-responsive text-nowrap">
						<div class="table-responsive text-nowrap">
						<table class="table  table-bordered">
							<thead class="table-dark">
								<tr>
									<th scope="col" align="center"><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>SL</strong></th>
									<th scope="col" align="center"><strong>Product</strong></th>
									<th scope="col" align="center"><strong>Total Bid</strong></th>
									<th scope="col" align="center"><strong>Success Bidder</strong></th>
								</tr>
							</thead>
							<tbody>
								<?php  
                            $PRODUCT_SQL  = oci_parse($objConnect, 
												"SELECT BB.ID,
												BB.MODEL,
												BB.BOOK_VALUE,
												BB.DISPLAY_PRICE,
												AA.MAX_BID_AMOUNT,
												AA.TOTAL_BID,
												BB.PRODUCT_BID_ID,
												(SELECT  USER_NAME FROM USER_PROFILE WHERE ID = (SELECT USER_ID FROM PRODUCT_BID WHERE ID = BB.PRODUCT_BID_ID)) AS USER_NAME,
												(BB.AUCTION_END_DATE - TRUNC (SYSDATE)) AUCTION_PENDING
										   FROM (SELECT A.PRODUCT_ID,
														  COUNT (PRODUCT_ID) TOTAL_BID,
														  MAX_BID_AMOUNT (A.PRODUCT_ID) MAX_BID_AMOUNT
													 FROM PRODUCT_BID A, PRODUCT B
													WHERE A.PRODUCT_ID = B.ID
												 GROUP BY A.PRODUCT_ID) AA,
												PRODUCT BB
										  WHERE AA.PRODUCT_ID = BB.ID");
												
	                        oci_execute($PRODUCT_SQL);
								$number = 0;
								while ($row = oci_fetch_assoc($PRODUCT_SQL)) {
									$number++;
								?>
									<tr>
										<td align="center"><i class="fab fa-angular fa-lg text-danger me-3 "></i>
											<strong><?php echo $number; ?></strong>
										</td>
										<td>
											<?php 
											echo $row['MODEL']; 
											//echo '<br>';
											//echo 'BV:'.$row['BOOK_VALUE']; 
											//echo '<br>';
											//echo 'DV:'.$row['DISPLAY_PRICE']; 
											//echo '<br>';
											//echo 'MV:'.$row['MAX_BID_AMOUNT']; 
											?>
										</td>
										<td><?php echo $row['TOTAL_BID']; ?></td>
										<td><?php echo $row['USER_NAME']; ?></td>
								
									</tr>
								<?php
								}
							  
								?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="col-lg-12 mb-2 order-0">
			<div class="card mt-1">
				<div class="card-body">
					<h5 class="card-title text-primary">Product Published Information</h5>
					<div class="table-responsive text-nowrap">
						<div class="table-responsive text-nowrap">
						<table class="table  table-bordered">
							<thead class="table-dark">
								<tr>
									<th scope="col" align="center"><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>SL</strong></th>
									<th scope="col" align="center"><strong>Brand</strong></th>
									<th align="center"><strong>Product Number</strong></th>
									<th align="center"><strong>Pre-Published</strong></th>
									<th scope="col" align="center"><strong>Published</strong></th>
									<th scope="col" align="center"><strong>Not Started</strong></th>
								</tr>
							</thead>
							<tbody>
								<?php
                            $PRODUCT_SQL  = oci_parse($objConnect, 
												"SELECT 
												 B.TITLE BRAND_NAME,
												(SELECT COUNT(A.ID) FROM PRODUCT A WHERE A.BRAND_ID=B.ID AND A.SALES_STATUS='No') TOTAL_PRODUCT,
												PRE_PUBLISHED_PRODUCT(B.ID) TOTAL_PRE_PUBLISHED,
												PUBLISHED_PRODUCT(B.ID,'Y')  TOTAL_PUBLISHED,
												(SELECT COUNT(A.ID) FROM PRODUCT A WHERE A.BRAND_ID=B.ID AND A.SALES_STATUS='No' AND PUBLISHED_STATUS='N' AND WORK_STATUS IS NULL) NOT_STARTED
												FROM BRAND B");
												
	                        oci_execute($PRODUCT_SQL);
								$number = 0;
								while ($row = oci_fetch_assoc($PRODUCT_SQL)) {
									$number++;
								?>
									<tr>
										<td align="center"><i class="fab fa-angular fa-lg text-danger me-3 "></i>
											<strong><?php echo $number; ?></strong>
										</td>
										<td><?php echo $row['BRAND_NAME']; ?></td>
										<td align="center">
											<a target="_blank" href=<?php echo $row['TOTAL_PRODUCT']; ?>>
												<span class="badge badge-center rounded-pill bg-info"><?php echo $row['TOTAL_PRODUCT']; ?></span>
											</a>
										</td>
										<td align="center">
											<a target="_blank" href=<?php echo $row['TOTAL_PRE_PUBLISHED']; ?>>
												<span class="badge badge-center rounded-pill bg-info"><?php echo $row['TOTAL_PRE_PUBLISHED']; ?></span>
											</a>
										</td>
										<td align="center">
											<a target="_blank" href=<?php echo $row['TOTAL_PUBLISHED']; ?>>
												<span class="badge badge-center rounded-pill bg-info"><?php echo $row['TOTAL_PUBLISHED']; ?></span>
											</a>
										</td>
										<td align="center">
											<a target="_blank" href=<?php echo $row['NOT_STARTED']; ?>>
												<span class="badge badge-center rounded-pill bg-info"><?php echo $row['NOT_STARTED']; ?></span>
											</a>
										</td>
									</tr>
								<?php
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
</div>
<!-- / Content -->



<?php require_once('../../../layouts/footer_info.php'); ?>

<?php require_once('../../../layouts/footer.php'); ?>