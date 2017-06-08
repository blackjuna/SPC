<!--
<script type="text/javascript" src="<?=base_url();?>assets/jquery-validation/jquery.validate.min.js"></script>
-->
<div style="padding:10px;">
	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img src="<?=base_url('assets/images/user/'.$image);?>" class="avatar img-circle" alt="avatar">
          <h6>Upload a different photo...</h6>
          <input type="button" id="btn_update_photo" class="btn btn-default" value="Browse">
		  <span></span>
          <input type="button" id="btn_remove_photo" class="btn btn-default" value="Remove">
          <!--
          <input type="file" class="form-control">
		  -->
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
		  <div class="message"></div>
        </div>
        <h3>Personal info</h3>
        
        <form class="form-horizontal" role="form">
			<input type="hidden" id="id" name="id" value="<?=$id;?>">
			<div class="form-group">
				<label class="col-lg-3 control-label">First name:</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" id="first_name" name="first_name" value="<?=$first_name;?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label">Last name:</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" id="last_name" name="last_name" value="<?=$last_name;?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label">Company:</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" value="<?=$u_comp;?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label">Branch:</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" value="<?=$u_br;?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label">Department:</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" value="<?=$u_dept;?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label">Phone/ext.:</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" id="phone" name="phone" value="<?=$phone;?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-3 control-label">Email:</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" id="email" name="email" value="<?=$email;?>" required>
				</div>
			</div>
			<!--
			<div class="form-group">
			<label class="col-lg-3 control-label">Time Zone:</label>
			<div class="col-lg-8">
			<div class="ui-select">
			<select id="user_time_zone" class="form-control">
			<option value="Hawaii">(GMT-10:00) Hawaii</option>
			<option value="Alaska">(GMT-09:00) Alaska</option>
			<option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
			<option value="Arizona">(GMT-07:00) Arizona</option>
			<option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
			<option value="Central Time (US &amp; Canada)" selected="selected">(GMT-06:00) Central Time (US &amp; Canada)</option>
			<option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
			<option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
			</select>
			</div>
			</div>
			</div>
			-->
			<h3>Activity info</h3>
		  
			<div class="form-group">
				<label class="col-md-3 control-label">Username:</label>
				<div class="col-md-8">
					<input class="form-control" type="text" value="<?=$username;?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Last login:</label>
				<div class="col-md-8">
					<input class="form-control" type="text" value="<?=$last_login;?>" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Last IP Address:</label>
				<div class="col-md-8">
					<input class="form-control" type="text" value="<?=$ip_address;?>" disabled>
				</div>
			</div>
			<!--
			<div class="form-group">
				<label class="col-md-3 control-label">Password:</label>
				<div class="col-md-8">
					<input class="form-control" type="password" value="11111122333">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Confirm password:</label>
				<div class="col-md-8">
					<input class="form-control" type="password" value="11111122333">
				</div>
			</div>
			-->
			<div class="form-group">
				<label class="col-md-3 control-label"></label>
				<div class="col-md-8">
					<input type="submit" class="btn btn-primary" value="Save Changes">
				</div>
			</div>
        </form>
      </div>
	</div>
</div>

