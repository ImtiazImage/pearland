<!-- START -->

<section>
  <div class="ad-com">
    <div class="ad-dash leftpadd">
      <div class="ud-cen">
        <div class="log-bor">&nbsp;</div>
        <span class="udb-inst">All Listing Details</span>
        <?php if($this->session->flashdata('message')){ ?>
          <div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
        <?php } ?>                
        <div class="ud-cen-s2">

          <h2>Listing details</h2>
          <div class="ad-int-sear">
            <input type="text" id="pg-sear" placeholder="Search this page..">
          </div>
          <a href="<?= base_url() ?>admin/add-listing-scratch" class="db-tit-btn">Add new listing</a>

          <table class="responsive-table bordered" id="pg-resu">
            <thead>
              <tr>
                <th>No</th>
                <th>Listing Name</th>
                <th>Category</th>
                <th>Postal Code</th>
                <th>Views</th>
                <th>Created by</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Preview</th>
              </tr>
            </thead>

            <tbody>

              <?php

              if (count($AllListings) > 0) {

                $i = 1;

                foreach ($AllListings as $value) {

                  ?>

                  <tr>

                    <td><?= $i; ?></td>

                    <td>
                      <img src="<?=  (empty($value->listing_image)) ? base_url('assets/images/no_photo.jpg') :  base_url($value->listing_image)?>"><?= $value->listing_name; ?><span><?= date('d, M Y',strtotime($value->created_at));?></span>

                      <td><span class="db-list-rat"><?= $value->category_name ?></span></td>
                      <td><span class="db-list-rat"><?= $value->postal_code ?></span></td>

                      <td><span class="db-list-rat">0</span> </td>

                      <td>
                         <?= $value->name; ?>
                       </td>


                       <td>



                        <?php if ($value->listing_status == 0) { ?>

                          <button class="db-list-ststus" onclick="updateStatus(1,<?= $value->listing_id;?>)">In-Active</button>

                        <?php } else { ?>

                          <button class="db-list-ststus" onclick="updateStatus(0,<?= $value->listing_id;?>)">Active</button>

                        <?php } ?>

                        <input type="hidden" id="updateField" value="listing_status">

                        <input type="hidden" id="tableName" value="listings">

                        <input type="hidden" id="tableIdName" value="listing_id">

                        <input type="hidden" id="id" value="<?= $value->listing_id;?>">

                      </td>  


                      <td><a href="<?= base_url('admin/edit-listing/'.$value->listing_slug); ?>" class="db-list-edit">Edit</a></td>
                      <td><a href="#" onclick="javascript:deleteConfirm('<?php echo base_url().'admin/delete-listing/'.$value->listing_slug;?>');" class="db-list-edit" >Delete</a></td>
                      <td><a href="<?= base_url('admin/listing-preview/'.$value->listing_slug); ?>" class="db-list-edit" target="_blank">Preview</a></td>
                      <!-- 'admin/listing-preview/'.$value->listing_id -->
                    </tr>                               

                    <?php       

                    $i++;   

                  }

                }

                ?> 

              </tbody>

               </table>

             </div>



             <div class="float-right">

              <?= $link; ?>

            </div>

          </div>

          <div class="ad-pgnat">

            <ul class="pagination">

              <li class="page-item"><a class="page-link" href="#">Previous</a></li>

              <li class="page-item active"><a class="page-link" href="#">1</a></li>

              <li class="page-item"><a class="page-link" href="#">2</a></li>

              <li class="page-item"><a class="page-link" href="#">3</a></li>

              <li class="page-item"><a class="page-link" href="#">Next</a></li>

            </ul>

          </div>

        </div>

      </div>

    </section>

    <!-- END -->

    <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>