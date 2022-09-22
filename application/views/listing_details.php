<style>
	.list-pg-inn-sp iframe {
	  width: 100% !important;
	}
</style>

	<section>
		<div class="list-bann">
			<img src="<?= (empty($listing->cover_image)) ? base_url('assets/images/CityofPearland.jpg') :  base_url($listing->cover_image);?>" alt="">
		</div>
	</section>

	<!-- END -->
	<!-- START -->
	<!--LISTING DETAILS-->
	<section class=" pg-list-1">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php if($this->session->flashdata('message')){ ?>
						<div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
					<?php } ?>	
					<div class="pg-list-1-pro">
						<img src="<?=(empty($listing->listing_image)) ? base_url('assets/images/no_photo.jpg') :  base_url($listing->listing_image);?>" alt=""> <span class="stat"><i class="material-icons">verified_user</i></span>
					</div>
					<div class="pg-list-1-left">
						<h3><?= $listing->listing_name;?></h3>
						<?php if($listing->display_address == 1){?>
							<p><b>Address:</b> <?= $listing->listing_address;?></p>
						<?php } ?>
						<div class="list-number pag-p1-phone">
							<ul>
								<?php 
									if($listing->display_phone == 1){
								?>
								<a href="Tel:<?= $listing->listing_mobile;?>">
									<li class="ic-php"><?= $listing->listing_mobile;?></li>
								</a>
								<?php
									} 
								?>
								<a href="mailto:<?= $listing->listing_email;?>">
									<li class="ic-mai"><?= $listing->listing_email;?></li>
								</a>
								<a target="_blank" href="<?= $listing->listing_website;?>">
									<li class="ic-web"><?= $listing->listing_website;?></li>
								</a>
							</ul>
						</div>
					</div>
					<div class="list-ban-btn">
						<ul>
							<?php
							if($listing->display_phone == '1'){
							?>
							<li> <a href="tel:<?= $listing->listing_mobile;?>" class="cta 	cta-call">Call now</a>
							</li>
							
							<li> <a href="https://wa.me/<?= $listing->display_phone ?>" class="cta cta-rev">WhatsApp</a>
							</li>
							<?php } ?>
							<li> <span data-toggle="modal" data-target="#quote" class="pulse cta cta-get">Get quote</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class=" list-pg-bg">
		<div class="container">
			<div class="row">
				<div class="com-padd">
					<div id="ld-abo" class="list-pg-lt list-page-com-p">
						<!--LISTING DETAILS: LEFT PART 1-->
						<div class="pglist-bg pglist-p-com">
							<div class="pglist-p-com-ti">
								<h3><span>About</span> <?= $listing->listing_name;?></h3>
							</div>
							<div class="list-pg-inn-sp list-pg-inn-abo">
								<div class="share-btn">
									<ul>
										<li>
											<a target="_blank" href="#" class="so-fb">
												<img src="<?=base_url('assets/images/social/3.png');?>" alt="Share on Facebook" title="Share on Facebook">
											</a>
										</li>
										<li>
											<a target="_blank" href="http://twitter.com/share?text=Rolexo Villas in California&url=http%3A%2F%2Flocalhost%2Fdirectory%2Fbizbook%2Flisting%2Frolexo-villas-in-california%3Fsrc%3Dtwitter" class="so-tw">
												<img src="<?=base_url('assets/images/social/2.png');?>" alt="Share On Twitter" title="Share On Twitter">
											</a>
										</li>
										<li>
											<!-- Check orginal theme omor faruk -->
											<a target="_blank" href="#" class="so-wa">
												<img src="<?=base_url('assets/images/social/6.png');?>" alt="Share on WhatsApp" title="Share on WhatsApp">
											</a>
										</li>
										<li>
											<a target="_blank" href="#" class="so-li">
												<img src="<?=base_url('assets/images/social/1.png');?>" alt="Share on LinkedIn" title="Share on LinkedIn">
											</a>
										</li>
										<li>
											<a target="_blank" href="#" class="so-pi">
												<img src="<?=base_url('assets/images/social/9.png');?>" alt="Share on Pinterest" title="Share on Pinterest">
											</a>
										</li>
									</ul>
								</div>
								<p>
									<?= $listing->listing_description;?>
								</p>
							</div>
						</div>
						<!--END LISTING DETAILS: LEFT PART 1-->
						<!--LISTING DETAILS: LEFT PART 2-->
						<!--START SERVICE AREAS-->



	 					<div id="ld-ser" class="pglist-bg pglist-p-com">
							<div class="pglist-p-com-ti">
								<h3><span>Service</span> Areas</h3>
							</div>
							<div class="list-pg-inn-sp">
								<div class="row pg-list-ser-area">
									<ul>
										<?php
										$service_area = explode(',', $listing->service_locations);
										foreach($service_area as $area ){
										?>
										<li><span><?= $area ?></span></li>
										<?php 
										}
										?>
									</ul>
								</div>
							</div>
						</div>
						<div id="ld-ser" class="pglist-bg pglist-p-com">
							<div class="pglist-p-com-ti">
								<h3><span>Service</span> Offered</h3>
							</div>
							<div class="list-pg-inn-sp">
								<div class="row pg-list-ser-area">
									<ul>
										<?php
										$service_offered = explode(',', $listing->service_offered);
										foreach($service_offered as $service_name ){
										?>
										<li><span><?= $service_name ?></span></li>
										<?php 
										}
										?>
									</ul>
								</div>
							</div>
						</div>
						<!--LISTING DETAILS: LEFT PART 3-->



 						<div id="ld-gal" class="pglist-bg pglist-p-com">
							<div class="pglist-p-com-ti">
								<h3><span>Our</span> Locations</h3>
							</div>
							<div class="list-pg-inn-sp">
				        <iframe 
								  width="300" 
								  height="170" 
								  frameborder="0" 
								  scrolling="no" 
								  marginheight="0" 
								  marginwidth="0" 
								  src="https://maps.google.com/maps?q=<?= $listing->listing_lat ?>, <?= $listing->listing_lng ?>&hl=en&z=14&amp;output=embed"
								 >
								 </iframe>

							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="ban-ati-com ads-all-list"> 
									<a href="#">
										<span>Ad</span>
										<img src="http://www.pearland411.com/graphic/banner.jpg" alt="" height="80">
									</a>						
								</div>
							</div>
						</div>
						<!--RELATED PREMIUM LISTINGS-->
						<div class="list-det-rel-pre">
							<h2>Related listings:</h2>
							<ul>
								<?php 
									foreach($RelatedListing as $RelatedList){
								?>
								<li>
									<div class="land-pack-grid">
										<div class="land-pack-grid-img">
											<img src="<?=(empty($RelatedList->listing_image)) ? base_url('assets/images/no_photo.jpg') :  base_url($listing->listing_image);?>" alt="">
										</div>
										<div class="land-pack-grid-text">
											<h4><?=$RelatedList->listing_name ?></h4>
											<div class="list-rat-all"> <b></b>
											</div>
										</div>
										<a target="_blank" href="<?= base_url('user/listing-preview/'.$RelatedList->listing_slug); ?>" class="land-pack-grid-btn"></a>
									</div>
								</li>
								<?php } ?>
							</ul>
						</div>
						<!--RELATED PREMIUM LISTINGS-->
						<!--END LISTING DETAILS: LEFT PART 3-->
						<!--END SERVICE AREAS-->
