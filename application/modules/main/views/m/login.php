<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />
	
	<title><?php echo $this->session->userdata('app_title');?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/login-style.css">
	
	<script type="text/javascript" src="<?php echo base_url();?>assets/jquery/jquery.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/jquery-vegas/jquery.vegas.css" />
	<script type="text/javascript" src="<?php echo base_url();?>assets/jquery-vegas/jquery.vegas.js"></script>
	
</head>
<body>
	<section class="main">
		<?php echo form_open(site_url('auth/login'));?>
			<p class="field">
				<?php echo form_input($identity);?>
				<i class="icon-user icon-large"></i>
			</p>
			<p class="field">
				<?php echo form_input($password);?>
				<i class="icon-lock icon-large"></i>
			</p>
			<?php if ( $this->config->item('use_captcha', 'ion_auth') ) { ?>
				<center>
				<img src="<?php echo base_url().'captcha/'.$this->session->userdata['image'];?>" width="180" height="50" />
				</center>
				<p class="field">
					<?php echo form_input($captcha);?>
					<i class="icon-lock icon-large"></i>
				</p>
			<?php }?>
			<div id="infoMessage"><?php echo $message;?></div>
			<p class="submit">
				<button type="submit" name="submit"><i class="icon-arrow-right icon-large"></i></button>
			</p>
		</form>
	</section>
	<div style="top:<?php if ( $this->config->item('use_captcha', 'ion_auth') ) echo '45%'; else echo '35%'; ?>;" class="strip shado"></div>
    <div style="top:<?php if ( $this->config->item('use_captcha', 'ion_auth') ) echo '45%'; else echo '35%'; ?>;" class="strip-2">
		<div class="info-heading text-shado"><br /><?php echo $this->session->userdata('app_title');?></div>
		<div class="info-content">
			<br /> © 2013 All Rights Reserved.xx
			<br /><?php echo $this->db->hostname .' ( '.$this->db->database.' )';?>
		</div>
    </div>
</body>
</html>

