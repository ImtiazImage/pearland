

<!-- START -->
<section>
    <div class="ad-com">
        <div class="ad-dash leftpadd">
            <div class="ud-cen">
                <div class="log-bor">&nbsp;</div>
                <span class="udb-inst">All Products</span>
    <?php if($this->session->flashdata('message')){ ?>
        <div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
    <?php } ?>	                
                <div class="ud-cen-s2">
                    <h2>Product details</h2>
                                        <a href="<?= base_url('admin/add-product');?>" class="db-tit-btn">Add new product</a>
                    <table class="responsive-table bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
<!--                            <th>product Date</th>-->
                            <!--<th>Created by</th>-->
                            <th>Status</th>
                            <th>Views</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Preview</th>
                        </tr>
                        </thead>
                        <tbody>
				<?php
					if (count($allProducts) > 0) {
						$i = 1;
						foreach ($allProducts as $product) {
				?>
					<tr>
						<td><?= $i; ?></td>
						<td>
							<?php
								$image = '';
								$images = json_decode($product->gallery_image);
								if($images != NULL)
								{
									$image = './'.$images[0];
								}
							?>
							<img src="<?= base_url($image) ;?>" alt="<?= $product->product_name; ?> ">
							<?= $product->product_name; ?> 
							<span><?= date('d, M, Y',strtotime($product->created_at)); ?></span>
						</td>
						<td>

                            <?php if ($product->product_status == 0) { ?>
                                <button class="db-list-ststus" onclick="updateStatus(1,<?= $product->product_id;?>)">In-Active</button>
                            <?php } else { ?>
                                <button class="db-list-ststus" onclick="updateStatus(0,<?= $product->product_id;?>)">Active</button>
                            <?php } ?>
	                        <input type="hidden" id="updateField" value="product_status">
	                        <input type="hidden" id="tableName" value="products">
	                        <input type="hidden" id="tableIdName" value="product_id">
	                        <input type="hidden" id="id" value="<?= $product->product_id;?>">
                        </td>  
						<td><span class="db-list-rat">0</span></td>
                        
						<td>
							<a href="<?= base_url('admin/edit-products/'.$product->product_slug);?>" class="db-list-edit">		Edit
							</a>
						</td>
						<td>
						    <a href="#" onclick="javascript:deleteConfirm('<?php echo base_url('admin/delete-product/'.$product->product_slug);?>');" class="db-list-edit">Delete</a>
						       
						</td>
						<td>
							<a href="<?= base_url('admin/product-details/'.$product->product_slug);?>" class="db-list-edit" target="_blank">
								Preview
							</a>
						</td>
					</tr>
				<?php	
				$i++;
						}
					} else {
				?>
					<tr>
						<td colspan="6"> No Products Available!!</td>
					</tr>
				<?php } ?>
                            
                        </tbody>
                    </table>
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