<!-- 						<div id="ld-ser" class="pglist-bg pglist-p-com">



							<div class="pglist-p-com-ti">



								<h3><span>Services</span> Offered</h3>



							</div>



							<div class="list-pg-inn-sp">



								<div class="row pg-list-ser">



									<ul>



										<li class="col-md-3">



											<div class="pg-list-ser-p1">



												<img src="<?= base_url('assets/images/services/13.jpg');?>" alt="" />



											</div>



											<div class="pg-list-ser-p2">



												<h4>Villa plots</h4>



											</div>



										</li>



										<li class="col-md-3">



											<div class="pg-list-ser-p1">



												<img src="<?= base_url('assets/images/services/14.jpg');?>" alt="" />



											</div>



											<div class="pg-list-ser-p2">



												<h4>Appartments</h4>



											</div>



										</li>



										<li class="col-md-3">



											<div class="pg-list-ser-p1">



												<img src="<?= base_url('assets/images/services/16.jpg');?>" alt="" />



											</div>



											<div class="pg-list-ser-p2">



												<h4>House constructions</h4>



											</div>



										</li>



                                        <li class="col-md-3">



											<div class="pg-list-ser-p1">



												<img src="<?//= base_url('assets/images/services/17.jpeg');?>" alt="" />



											</div>



											<div class="pg-list-ser-p2">



												<h4>Plots</h4>



											</div>



										</li>



									</ul>



								</div>



							</div>



						</div> -->



						<!--END LISTING DETAILS: LEFT PART 2-->



						<!--START SERVICE AREAS-->



	<!-- 					<div id="ld-ser" class="pglist-bg pglist-p-com">



							<div class="pglist-p-com-ti">



								<h3><span>Service</span> Areas</h3>



							</div>



							<div class="list-pg-inn-sp">



								<div class="row pg-list-ser-area">



									<ul>



										<li><span>Sablon</span>



										</li>



										<li><span> Saco</span>



										</li>



										<li><span> Santa Cruz Gardens</span>



										</li>



										<li><span> Napa County</span>



										</li>



										<li><span> Los Angeles County</span>



										</li>



										<li><span> Fresno County</span>



										</li>



										<li><span> Monterey County</span>



										</li>



									</ul>



								</div>



							</div>



						</div> -->



						<!--END SERVICE AREAS-->



						



						<!--LISTING DETAILS: LEFT PART 4-->



