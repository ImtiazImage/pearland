
<!--CENTER SECTION-->
<div class="ud-cen">
	<div class="log-bor">&nbsp;</div> <span class="udb-inst">User Dashboard</span>
	<div class="cd-cen-intr">
		<div class="cd-cen-intr-inn">
			<h2>Welcom back, <b>User Test</b></h2>
			<p>Stay up to date reports in your listing, products, events and blog reports here</p>
		</div>
	</div>
	<div class="ud-cen-s1">
		<ul>
			<li>
				<div> <b>21</b>
					<h4>All Listings</h4>
					<p>Total no of listings</p> <a href="#">&nbsp;</a>
				</div>
			</li>
			<li>
				<div> <b>13</b>
					<h4>Enquiries</h4>
					<p>Total no of enquiry</p> <a href="#">&nbsp;</a>
				</div>
			</li>
			<li>
				<div> <b>18</b>
					<h4>Followings</h4>
					<p>Total no of followings</p> <a href="#">&nbsp;</a>
				</div>
			</li>
		</ul>
	</div>
	<!-- START -->
	<!--<div class="ud-cen-s3 ud-cen-s4">-->
	<!--	<h2>Profile page</h2>-->
	<!--	<a href="db-my-profile-edit.html" class="db-tit-btn">Edit profile page</a>-->
	<!--	<div class="ud-payment ud-pro-link">-->
	<!--		<div class="pay-lhs">-->
	<!--			<div class="lis-pro-badg">-->
	<!--				<div>-->
	<!--					<img src="<?= base_url() ?>assets/images/user/62736rn53themes.png" alt="">-->
	<!--					<h4>Rn53 Themes</h4>-->
	<!--					<p>Member since 26, Mar 2021</p>-->
	<!--				</div> <a href="profile.html" class="fclick" target="_blank">&nbsp;</a>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--		<div class="pay-rhs">-->
	<!--			<ul>-->
	<!--				<li><b>Name : </b> Rn53 Themes</li>-->
	<!--				<li><b>Followers : </b>  <span>07</span>-->
	<!--				</li>-->
	<!--				<li><b>City : </b> Sydney</li>-->
	<!--				<li><b>Email : </b> rn53themes@gmail.com</li>-->
	<!--				<li class="pro">-->
	<!--					<input type="text" value="profile.html" readonly>-->
	<!--				</li>-->
	<!--				<li class="pre"><a target="_blank" href="profile.html">View my profile page</a>-->
	<!--				</li>-->
	<!--			</ul>-->
	<!--		</div>-->
	<!--	</div>-->
	<!--</div>-->
	<!-- END -->
	<!-- START -->
	<!--<div class="ud-cen-s3 ud-cen-s4">-->
	<!--	<h2>Business page</h2>-->
	<!--	<a href="company-profile-edit.html" class="db-tit-btn">Edit business page</a>-->
	<!--	<div class="ud-payment ud-pro-link bus-pg">-->
	<!--		<div class="pay-lhs">-->
	<!--			<div class="lis-pro-badg">-->
	<!--				<div>-->
	<!--					<img src="<?= base_url() ?>assets/images/user/39791rn53-themes.png" alt="">-->
	<!--					<h4>Rn53 Themes net</h4>-->
	<!--					<p>Member since 26, Mar 2021</p>-->
	<!--				</div> <a href="company-profile.html" class="fclick" target="_blank">&nbsp;</a>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--		<div class="pay-rhs">-->
	<!--			<ul>-->
	<!--				<li><b>Name : </b> Rn53 Themes net</li>-->
	<!--				<li><b>Page views : </b>  <span>19</span>-->
	<!--				</li>-->
	<!--				<li class="pro">-->
	<!--					<input type="text" value="company-profile.html" readonly>-->
	<!--				</li>-->
	<!--				<li class="pre"><a target="_blank" href="company-profile.html">View business page</a>-->
	<!--				</li>-->
	<!--			</ul>-->
	<!--		</div>-->
	<!--	</div>-->
	<!--</div>-->
	<!-- END -->
	<div class="ud-cen-s2">
		<h2>Listing Details</h2>
		<a href="<?= base_url('user/add_new_listing_start');?>" class="db-tit-btn">Add New Listing</a>
		<table class="responsive-table bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Listing Name</th>
					<th>Rating</th>
					<th>Views</th>
					<!--                    <th>Expiry on</th>-->
					<th>Status</th>
					<th>Edit</th>
					<th>Delete</th>
					<!--                    <th>-->
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
						<img src="<?=base_url($value->listing_image);?>"><?= $value->listing_name; ?> <span><?= date('d, M Y',strtotime($value->created_at));?></span>
					</td>
					<td><span class="db-list-rat">0</span>
					</td>
					<td><span class="db-list-rat">1</span>
					</td>
					<!--									<td><span class="db-list-ststus">8 June 2020</span></td>-->
					<td><span class="db-list-ststus"><?= $value->listing_status == 1? 'Active': 'Inactive';?></span>
					</td>
					<td><a href="<?= base_url('user/edit-listing/'.$value->listing_id); ?>" class="db-list-edit">Edit</a>
					</td>
					<td><a href="#" onclick="javascript:deleteConfirm('<?php echo base_url().'user/delete-listing/'.$value->listing_id;?>');" class="db-list-edit">Delete</a>
					</td>
					<!--									<td><a href="promote-business.html?code=-->
					<!--&&type=listing" class="db-list-edit">-->
					<!--</a></td>-->
					<td><a href="<?= base_url('user/listing-preview/'.$value->listing_slug); ?>" class="db-list-edit" target="_blank">Preview</a>
					</td>
				</tr>								
				<?php		
						$i++;
						}
					} else {
				?>
				<tr>
					<td colspan="8"><p></p>No Listings Available!</p></td>
				</tr>
				<?php		
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="ud-cen-s3">
		<h2>Events</h2>
		<a href="<?= base_url('user/add_user_event');?>" class="db-tit-btn">Add new Event</a>
		<ul>
			<?php
				if (count($AllEvents) > 0) {
					foreach ($AllEvents as $value) {
			?>			
			<li>
				<div class="db-eve">
					<a href="<?= base_url('user/event-preview/'.$value->event_id);?>" >
						<img src="<?= base_url($value->event_image); ?>" alt="">
						<h5><?= $value->event_name;?></h5>
						<span>Created: <?= date('d, M Y',strtotime($value->created_at));?></span>
					</a>
				</div>
			</li>							
			<?php		
					}
				} else {
			?>
				<li>No Events Available!</li>
			<?php		
				}
			?>
		</ul>
	</div>
	<div class="ud-cen-s3 ud-cen-s4">
		<h2>Blog posts</h2>
		<a href="<?= base_url('user/add-blog');?>" class="db-tit-btn">Add new post</a>
		<ul>
		<?php
			if (count($AllBlogs) > 0) {
				foreach ($AllBlogs as $value) {
		?>	
			<li>
				<div class="db-eve">
					<a href="<?= base_url('user/blog-preview/'.$value->blog_id);?>">
						<img src="<?= base_url($value->blog_image); ?>" alt="">
						<h5><?= $value->blog_name;?></h5>
						<span>Created: <?= date('d, M Y',strtotime($value->created_at));?></span>
					</a>
				</div>
			</li>
			<?php		
					}
				} else {
			?>
				<li>No Blog Posts Available!</li>
			<?php		
				}
			?>			
		</ul>
	</div>
</div>
