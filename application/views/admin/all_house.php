<!-- START -->
<section>
  <div class="ad-com">
    <div class="ad-dash leftpadd">
      <div class="ud-cen">
        <div class="log-bor">&nbsp;</div>
        <span class="udb-inst">House For Sale</span>
        <div class="ud-cen-s2">
          <h2>House For Sale List</h2>
          <div class="ad-int-sear">
            <input type="text" id="pg-sear" placeholder="Search this page..">
          </div>
          <a href="<?= base_url('admin/add-house');?>" class="db-tit-btn">Add House For Sale</a>

          <?php if($this->session->flashdata('message')){ ?>
            <div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
          <?php } ?>  
          <table class="responsive-table bordered" id="pg-resu">
           <thead>
            <tr>
             <th>No</th>
             <th>House Title</th>
             <th>Category</th>
             <th>Created by</th>
             <th>Views</th>
             <th>Status</th>
             <th>Edit</th>
             <th>Delete</th>
             <th>Preview</th>
           </tr>
         </thead>
         <tbody>
          <?php
            if ($houseList != NULL) {
              $i = 1;
              foreach ($houseList as $house) {
          ?>              
          <tr>
            <td><?= $i; ?></td>
            <td>
              <img src="<?=  (empty($house->house_image)) ? base_url('assets/images/no_photo.jpg') :  base_url($house->house_image)?>"><?= $house->house_title; ?><span><?= date('d, M Y',strtotime($house->created_at));?></span>
            </td>
            <td><a href="" class="db-list-ststus" target="_blank"><?= $house->category_name ?></a></td>
            <td><a href="" class="db-list-ststus" target="_blank"><?= $house->name; ?></a></td>
            <td><a href="" class="db-list-ststus" target="_blank">0</a></td>
            <td>
              <?php if ($house->house_status == 0) { ?>
                  <button class="db-list-ststus" onclick="updateStatus(1,<?= $house->house_id;?>)">In-Active</button>
              <?php } else { ?>
                  <button class="db-list-ststus" onclick="updateStatus(0,<?= $house->house_id;?>)">Active</button>
              <?php } ?>

              <input type="hidden" id="updateField" value="house_status">
              <input type="hidden" id="tableName" value="house">
              <input type="hidden" id="tableIdName" value="house_id">
              <input type="hidden" id="id" value="<?= $house->house_id;?>">
            </td>  

            <td>
              <a href="<?= base_url('admin/edit-house/'.$house->house_id); ?>" class="db-list-edit">Edit</a>
            </td>
            <td>
              <a href="#" onclick="javascript:deleteConfirm('<?php echo base_url().'admin/delete-house/'.$house->house_id;?>');" class="db-list-edit">Delete</a>
            </td>
            <td><a href="<?= base_url('admin/house-details/'.$house->house_id); ?>" class="db-list-edit" target="_blank">Preview</a></td>
          </tr>
          <?php 
            $i++;   
              }
            } else {
          ?>
            <tr>
              <td colspan="5"> <strong class="text-red">No house Available!!</strong></td>
            </tr>
          <?php } ?>            
        </tbody>
      </table>
    </div>

  </div>
<!--   <div class="ad-pgnat">
    <ul class="pagination">
      <li class="page-item"><a class="page-link" href="#">Previous</a></li>
      <li class="page-item active"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
  </div> -->
</div>
</div>
</section>
<!-- END -->    