<!-- 						<div id="ld-off" class="pglist-bg pglist-off-last pglist-p-com">



							<div class="pglist-p-com-ti">



								<h3><span>Special</span> Offers</h3>



							</div>



							<div class="list-pg-inn-sp">



								<div class="home-list-pop">



									<!--LISTINGS IMAGE--



									<div class="col-md-3">



										<img src="images/services/2.jpeg" alt="">



									</div>



									<!--LISTINGS: CONTENT--



									<div class="col-md-9 home-list-pop-desc inn-list-pop-desc list-room-deta"><a href="#!"><h3>Villa offer 10%</h3></a>



										<p>Special booking March offer It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p> <span class="home-list-pop-rat list-rom-pric">$5000</span>



										<div class="list-enqu-btn">



											<ul>



												<li> <a target="_blank" href="#">View more</a>



												</li>



												<li><a href="#!" data-toggle="modal" data-target="#quote">Send enquiry</a>



												</li>



											</ul>



										</div>



									</div>



								</div>



							</div>



						</div> -->



						<!--END 360 DEGREE MAP: LEFT PART 8-->



<!-- 						<div class="pglist-bg pglist-p-com" id="ld-360">



							<div class="pglist-p-com-ti">



								<h3><span>360 </span> Degree View</h3>



							</div>



							<div class="list-pg-inn-sp list-360">



								<?= $listing->google_map;?>



							</div>



						</div> -->



						<!--END 360 DEGREE MAP: LEFT PART 8-->



						<!--LISTING DETAILS: LEFT PART 6-->



						<!--LISTING DETAILS: LEFT PART 6-->



