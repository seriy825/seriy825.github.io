<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Conferences</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
	
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col mt-5 ">
				<a href="view/insert.php" class="btn btn-success pull-right mb-5"><i class="fa fa-plus"> Add new Conference</i></a>
				
					<?php 
					if (!empty($result)){
					?>
					<table class="table shadow ">
						<thead class="thead-dark">
							<tr>
								<th>Title of conference</th>
								<th>Date</th>							
								<th>Actions</th>
							</tr>
						</thead>						
						<tbody >
							<?php foreach ($result as $value) { ?>
								<tr>
									<td><a href="index.php?act=current&id=<?=$value['id'] ?>"><?=$value['title'] ?></a></td>
									<td><?=$value['date'] ?></td>
									<td>
										<a href="index.php?act=update&id=<?=$value['id'] ?>" class="btn btn-success btn-sm" ><i class="fa fa-edit"> Edit Record</i></a> 
										<a href="?delete=<?=$value['id'] ?>" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?=$value['id'] ?>"><i class="fa fa-trash"> Delete Record</i></a>
										<!-- DELETE MODAL -->
										<div class="modal fade" id="deleteModal<?=$value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content shadow">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Are you sure for delete conference "<?=$value['title'] ?>" ?</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
												<form action="?id=<?=$value['id'] ?>" method="post">
												<a href="index.php?act=delete&id=<?=$value['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash" > Delete Record</i></a>
												</form>
											</div>
											</div>
										</div>
										</div>

									</td>
									</div>
								</tr> 
							<?php } ?>
							
						</tbody>					
						</table>
					<?php } else { ?><p class='lead'><em>No records were found.</em></p> <?php } ?>				
			</div>
		</div>
	</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>