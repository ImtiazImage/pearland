<section class=" login-reg">
	<div class="container">
		<div class="row">
			<div class="login-main add-list">
				<div class="log-bor">&nbsp;</div> <span class="steps">Edit News</span>
				<div class="log">
					<div class="login add-list-off">
						<h4>Edit this News</h4>
						<?php if($this->session->flashdata('message')){ ?>
							<div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
						<?php } ?>		
						<form action="<?= base_url('admin/edit-news/'.$news->news_id); ?>" class="news_edit_form" id="news_edit_form" name="news_form" method="post" enctype="multipart/form-data">

							<ul>
								<li>
									<!--FILED START-->
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<select name="user_id" required="required" class="form-control" id="user_id">
													<option value="">Choose a user</option>
													<?php 
													if($users){
														foreach($users as $user){
															?>
															<option value="<?= $user->user_id; ?>" <?= ($news->user_id == $user->user_id) ? 'SELECTED' : '';?> ><?= $user->name; ?></option>
														<?php } } ?>
													</select>      
												</div>
											</div>
										</div>
										<!--FILED END-->

										<!--FILED START-->
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<input type="text" name="news_title" required="required" value="<?= set_value('news_title',$news->news_title);?>" class="form-control" placeholder="News Title*">
												</div>
												<span class="text-danger"><?= form_error("news_title")?form_error("news_title"):'' ;?></span>
											</div>
										</div>

										<!--FILED END-->
										<!--FILED START-->

										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<select onChange="getSubCategory(this.value);" name="news_category_id" id="news_category_id"  class="form-control">
														<option value="">Select Category</option>
														<?php
														if(count($all_news_category) > 0){
															foreach ($all_news_category as $value) {
																?>
																<option value="<?= $value->category_id;?>" <?= ($news->news_category_id == $value->category_id) ? 'SELECTED' : '';?>><?= $value->category_name;?></option>
																<?php 
															}
														}
														?>
													</select>
												</div>
											</div>
										</div>
										<!--FILED END-->
										<!--FILED START-->

										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<textarea name="news_description" id="news_description" required="required" class="form-control" placeholder="Post Details">
														<?= $news->news_description;?>
													</textarea>
												</div>

												<span class="text-danger"><?= form_error("news_description")?form_error("news_description"):'' ;?></span>

											</div>

										</div>

										<!--FILED END-->

										<!--FILED START-->

										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Choose News image</label>
													<input type="file" name="news_image" class="form-control">
												</div>
											</div>
										</div>

										<!--FILED END-->

										<!--FILED START-->

										<div class="row">
											<div class="col-md-12">
												<div>
													<div class="chbox">
														<input type="checkbox" name="featured_news" value="1"  id="featured_news" <?= $news->featured_news == '1' ? 'CHECKED': '' ?>>
														<label for="featured_news">Featured News</label>
													</div>
												</div>
											</div>
										</div>

										<!--FILED END-->

									</li>

								</ul>

								<!--FILED START-->

								<div class="row">

									<div class="col-md-12">

										<button type="submit" name="news_submit" class="btn btn-primary">Submit</button>

									</div>

									<div class="col-md-12"> <a href="<?= base_url('/admin/dashboard'); ?>" class="skip">Go to Admin Dashboard >></a>

									</div>

								</div>

								<!--FILED END-->

							</form>

						</div>

					</div>

				</div>

			</div>

		</div>

	</section>

	

	

	

	

	<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>



	<script src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>

	<script>

		CKEDITOR.replace('news_description');

	</script>