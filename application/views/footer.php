	<!-- START -->
	<span class="btn-ser-need-ani">Help & Support</span>
	<div class="ani-quo-form"> <i class="material-icons ani-req-clo">close</i>
		<div class="tit">
			<h3>What service do you need? <span>Pearland will help you</span></h3>
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
					<select name="enquiry_category" id="enquiry_category" class="form-control">
						<option value="">Select Category</option>
						<option value="19">Wedding halls</option>
						<option value="18">Hotel & Food</option>
						<option value="17">Pet shop</option>
						<option value="16">Digital Products</option>
						<option value="15">Spa and Facial</option>
						<option value="10">Real Estate</option>
						<option value="8">Sports</option>
						<option value="7">Education</option>
						<option value="6">Electricals</option>
						<option value="5">Automobiles</option>
						<option value="3">Transportation</option>
						<option value="2">Hospitals</option>
						<option value="1">Hotels And Resorts</option>
					</select>
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

	<!-- START -->
	<section>
		<div class="full-bot-book">
			<div class="container">
				<div class="row">
					<div class="bot-book">
						<div class="col-md-2 bb-img">
							<img src="<?= base_url() ?>assets/images/idea.png" alt="">
						</div>
						<div class="col-md-7 bb-text">
							<h4>#1 Business Directory and Service Provider</h4>
							<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
						</div>
						<div class="col-md-3 bb-link"> <a href="pricing-details.html">Add my business</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END -->
	<section class=" wed-hom-footer">
		<div class="container">
			<div class="row foot-supp">
				<h2><span>Free support:</span> +01 5426 24400 &nbsp;&nbsp;|&nbsp;&nbsp; <span>Email:</span>info@pearland411.com</h2>
			</div>
			<div class="row wed-foot-link">
				<div class="col-md-4 foot-tc-mar-t-o">
					<h4>Top Category</h4>
					<ul>
						<li><a href="all-listing.html">Digital Products</a>
						</li>
						<li><a href="all-listing.html">Spa and Facial</a>
						</li>
						<li><a href="all-listing.html">Real Estate</a>
						</li>
						<li><a href="all-listing.html">Sports</a>
						</li>
						<li><a href="all-listing.html">Education</a>
						</li>
						<li><a href="all-listing.html">Electricals</a>
						</li>
						<li><a href="all-listing.html">Automobiles</a>
						</li>
						<li><a href="all-listing.html">Transportation</a>
						</li>
					</ul>
				</div>
				<div class="col-md-4">
					<h4>Trending Category</h4>
					<p>Address: 28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A.</p>
					<p>Phone: <a href="tel:+01 5426 24400">+01 5426 24400</a>
					</p>
					<p>Email: <a href="mailto:rn53themes@gmail.com">rn53themes@gmail.com</a>
					</p>
					<a target="_blank" href="">
						<img src="<?= base_url() ?>assets/images/social/1.png" alt="">
					</a>
					<a target="_blank" href="https://twitter.com/Google?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor">
						<img src="<?= base_url() ?>assets/images/social/2.png" alt="">
					</a>
					<a target="_blank" href="https://www.facebook.com/Rn53themes-1956793534579530/">
						<img src="<?= base_url() ?>assets/images/social/3.png" alt="">
					</a>
					<a target="_blank" href="">
						<img src="<?= base_url() ?>assets/images/social/4.png" alt="">
					</a>
				</div>
				<div class="col-md-4">
					<h4>HELP &amp; SUPPORT</h4>
					<ul>
						<li><a href="about.html">About us</a>
						</li>
						<li><a href="faq.html">FAQ</a>
						</li>
						<li><a href="feedback.html">Feedback</a>
						</li>
						<li><a href="contact-us.html">Contact us</a>
						</li>
						<!--                    <li><a href="#">-->
							<!--</a>-->
							<!--                    </li>-->
						</ul>
					</div>
				</div>
				
			</div>
		</section>
		<!-- START -->
		<section>
			<div class="cr">
				<div class="container">
					<div class="row">
						<p>Copyright © 2022 <a href="#" target="_blank">Pearland411</a>. Proudly powered by <a href="https://www.spacecentersystems.com/" target="_blank">Space Center Systems</a>
						</p>
					</div>
				</div>
			</div>
		</section>
		<!-- END -->
		<!-- START -->
		<div class="fqui-menu">
			<ul>
				<li>
					<a href="index.html">
						<img src="<?= base_url() ?>assets/images/icon/home.png">Home</a>
					</li>
					<li><span class="mob-sear"><img src="<?= base_url() ?>assets/images/icon/search1.png">Search</span>
					</li>
					<li>
						<a href="all-category.html" class="act">
							<img src="<?= base_url() ?>assets/images/icon/shop.png">Services</a>
						</li>
						<li>
							<a href="events.html">
								<img src="<?= base_url() ?>assets/images/icon/calendar.png">Events</a>
							</li>

							<li>
								<a href="coupons.html">
									<img src="<?= base_url() ?>assets/images/icon/coupons.png">Coupons</a>
								</li>
								<li>
									<a href="blog-posts.html">
										<img src="<?= base_url() ?>assets/images/icon/blog1.png">Bolgs</a>
									</li>
								</ul>
							</div>
							<!-- END -->
							<!-- Optional JavaScript -->
							<!-- jQuery first, then Popper.js, then Bootstrap JS -->
							<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
							<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
							<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
							<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>	<script src="<?= base_url() ?>assets/js/select-opt.js"></script>

							<script src="<?= base_url('assets/js/bootstrap.min.js');?>"></script>
							<script src="<?= base_url('assets/js/jquery-ui.js');?>"></script>
							<script src="<?= base_url('assets/js/select-opt.js');?>"></script>
							<script src="<?= base_url() ?>assets/js/custom.js"></script>
							<script src="<?= base_url() ?>assets/js/jquery.validate.min.js"></script>
							<script src="<?= base_url() ?>assets/js/custom_validation.js"></script>	
							<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
							<!--DataTable-->
							<script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>	
							<script src="<?= base_url('assets/js/customCode.js'); ?>"></script>	
							<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>	
							<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

                            <script type="text/javascript">
                              $("#selectCategory").select2();
                            </script>
                                                    
                        	<script>
                        	    $( "#selectCategory" ).on('change',function() {
                                  var id = $('#selectCategory').val();
                                  window.location.replace('<?= base_url('user/all-listing/');?>'+id)
                                });
                        	</script>

							<script>
								$(window).scroll(function () {
									var scroll = $(window).scrollTop();
									if (scroll >= 250) {
										$(".hom-top").addClass("dmact");
									}
									else {
										$(".hom-top").removeClass("dmact");
									}
								});

								$('.owl-carousel').owlCarousel({
									loop:true,
									margin:10,
									autoplay:true,
									nav:true,
									responsive:{
										0:{
											items:1
										},
										600:{
											items:1
										},
										1000:{
											items:1
										}
									}
								});
							</script>
						</body>

						</html>