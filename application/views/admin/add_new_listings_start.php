<!-- START -->
<section>
  <div class="ad-com">
    <div class="ad-dash leftpadd">
      <div class="login-reg">
        <div class="container">
          <form action="" class="listing_form" id="listing_form" name="listing_form" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="login-main add-list posr">
              <div class="log-bor">&nbsp;</div>
              <span class="udb-inst">step 1</span>
              <div class="log log-1">

                <div class="login">

                  <h4>Listing Details</h4>
                  <!--FILED START-->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <select name="user_id" class="form-control" required="required">
                          <option value="" disabled selected>User Name</option>
                          <?php
                          if(count($users) > 0){
                            foreach ($users as $value) {
                              ?>
                              <option value="<?= $value->user_id;?>"><?= $value->name;?></option>

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
                        <input id="listing_name" name="listing_name" type="text" required="required" class="form-control" placeholder="Listing name *">
                      </div>
                    </div>
                  </div>

                  <!--FILED END-->
                  <!--FILED START-->
                  <div class="row">
                    <div class="col-md-6">
                      <div>
                        <div class="chbox">
                          <input type="checkbox" id="featured_listing" name="featured_listing" value="1">
                          <label for="featured_listing">Featured Listing</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div>
                        <div class="chbox">
                          <input type="checkbox" id="spotlight_listing" name="spotlight_listing" value="1">
                          <label for="spotlight_listing">Spotlight Listing</label>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  <!--FILED END-->
                  <!--FILED START-->

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <select onChange="getSubCategory(this.value);" name="category_id" id="category_id" class="form-control">
                          <option value="">Select Category</option>
                          <?php
                          if(count($categories) > 0){
                            foreach ($categories as $value) {
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
                    <div class="col-md-12">
                      <div class="form-group">
                        <select  data-placeholder="Select Sub Category" name="sub_category_id" id="sub_category_id"  class="chosen-select form-control">
                        </select>
                      </div>
                    </div>
                  </div>

                  <!--FILED END-->
                  <!--FILED START-->

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" name="listing_mobile" class="form-control" placeholder="Phone number">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" name="listing_whatsapp" class="form-control" placeholder="Whatsapp Number">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label class="col-sm-4">Display Phone Number?</label>
                        <div class="col-sm-4">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="display_phone" id="display_phone" value="1">
                            <label class="form-check-label" >Yes</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="display_phone" id="display_phone" value="0">
                            <label class="form-check-label" >No</label>
                          </div>
                        </div>
                      </div>
                    </div>    
                  </div>
                  <!--FILED END-->
                  <!--FILED START-->

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <select name="county_name" id="" class="form-control">
                          <option value="">Choose a County</option>
                          <option value="Brazoria">Brazoria</option>
                          <option value="Fort Bend">Fort Bend</option>
                          <option value="Harris">Harris</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <select name="postal_code" id="" class="form-control">
                          <option value="">Choose a Postal Code</option>
                          <option value="77584">77584</option>
                          <option value="77581">77581</option>
                          <option value="77588">77588</option>
                          <option value="77047">77047</option>
                          <option value="77089">77089</option>
                        </select>
                      </div>
                    </div>   
                  </div>
                  <!--FILED END-->
                  <!--FILED START-->

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" name="listing_lat" class="form-control" placeholder="Latitude i.e 40.730610">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" name="listing_lng" class="form-control" placeholder="Longitude i.e -73.935242">
                      </div>
                    </div>   
                  </div>
                  <!--FILED END-->
                  <!--FILED START-->

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="email" name="listing_email" class="form-control" placeholder="Email id">
                      </div>
                    </div>
                  </div>

                  <!--FILED END-->

                  <!--FILED START-->

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" name="listing_website" class="form-control" placeholder="Website(www.website.com)">
                      </div>
                    </div>
                  </div>
                  <!--FILED END-->

                  <!--FILED START-->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" name="listing_address" required="required" class="form-control" placeholder="Business address">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label class="col-sm-4">Display Address?</label>
                        <div class="col-sm-4">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="display_address" value="1" id="display_phone">
                            <label class="form-check-label" >Yes</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="display_address" value="0" id="display_phone">
                            <label class="form-check-label" >No</label>
                          </div>
                        </div>
                      </div>
                    </div> 
                  </div>
                  <!--FILED END-->
                  <!--FILED START-->

                  <div class="row">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Details about your listing</label>
                        <textarea class="form-control" id="listing_description" name="listing_description" placeholder="Details about your listing"></textarea>
                      </div>
                    </div>
                  </div>
                  <!--FILED END-->
                  <!--FILED START-->

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea class="form-control" id="service_locations" name="service_locations" placeholder="Enter your service locations... &#10;(i.e) Pearland,Arlington, Austin"></textarea>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea class="form-control" id="service_offered" name="service_offered" placeholder="Enter Offered Services ... &#10;(i.e) Car Wash, Car Service"></textarea>
                      </div>
                    </div>
                    
                  </div>
                  <!--FILED END-->
                </div>

              </div>

            </div>

          </div>
          <div class="row">
            <div class="login-main add-list">
              <div class="log-bor">&nbsp;</div>
              <span class="steps">Step 2</span>
              <div class="log add-list-map">
                <div class="login add-list-map">
                  <h4 class="pt30">Photo gallery</h4>
                  <!--FILED START-->

                  <!--FILED START-->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Upload Listing Logo</label>
                        <input type="file" name="listing_profile_image" class="form-control">
                      </div>
                    </div>
                  </div>
                  <!--FILED END-->
                  <h4>Video Gallery</h4>
                  <ul>
                    <li>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <textarea id="listing_video" name="listing_video" class="form-control" placeholder="Paste Your Youtube Url here"></textarea>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="login-main add-list">
              <div class="log-bor">&nbsp;</div>
              <span class="steps">SEO Setting</span>
              <div class="log add-list-map">

                <div class="login add-list-map">
                    <div class="form-group">
                      <label>Page title</label>
                      <input type="text" name="listing_seo_title" value="" placeholder=""  class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Page keywords</label>
                      <input type="text" name="listing_seo_keywords" value=""  class="form-control" placeholder="i.e:wedding hall, best wedding hall">
                    </div>
                    <div class="form-group">
                      <label>Page descriptions</label>
                      <input type="text" name="listing_seo_description" value=""  class="form-control">
                    </div>
                </div>
              </div>
            </div>
          </div>
            <div class="row">
              <div class="login-main add-list">
                <div class="log">
                  <div class="login add-lis-oth">


                    <!--FILED START-->

                    <div class="row">
                      <div class="col-md-12">
                        <button type="submit" name="listing_submit" class="btn btn-primary">Submit Listing</button>
                      </div>
                      <div class="col-md-12">
                        <a href="profile.html" class="skip">Go to Dashboard >></a>
                      </div>
                    </div>

                  </div>

                </div>



              </div>

            </div>

          </form>





        </div>

      </div>

    </div>

  </div>

</section>

<!-- END -->



<script src="../js/select-opt.js"></script>

<script>

  function getSubCategory(val) {

    $.ajax({

      type: "POST",

      url: '<?=base_url()?>/admin/get_listing_sub_category',

      data: 'category_id=' + val,

      success: function (data) {

        $("#sub_category_id").html(data);

        $('#sub_category_id').trigger("chosen:updated");

      }

    });

  }

</script>

<script src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>

<script>

  CKEDITOR.replace('listing_description');

</script>

