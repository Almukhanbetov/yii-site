<div>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<td>tag ID</td>
			<td>tag Name</td>
			<td>tag Alias</td>
			<td>ID tag</td>
			<td>ID user</td>
		</thead>
	<?foreach($resp as $tag):?>
	<tr>
		<td><?=$tag['id']?></td>
		<td><?=$tag['tag_name']?></td>
		<td><?=$tag['tag_alias']?></td>
		<td><?=$tag['id_tag']?></td>
		<td><?=$tag['id_user']?></td>
	</tr>
	<?endforeach;?>
	</table>

</div>