<!-- 						<div class="pglist-bg pglist-p-com" style="" id="ld-rew">



							<div class="pglist-p-com-ti">



								<h3><span>Write Your</span> Reviews</h3>



							</div>



							<div class="list-pg-inn-sp">



								<div class="list-pg-write-rev">



									<form class="col" name="review_form" id="review_form" method="post">



										<input type="hidden" class="form-control" name="listing_id" value="385">



										<input type="hidden" class="form-control" name="listing_user_id" value="325">



										<input name="review_user_id" value="37" type="hidden">



										<p>Writing great reviews may help others discover the places that are just apt for them. Here are a few tips to write a good review:</p>



										<div id="review_success" style="text-align:center;display: none;color: green;">Thanks for your Review !! Your Review Is Successful!!</div>



										<div id="review_fail" style="text-align:center;display: none;color: red;">Something Went Wrong!!!</div>



										<div class="row">



											<div>



												<fieldset class="rating">



													<input type="radio" id="star5" name="price_rating" class="price_rating" value="5" />



													<label class="full" for="star5" title="Awesome"></label>



													<input type="radio" id="star4" name="price_rating" class="price_rating" value="4" />



													<label class="full" for="star4" title="Excellent"></label>



													<input type="radio" checked="checked" id="star3" class="price_rating" name="price_rating" value="3" />



													<label class="full" for="star3" title="Good"></label>



													<input type="radio" id="star2" name="price_rating" class="price_rating" value="2" />



													<label class="full" for="star2" title="Average"></label>



													<input type="radio" id="star1" name="price_rating" class="price_rating" value="1" />



													<label class="full" for="star1" title="Poor"></label>



													<input type="radio" id="star0" name="price_rating" class="price_rating" value="0" />



													<label class="" for="star0" title="Very Poor"></label>



												</fieldset>



												<div id="star-value">3 Star</div>



											</div>



										</div>



										<div class="row">



											<div class="input-field col s6">



												<input id="review_name" readonly name="review_name" type="text" value="Rn53 Themes">



											</div>



											<div class="input-field col s6">



												<input id="review_mobile" readonly name="review_mobile" type="text" onkeypress="return isNumber(event)" placeholder="Mobile number" value="5522114422">



											</div>



										</div>



										<div class="row">



											<div class="input-field col s6">



												<input id="review_email" readonly name="review_email" type="email" placeholder="Email Id" value="rn53themes@gmail.com">



											</div>



											<div class="input-field col s6">



												<input id="review_city" name="review_city" placeholder="City" type="text">



											</div>



										</div>



										<div class="row">



											<div class="input-field col s12">



												<textarea id="review_message" placeholder="Write review" name="review_message"></textarea>



											</div>



										</div>



										<div class="row">



											<div class="input-field col s12">



												<input type="submit" id="review_submit" name="review_submit" value="Submit Review">



											</div>



										</div>



									</form>



								</div>



							</div>



						</div> -->



						<!--END LISTING DETAILS: LEFT PART 6-->



						<!--END LISTING DETAILS: LEFT PART 6-->



						<!--LISTING DETAILS: LEFT PART 5-->



						<!--LISTING DETAILS: LEFT PART 5-->



<!-- 						<div class="pglist-p3 pglist-bg pglist-p-com" id="ld-rev">



							<div class="pglist-p-com-ti">



								<h3><span>User</span> Reviews</h3>



							</div>



							<div class="list-pg-inn-sp">



								<div class="lp-ur-all">



									<div class="lp-ur-all-left">



										<div class="lp-ur-all-left-1">



											<div class="lp-ur-all-left-11">Excellent</div>



											<div class="lp-ur-all-left-12">



												<div class="lp-ur-all-left-13"></div>



											</div>



										</div>



										<div class="lp-ur-all-left-1">



											<div class="lp-ur-all-left-11">Good</div>



											<div class="lp-ur-all-left-12">



												<div class="lp-ur-all-left-13 lp-ur-all-left-Good"></div>



											</div>



										</div>



										<div class="lp-ur-all-left-1">



											<div class="lp-ur-all-left-11">Satisfactory</div>



											<div class="lp-ur-all-left-12">



												<div class="lp-ur-all-left-13 lp-ur-all-left-satis"></div>



											</div>



										</div>



										<div class="lp-ur-all-left-1">



											<div class="lp-ur-all-left-11">Below Average</div>



											<div class="lp-ur-all-left-12">



												<div class="lp-ur-all-left-13 lp-ur-all-left-below"></div>



											</div>



										</div>



										<div class="lp-ur-all-left-1">



											<div class="lp-ur-all-left-11">Below Average</div>



											<div class="lp-ur-all-left-12">



												<div class="lp-ur-all-left-13 lp-ur-all-left-poor"></div>



											</div>



										</div>



									</div>



									<div class="lp-ur-all-right">



										<h5>Overall Ratings</h5>



										<p>



											<label class="rat"> <i class="material-icons">star</i>



												<i class="material-icons">star</i>



												<i class="material-icons">star</i>



												<i class="material-icons">star</i>



												<i class="material-icons">star</i>



											</label> <span>based on 1 reviews</span>



										</p>



									</div>



								</div>



								<div class="lp-ur-all-rat">



									<h5>Reviews</h5>



									<ul>



										<li>



											<div class="lr-user-wr-img">



												<img src="images/services/25.jpeg" alt="">



											</div>



											<div class="lr-user-wr-con">



												<h6>Rn53 Themes</h6>



												<label class="rat"> <i class="material-icons">star</i>



													<i class="material-icons">star</i>



													<i class="material-icons">star</i>



													<i class="material-icons">star</i>



													<i class="material-icons">star</i>



												</label> <span class="lr-revi-date">07, Mar 2021</span>



												<p>verified_userRolexo Villas is well-known to all as a premier builder of villas and apartments. Even though they have various departments they stay united in giving the customers the best service. I really had a good service right from on time delivery, quality of work, perfection in work completion. The relationship does not end in just in hand over but they stand strong in all tuff times for the commitment given. After 3+ years of handover they addressed the compound wall cracks which expanded and in a week condition. They still respond to any queries / faults on time and track it to closure.</p>



											</div>



										</li>



									</ul>



								</div>



							</div>



						</div> -->



						<!--END LISTING DETAILS: LEFT PART 5-->



						<!--ADS-->



