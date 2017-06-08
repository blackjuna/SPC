<link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/jquery-easyui/themes/icon.css">
<link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/jquery-easyui/themes/black/easyui.css">
<link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/jquery-easyui/themes/color.css">
<script type="text/javascript" src="<?=base_url();?>assets/jquery-easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jeasyui-custom.js"></script>

<div id="cc" class="easyui-layout">  
	<div data-options="region:'center'" border="false">
		<div class="easyui-layout" data-options="fit:true">  
			<div data-options="region:'center'" border="false">
				<table id="grid" style='height:100%; width:100%;' toolbar="#tb"></table>
				<div id="tb" style="padding:7px">  
					<div>  
						<input id="ss" class="easyui-searchbox" style="width:300px" data-options="searcher:goFilter, prompt:'Search...',menu:'#mm'"></input>
					</div> 
				</div>
				<div id="mm" style="width:120px">  
					<div data-options="name:'ALL',iconCls:'icon-ok'">ALL</div>  
					<div data-options="name:'code'">CODE</div>  
					<div data-options="name:'name'">NAME</div>  
				</div> 
			</div>  
		</div>  
	</div>  
</div>

<div id="dlg" class="easyui-window" data-options="width:465, height:200, closed:true, cache:false, modal:true">
	<form id="forms" method="post" autocomplete="off" style="width:100%; height:100%">
		<input type="hidden" id="id" name="id" />
		<input type="hidden" id="code" name="code" />
		<div class="easyui-layout" data-options="fit:true">
			<div data-options="region:'center',border:false" style="padding-top:10px;">
				<div class="group_box width_440">
					<div class="easyui-panel" title="GENERAL" style="width:auto;height:auto;padding:10px;">
						<table class="input_form">
							<tr>
								<td><label for="code_new">Code&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td> 	
								<td><input class="easyui-validatebox" type="text" id="code_new" name="code_new" style="width:100%;" data-options="required:true" /></td>
							</tr>
							<tr>
								<td><label for="name">Name</label></td> 		
								<td><input class="easyui-validatebox" type="text" id="name" name="name" style="width:100%;" data-options="required:true" /></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div data-options="region:'south',border:false">
				<div style="height:100%; width:100%; border-top:1px solid #cfcfcf;">
					<table style="height:100%; width:100%; border-collapse:collapse; border-spacing:0;">
						<tr>
							<td>
								<center>
									<table style="border-collapse:collapse; border-spacing:0;">
										<tr>
											<td style="padding:4px; white-space:nowrap;">
												<a href="#" id="btn_save" onclick="btn_save()" class="easyui-linkbutton c8" data-options="plain:false">&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;</a>
											</td>  		
											<td style="padding:4px; white-space:nowrap;">
												<a href="#" id="btn_save_new" onclick="btn_save(1)" class="easyui-linkbutton c8" data-options="plain:false">&nbsp;&nbsp;&nbsp;Save & New&nbsp;&nbsp;&nbsp;</a>
											</td>  		
											<td style="padding:4px; white-space:nowrap;">
												<a href="#" id="btn_save_next" onclick="btn_save(2)" class="easyui-linkbutton c8" data-options="plain:false">&nbsp;&nbsp;&nbsp;Save & Next&nbsp;&nbsp;&nbsp;</a>
											</td>  		
										</tr>
									</table>
								</center>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	var url;
	
	$(function(){
		resizelayout();
		$(window).resize(resizelayout);
	});
	
	function goFilter( value, name ) {
		if(typeof(value)==='undefined') value = "";
		if(typeof(name)==='undefined') name = "";
	
		$('#grid').datagrid('load',{  
			findKey: name,
			findVal: value
		});
	}
	
	// NEXT TO LOAD (THIS VALUE CAN BE CHANGE)
	$(function(){  
	
		$(document).on("keydown", function(e){ 
			switch(e.keyCode){
			case 27:	// esc
				$('#dlg').window('close');
				break;
			}
		});
	});
	
	// =========================================================================================
	$(function(){  
		$("#grid").datagrid({        
			url:'<?php echo site_url('systems/currency/r')?>',	
			columns:[[
				{field:"code", title:'CODE', width:75, sortable:true},
				{field:"name", title:'NAME', width:250, sortable:true},
				{field:'id', title:'ID', width:50, sortable:true, formatter:greyField}
			]],
			// title:'',
			fit:true,
			rownumbers:true,
			singleSelect:true,
			pagination:true,
			pagePosition:'bottom',
			idField:'id',
			sortName: 'id',
			sortOrder: "desc",
			onDblClickRow: function(rowIndex, rowData) { crud('u') }
		});

		$('#grid').datagrid('getPager').pagination({  
			buttons:[{  
				text:'<?php echo l('form_btn_create');?>',
				iconCls:'icon-add',  
				handler:function(){ crud('c') }  
			},{  
				text:'<?php echo l('form_btn_update');?>',
				iconCls:'icon-edit',  
				handler:function(){ crud('u') }  
			},{  
				text:'<?php echo l('form_btn_delete');?>',
				iconCls:'icon-remove',  
				handler:function(){ crud('d') }  
			}]  
		});           

		setKeyTrapping_grid('#grid', 'crud');
	})

	function crud ( mode, target ) {
		if(typeof(target)==='undefined') target = "";
		
		url = "<?php echo site_url('systems/currency');?>/"+mode;

		if ( mode=='c' ) {
			var is_allow = <?php echo (is_allow('c', 'systems', 'currency'))?1:0; ?>;
			if ( !is_allow ) {
				dhtmlx.alert({title:"<?php echo l('notification');?>", type:"alert-error", text:"<?php echo l('permission_failed_crud');?>"});
				return false;
			}
			
			$('#forms').form('reset'); 
			
			$('#dlg').window({title: "<?php echo l('form_create');?>"}).window('open');
			$('#forms #btn_save_new').show();
			$('#forms #btn_save_next').hide();
		}
		
		if ( mode=='u' ) {
			var is_allow = <?php echo (is_allow('u', 'systems', 'currency'))?1:0; ?>;
			if ( !is_allow ) {
				dhtmlx.alert({title:"<?php echo l('notification');?>", type:"alert-error", text:"<?php echo l('permission_failed_crud');?>"});
				return false;
			}
			
			var row = $('#grid').datagrid('getSelected');   
			if (!row)
				return;

			$('#forms').form('reset'); 
			$('#forms').form('load',row); 
		
			$('#dlg').window({title: "<?php echo l('form_update');?>"}).window('open');
			$('#forms #btn_save_new').hide();
			$('#forms #btn_save_next').show();
			
			$('#forms #code_new').val(row.code); 
			$('#forms #code_new').focus(); 
		}
		
		if ( mode=='d' ) {
			var is_allow = <?php echo (is_allow('d', 'systems', 'currency'))?1:0; ?>;
			if ( !is_allow ) {
				dhtmlx.alert({title:"<?php echo l('notification');?>", type:"alert-error", text:"<?php echo l('permission_failed_crud');?>"});
				return false;
			}
			
			var row = $('#grid').datagrid('getSelected');  
			if (!row)
				return false;
				 
			dhtmlx.confirm({ title:"<?php echo l('confirm');?>", type:"confirm-warning", width:"350px", text:"<?php echo l('confirm_delete');?>", callback: function(r){  
				if (r){  
					$.post(url,{id:row.id},function(result){  
						if (result.success){  
							$('#grid').datagrid('reload');    // reload the user data  
							dhtmlx.message("<?php echo l('success_delete');?>");
						} else {  
							dhtmlx.alert({ title:"<?php echo l('notification');?>", type:"alert-error", text:result.errorMsg });
						}  
					},'json');  
				}}  
			});  
		}

	}
	
	function btn_save( save_option ) {  
		if(typeof(save_option)==='undefined') save_option = 0;
		
		var dlg = $('#dlg');
		var forms = $('#forms');
		var grid = $('#grid');
		var crud = 'crud';
		
		forms.form('submit',{  
			url: url,  
			onSubmit: function(param){  
				return $(this).form('validate'); 
			},  
			success: function(result){  
				var result = eval('('+result+')');  
				if (result.errorMsg){  
					dhtmlx.alert({ title:"<?php echo l('notification');?>", type:"alert-error", text:result.errorMsg });
				} else {  
					dlg.dialog('close');      // close the dialog  
					grid.datagrid('reload');    // reload the user data  
					if (save_option==1) 
					{
						window[crud]('c');
					}
					else if (save_option==2)
					{
						var lastIndex = grid.datagrid('getRows').length-1;
						var selected = grid.datagrid('getSelected');
						if (selected){
							var index = grid.datagrid('getRowIndex', selected);
							if (index==lastIndex) return
							grid.datagrid('selectRow', index+1);
							window[crud]('u');
						}
					}	
					dhtmlx.message("<?php echo l('success_saving');?>");
				}  
			}  
		});  
	} 

</script>
