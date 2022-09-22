
	<section class="abou-pg commun-pg-main">
		<div class="about-ban comunity-ban">
			<h1>All Services</h1>
			<p>Connect with the right Service Experts</p>
			<input type="text" id="tail-se" placeholder="Search sub category here..">
		</div>
	</section>
	<!-- START -->
	<section>
		<div class="str all-cate-pg">
			<div class="container">
				<div class="row">
					<div class="sh-all-scat">
						<?php
						if(count($AllCategory) > 0){
							foreach($AllCategory as $category){
						?>
                        <ul id="tail-re">
							<li>
								<div class="sh-all-scat-box">
									<div class="lhs">
										<img src="<?= base_url($category->category_image);?>"  alt="">
									</div>
									<div class="rhs">
										<h4>
                                            <a href="<?= base_url('user/all-listing/'.$category->category_id) ?>"><?= $category->category_name; ?></a>
                                        </h4>
										<!-- <ol>
											<li> <a href="all-listing.html">Villas                                                        <span>87</span></a>
											</li>
											<li> <a href="all-listing.html">Indepentant House                                                        <span>45</span></a>
											</li>
											<li> <a href="all-listing.html">Plots and Lands                                                        <span>80</span></a>
											</li>
										</ol> -->
									</div>
								</div>
							</li>
						</ul>
						<?php } } ?>
					</div>
				</div>
			</div>
	</section>
	<!-- END -->
	<!-- START -->
	<!--<section>
    <div class="hom-ads">
        <div class="container">
            <div class="row">
                <div class="filt-com lhs-ads">
                    <div class="ads-box">
                        <a href="listing-details.html">
                            <span>Ad</span>
                            <img src="images/ads/ads2.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->
	<!-- END -->
	<script>
		$("#tail-se").on("keyup", function () {
		        var value = $(this).val().toLowerCase();
		        $(".sh-all-scat-box").filter(function () {
		            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		        })
		    });
	</script>
</body>

</html>