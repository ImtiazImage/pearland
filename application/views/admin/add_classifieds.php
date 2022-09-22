<!-- START -->
<section>
  <div class="ad-com">
    <div class="ad-dash leftpadd">
     <section class="login-reg">
      <div class="container">
       <div class="row">
        <div class="login-main add-list posr">
         <div class="log-bor">&nbsp;</div>
         <span class="udb-inst">Add Classifieds</span>
         <div class="log log-1">
          <div class="login">
            <h4>Add Classifieds</h4>
            <form name="classifieds_form" id="classifieds_form" method="post" action="<?= base_url('admin/add-classifieds') ?>" enctype="multipart/form-data">
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
                        <option value="<?= $user->user_id; ?>"><?= $user->name; ?></option>

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
                        <input type="text" name="classifieds_title" required="required" class="form-control" placeholder="classifieds Title *">
                      </div>
                    </div>
                  </div>
                  <!--FILED END-->
                  <!--FILED START-->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="">Price</label>
                        <input type="text" name="classifieds_price" required="required" class="form-control" placeholder="Exp - 200">
                      </div>
                    </div>
                  </div>
                  <!--FILED END-->
                  
                  <!--FILED START-->

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <select onChange="getSubCategory(this.value);" name="classifieds_category_id" id="classifieds_category_id" class="form-control">
                          <option value="">Select Category</option>
                          <?php
                          if(count($all_classifieds_category) > 0){
                            foreach ($all_classifieds_category as $value) {
                              ?>
                              <option value="<?= $value->category_id;?>"><?= $value->category_name;?></option>
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
                    <div class="col-md-6">
                      <div>
                        <div class="chbox">
                          <input type="checkbox" id="featured_classifieds" name="featured_classifieds" value="1">
                          <label for="featured_classifieds">Featured Classifieds</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div>
                        <div class="chbox">
                          <input type="checkbox" id="spotlight_classifieds" name="spotlight_classifieds" value="1">
                          <label for="spotlight_classifieds">Spotlight Classifieds</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--FILED END-->  
                  <!--FILED START-->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="chbox">
                        <input type="checkbox" name="display_contact"  id="display_contact" value="1">
                          <label for="display_contact">Display Contact Information</label>
                      </div>
                    </div>
                  </div>
                  <!--FILED END-->

                  <!--FILED START-->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Classifieds Details</label>
                        <textarea name="classifieds_description" id="classifieds_description" required="required" class="form-control" placeholder="classifieds details"></textarea>
                      </div>
                    </div>
                  </div>
                  <!--FILED END-->
                  <!--FILED START-->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Choose Classifieds Image</label>
                        <input type="file" name="classifieds_image" class="form-control">
                      </div>
                    </div>
                  </div>
                  <!--FILED END-->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>SEO Title</label>
                        <input type="text" name="classifieds_seo_title" value="" placeholder=""  class="form-control">
                      </div>
                      <div class="form-group">
                        <label>SEO Keywords</label>
                        <input type="text" name="classifieds_seo_keywords" value=""  class="form-control" placeholder="i.e:wedding hall, best wedding hall">
                      </div>
                      <div class="form-group">
                        <label>SEO Descriptions</label>
                        <input type="text" name="classifieds_seo_description" value=""  class="form-control">
                      </div>
                    </div>
                  </div>  

                </li>
              </ul>
              <!--FILED START-->
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" name="classifieds_submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
              <!--FILED END-->
            </form>
            <div class="col-md-12">
              <a href="<?= base_url('admin/dashboard') ?>" class="skip">Go to Admin Dashboard >></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</div>
</div>
</section>
<!-- END -->    


<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>

<script src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace('classifieds_description');
</script>