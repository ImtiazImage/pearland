<!-- START -->
<section>
  <div class="ad-com">
    <div class="ad-dash leftpadd">
      <div class="ud-cen">
        <div class="log-bor">&nbsp;</div>
        <span class="udb-inst">Classifieds</span>
        <div class="ud-cen-s2">
          <h2>Classifieds List</h2>
          <a href="<?= base_url('user/add-classifieds');?>" class="db-tit-btn">Add classifieds</a>

          <?php if($this->session->flashdata('message')){ ?>
            <div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
          <?php } ?>  
          <table class="responsive-table bordered" id="pg-resu">
           <thead>
            <tr>
             <th>No</th>
             <th>classifieds Title</th>
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
            if ($classifiedsList != NULL) {
              $i = 1;
              foreach ($classifiedsList as $classifieds) {
          ?>              
          <tr>
            <td><?= $i; ?></td>
            <td>
              <img src="<?=  (empty($classifieds->classifieds_image)) ? base_url('assets/images/no_photo.jpg') :  base_url($classifieds->classifieds_image)?>"><?= $classifieds->classifieds_title; ?><span><?= date('d, M Y',strtotime($classifieds->created_at));?></span>
            </td>
            <td><a href="" class="db-list-ststus" target="_blank"><?= $classifieds->category_name ?></a></td>
            <td><a href="" class="db-list-ststus" target="_blank"><?= $classifieds->name; ?></a></td>
            <td><a href="" class="db-list-ststus" target="_blank">0</a></td>
            <td>
              <span class="db-list-ststus">
                <?= $classifieds->classifieds_status == 1 ? 'Active' : 'Inactive';?>
              </span>
            </td>  

            <td>
              <a href="<?= base_url('user/edit-classifieds/'.$classifieds->classifieds_id); ?>" class="db-list-edit">Edit</a>
            </td>
            <td>
              <a href="#" onclick="javascript:deleteConfirm('<?php echo base_url().'user/delete-classifieds/'.$classifieds->classifieds_id;?>');" class="db-list-edit">Delete</a>
            </td>
            <td><a href="<?= base_url('user/classifieds-details/'.$classifieds->classifieds_id); ?>" class="db-list-edit" target="_blank">Preview</a></td>
          </tr>
          <?php 
            $i++;   
              }
            } else {
          ?>
            <tr>
              <td colspan="5"> <strong class="text-red">No Classifieds Available!!</strong></td>
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

