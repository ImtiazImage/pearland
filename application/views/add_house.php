<!-- START -->
<section>
  <div class="ad-com">
    <div class="ad-dash leftpadd">
      <div class="login-reg">
        <div class="container">
          <form name="house_form" id="house_form" method="post" action="<?= base_url('user/add-house') ?>" enctype="multipart/form-data">
            <div class="row">
              <div class="login-main add-list posr">
                <div class="log-bor">&nbsp;</div>
                <span class="udb-inst">Add House For Sale</span>
                <div class="log log-1">
                  <div class="login">
                    <h4>Add House For Sale</h4>
                      <!--FILED START-->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="">Property Title</label>
                            <input type="text" value="<?= set_value('house_title');?>" name="house_title" required="required" class="form-control" placeholder="Property Title *">
                          </div>
                        </div>
                      </div>
                      <!--FILED END-->
                      <!--FILED START-->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="">house Price</label>
                            <input type="text" name="house_price" value="<?= set_value('house_price');?>" required="required" class="form-control" placeholder="Exp - 200">
                          </div>
                        </div>
                      </div>
                      <!--FILED END-->
                      <!--FILED START-->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <select onChange="getSubCategory(this.value);" name="house_category_id" id="house_category_id" class="form-control">
                              <option value="">Select A Category</option>
                              <?php
                              if(count($all_house_category) > 0){
                                foreach ($all_house_category as $value) {
                                  ?>
                                  <option value="<?= $value->category_id;?>" ><?= $value->category_name;?></option>
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
                              <input type="checkbox" id="featured_house" name="featured_house" value="1">
                              <label for="featured_house">Featured house</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div>
                            <div class="chbox">
                              <input type="checkbox" id="spotlight_house" name="spotlight_house" value="1">
                              <label for="spotlight_house">Spotlight house</label>
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
                            <label>Property Address </label>
                            <textarea name="house_address" id="house_address" required="required" class="form-control" placeholder="Property Address"> <?= set_value('house_address');?></textarea>
                          </div>
                        </div>
                      </div>
                      <!--FILED END-->
                      
                      <!--FILED START-->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Choose house Image</label>
                            <input type="file" name="house_image" class="form-control">
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
                  <span class="steps">General Property Information</span>
                  <div class="log add-list-map">
                    <div class="login add-list-map">
                      <!--FILED START-->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Property Description </label>
                            <textarea name="house_description" id="house_description" required="required" class="form-control" placeholder="Property details"></textarea>
                          </div>
                        </div>
                      </div>
                      <!--FILED END-->
                      <!--FILED START-->
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Bedroom(s) </label>
                            <input type="text" name="bedrooms" class="form-control" placeholder="Exp 2">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Living Area (Sq. Ft.)</label>
                            <input type="text" name="living_area" class="form-control" placeholder="Exp 2000">
                          </div>
                        </div> 
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Bathroom(s) </label>
                            <input type="text" name="bathroom" class="form-control" placeholder="Exp 2">
                          </div>
                        </div> 
                      </div>
                      <!--FILED END-->
                      <!--FILED START-->
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Property Age</label>
                            <input type="text" name="property_age" value="" placeholder="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Garage(s)</label>
                            <input type="text" name="garage" class="form-control" placeholder="Exp 2000">
                          </div>
                        </div> 
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="">Floors </label>
                            <input type="text" name="floors" class="form-control" placeholder="Exp 2">
                          </div>
                        </div> 
                      </div>
                      <!--FILED END-->
                      <!--FILED START-->
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <div>
                              <div class="chbox">
                                <input type="checkbox" id="rent_to_own" name="rent_to_own" value="1">
                                <label for="rent_to_own">Rent to Own?</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <div>
                              <div class="chbox">
                                <input type="checkbox" id="can_sublet" name="can_sublet" value="1">
                                <label for="can_sublet">Can Sublet? </label>
                              </div>
                            </div>
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
                  <span class="steps">SEO Setting</span>
                  <div class="log add-list-map">
                    <div class="login add-list-map">
                      <div class="form-group">
                        <label>Page title</label>
                        <input type="text" name="house_seo_title" value="" placeholder="" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Page keywords</label>
                        <input type="text" name="house_seo_keywords" value="" class="form-control" placeholder="i.e:wedding hall, best wedding hall">
                      </div>
                      <div class="form-group">
                        <label>Page descriptions</label>
                        <input type="text" name="house_seo_description" value="" class="form-control">
                      </div>
                      <!--FILED START-->
                      <div class="row">
                        <div class="col-md-12">
                          <button type="submit" name="house_submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                      <!--FILED END-->
                      <div class="col-md-12">
                        <a href="<?= base_url('user/dashboard') ?>" class="skip">Go to Admin Dashboard >></a>
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
  </section>
  <!-- END -->    

  <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>

  <script src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('house_description');
    CKEDITOR.replace('house_address');
  </script>