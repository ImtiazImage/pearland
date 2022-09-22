
	<!-- START -->
	<section>
		<div class="all-listing all-listing-pg">
			<!--FILTER ON MOBILE VIEW-->
			<div class="fil-mob fil-mob-act">
				<h4>Listing filters <i class="material-icons">filter_list</i></h4>
			</div>
			<div class="all-list-bre">
				<div class="container sec-all-list-bre">
					<div class="row">
						<div class="col-md-4">
							<h1>Business</h1>
							<ul>
								<li><a href="<?= base_url('/');?>">Home</a>
								</li>
								<!--<li><a href="all-category.html">All category</a>-->
								<!--</li>-->
								<!--<li> <a href="all-listing.html">Business</a>-->
								<!--</li>-->
							</ul>
						</div>
						<div class="col-md-8">
							<div class="ban-ati-com ads-all-list">
                                <a href="#"><span>Ad</span><img src="<?= base_url('assets/images/ads/3.png'); ?>"></a>
                        	</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-3 fil-mob-view listing_col3">
						<div class="all-filt"> <span class="fil-mob-clo"><i class="material-icons">close</i></span>
							<!--START-->
							<div class="filt-alist-near">
								<div class="tit">
									<h4>Top Featured Listing</h4>
								</div>
								<div class="near-ser-list top-ser-secti-prov">
									<ul>
									    <?php
									        if($randListings){
									            foreach($randListings as $value){
									   ?>
										<li>
											<div class="near-bx">
												<div class="ne-1">
													<img src="<?= (empty($value->listing_image)) ? base_url('assets/images/no_photo.jpg') :  base_url($value->listing_image);?>" alt="">
												</div>
												<div class="ne-2">
													<h5><?= $value->listing_name;?></h5>
													<p><?= ($value->display_address == 1) ? $value->listing_address: '[Adderss hidden]';?></p>
												</div>
												<!--<div class="ne-3"> <span>5.0</span>-->
												<!--</div>-->
												<a href="<?= base_url('user/listing-preview/'.$value->listing_slug); ?>"></a>
											</div>
										</li>
									   
									   <?php
									            }
									        }
									    ?>
									</ul>
								</div>
								
							</div>
							<!--END-->
							<!--START-->
							<div class="filt-com lhs-cate">
								<h4>Categories</h4>

								<div class="dropdown">
									<select class="chosen-select form-control" id="selectCategory">
										<option value="">Select Category</option>
                                        <?php if($allCategories){
                                            foreach($allCategories as $value){
                                        ?>
                                        <option value="<?= $value->category_id; ?>"><?= $value->category_name; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
									</select>
								</div>
							</div>
							<!--END-->
							<!--START-->
							<div class="filt-com lhs-ads">
								<ul>
									<li>
										<div class="ads-box">
											<a href=""> <span>Ad</span>
												<img src="<?= base_url('assets/images/ads/ads1.jpg') ?>" alt="">
											</a>
										</div>
									</li>
									<div class="ban-ati-com ads-det-page">
                                        <a href=""><span>Ad</span><img src="<?= base_url('assets/images/ads/ads1.jpg') ?>" alt=""></a>
								    </div>
								</ul>
							</div>
							<!--END-->
							<div class="all-list-filt-form form-position">
								<div class="tit">
									<h3>What service do you need? <span>BizBook will help you</span></h3>
								</div>
								<div class="hom-col-req">
									<div id="home_slide_enq_success" class="log" style="display: none;">
										<p>Your Enquiry Is Submitted Successfully!!!</p>
									</div>
									<div id="home_slide_enq_fail" class="log" style="display: none;">
										<p>Something Went Wrong!!!</p>
									</div>
									<div id="home_slide_enq_same" class="log" style="display: none;">
										<p>You cannot make enquiry on your own listing</p>
									</div>
									<form name="home_slide_enquiry_form" id="home_slide_enquiry_form" method="post" enctype="multipart/form-data">
										<input type="hidden" class="form-control" name="listing_id" value="0" placeholder="" required>
										<input type="hidden" class="form-control" name="listing_user_id" value="0" placeholder="" required>
										<input type="hidden" class="form-control" name="enquiry_sender_id" value="" placeholder="" required>
										<input type="hidden" class="form-control" name="enquiry_source" value="Website" placeholder="" required>
										<div class="form-group">
											<input type="text" name="enquiry_name" value="" required="required" class="form-control" placeholder="Enter name*">
										</div>
										<div class="form-group">
											<input type="email" class="form-control" placeholder="Enter email*" required="required" value="" name="enquiry_email" pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$" title="Invalid email address">
										</div>
										<div class="form-group">
											<input type="text" class="form-control" value="" name="enquiry_mobile" placeholder="Enter mobile number *" pattern="[7-9]{1}[0-9]{9}" title="Phone number starting with 7-9 and remaing 9 digit with 0-9" required="">
										</div>
										<div class="form-group">
											<textarea class="form-control" rows="3" name="enquiry_message" placeholder="Enter your query or message"></textarea>
										</div>
										<input type="hidden" id="source">
										<button type="submit" id="home_slide_enquiry_submit" name="home_slide_enquiry_submit" class="btn btn-primary">Submit Requirements</button>
									</form>
								</div>
							</div>
							<!-- END -->
							<div class="ban-ati-com ads-det-page">
                                <a href=""><span>Ad</span><img src="<?= base_url('assets/images/ads/ads1.jpg') ?>" alt=""></a>
							</div>
						</div>
					</div>
					<div class="col-md-9" style="margin-bottom:110px">
						<div class="f2">
							<div class="vfilter"> <i class="material-icons ic1 " title="Grid view">apps</i>
								<i class="material-icons ic2 act" title="List view">format_list_bulleted</i>
								<i class="material-icons ic3" title="Map view">location_on</i>
							</div>
						</div>
						<div class="ban-ati-com ads-all-list"> 
                            <a href="#"><span>Ad</span><img src="<?= base_url('assets/images/ads/3.png'); ?>" alt=""></a>
						</div>
							<!--ADS-->
						<!-- Loader Image -->
						<div id="loadingmessage" style="display:none">
							<div id="loadingmessage1">&nbsp;</div>
						</div>
						<!-- Loader Image -->
						<div class="all-list-sh all-listing-total">
							<ul>
								<?php 
									if(count($allListings) > 0){
										foreach ($allListings as $value) {
								?>	
								<li>
									<div class="eve-box">
										<!---LISTING IMAGE--->
										<div class="al-img"> <span class="open-stat">open</span>
											<a href="<?= base_url('user/listing-preview/'.$value->listing_slug); ?>">

                                                <img src="<?= (empty($value->listing_image)) ? base_url('assets/images/no_photo.jpg') :  base_url($value->listing_image);?>" alt="">
                                            </a>
										</div>
										<!---END LISTING IMAGE--->
										<!---LISTING NAME--->
										<div>
											<h4>
                                                <a href="<?= base_url('user/listing-preview/'.$value->listing_slug); ?>"><?= $value->listing_name; ?></a>
                                                <i class="li-veri"><img src="<?= base_url('assets/images/icon/svg/verified.png');?>" alt=""></i>
                                            </h4>

                                            <span class="addr"><?= ($value->display_address == 1) ? $value->listing_address:'[Address hidden]'; ?></span>
											<span class="pho"><?= ($value->display_phone == 1) ? $value->listing_mobile : '[Number hidden]'; ?></span>
											<span class="mail"><?= (empty($value->listing_email)) ? '[Not Available]' : $value->listing_email; ?></span>
											<div class="links">
                                                <!-- <a href="#" data-toggle="modal" data-target="#quote" class="quo">Get quote</a> -->
												<a href="<?= base_url('user/listing-preview/'.$value->listing_slug); ?>">View more</a>
												<?php if($value->display_phone == 1){ ?>
												<a href="Tel:<?= $value->listing_mobile;?>">Call Now</a>
												<a href="<?= 'https://wa.me/'.$value->listing_whatsapp;?>" class="what" target="_blank">WhatsApp</a>
												<?php } ?>
												
											</div>
										</div>
										<!---END LISTING NAME--->

									</div>
								</li>				

								<?php  } } else { ?>
									<div class="eve-box-full-width">
                                        <div class="top-section-container">
                                        	<div class="col2-body-col">
                                        		<div class="row">									    
                                        			<div class="top-category-container">
                                        				<div class="col-sm-12 col-md-12 col-lg-12">
                                        					<div class="top-module-title color-mb-bottom">Channels</div>
                                        				</div>
                                        				
                                        				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        					<div class="column-container top-bus-container">
                                        					    <div class="row">
                                        						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                        							<div class="top-category-links">
                                                    				<?php
                                                    				if($allCategories){
                                                    				    $i = 0;
                                                                        foreach($allCategories as $value){
                                                                        $i++;
                                                    				?>
                                        								
                                    									<li><h2 style="margin:0;"><a href="<?= base_url('user/all-listing/'.$value->category_id); ?>"><?= $value->category_name; ?></a></h2></li>
                                        							
                                        							<?php
                                        							    if($i %10 == 0){
                                        							?>
                                                							</div>
                                                						</div>
                                                						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                							<div class="top-category-links">
                                        							<?php    
                                        							    }
                                        							?>

                                        								
                                                                    <?php 
                                                                        }
                                                    				}
                                                    				?>
                                        								
                                        							</div>
                                        						</div>
                                        						
                                        						</div>
                                        					</div>
                                        				</div>
                                        			</div>
                                        		</div>
                                        	</div>
                                        </div>
									</div>
								<?php } ?>

								<div style="float: right">
								    <?php echo $link?>
								</div>	
							</ul>
							<!--ADS-->
							<div class="ban-ati-com ads-all-list"> 
                                <a href="#"><span>Ad</span><img src="<?= base_url('assets/images/ads/3.png') ?>" alt=""></a>
							</div>
							<!--ADS-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END -->
	<!-- START -->
	<section>
		<div class="list-map"> <span id="map-error-box" class="map-error-box" style="display:none;">!!! Oops No Listing with the Selected Category</span>
			<div class="list-map-resu map-view" id="map-view"></div>
			<div class="list-map-filt">
				<div class="map-fi-com map-fi-view">
					<div class="vfilter"> <i class="material-icons ic-map-1" title="Grid view">apps</i>
						<i class="material-icons ic-map-2" title="List view">format_list_bulleted</i>
						<i class="material-icons ic-map-3 act" title="Map view">layers</i>
					</div>
				</div>
				<div class="map-fi-com map-fi-cate">
					<select onChange="SubcategoryFilter1(this.value);" name="cat_check" id="cat_check1" class="cat_check chosen-select ">
						<option value="">Select Category</option>
						<option value="hotels-and-resorts">Hotels And Resorts</option>
						<option value="spa-and-facial">Spa and Facial</option>
						<option value="digital-products">Digital Products</option>
						<option value="pet-shop">Pet shop</option>
						<option value="hotel---food">Hotel & Food</option>
						<option value="wedding-halls">Wedding halls</option>
						<option selected value="real-estate">Real Estate</option>
						<option value="sports">Sports</option>
						<option value="education">Education</option>
						<option value="transportation">Transportation</option>
						<option value="electricals">Electricals</option>
						<option value="automobiles">Automobiles</option>
						<option value="hospitals">Hospitals</option>
					</select>
				</div>
				<div class="sub_cat_section1 map-fi-com map-fi-subcate">
					<select name="sub_cat_check" id="sub_cat_check1" class="sub_cat_check">
						<option value="">Select sub-category</option>
						<option value="22">Villas</option>
						<option value="21">Indepentant House</option>
						<option value="20">Plots and Lands</option>
					</select>
				</div>
				<!--        <div class="map-fi-com map-fi-rat">-->
				<!--            <select id="rating_check1" name="rating_check">-->
				<!--                <option value="">Select Rating</option>-->
				<!--                <option value="5">5 Star</option>-->
				<!--                <option value="4">4 Star</option>-->
				<!--                <option value="3">3 Star</option>-->
				<!--                <option value="2">2 Star</option>-->
				<!--                <option value="1">1 Star</option>-->
				<!--            </select>-->
				<!--        </div>-->
				<div class="map-fi-com map-fi-fea">
					<select id="city_check1" name="city_check">
						<option value="">Select City</option>
						<option value="10519">Toronto</option>
						<option value="1068">Vadodara</option>
						<option value="11">Akkarampalle</option>
						<option value="1131">Hisar</option>
						<option value="26">Balapur</option>
						<option value="114">Karnul</option>
						<option value="706">Delhi</option>
						<option value="707">New Delhi</option>
						<option value="3659">Chennai</option>
					</select>
				</div>
				<div class="map-fi-com map-fi-fea">
					<select id="feature_check1" name="feature_check">
						<option value="">Select Feature</option>
						<option value="trusted">Trusted services provider</option>
						<option value="premium">Premium services</option>
						<option value="verified">Verified services</option>
						<option value="trending">Trending services</option>
						<option value="offers">Offers and discounts</option>
						<option value="latest">Latest updated</option>
						<option value="likes">Most likes</option>
					</select>
				</div>
			</div>
		</div>
	</section>
	<!-- END -->

	