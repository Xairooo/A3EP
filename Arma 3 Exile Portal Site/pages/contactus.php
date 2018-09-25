<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>

	<script>
		$(document).ready(function(){
		    var table = $('#tableList').DataTable( {
		        "lengthMenu": [ [25, 50, 100, -1], [25, 50, 100, "All"] ],
		        "columnDefs": [
		            {"orderSequence": ["desc", "asc"], "targets": [1,2,3,4,5,6,7]}
		        ]
		    } );
		    table
		    .order( [ 0, 'desc'] )
		    .draw();
		});
	</script>
<div class="container">
<div class="row new">
		<h1><?php echo $langs->word($dlang,'contactus_title'); ?></h1>
		<p><?php echo $langs->word($dlang,'contactus_title_description'); ?></p>
			<div class="c-box">
<div class="table-responsive">
			<table id="tableList" class="table table-striped table-condensed">
			<thead>
			<tr>
			  <th><?php echo $langs->word($dlang,'table_name'); ?></th>
			  <th><?php echo $langs->word($dlang,'table_message'); ?></th>
			</tr>
		  </thead>
		  <?php $query = "
					SELECT
						*
					   FROM ".$tblpre."users WHERE admin = 1 ORDER BY id
				";

				try
				{
					$stmt = $db->prepare($query);
					$stmt->execute();
				}
				catch(PDOException $ex)
				{
					die("Failed to run query: " . $ex->getMessage());
				}
				$rows = $stmt->fetchAll(); ?>
		  <tbody>

			<?php foreach($rows as $row):
				$username = $row['username'];
				$id = $row['id'];
			?>
				<tr>
				  <td><?php echo $username; ?></td>
				  <td><a style= "color:red" href="?page=sendmessage&id=<?php echo $id; ?>"><?php echo $langs->word($dlang,'table_private'); ?></a></td>
				</tr>
				<?php endforeach; ?>
		  </tbody>
		</table>
  </div>
</div>
</div>
</div> <!-- /container -->
<?php ?>