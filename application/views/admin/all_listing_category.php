

<!-- START -->

<section>

  <div class="ad-com">

    <div class="ad-dash leftpadd">

      <div class="ud-cen">

        <div class="log-bor">&nbsp;</div>

	      <span class="udb-inst">Listing Category</span>

        <div class="ud-cen-s2 hcat-cho">

          <h2>All Listing Category</h2>
          <?php if($this->session->flashdata('message')){ ?>
            <div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
          <?php } ?>
          <div class="ad-int-sear">

              <input type="text" id="pg-sear" placeholder="Search this page..">

          </div>

          <a href="<?= base_url() ?>admin/add_new_listing_category" class="db-tit-btn">Add New Listing Category</a>

          <table class="responsive-table bordered" id="pg-resu">

  			<thead>

  			    <tr>

      				<th>No</th>

                    <th>Category Name</th>

                    <th>Category Image</th>

  					<th>Created date</th>

  					<th>Listing</th>

                    <th>Sub Cate</th>

  					<th>Edit</th>

                    <th>View Sub Cate</th>

  					<th>Delete</th>

  				</tr>

  			</thead>

  			<tbody>

  		        <?php 

  		            if($all_listing_category){

  		                $i = 0;

  		                foreach($all_listing_category as $category){

  		                    $i++;

  		        ?>		    

  		        

              <tr>

                <td><?= $i; ?></td>

                <td><b class="db-list-rat"><?= $category->category_name; ?></b></td>

                <td><img src="<?= base_url($category->category_image);?>" alt="<?= $category->category_name; ?>"></td>

                <td><?= date('d, M Y',strtotime($category->created_at)); ?></td>

                <td><span class="db-list-ststus" data-toggle="tooltip" title="Total listings in this category">0</span></td>

                <td><span class="db-list-ststus" data-toggle="tooltip" title="Total Sub Category">0</span></td>

                <td><a href="<?= base_url('admin/edit_listing_category/'.$category->category_id);?>" class="db-list-edit">Edit</a></td>

                <td><a href="<?= base_url('admin/all_listing_sub_category/'.$category->category_id);?>" class="db-list-edit">View</a></td>

                <td>
                  <a class="db-list-edit" onclick="javascript:deleteConfirm('<?php echo base_url().'admin/delete_listing_category/'.$category->category_id;?>');"  href="#">Delete</a>
                </td>

              </tr>

              

              <?php }}?>

              

  					</tbody>

  				</table>

        </div>

      </div>

    </div>

  </div>

</section>

<!-- END -->    



    