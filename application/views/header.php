<!doctype html>
	<html lang="en">
	<head>
		<title>Pearland411</title>
		<!--== META TAGS ==-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="theme-color" content="#76cef1" />
		<meta property="og:image" content="<?= base_url() ?>assets/images/pearland-logo.png" />
		<meta name="description" content="">
		<meta name="keyword" content="">

		<!--== FAV ICON(BROWSER TAB ICON) ==-->
		<link rel="shortcut icon" href="<?= base_url() ?>assets/images/fav.ico" type="image/x-icon">

		<!--== GOOGLE FONTS ==-->
		<link href="https://fonts.googleapis.com/css?family=Oswald:700|Source+Sans+Pro:300,400,600,700&display=swap" rel="stylesheet">

		<!--== WEB ICON FONTS ==-->
		<link rel="preload" as="font" href="css/icon.woff2" type="font/woff2" crossorigin="anonymous">

		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

		<!--== CSS FILES ==-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
		<link rel="stylesheet" href="<?= base_url() ?>assets/css/fonts.css">

		<!--DataTable-->
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>

    <script src="js/html5shiv.js"></script>

    <script src="js/respond.min.js"></script>

  <![endif]-->
  </head>
  <body>
  	<!-- START -->
  	<section>
  		<div class="str">
  			<?php
  			if(current_url() == base_url()){
  				?>
  				<div class="hom-head" >
  					<?php 
  				}else{ ?>
  					<div>
  					<?php } ?>
  					<style>
  						.mt5{

  							margin-top: 5px;

  						}

  					</style>
  					<div class="hom-top">
  						<div class="container">
  							<div class="row">
  								<div class="hom-nav  db-open ">
  									<!--MOBILE MENU-->
  									<a href="<?= base_url();?>" class="top-log">
  										<img src="<?= base_url() ?>assets/images/pearland-logo.png" alt="" class="ic-logo">
  									</a>
  									<div class="mt30">
  										<div class="menu">
  											<h4>All Category</h4>
  										</div>
  										<div class="pop-menu">
  											<div class="container">
  												<div class="row"> <i class="material-icons clopme">close</i>
  													<div class="pmenu-spri">
  														<ul>
  															<li>
  																<a href="<?= base_url('all_category') ?>" class="act"><img src="<?= base_url() ?>assets/images/icon/shop.png">All Services</a>
  															</li>
  															<li>
  																<a href="<?= base_url('event') ?>">

  																	<img src="<?= base_url() ?>assets/images/icon/calendar.png">Events</a>

  																</li>

  																<li>

  																	<a href="<?= base_url('all_products') ?>">

  																		<img src="<?= base_url() ?>assets/images/icon/cart.png">Products</a>

  																	</li>

  																	<li>

  																		<a href="#">

  																			<img src="<?= base_url() ?>assets/images/icon/coupons.png">Coupon & deals</a>

  																		</li>

  																		<li>

  																			<a href="<?= base_url('all_blog') ?>">

  																				<img src="<?= base_url() ?>assets/images/icon/blog1.png">Blogs</a>

  																			</li>

  																			<li>

  																				<a href="#">

  																					<img src="<?= base_url() ?>assets/images/icon/11.png">Community</a>

  																				</li>

  																			</ul>

  																		</div>

  																		<div class="pmenu-cat">

  																			<h4>All Categories</h4>

  																			<input type="text" id="pg-sear" placeholder="Search category">

  																			<ul id="pg-resu">



  																				<li><a href="<?= base_url('user/all-listing/39'); ?>">Business - <span>5318</span></a>

  																				</li>



  																			</ul>

  																		</div>

  																		<div class="dir-home-nav-bot">

  																			<ul>

  																				<li>A few reasons you’ll love Online Business Directory <span>Call us on: +01 6214 6548</span> 

  																				</li>

  																				<li><a href="post-your-ads.html.html" class="waves-effect waves-light btn-large"><i class="material-icons">font_download</i> Advertise with us</a>

  																				</li>

  																				<li>

  																					<a href="<?= base_url() ?>pricing_n" class="waves-effect waves-light btn-large"> <i class="material-icons">store</i> Add your business</a>

  																				</li>

  																			</ul>

  																		</div>

  																	</div>

  																</div>

  															</div>

  															<!--END MOBILE MENU-->

  															<div class="top-ser">

  																<form name="filter_form" id="filter_form" class="filter_form">

  																	<ul>

  																		<li class="sr-sea">

  																			<input type="text" autocomplete="off" id="top-select-search" placeholder="Search for services and business...">

  																		</li>

  																		<li class="sbtn">

  																			<button type="button" class="btn btn-success" id="top_filter_submit"><i class="material-icons">&nbsp;</i>

  																			</button>

  																		</li>

  																	</ul>

  																</form>



  															</div>







  															<?php



  															if (!isset($_SESSION['logged_user']) && empty($_SESSION['logged_user'])) { ?>



  																<ul class="bl">

  																	<!-- <li><div id="google_translate_element"></div></li> -->

  																	<li><a href="<?= base_url() ?>pricing_n">Add business</a></li>



  																	<li><a href="<?= base_url() ?>login">Sign In</a></li>



  																	<li><a href="<?= base_url() ?>register">Create an account</a></li>



  																</ul>



  															<?php } else { ?>

	                <!-- <ul class="bl">

                  	<li><div id="google_translate_element"></div></li>

                  </ul>	 -->

                  <div class="al">

                  	<div class="head-pro">

                  		<img src="<?= base_url() ?>assets/images/user/62736rn53themes.png" alt=""> <b>Profile by</b>

                  		<br>

                  		<h4>Rn53 Themes</h4>

                  		<a href="#" class="fclick"></a>

                  	</div>

                  	<div class="db-menu">

                  		<ul>

                  			<li>

                  				<a href="<?= base_url('dashboard') ?>" class="db-lact">

                  					<img src="<?= base_url() ?>assets/images/icon/dbl1.png" alt="" />My Dashboard</a>

                  				</li>

                  				<li>

                  					<a href="<?= base_url('user-listing') ?>">

                  						<img src="<?= base_url() ?>assets/images/icon/dbl7.png" alt="" />All Listings</a>

                  					</li>

                  					<li>

                  						<a href="<?= base_url('user/add_new_listing_start') ?>" class="tz-lma">

                  							<img src="<?= base_url() ?>assets/images/icon/dbl3.png" alt="" />Add New Listing</a>

                  						</li>

                  						<li>

                  							<a href="<?= base_url('user-events') ?>">

                  								<img src="<?= base_url() ?>assets/images/icon/dbl4.png" alt="" />Events</a>

                  							</li>

                  							<li>

                  								<a href="<?= base_url('blog-list') ?>">

                  									<img src="<?= base_url() ?>assets/images/icon/dbl10.png" alt="" />Blog posts</a>

                  								</li>

                  								<li>

                  									<a href="<?= base_url('logout') ?>">

                  										<img src="<?= base_url() ?>assets/images/icon/dbl12.png" alt="" />Log Out</a>

                  									</li>

                  								</ul>

                  							</div>

                  						</div>



                  					<?php } ?>

                  				</div>

                  				<script type="text/javascript">

									/*function googleTranslateElementInit() {

									  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');

									}*/

								</script>



								<!-- <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->



								

								<!--MOBILE MENU-->

								<div class="mob-menu">

									<div class="mob-me-ic"><i class="material-icons">menu</i>

									</div>

									<div class="mob-me-all">

										<div class="mob-me-clo"><i class="material-icons">close</i>

										</div>

										<div class="mv-pro ud-lhs-s1">

											<img src="<?= base_url() ?>assets/images/user/62736rn53themes.png" alt="">

											<h4>Rn53 Themes</h4>

											<b>Join on 26, Mar 2021</b>

										</div>

										<div class="mv-pro-menu ud-lhs-s2">

											<ul>

												<li>

													<a href="<?= base_url() ?>dashboard" class="">

														<img src="<?= base_url() ?>assets/images/icon/dbl1.png" alt="" />My Dashboard</a>

													</li>

													<li>

														<a href="<?= base_url() ?>user_listing" class="">

															<img src="<?= base_url() ?>assets/images/icon/shop.png" alt="" />All Listings</a>

														</li>

														<li>

															<a href="<?= base_url() ?>add_listing_start">

																<img src="<?= base_url() ?>assets/images/icon/dbl3.png" alt="" />Add New Listing</a>

															</li>

															<li>
																<a href="<?= base_url() ?>user_enquiry" class=""><img src="<?= base_url() ?>assets/images/icon/tick.png" alt="" />Lead enquiry</a>

															</li>

															<li>

																<a href="<?= base_url() ?>user_products" class="">

																	<img src="<?= base_url() ?>assets/images/icon/cart.png" alt="" />All Products</a>

																</li>

																<li>

																	<a href="<?= base_url() ?>user_events" class="">

																		<img src="<?= base_url() ?>assets/images/icon/calendar.png" alt="" />Events</a>

																	</li>

																	<li>

																		<a href="<?= base_url() ?>user_blog_posts" class="">

																			<img src="<?= base_url() ?>assets/images/icon/blog1.png" alt="" />Blog posts</a>

																		</li>

																		<li>

																			<a href="<?= base_url() ?>user_coupons" class="">

																				<img src="<?= base_url() ?>assets/images/icon/coupons.png" alt="" />Coupons</a>

																			</li>

																			<li>

																				<a href="<?= base_url() ?>my_profile" class="">

																					<img src="<?= base_url() ?>assets/images/icon/dbl6.png" alt="" />My Profile</a>

																				</li>



																				<li>

																					<a href="<?= base_url() ?>logout">

																						<img src="<?= base_url() ?>assets/images/icon/dbl12.png" alt="" />Log Out</a>

																					</li>

																				</ul>

																			</div>

																		</div>

																	</div>

																	<!--END MOBILE MENU-->

																</div>

															</div>

														</div>

													</div>

													

												</div>

											</div>

										</section>

										<!-- END -->

										<section class="news-top-menu">

											<div class="container">

												<div class="row">

													<div class="news-menu">

														<ul>

															<li><a href="<?= base_url() ?>" class="act">Home</a></li>

															<li><a href="<?= base_url() ?>listing_list_n" class="">Directory</a></li>

															<li><a href="<?= base_url() ?>listing_list_n" class="">Events</a></li>

															<li><a href="<?= base_url() ?>listing_list_n" class="">News</a></li>

															<li><a href="<?= base_url() ?>listing_list_n" class="">Videos</a></li>

                              <li><a href="<?= base_url() ?>listing_list_n" class="">Classifieds</a></li>

															<li><a href="<?= base_url() ?>listing_list_n" class="">Sports</a></li>

															<li><a href="<?= base_url() ?>listing_list_n" class="">Health</a></li>

															<li><a href="<?= base_url() ?>listing_list_n" class="">Video</a></li>

															<li><a href="<?= base_url() ?>listing_list_n" class="">Others</a></li>

														</ul>

													</div>

												</div>

											</div>

										</section>