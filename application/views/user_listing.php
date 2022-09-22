
			<!--CENTER SECTION-->
			<div class="ud-cen">
				<div class="log-bor">&nbsp;</div>	<span class="udb-inst">All Listings</span>
          		<?php if($this->session->flashdata('message')){ ?>
	            	<div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
	            <?php } ?>
				<div class="ud-cen-s2">
					<h2>Listing Details</h2>
					<a href="<?= base_url('user/add_new_listing_start');?>" class="db-tit-btn">Add New Listing</a>
					<div class="table-responsive">
						<table class="table bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>Listing Name</th>
									<th>Rating</th>
									<th>Views</th>
									<!--<th>Expiry on</th>-->
									<th>Status</th>
									<th>Edit</th>
									<th>Delete</th>
									<!--<th>-->
									<!--</th>-->
									<th>Preview</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if (count($AllListings) > 0) {
										$i = 1;
										foreach ($AllListings as $value) {
								?>
								<tr>
									<td><?= $i; ?></td>
									<td>
										<img src="<?=  (empty($value->listing_image)) ? base_url('assets/images/no_photo.jpg') :  base_url($value->listing_image)?>"><?= $value->listing_name; ?> <span><?= date('d, M Y',strtotime($value->created_at));?></span>
									</td>
									<td><span class="db-list-rat">0</span>
									</td>
									<td><span class="db-list-rat">1</span>
									</td>
									<!--									<td><span class="db-list-ststus">8 June 2020</span></td>-->
									<td><span class="db-list-ststus"><?= $value->listing_status == 1? 'Active': 'In-active';?></span>
									</td>
									<td><a href="<?= base_url('user/edit-listing/'.$value->listing_slug); ?>" class="db-list-edit">Edit</a>
									</td>
									<td><a href="#" onclick="javascript:deleteConfirm('<?php echo base_url().'user/delete-listing/'.$value->listing_slug;?>');" class="db-list-edit">Delete</a>
									</td>
									<!--									<td><a href="promote-business.html?code=-->
									<!--&&type=listing" class="db-list-edit">-->
									<!--</a></td>-->
									<td><a href="<?= base_url('user/listing-preview/'.$value->listing_slug); ?>" class="db-list-edit" target="_blank">Preview</a>
									</td>
									<!-- 'user/listing-preview/'.$value->listing_id -->
								</tr>								
								<?php		
										$i++;	
										}
									}
								?>


							</tbody>

						</table>
						<?= $link; ?>
					</div>
				</div>
			</div>
