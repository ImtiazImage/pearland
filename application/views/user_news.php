<!--CENTER SECTION-->
<div class="ud-cen">
	<div class="log-bor">&nbsp;</div> <span class="udb-inst">All newss</span>

    <?php if($this->session->flashdata('message')){ ?>
        <div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
    <?php } ?>	

	<div class="ud-cen-s2">
		<h2>news Details</h2>
		<a href="<?= base_url('user/user_add_news');?>" class="db-tit-btn">Add new news</a>
		<table class="responsive-table bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>news Name</th>
					<th>Views</th>
					<!-- <th>Expiry on</th> -->
					<th>Status</th>
					<th>Edit</th>
					<th>Delete</th>
					<th>Preview</th>
				</tr>
			</thead>

			<tbody>
				<?php
					if (count($allNews) > 0) {
						$i = 1;
						foreach ($allNews as $news) {
				?>

					<tr>
						<td><?= $i; ?></td>
						<td>

						
							<img src="<?=  (empty($news->news_image)) ? base_url('assets/images/no_photo.jpg') :  base_url($news->news_image)?>	" alt="<?= $news->news_title; ?> ">
							<?= $news->news_title; ?> 
							<span><?= date('d, M, Y',strtotime($news->created_at)); ?></span>
						</td>
						<td><span class="db-list-rat">0</span></td>
						<td>
							<span class="db-list-ststus">
								<?= $news->news_status == 1 ? 'Active' : 'Inactive';?>
							</span>
						</td>
						<td>
							<a href="<?= base_url('user/user-edit-news/'.$news->news_id);?>" class="db-list-edit">		Edit
							</a>
						</td>

						<td><a href="<?= base_url('user/user-delete-news/'.$news->news_id);?>" class="db-list-edit">Delete</a>

						</td>

						<td>

							<a href="<?= base_url('user/news-details/'.$news->news_id);?>" class="db-list-edit" target="_blank">

								Preview

							</a>

						</td>

					</tr>

				<?php	

				$i++;

						}

					} else {

				?>

					<tr>

						<td colspan="6"> No newss Available!!</td>

					</tr>

				<?php } ?>

			</tbody>

		</table>

	</div>

</div>

			