<!-- 						<div class="ban-ati-com ads-det-page"> <a href=""><span>Ad</span>



                            <img src="images/ads/3.png"></a>



                          </div> -->



                          <!--ADS-->



                          <!--RELATED PREMIUM LISTINGS-->



<!-- 						<div class="list-det-rel-pre">



							<h2>Related listings:</h2>



							<ul>



								<li>



									<div class="land-pack-grid">



										<div class="land-pack-grid-img">



											<img src="images/services/28.jpeg" alt="">



										</div>



										<div class="land-pack-grid-text">



											<h4>Core real estates</h4>



											<div class="list-rat-all"> <b></b>



											</div>



										</div>



										<a target="_blank" href="#" class="land-pack-grid-btn"></a>



									</div>



								</li>



								<li>



									<div class="land-pack-grid">



										<div class="land-pack-grid-img">



											<img src="images/services/25.jpeg" alt="">



										</div>



										<div class="land-pack-grid-text">



											<h4>Museo Villas and Plots</h4>



											<div class="list-rat-all"> <b></b>



											</div>



										</div>



										<a target="_blank" href="#" class="land-pack-grid-btn"></a>



									</div>



								</li>



								<li>



									<div class="land-pack-grid">



										<div class="land-pack-grid-img">



											<img src="images/services/30.jpg" alt="">



										</div>



										<div class="land-pack-grid-text">



											<h4>ccc</h4>



											<div class="list-rat-all"> <b></b>



											</div>



										</div>



										<a target="_blank" href="#" class="land-pack-grid-btn"></a>



									</div>



								</li>



							</ul>



						</div> -->



						<!--RELATED PREMIUM LISTINGS-->



					</div>







					<div class="list-pg-rt">



						<!--LISTING DETAILS: LEFT PART 9-->



						<div class="list-rhs-form pglist-bg pglist-p-com">



							<div class="quote-pop">



								<h3><span>Get</span> Quote</h3>



								<div id="detail_enq_success" class="log" style="display: none;">



									<p>Your Enquiry Is Submitted Successfully</p>



								</div>



								<div id="detail_enq_same" class="log" style="display: none;">



									<p>You cannot make enquiry on your own listing</p>



								</div>



								<div id="detail_enq_fail" class="log" style="display: none;">



									<p>Something Went Wrong!!!</p>



								</div>



								<?php if ($logged_id != NULL) { ?>



									<form method="post" action="<?= base_url('user/add-enquiry/'.'listing_preview/'.$listing->listing_id);?>" name="detail_enquiry_form" id="detail_enquiry_form">







										<input type="hidden" class="form-control" name="listing_id" value="<?=set_value('listing_id',$listing->listing_id);?>" placeholder="" required>



										<input type="hidden" class="form-control" name="event_id" value="" placeholder="" required>



										<input type="hidden" class="form-control" name="blog_id" value="" placeholder="" required>



										<input type="hidden" class="form-control" name="product_id" value="" placeholder="" required>



										<input type="hidden" class="form-control" name="receiving_user_id" value="<?=set_value('receiving_user_id',$listing->user_id);?>" placeholder="" required>



										<input type="hidden" class="form-control" name="enquiry_sender_id" value="<?=set_value('enquiry_sender_id',$logged_id);?>" placeholder="" required>



										<input type="hidden" class="form-control" name="enquiry_source" value="<?=set_value('enquiry_source',$listing->listing_name);?>" placeholder="" required>



										<input type="hidden" class="form-control" name="enquiry_type" value="<?=set_value('enquiry_type','listing');?>" placeholder="" required>



										



										<div class="form-group ic-user">



											<input type="text" name="enquiry_name" value="<?= set_value('enquiry_name');?>" required="required" class="form-control" placeholder="Enter name*">



											<span class="text-danger"><?= form_error("enquiry_name")?form_error("enquiry_name"):'' ;?></span>



										</div>



										<div class="form-group ic-eml">



											<input type="email" class="form-control" name="enquiry_email" placeholder="Enter email*" required="required" value="<?=set_value('enquiry_email');?>" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" title="Invalid email address">



											<span class="text-danger"><?= form_error("enquiry_email")?form_error("enquiry_email"):'' ;?></span>



										</div>



										<div class="form-group ic-pho">



											<input type="text" class="form-control" name="enquiry_mobile" value="<?=set_value('enquiry_mobile');?>" placeholder="Enter mobile number *" pattern="[7-9]{1}[0-9]{9}" title="Phone number starting with 7-9 and remaing 9 digit with 0-9" required>



											<span class="text-danger"><?= form_error("enquiry_mobile")?form_error("enquiry_mobile"):'' ;?></span>



										</div>



										<div class="form-group">



											<textarea class="form-control" rows="3" name="enquiry_message" placeholder="Enter your query or message"></textarea>



											<span class="text-danger"><?= form_error("enquiry_message")?form_error("enquiry_message"):'' ;?></span>



										</div>



										<button type="submit" id="detail_enquiry_submit" name="enquiry_submit" class="btn btn-primary">Submit</button>



									</form>



								<?php } else { ?>



									<div class="form-notes">



										<a href="<?= base_url('user/index');?>"><button class="btn btn-primary"> Please Log In First</button></a>



										<!-- <button id="detail_enquiry_submit" name="enquiry_submit" class="btn btn-primary">Submit</button> -->



									</div>



								<?php } ?>







							</div>



						</div>



						<!--END LISTING DETAILS: LEFT PART 9-->



						<!--LISTING DETAILS: LEFT PART 7-->

						<div class="lide-guar pglist-bg pglist-p-com">
							<div class="pglist-p-com-ti pglist-p-com-ti-right">
								<h3><span>Claim</span> Listing</h3>
							</div>

							<div class="list-pg-inn-sp">
								<div class="list-pg-guar">
									<ul>
										<li>
											<div class="list-pg-guar-img">
												<img src="images/icon/g2.png" alt="" />
											</div>
											<h4>Claim this business</h4>
											<span data-toggle="modal" data-target="#claim" class="clim-edit">Suggest an edit</span>
										</li>

										<div class="ban-ati-com ads-det-page">
											<a href=""><span>Ad</span><img src="https://bizbookdirectorytemplate.com/images/ads/59040boat-728x90.png"></a>
										</div>
										<li>
											<div class="ads-box">
												<a href=""> <span>Ad</span>
													<img src="<?= base_url() ?>assets/images/ads/ads1.jpg" alt="">
												</a>

											</div>

										</li>

										<li>

											<a href="post-your-ads.html.html" class="btn btn-info btn-large"> Click Here to Advertise with Us! </a>

										</li>

										<li>

											<div class="ads-box">

												<a href=""> <span>Ad</span>

													<img src="<?= base_url() ?>assets/images/ads/ads2.jpg" alt="">

												</a>

											</div>

										</li>

										<div class="ban-ati-com ads-det-page">

											<a href=""><span>Ad</span><img src="https://bizbookdirectorytemplate.com/images/ads/59040boat-728x90.png"></a>

										</div>



									</ul>



								</div>



							</div>



						</div>



						<!--END LISTING DETAILS: LEFT PART 7-->



						<!--LISTING DETAILS: COMPANY BADGE-->



