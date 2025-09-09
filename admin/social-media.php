<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Social Media</h1>
	</div>
	<div class="content-header-right">
		<a href="social-media-add.php" class="btn btn-primary btn-sm">Add Social Media</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th width="5">S.No</th>
								<th width="60">Name</th>
								<th width="160">Media URL</th>
								<th width="40">Icon</th>
								<th width="60">Show In Header?</th>
								<th width="60">Show In Footer?</th>
								<th width="40">Action</th>
							</tr>
						</thead>
						<tbody>
								<?php
								$i = 0;
								$statement = $pdo->prepare("SELECT * FROM  tbl_social");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);
								foreach ($result as $row) {
									$i++;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['social_name']; ?></td>
									<td><?php echo $row['social_url']; ?></td>
									<td>
										<i style="font-size:40px;" class="<?php echo $row['social_icon']; ?>"></i>
									</td>
									<td>
										<?php if ($row['status'] == 1) {
											echo '<span class="badge badge-success" style="background-color:green;">Yes</span>';
										} else {
											echo '<span class="badge badge-danger" style="background-color:red;">No</span>';
										} ?>
									</td>
									<td>
										<?php if ($row['footer'] == 1) {
											echo '<span class="badge badge-success" style="background-color:green;">Yes</span>';
										} else {
											echo '<span class="badge badge-danger" style="background-color:red;">No</span>';
										} ?>
									</td>
									<td>
										<a href="social-media-edit.php?id=<?php echo $row['social_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<a href="#" class="btn btn-danger btn-xs" data-href="social-media-delete.php?id=<?php echo $row['social_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>