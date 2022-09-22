
<!-- START -->
<section class=" blog-head eve-head">
	<div class="container">
		<div class="blog-head-inn">
			<h1>Events</h1>
			<p>Here post your events, seminar, webinar, fetivals and more</p>
		</div>
		<div class="ban-search">
			<form>
				<ul>
					<li class="sr-sea">
						<input type="text" id="event-search" class="autocomplete" placeholder="Search event in your city...">
					</li>
				</ul>
			</form>
		</div>
	</div>
</section>
<!--END-->
<!-- START -->
<section class=" event-body">
	<div class="container">
		<div class="us-ppg-com">
			<ul id="intseres">
				<?php
				if(count($Allevent) > 0){
					foreach($Allevent as $event){
				?>
				<li>
					<div class="eve-box">
						<div>
							<a href="<?= base_url('user/event-details/'.$event->event_id);?>">
								<img src="<?= base_url($event->event_image);?>" alt=""> 
                                <span><?= date('M',strtotime($event->created_at)); ?><b><?= date('d',strtotime($event->created_at)); ?></b></span>
							</a>
						</div>
						<div>
							<h4>
                                <a href="<?= base_url('user/event-details/'.$event->event_id);?>"><?= $event->event_name ?></a>
                            </h4>
							<span class="addr"><?= $event->event_address ?></span>
							<span class="pho"> <?= $event->event_mobile ?> </span>
						</div>
						<div>
							<div class="auth">
								<img src="images/user/1.png" alt=""> <b>Hosted by</b>
								<br>
								<h4>Directory Finder</h4>
								<a target="_blank" href="event-details.html" class="fclick"></a>
							</div>
						</div>
					</div>
				</li>
				<?php } } ?>
			</ul>
		</div>
	</div>
</section>
<!--END-->