<script>
	
	$(function(){
		$("div.alert").hide();
		init_uploader();
	});
	
	var uploader;
	function init_uploader(){
		if (uploader)
			uploader.destroy();

		uploader = new plupload.Uploader({
			runtimes : 'html5,flash,silverlight,html4',
			browse_button : 'btn_update_photo', // you can pass in id...
			url : "<?=site_url('systems/profile/update_picture');?>",
			flash_swf_url : "<?=base_url()?>assets/jquery-plupload/js/Moxie.swf",
			silverlight_xap_url : "<?=base_url()?>assets/jquery-plupload/js/Moxie.xap",
			chunk_size: '200kb',
			max_retries: 3,
			multipart: true,
			multipart_params: {},
			
			filters : {
				max_file_size : '5mb',
				mime_types: [
					{title : "Image files", extensions : "jpg,gif,png"}
				]
			},

			init: {
				FilesAdded: function(up, files) {
					/* plupload.each(files, function(file) {
						document.getElementById('attach_box').innerHTML += '<div class="item" id="' + file.id + '" style="width:99%; padding:0px 0px 0px 0px;">'+
							'<div class="item_name" style="display:inline-block; width:220px; border:0px solid #99CCFF;">' + truncate(file.name, 20) + ' <span style="color:#bbb">(' + plupload.formatSize(file.size) + ')</span> &nbsp;</div>'+
							'<div class="item_progress" style="width:200px;display:inline-block;vertical-align:middle; border:0px solid #99CCFF;">'+
								'<div class="easyui-progressbar" style="width:200px; vertical-align:middle;"></div>'+
							'</div>'+
							'<div class="item_remove icon_x_12 _12px" data-file="'+file+'" style="width:16px;display:inline-block;vertical-align:middle;cursor:pointer;"></div>'+
							'</div>';
					}); */
					var file = files[0];
					var ext = file.name.split(".").pop();
					// console.log(file.name);
					// console.log(ext);
					file.name = $("#id").val()+'.'+ext;
					// console.log(file.name);
					// return false;
					// var new_name = file.name.replace(/[^a-z0-9\.]+/gi,"_").toLowerCase();
					uploader.settings.multipart_params["id"] = $("#id").val();
					uploader.start();
					
					return false;
				},

				UploadProgress: function(up, file) {
					$("#dlg_progress").dialog('setTitle', 'Uploading your photo, please wait...').dialog('open');
					// $("#"+file.id+" .easyui-progressbar").progressbar({height:17, value: file.percent, text:''});
				},
				
				FileUploaded: function(up, file, info) {
					$("#dlg_progress").dialog('close');
				    // <img src="<?=base_url('assets/images/user/'.$profile_pic.'.jpg');?>" class="avatar img-circle" alt="avatar">
					var d = new Date();
					// $("#myimg").attr("src", "/myimg.jpg?"+d.getTime());
					// console.log("<?=base_url('assets/images/user');?>/"+file.name+"?"+d.getTime());
					
					$(".avatar").attr("src", "<?=base_url('assets/images/user');?>/"+file.name+"?"+d.getTime());
					$(".user-image").attr("src", "<?=base_url('assets/images/user');?>/"+file.name+"?"+d.getTime());
					$(".img-circle").attr("src", "<?=base_url('assets/images/user');?>/"+file.name+"?"+d.getTime());
					
					// $("#"+file.id+" .easyui-progressbar").fadeOut('slow');
					var response = $.parseJSON(info.response);
					if (response){
						if (response.errMessage){
							dhtmlx.alert({title:"<?php echo l('notification');?>", type:"alert-error", text:"\nError #" + response.errCode + ": " + response.errMessage});
						}
					}
				},

				Error: function(up, err) {
					dhtmlx.alert({title:"<?php echo l('notification');?>", type:"alert-error", text:"\nError #" + err.code + ": " + err.message});
				}
			}
		});

		uploader.init();
	}
	
	$("#btn_remove_photo").click(function(){
		dhtmlx.confirm({ title:"<?php echo l('confirm');?>", type:"confirm-warning", width:"350px", text:"Are you sure want to remove this picture?", callback: function(r){  
			if (r){  
				$.post("<?=site_url('systems/profile/remove_picture');?>",
				{id: $("#id").val()}, function(result){  
					if (result.success){  
						var d = new Date();
						$(".avatar").attr("src", "<?=base_url('assets/images/user/no_photo.jpg');?>?"+d.getTime());
						$(".user-image").attr("src", "<?=base_url('assets/images/user/no_photo.jpg');?>?"+d.getTime());
						$(".img-circle").attr("src", "<?=base_url('assets/images/user/no_photo.jpg');?>?"+d.getTime());
						dhtmlx.message("Ohhh noo...!!, the picture has been remove !");
					} else {  
						dhtmlx.alert({ title:"<?php echo l('notification');?>", type:"alert-error", text:result.errorMsg });
					}  
				},'json');  
			}}  
		});  
	});
	
	$("form").submit(function(e){
		e.preventDefault();
		
		/* $("form").form('submit',{  
			url: "<?=site_url('systems/profile/u');?>",  
			async: false,
			onSubmit: function(param){  
				
				return $(this).form('validate'); 
			},  
			success: function(result){  
				var result = eval('('+result+')');  
				if (result.errorMsg){
					$("div.alert").html("<strong><?=l('notification');?></strong> ".result.errorMsg).show();
				} else {  
					// var id = result.id;
					// if (uploader.files.length > 0) {
						// uploader.settings.multipart_params["ticket_id"] = id;
						// uploader.start();
					// }
					$("div.alert").html("<?=l('success_saving');?>").show();
				}  
			}  
		});  */		
		$.ajax({
			url: "<?=site_url('systems/profile/u');?>",
			data: {
				formData : $("form").serialize()
			},
			type: 'post',                  
			async: 'true',
			dataType: 'json',
			beforeSend: function() {
				// $("form").validate();
				$("#dlg_progress").dialog('setTitle', 'We are preparing your data, please wait...').dialog('open');
			},
			complete: function() {

				$("#dlg_progress").dialog('close');
			},
			success: function (result) {
				if(result.success) {
					dhtmlx.message(result.infoMsg);
					// $("div.alert.message").html("<?=l('success_saving');?>").parent().show("slow");
				} else {
					// $("div.alert.message").html("<strong><?=l('notification');?></strong> ".result.errorMsg).parent().show("slow");
					dhtmlx.alert({ title:"Notification", type:"alert-error", text:result.errorMsg });
				}
			},
			error: function (request,error) {
				// This callback function will trigger on unsuccessful action               
				dhtmlx.alert({ title:"Notification", type:"alert-error", text:'Network error has occurred please try again!' });
			}
		});      
	});
</script>