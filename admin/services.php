<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Services</h1>
	</div>
	<!-- <div class="content-header-right">
		<a href="services-add.php" class="btn btn-primary btn-sm">Add Services</a>
	</div> -->
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
								<th width="160">Name</th>
								<th width="160">Heading</th>
								<th width="60">Image</th>
								<th width="160">Description</th>
								<th width="30">Show In Menu?</th>
								<th width="40">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$statement = $pdo->prepare("SELECT * FROM tbl_services ORDER BY id DESC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								$i++;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['ser_name']; ?></td>
									<td><?php echo $row['ser_heading']; ?></td>
									<td style="width:82px;">
										<img src="./uploads/services/<?php echo $row['ser_image']; ?>" alt="<?php echo $row['ser_name']; ?>" style="width:80px;">
									</td>
									<td>
										<?php
										$desc = strip_tags($row['ser_description']);
										$words = explode(' ', $desc);
										$limited_words = array_slice($words, 0, 30);
										echo implode(' ', $limited_words);
										if (count($words) > 30) echo '...';
										?>
									</td>
									<td>
										<?php if (($row['status'] ?? 0) == 1) {
											echo '<span class="badge badge-success" style="background-color:green;">Yes</span>';
										} else {
											echo '<span class="badge badge-danger" style="background-color:red;">No</span>';
										} ?>
									</td>
									<td>
										<a href="services-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<!-- <a href="#" class="btn btn-danger btn-xs" data-href="services-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a> -->
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
				<p>Are you sure you want to delete this item?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>
