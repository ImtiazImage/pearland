
<!--CENTER SECTION-->
<div class="ud-cen">
<div class="log-bor">&nbsp;</div> <span class="udb-inst">Paid ads</span>
		<?php if($this->session->flashdata('message')){ ?>
			<div class="log-suc" ><p><?= $this->session->flashdata('message') ?></p></div>
        <?php } ?>	 
<div class="ud-cen-s2">
	<h2>Your Bannear Ads</h2>
	<a href="<?= base_url() ?>post_ads" class="db-tit-btn db-tit-btn-2-ads">Post your Ads</a>
	<a href="<?= base_url('user/ads-price'); ?>" class="db-tit-btn">Pricing and other details</a>
	<table class="responsive-table bordered">
		<thead>
			<tr>
				<th>No</th>
				<!--<th>Ads Name</th>-->
				<th>Ads Position</th>
				<th>Start date</th>
				<th>End date</th>
				<th>Duration</th>
				<th>Status</th>
				<th>Views</th>
				<th>Clicks</th>
			</tr>
		</thead>
		<tbody>
		<?php
            if($ads && $ads != null){
              $j = 0;
              foreach ($ads as $key => $value) {
                $j++;
          ?>      
              <tr>
                <td><?= $j; ?></td>
                <td><?= $value->ads_price_name; ?></td>
                <td><?= date('d, M Y', strtotime($value->ad_start_date)); ?></td>
                <td><?= date('d, M Y', strtotime($value->ad_end_date)); ?></td>
                <td><?= $value->ad_total_days; ?> day(s)</td>
				<td><span class="db-list-rat"><?= ($value->ad_status ==  1) ? 'Active':'In-Active';?></span></td>
				<td><span class="db-list-rat">1k</span></td>
				<td><span class="db-list-rat">642</span></td>
              </tr>
          <?php    
              }
            } else {
          ?>
              <tr>
                <td colspan="9">No Data Available!</td>

              </tr>        
          <?php
            }
          ?>
		</tbody>
	</table>
	<div class="ud-notes">
		<p><b>Notes:</b> Hi, Before start "Ads Payment" you must know the pricing details and positions and all. You just click the "Pricing and other details" button in this same page and you know the all details. If your payment done means your invoice automaticall received your "Payment invoice" page and you never stop your Ads till the end date.</p>
	</div>
</div>
</div>
<!-- <tr>
				<td>1</td>
				<!--                        <td>Taj Luxury Hotel</td>--
				<td>Home page Bottom</td>
				<td>31, Mar 2021</td>
				<td>29, Apr 2021</td>
				<td>0 Days</td>
				<td><span class="db-list-ststus">InActive</span>
				</td>
				<td><span class="db-list-rat">1k</span>
				</td>
				<td><span class="db-list-rat">642</span>
				</td>
			</tr> -->