<!-- 		<div class="ld-rhs-pro pglist-bg pglist-p-com">



			<div class="lis-comp-badg">



				<div class="s1">



					<div> <span class="by">Business profile</span>



						<img class="proi" src="images/user/1.png" alt="">



						<h4>Rn53 Themes net</h4>



						<p>Address: 28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A</p>



						<ul>



							<li>



								<a href="https://www.facebook.com/53themes" target="_blank">



									<img src="https://bizbookdirectorytemplate.com/images/social/3.png">



								</a>



							</li>



							<li>



								<a href="https://twitter.com/53themes" target="_blank">



									<img src="https://bizbookdirectorytemplate.com/images/social/2.png">



								</a>



							</li>



							<li>



								<a href="https://www.youtube.com/channel/UC3wN3O2GXTt7ZZniIoMZumg" target="_blank">



									<img src="https://bizbookdirectorytemplate.com/images/social/5.png">



								</a>



							</li>



							<li>



								<a href="#" target="_blank">



									<img src="https://bizbookdirectorytemplate.com/images/social/6.png">



								</a>



							</li>



						</ul>



					</div>



				</div>



				<div class="s2"> <a target="_blank" href="company-profile.html" class="use-fol">View profile</a>



					<a target="_blank" href="company-profile.html#home_enquiry_form">Get in touch with us</a>



				</div>



			</div>



		</div> -->



		<!--END LISTING DETAILS: COMPANY BADGE-->



		<!--LISTING DETAILS: LEFT PART 8-->



