<link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/jquery-easyui/themes/icon.css">
<link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/jquery-easyui/themes/black/easyui.css">
<link type="text/css" rel="stylesheet" href="<?=base_url();?>assets/jquery-easyui/themes/color.css">
<script type="text/javascript" src="<?=base_url();?>assets/jquery-easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jeasyui-custom.js"></script>

<div id="dlg_setting" class="easyui-dialog" style="padding:10px;" data-options="width:380, height:'auto', closable:false, closed:false, cache:false, modal:false">
	<form id="form_setting" method="post" autocomplete="off" style="width:100%; height:100%">
		<div class="group_box width_340">
			<div class="easyui-panel" title="" style="width:auto;height:auto;padding:10px;">
				<table class="input_form" style="width:100%;">
					<tr>
						<td>Company</td>
						<td>
							<input class="easyui-combogrid" id="company" name="company" style="width:200px;" data-options="
								url:'<?php echo site_url('systems/get_company_by_user');?>',
								editable:false, required:false, panelWidth:300, panelHeight:150, idField:'company_id', textField:'company_name', mode:'remote', 
								rownumbers:true, fitColumns:true, value:<?=sesCompany(FALSE);?>,
								columns: [[
									{field:'id'	 ,title:'ID',width:20,sortable:true,hidden:true},
									{field:'company_id'	 ,title:'company_id',width:20,sortable:true,hidden:true},
									{field:'company_code',title:'CODE',width:30,sortable:true},
									{field:'company_name',title:'NAME',width:70,sortable:true}
								]],
								onSelect: onSelectCompany" />
						</td>
					</tr>
					<tr>
						<td>Branch</td>
						<td>
							<input class="easyui-combogrid" id="branch" name="branch" style="width:200px;" data-options="
								url:'<?php echo site_url('systems/get_branch_by_user');?>',
								editable:false, required:false, panelWidth:300, panelHeight:250, idField:'branch_id', textField:'branch_name', mode:'remote', 
								rownumbers:true, fitColumns:true, value:<?=sesBranch(FALSE);?>,
								columns: [[
									{field:'id'	 ,title:'ID',width:20,sortable:true,hidden:true},
									{field:'branch_id'	 ,title:'branch_id',width:20,sortable:true,hidden:true},
									{field:'branch_code',title:'CODE',width:30,sortable:true},
									{field:'branch_name',title:'NAME',width:70,sortable:true}
								]],
								onSelect: onSelectBranch" />
						</td>
					</tr>
					<tr>
						<td>Department&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>
							<input class="easyui-combogrid" id="department" name="department" style="width:200px;" data-options="
								url:'<?php echo site_url('systems/get_department_by_user');?>',
								editable:false, required:false, panelWidth:300, panelHeight:200, idField:'department_id', textField:'department_name', mode:'remote', 
								rownumbers:true, fitColumns:true, value:<?=sesDepartment(FALSE);?>,
								columns: [[
									{field:'id'	 ,title:'ID',width:20,sortable:true,hidden:true},
									{field:'department_id'	 ,title:'department_id',width:20,sortable:true,hidden:true},
									{field:'department_code',title:'CODE',width:30,sortable:true},
									{field:'department_name',title:'NAME',width:70,sortable:true}
								]],
								onSelect: onSelectDepartment" />
						</td>
					</tr>
				</table>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript"> 

	$(document).on("keydown", function(e){ 
		switch(e.keyCode){
		case 27:	// esc
			// $('#dlg_setting').dialog('close');
			break;
		}
	});
		
	// NEXT TO LOAD (THIS VALUE CAN BE CHANGE)
	$(function(){
		$('#dlg_setting').dialog('setTitle',"<?=$title;?>").dialog('open');
	});
	
	function onSelectCompany(index, row){
		$.post("<?php echo site_url('systems/set_company_by_user');?>", {"company_id" : row.company_id});
		$("#company").html(row.company_code);
	}
	
	function onSelectBranch(index, row){
		$.post("<?php echo site_url('systems/set_branch_by_user');?>", {"branch_id" : row.branch_id});
		$("#branch").html(row.branch_code);
	}
	
	function onSelectDepartment(index, row){
		$.post("<?php echo site_url('systems/set_department_by_user');?>", {"department_id" : row.department_id});
		$("#department").html(row.department_code);
	}
	
</script>
