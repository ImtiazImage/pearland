<!-- START -->
<section>
	<div class="ad-com">
		<div class="ad-dash leftpadd">
			<div class="ud-cen">
				<div class="log-bor">&nbsp;</div>
				<span class="udb-inst">events</span>
				<div class="ud-cen-s2">
					<h2>Event details</h2>
            		<?php if($this->session->flashdata('message')){ ?>
                        <div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
                    <?php } ?>
					<a href="<?= base_url() ?>admin/add-new-event" class="db-tit-btn">Add new event</a>
					<table class="responsive-table bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Event Name</th>
								<th>Event Date</th>
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

                                if($allEvents){
                                  $i = 0;
                                  foreach($allEvents as $event){
                                    $i++;
                    
                            ?>
							<tr>
								<td>1</td>
								<td><?= $event->event_name; ?> <span><?= date('d, M Y',strtotime($event->created_at)); ?></span></td>
								<td><?= date('d, M Y',strtotime($event->event_start_date)); ?></td>
								<td><a href="" class="db-list-ststus" target="_blank"><?= $event->name; ?></a></td>
								<td><span class="db-list-rat">8</span></td>
								
								<td>

                                    <?php if ($event->event_status == 0) { ?>
                                        <button class="db-list-ststus" onclick="updateStatus(1,<?= $event->event_id;?>)">In-Active</button>
                                    <?php } else { ?>
                                        <button class="db-list-ststus" onclick="updateStatus(0,<?= $event->event_id;?>)">Active</button>
                                    <?php } ?>
                                <input type="hidden" id="updateField" value="event_status">
                                <input type="hidden" id="tableName" value="events">
                                <input type="hidden" id="tableIdName" value="event_id">
                                <input type="hidden" id="id" value="<?= $event->event_id;?>">
                                </td>  
                                
								<td><a href="<?= base_url('admin/edit_event/'.$event->event_id);?>" class="db-list-edit">Edit</a></td>
								<td><a onclick="javascript:deleteConfirm('<?php echo base_url().'admin/delete_event/'.$event->event_id;?>');"  href="#" class="db-list-edit">Delete</a></td>
								<td><a href="<?= base_url('admin/event-details/'.$event->event_id);?>" class="db-list-edit" target="_blank">Preview</a></td>
							</tr>
							<?php } } ?>

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

