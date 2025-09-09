<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Vaastus</h1>
	</div>
	<div class="content-header-right">
		<a href="Vaastu-add.php" class="btn btn-primary btn-sm">Add Vaastus</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-hover table-striped">
						<thead class="thead-dark">
							<tr>
								<th width="5">S.No</th>
								<th width="100">Name</th>
								<th width="60">Image</th>
								<th width="60">Icon Image</th>
								<th width="160">Description</th>
								<th width="40">Page Order</th>
								<th width="40">Show In Menu</th>
								<th width="40">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$statement = $pdo->prepare("SELECT * FROM tbl_vaastu ORDER BY id DESC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								$i++;
							?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['ser_name']; ?></td>
									<td style="width:82px;"><img src="./uploads/vaastu/<?php echo $row['ser_image']; ?>" alt="<?php echo $row['ser_name']; ?>" style="width:80px;"></td>
									<td style="width:82px;"><img src="./uploads/vaastu/icon/<?php echo $row['ser_icon']; ?>" alt="<?php echo $row['ser_name']; ?>" style="width:80px;"></td>
									<td>
										<?php
										$words = explode(' ', strip_tags($row['ser_description']));
										$limited_words = array_slice($words, 0, 20);
										echo implode(' ', $limited_words);
										if (count($words) > 20) {
											echo '...';
										}
										?>
									</td>
									<td><?php echo $row['page_order']; ?></td>
									<td>
										<?php if ($row['status'] == 1) {
											echo '<span class="badge badge-success" style="background-color:green;">Yes</span>';
										} else {
											echo '<span class="badge badge-danger" style="background-color:red;">No</span>';
										} ?>
									</td>
									<td>
										<a href="Vaastu-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<a href="#" class="btn btn-danger btn-xs" data-href="Vaastu-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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
</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure want to delete this item?</p>
				<p style="color:red;">Be careful! This product will be deleted from the order table, payment table, size table, color table and rating table also.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>