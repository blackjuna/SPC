<div data-role="page" id="home">
	<div data-role="panel" id="panel_l" data-position="left" data-position-fixed="true" data-display="overlay" data-theme="b">
		<?php if ( !empty($menus) ) { ?>
		<ul data-role="listview" data-inset="true" data-divider-theme="a">
			<?php // MENU
			$module_group_id = 0;
			foreach ($menus as $menu)
			{
				if ($module_group_id != $menu->module_group_id)
				{
					$module_group_id   = $menu->module_group_id;
					echo "<li data-role='list-divider'>".$menu->module_group_name."</li>";
					
					// SUB MENU DETAIL
					$module_page_link = site_url($menu->module_page_link_m);
					if ($menu->module_is_form) 
						echo "<li data-icon='false'><a href='#main_page' onclick='show_dlg(\"$module_page_link\"); return false;'>".$menu->module_name."</a></li>";
					else 
						echo "<li data-icon='false'><a href='$module_page_link' data-transition='slide'>".$menu->module_name."</a></li>";
				}
				else
				{
					$module_group_id   = $menu->module_group_id;
					
					// SUB MENU DETAIL
					$module_page_link = site_url($menu->module_page_link_m);
					if ($menu->module_is_form) 
						echo "<li data-icon='false'><a href='#main_page' onclick='show_dlg(\"$module_page_link\"); return false;'>".$menu->module_name."</a></li>";
					else 
						echo "<li data-icon='false'><a href='$module_page_link' data-transition='slide'>".$menu->module_name."</a></li>";
				}
			}
			?>
		</ul>
		<?php } ?>
		<ul data-role="listview" data-inset="true" data-divider-theme="a">
			<li data-icon="delete"><a id="logout" href="<?php echo site_url('systems/logout');?>" rel="external" data-transition="slide" data-direction="reverse">LOGOUT</a></li>
		</ul>
	</div><!-- /panel -->
	
	<div data-role="panel" id="panel_r" data-position="right" data-position-fixed="true" data-display="overlay" data-theme="b">
		<a id="logout" href="<?php echo site_url('systems/logout'); ?>" rel="external" data-transition="slide" data-direction="reverse" class="ui-btn ui-input-btn ui-corner-all ui-shadow ui-btn-inline">LOGOUT</a>
	</div><!-- /panel -->
	
	<div data-role="header" data-theme="b">
		<h1><?php echo $title; ?></h1>
		<a href="#panel_l" data-icon="bars" class="ui-btn-left" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-nodisc-icon">Open left panel</a>
		<!--<a href="#panel_r" data-icon="gear" class="ui-btn-right" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-nodisc-icon">Open right panel</a>-->
	</div><!-- /header -->
	<div data-role="content">
		<div id="curr_url" url="<?php echo uri_string();?>"></div>
		<ul data-role="listview" data-inset="true" data-theme="c" data-divider-theme="b"> 
			<li data-role="list-divider">WELCOME</li> 
			<li><?php echo title_case(sesUser()->first_name.' '.sesUser()->last_name); ?></li>
			<li data-role="list-divider"></li>
		</ul>
		<ul data-role="listview" data-inset="true" data-theme="c" data-divider-theme="b"> 
			<li data-role="list-divider">INQUIRY<a id="c_inq1" href="<?php echo site_url('marketing/m_inquiry/c_view/home');?>"><span class='ui-li-count'>ADD NEW</span></a></li>
			<li><a id="v_inq_today" href="<?php echo site_url('marketing/m_inquiry/today');?>">
				<img src="<?php echo base_url(); ?>assets/images/mobile/marketing/inquiry.png" /> 
				<h6>TODAY</h6> 
				<p>Data Inquiry per-hari ini</p> 
				<span class="ui-li-count"><?php echo $inq_today;?></span>
				</a>
			</li>
			<li><a id="v_inq_open" href="<?php echo site_url('marketing/m_inquiry/open');?>"> 
				<img src="<?php echo base_url(); ?>assets/images/mobile/marketing/inquiry_open.png" /> 
				<h6>OPEN</h6> 
				<p>Inquiry yang belum ter-proses</p> 
				<span class="ui-li-count"><?php echo $inq_open;?></span>
				</a>
			</li>
			<li><a id="v_inq_process" href="<?php echo site_url('marketing/m_inquiry/process');?>"> 
				<img src="<?php echo base_url(); ?>assets/images/mobile/marketing/inquiry_process.png" /> 
				<h6>PROCESS</h6> 
				<p>Inquiry yang sedang di proses</p> 
				<span class="ui-li-count"><?php echo $inq_process;?></span>
				</a>
			</li>
			<li data-role="list-divider"></li>
		</ul>
		<ul data-role="listview" data-inset="true" data-theme="c" data-divider-theme="b"> 
			<li data-role="list-divider">QUOTATION</li>
			<li><a id="v_quo_ready" href="<?php echo site_url('marketing/m_quotation/ready'); ?>"> 
				<img src="<?php echo base_url(); ?>assets/images/mobile/marketing/quotation.png" /> 
				<h6>READY</h6> 
				<p>Inquiry yang sudah siap ditawarkan</p> 
				<span class="ui-li-count"><?php echo $quo_ready;?></span>
				</a>
			</li>
			<li><a id="v_quo_ready" href="<?php echo site_url('marketing/m_quotation/process'); ?>"> 
				<img src="<?php echo base_url(); ?>assets/images/mobile/marketing/doc_progress.png" /> 
				<h6>PROCESS</h6> 
				<p>Quotation yang dalam proses</p> 
				<span class="ui-li-count"><?php echo $quo_process;?></span>
				</a>
			</li>
			<li><a id="v_quo_deal" href="<?php echo site_url('marketing/m_quotation/deal'); ?>"> 
				<img src="<?php echo base_url(); ?>assets/images/mobile/marketing/handshake.png" /> 
				<h6>DEAL</h6> 
				<p>Quotation yang jadi Sales Order</p> 
				<span class="ui-li-count"><?php echo $quo_deal;?></span>
				</a>
			</li>
			<li><a id="v_quo_nodeal" href="<?php echo site_url('marketing/m_quotation/nodeal'); ?>"> 
				<img src="<?php echo base_url(); ?>assets/images/mobile/marketing/no_handshake.png" /> 
				<h6>NO DEAL</h6> 
				<p>Quotation yang tidak jadi Order</p> 
				<span class="ui-li-count"><?php echo $quo_nodeal;?></span>
				</a>
			</li>
			<li data-role="list-divider"></li>
		</ul>
	</div>
	<div data-role="footer" data-theme="b">
		<h1><?php echo $this->db->hostname .' ( '.$this->db->database.' )';?></h1>
	</div><!-- /footer -->
</div> <!-- /main_page -->

</body>
</html>