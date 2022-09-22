 

<!-- START -->
<section>
  <div class="ad-com">
    <div class="ad-dash leftpadd">
      <div class="ud-cen">
        <div class="log-bor">&nbsp;</div>
        <span class="udb-inst">Blogs</span>
        <div class="ud-cen-s2">
          <h2>Blog post details</h2>
          <div class="ad-int-sear">
            <input type="text" id="pg-sear" placeholder="Search this page..">
          </div>
          <a href="<?= base_url('admin/add-blog');?>" class="db-tit-btn">Add new post</a>

          <?php if($this->session->flashdata('message')){ ?>
            <div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
          <?php } ?>  
          <table class="responsive-table bordered" id="pg-resu">
           <thead>
            <tr>
             <th>No</th>
             <th>Post Name</th>
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
            if ($blogList != NULL) {
              $i = 1;
              foreach ($blogList as $blog) {
          ?>              
          <tr>
            <td><?= $i; ?></td>
            <td>
              <?= $blog->blog_name; ?> 
              <span><?= date('d, M Y',strtotime($blog->created_at)); ?></span>
            </td>
            <td><a href="http://localhost/directory/bizbook/profile/rn53-themes" class="db-list-ststus" target="_blank">Rn53 Themes</a></td>
            <td><span class="db-list-rat">15</span></td>

            <td>
              <?php if ($blog->blog_status == 0) { ?>
                  <button class="db-list-ststus" onclick="updateStatus(1,<?= $blog->blog_id;?>)">In-Active</button>
              <?php } else { ?>
                  <button class="db-list-ststus" onclick="updateStatus(0,<?= $blog->blog_id;?>)">Active</button>
              <?php } ?>

              <input type="hidden" id="updateField" value="blog_status">
              <input type="hidden" id="tableName" value="blogs">
              <input type="hidden" id="tableIdName" value="blog_id">
              <input type="hidden" id="id" value="<?= $blog->blog_id;?>">
            </td>  

            <td>
              <a href="<?= base_url('admin/edit-blog/'.$blog->blog_id); ?>" class="db-list-edit">Edit</a>
            </td>
            <td>
              <a href="#" onclick="javascript:deleteConfirm('<?php echo base_url().'admin/delete-blog/'.$blog->blog_id;?>');" class="db-list-edit">Delete</a>
            </td>
            <td><a href="<?= base_url('admin/blog-details/'.$blog->blog_id); ?>" class="db-list-edit" target="_blank">Preview</a></td>
          </tr>
          <?php 
            $i++;   
              }
            } else {
          ?>
            <tr>
              <td colspan="5"> No Blogs Available!!</td>
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