<!-- 						<div class="pglist-p3 pglist-bg pglist-p-com">



							<div class="pglist-p-com-ti pglist-p-com-ti-right">



								<h3><span>Our</span> Location</h3>



							</div>



							<div class="list-pg-inn-sp">



								<div class="list-pg-map">



									<iframe src="https://www.google.com/maps/@29.5628004,-95.2841068,19z" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>



								</div>



							</div>



						</div> -->



						<!--END LISTING DETAILS: LEFT PART 8-->



						<!--LISTING DETAILS: LEFT PART 9-->



<!-- 						<div class="pglist-p3 pglist-bg pglist-p-com">



							<div class="pglist-p-com-ti pglist-p-com-ti-right">



								<h3><span>Company</span> Info</h3>



							</div>



							<div class="list-pg-inn-sp">



								<div class="list-pg-oth-info">



									<ul>



										<li>Available villas <span>12</span>



										</li>



										<li>Booking advance <span>$500</span>



										</li>



										<li>Contact number <span>986516876516</span>



										</li>



										<li>WhatsApp <span>65468764879</span>



										</li>



										<li>Email id <span>booking@rolex.com</span>



										</li>



										<li>Contact name <span>Bruce mecho</span>



										</li>



										<li>Website <span>www.relexovillas.com</span>



										</li>



										<li>Available plots <span>32</span>



										</li>



										<li>Next project location <span>Losangles</span>



										</li>



									</ul>



								</div>



							</div>



						</div>



					-->						<!--END LISTING DETAILS: LEFT PART 9-->



					<!--LISTING DETAILS: LEFT PART 7-->



<!-- 						<div class="ld-rhs-pro pglist-bg pglist-p-com">



							<div class="lis-pro-badg">



								<div> <span class="rat" alt="User rating">4.2</span>



									<span class="by">Created by</span>



									<img src="images/user/3.jpg" alt="">



									<h4>Loki</h4>



									<p>Member since Feb 2021</p>



								</div> <a href="profile.html" class="fclick" target="_blank">&nbsp;</a>



							</div>



						</div> -->



						<!--END LISTING DETAILS: LEFT PART 7-->



						<!--LISTING DETAILS: LEFT PART 10-->



						<div class="list-mig-like">



							<div class="list-ri-peo-like">



								<h3>Who all are like this</h3>



								<ul>



									<li>



										<a href="profile.html" target="_blank">



											<img src="images/user/62736rn53themes.png" alt="">



										</a>



									</li>



								</ul>



							</div>



						</div>



						<!--END LISTING DETAILS: LEFT PART 10-->



						<!--ADS-->



