<!-- START -->
<section>
  <div class="ad-com">
    <div class="ad-dash leftpadd">
      <div class="ud-cen">
        <div class="log-bor">&nbsp;</div>
        <span class="udb-inst">Rental</span>
        <div class="ud-cen-s2">
          <h2>Rental List</h2>
          <a href="<?= base_url('user/add-rental');?>" class="db-tit-btn">Add Rental</a>

          <?php if($this->session->flashdata('message')){ ?>
            <div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
          <?php } ?>  
          <table class="responsive-table bordered" id="pg-resu">
           <thead>
            <tr>
             <th>No</th>
             <th>rental Title</th>
             <th>Category</th>
             <!-- <th>Views</th> -->
             <th>Status</th>
             <th>Edit</th>
             <th>Delete</th>
             <th>Preview</th>
           </tr>
         </thead>
         <tbody>
          <?php
            if ($rentalList != NULL) {
              $i = 1;
              foreach ($rentalList as $rental) {
          ?>              
          <tr>
            <td><?= $i; ?></td>
            <td>
              <img src="<?=  (empty($rental->rental_image)) ? base_url('assets/images/no_photo.jpg') :  base_url($rental->rental_image)?>"><?= $rental->rental_title; ?><span><?= date('d, M Y',strtotime($rental->created_at));?></span>
            </td>
            <td><a href="" class="db-list-ststus" target="_blank"><?= $rental->category_name ?></a></td>
            <!-- <td><a href="" class="db-list-ststus" target="_blank">0</a></td> -->
            <td>
              <span class="db-list-ststus">
                <?= $rental->rental_status == 1 ? 'Active' : 'In-active';?>
              </span>              
            </td>  

            <td>
              <a href="<?= base_url('user/edit-rental/'.$rental->rental_id); ?>" class="db-list-edit">Edit</a>
            </td>
            <td>
              <a href="#" onclick="javascript:deleteConfirm('<?php echo base_url().'user/delete-rental/'.$rental->rental_id;?>');" class="db-list-edit">Delete</a>
            </td>
            <td><a href="<?= base_url('user/rental-details/'.$rental->rental_id); ?>" class="db-list-edit" target="_blank">Preview</a></td>
          </tr>
          <?php 
            $i++;   
              }
            } else {
          ?>
            <tr>
              <td colspan="5"> <strong class="text-red">No Rental Available!!</strong></td>
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

