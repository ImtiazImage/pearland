
	<!-- START -->
	<section class=" blog-head">
		<div class="container">
			<div class="blog-head-inn">
				<h1>Blog posts</h1>
				<p>Here submit your blogs and make your own audiance.</p>
			</div>
			<div class="ban-search">
				<form>
					<ul>
						<li class="sr-sea">
							<input type="text" id="blog-search" class="autocomplete" placeholder="Search blog posts...">
						</li>
					</ul>
				</form>
			</div>
		</div>
	</section>
	<!--END-->
	<!-- START -->
	<section class=" blog-body">
		<div class="container">
			<div class="us-ppg-com us-ppg-blog">
				<ul id="intseres">
					<?php
					if(count($AllBlog) > 0){
						foreach($AllBlog as $blog){
					?>
					<li>
						<div class="pro-eve-box">
							<div>
								<img src="<?= base_url($blog->blog_image);?>" alt="">
							</div>
							<div>
								<p><?= date('d, M Y',strtotime($blog->created_at)); ?></p>
								<h2><?= $blog->blog_name; ?></h2>
							</div> <a href="<?= base_url('user/blog-details/'.$blog->blog_id);?>" class="fclick">&nbsp;</a>
						</div>
					</li>
					<?php } }?>
				</ul>
			</div>
		</div>
	</section>
	<!--END-->