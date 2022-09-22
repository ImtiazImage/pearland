
<!--CENTER SECTION-->
<div class="ud-cen">
<div class="log-bor">&nbsp;</div> <span class="udb-inst">Blog posts</span>
<div class="ud-cen-s2">
	<h2>Blog Details</h2>
	<a href="<?= base_url('user/add-blog');?>" class="db-tit-btn">Add new post</a>

  <?php if($this->session->flashdata('message')){ ?>
    <div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
  <?php } ?>		
					          			
	<table class="responsive-table bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Post Name</th>
				<th>Views</th>
				<th>Edit</th>
				<th>Delete</th>
				<th>Preview</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if ($blogList != NULL) {
					$i = 1;
					foreach ($blogList as $blog) {
			?>			
			<tr>
				<td><?= $i; ?></td>
				<td><?= $blog->blog_name; ?> <span><?= date('d, M Y',strtotime($blog->created_at)); ?></span>
				</td>
				<td><span class="db-list-rat">15</span>
				</td>
				<td><a href="<?= base_url('user/edit-blog/'.$blog->blog_id); ?>" class="db-list-edit">Edit</a>
				</td>
				<td><a href="#" class="db-list-edit" onclick="javascript:deleteConfirm('<?php echo base_url().'user/delete-blog/'.$blog->blog_id;?>');" class="db-list-edit">Delete</a>
				</td>
				<td><a href="<?= base_url('user/blog-details/'.$blog->blog_id); ?>" class="db-list-edit" target="_blank">Preview</a>
				</td>
			</tr>
			<?php	
				$i++;		
					}
				} else {
			?>
				<tr>
					<td colspan="5"> No Blogs Available!!</td>
				</tr>
			<?php } ?>			
		</tbody>
	</table>
</div>
</div>
