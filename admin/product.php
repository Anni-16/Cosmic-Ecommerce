<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Products</h1>
	</div>
	<div class="content-header-right">
		<a href="product-add.php" class="btn btn-primary btn-sm">Add Products</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<?php
					$i = 0;
					$statement = $pdo->prepare("
						SELECT * FROM tbl_product t1
						JOIN tbl_product_category t2
						ON t1.cat_id = t2.cat_id
						ORDER BY t1.a_id DESC
					");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					?>
					<table class="table table-bordered table-hover table-striped">
						<thead class="thead-dark">
							<tr>
								<th width="10">S.No</th>
								<th>Product Id</th>
								<th>Photo</th>
								<th width="160">Product Name</th>
								<th width="60">Price</th>
								<th width="60">Stock</th>
								<th>QTY</th>
								<th>Featured?</th>
								<th>Active?</th>
								<th>Category</th>
								<th width="80">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($result as $row): ?>
								<?php $i++; ?>
								<tr>
									<td><?= $i ?></td>
									<td><?= ($row['a_code']) ?></td>
									<td style="width:82px;">
										<img src="./uploads/products/<?= ($row['a_photo']) ?>" alt="<?= ($row['a_name']) ?>" style="width:80px;">
									</td>
									<td><?= ($row['a_name']) ?></td>
									<td>₹<?= ($row['a_current_price']) ?></td>
									<td><?= ($row['a_available']) ?></td>
									<td><?= ($row['a_stock_qty']) ?></td>
									<td>
										<?php if ($row['a_is_featured'] == 1): ?>
											<span class="badge badge-success" style="background-color:green;">Yes</span>
										<?php else: ?>
											<span class="badge badge-danger" style="background-color:red;">No</span>
										<?php endif; ?>
									</td>
									<td>
										<?php if ($row['a_is_active'] == 1): ?>
											<span class="badge badge-success" style="background-color:green;">Yes</span>
										<?php else: ?>
											<span class="badge badge-danger" style="background-color:red;">No</span>
										<?php endif; ?>
									</td>
									<td><?= ($row['cat_name']) ?></td>
									<td>
										<a href="product-edit.php?id=<?= $row['a_id'] ?>" class="btn btn-primary btn-xs">Edit</a>
										<a href="#" class="btn btn-danger btn-xs" data-href="product-delete.php?id=<?= $row['a_id'] ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
									</td>
								</tr>
							<?php endforeach; ?>
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
				<p style="color:red;">Be careful! This product will be deleted from the order table, payment table and rating table also.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>