<!-- 						<div class="ban-ati-com ads-det-page"> <a href=""><span>Ad</span><img



                                src="images/ads/59040boat-728x90.png"></a>



                              </div> -->



                              <!--ADS-->



                            </div>



                          </div>



                        </div>



                      </div>



                    </section>



                    <!-- The Modal -->



                    <div class="modal fade" id="claim">



                    	<div class="modal-dialog">



                    		<div class="modal-content">



                    			<div class="log-bor">&nbsp;</div>



                    			<span class="udb-inst">Claim now</span>



                    			<button type="button" class="close" data-dismiss="modal">&times;</button>



                    			<!-- Modal Header -->



                    			<div class="quote-pop">



                    				<h4>Claim this business</h4>



                    				<div id="pop_claim_success" class="log" style="display: none;"><p>Your



                    				Claim Request Submitted Successfully</p>



                    			</div>



                    			<div id="pop_claim_same" class="log" style="display: none;"><p>You cannot make



                    			enquiry on your own listing</p>



                    		</div>



                    		<div id="pop_claim_fail" class="log" style="display: none;"><p>Something



                    		Went Wrong!!!</p>



                    	</div>







                    	<?php 



                    	if ($logged_id != NULL) { 



                    		if ((($listing->user_id != NULL) && ($listing->user_id != $logged_id)) || ($listing->user_id == NULL )) {



                    			?>



                    			<form method="post" action="<?= base_url('user/claim-listing/'.$listing->listing_slug);?>" name="popup_claim_form" id="popup_claim_form" enctype="multipart/form-data">



                    				<fieldset  >



                    					<input type="hidden" class="form-control" name="listing_id" value="<?=set_value('listing_id',$listing->listing_id);?>" placeholder=""  required>



                    					<input type="hidden" class="form-control" name="enquiry_sender_id" value="<?=set_value('enquiry_sender_id',$logged_id);?>" placeholder="" required>



                    					<input type="hidden" class="form-control" name="enquiry_source" value="<?=set_value('enquiry_source',$listing->listing_name);?>" placeholder="" required>







                    					<div class="form-group">



                    						<input type="text" name="enquiry_name" value="" required="required" class="form-control" placeholder="Enter name*"> 



                    					</div>



                    					<div class="form-group">



                    						<input type="email" class="form-control"



                    						placeholder="Enter this business email id*" required="required"



                    						value=""



                    						name="enquiry_email"



                    						pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"



                    						title="Invalid email address">



                    					</div>



                    					<div class="form-group">



                    						<input type="text" class="form-control"



                    						value=""



                    						name="enquiry_mobile"



                    						placeholder="Enter mobile number *"



                    						pattern="[7-9]{1}[0-9]{9}"



                    						title="Phone number starting with 7-9 and remaining 9 digit with 0-9"



                    						required>



                    					</div>



                    					<div class="form-group">



                    						<input type="file" class="form-control"



                    						name="enquiry_image"



                    						placeholder="Identification Proof *"



                    						required>



                    					</div>



                    					<div class="form-group">



                    						<textarea class="form-control" rows="3" name="enquiry_message"



                    						placeholder="Enter your query and why claim this business"></textarea>



                    					</div>



                    					<input type="hidden" id="source">



                    					<button type="submit"  id="popup_claim_submit" name="popup_claim_submit"



                    					class="btn btn-primary">Submit



                    				</button>



                    			</fieldset>



                    		</form>



                    		<?php 



                    	} 



                    	if ($listing->user_id == $logged_id) { 



                    		



                    		?>



                    		<div class="form-notes"><p>Already Claimed</p></div>



                    	<?php } } else { ?>







                    		<center><a href="<?= base_url('user/login');?>" name="popup_claim_submit"



                    			class="btn btn-primary text-center">Please Log In to Claim</a></center>



                    			<!-- <button id="detail_enquiry_submit" name="enquiry_submit" class="btn btn-primary">Submit</button> -->



                    		</div>



                    	<?php	} ?>



<!--                         <div class="form-notes"><p>We send you the verification email to you provider the email id. Once



you done the verification process then you can manage this business.</p></div> -->



</div>



</div>



</div>



</div>
