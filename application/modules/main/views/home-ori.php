	<!-- load jquery ui css theme -->
    <link type="text/css" href="<?php echo base_url();?>assets/jquery-sDashboard/css/jquery-ui.css" rel="stylesheet" />

	<!-- load gitter css -->
	<link href="<?php echo base_url();?>assets/jquery-sDashboard/css/gitter/css/jquery.gritter.css" rel="stylesheet">

	<!-- load the sDashboard css -->
    <link href="<?php echo base_url();?>assets/jquery-sDashboard/sDashboard.css" rel="stylesheet">

    <!-- load jquery ui library -->
    <script src="<?php echo base_url();?>assets/jquery-sDashboard/libs/jquery/jquery-ui.js" type="text/javascript"></script>

	<!-- load touch punch library to enable dragging on touch based devices -->
	<script src="<?php echo base_url();?>assets/jquery-sDashboard/libs/touchpunch/jquery.ui.touch-punch.js" type="text/javascript"> </script>

	<!-- load gitter notification library -->	
	<script src="<?php echo base_url();?>assets/jquery-sDashboard/libs/gitter/jquery.gritter.js" type="text/javascript"> </script>		
	
    <!-- load datatables library -->
    <script src="<?php echo base_url();?>assets/jquery-sDashboard/libs/datatables/jquery.dataTables.js"></script>

    <!-- load flot charting library -->
    <script src="<?php echo base_url();?>assets/jquery-sDashboard/libs/flotr2/flotr2.js" type="text/javascript"></script>

    <!-- load sDashboard library -->
    <script src="<?php echo base_url();?>assets/jquery-sDashboard/jquery-sDashboard.js" type="text/javascript"></script>

	<!--
    <script src="<?php echo base_url();?>assets/jquery-sDashboard/libs/exampleData.js" type="text/javascript"></script>
	-->
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/jquery-vegas/jquery.vegas.css" />
	<script type="text/javascript" src="<?php echo base_url();?>assets/jquery-vegas/jquery.vegas.js"></script>
</head>
<body>

<div style="margin-top: 15px; padding:10px">	
	<ul id="myDashboard"></ul>
</div>

<script type="text/javascript">

	function changeBackground() {
		var folder = 1 + Math.floor(Math.random() * 2);
		if ( folder==1 )
			var file = 1 + Math.floor(Math.random() * 157);
		else if ( folder==2 )
			var file = 1 + Math.floor(Math.random() * 153);
		else if ( folder==3 )
			var file = 1 + Math.floor(Math.random() * 41);
		
		// $.vegas({ src: '<?php echo base_url();?>assets/images/background/'+folder+'/'+file+'.jpg', fade:1000 });
		$.vegas({ src: '<?php echo base_url();?>assets/images/background/background-01.jpg', fade:1000 });
		$.vegas('overlay', { src:'<?php echo base_url();?>assets/jquery-vegas/overlays/01.png' });
	}

	/* $(function(){
		changeBackground();
		setInterval(function() {
			changeBackground();
		}, 15000); 
	}) */
	
	
	//**********************************************//
	//dashboard json data
	//this is the data format that the dashboard framework expects
	//**********************************************//

	var pieChartOptions = {
		HtmlText : false,
		grid : {
			verticalLines : false,
			horizontalLines : false
		},
		xaxis : {
			showLabels : false
		},
		yaxis : {
			showLabels : false
		},
		pie : {
			show : true,
			explode : 6
		},
		mouse : {
			track : true
		},
		legend : {
			position : "se",
			backgroundColor : "#D2E8FF"
		}
	};

	$(function() {

		changeBackground();
		
		var company_id  = parseInt(<?php echo $this->session->userdata('company_id')?>);
		var branch_id 	= parseInt(<?php echo $this->session->userdata('branch_id')?>);
		var branch_name = "<?php echo $this->shared_model->get_branch_name( $this->session->userdata('branch_id') )?>";
		branch_name = branch_name.slice(0,1).toUpperCase() + branch_name.slice(1).toLowerCase();
		// console.log(branch_name);
		
		/* $("#myDashboard").sDashboard({
			dashboardData : [{
				widgetTitle : "Widget Information",
				widgetId : "id000",
				widgetContent : "Dashboard Widget"
			}]
		}); */
		
		/* $.getJSON('<?php echo site_url('main/dashboard_pie_total_phd_all_yearly')?>', function(data) {
		
			$("#myDashboard").sDashboard("addWidget", {
				widgetTitle : "Total PHD All Branch This Year",
				widgetId : "id001",
				widgetType : "chart",
				widgetContent : {
					data : data,
					options : pieChartOptions
				}
			});
		}); */

		/* if (company_id==1 && branch_id==1) {			
			$.getJSON('<?php echo site_url('main/dashboard_pie_total_phd_all_monthly')?>', function(data) {
			
				$("#myDashboard").sDashboard("addWidget", {
					widgetTitle : "Total PHD All Branch This Month",
					widgetId : "id002",
					widgetType : "chart",
					widgetContent : {
						data : data,
						options : pieChartOptions
					}
				});
			});
		} */
		
		/* $.getJSON('<?php echo site_url('main/dashboard_pie_total_phd_branch_yearly')?>', function(data) {
		
			$("#myDashboard").sDashboard("addWidget", {
				widgetTitle : "Total PHD Branch This Year",
				widgetId : "id003",
				widgetType : "chart",
				widgetContent : {
					data : data,
					options : pieChartOptions
				}
			});
		}); */
		
		/* if (company_id==1 && branch_id!=1) {			
			$.getJSON('<?php echo site_url('main/dashboard_pie_total_phd_branch_monthly')?>', function(data) {
			
				$("#myDashboard").sDashboard("addWidget", {
					widgetTitle : "Total PHD Branch "+branch_name+" This Month",
					widgetId : "id004",
					widgetType : "chart",
					widgetContent : {
						data : data,
						options : pieChartOptions
					}
				});
			});
		} */
		
		/* if (company_id==1 && branch_id!=1) {			
			$.getJSON('<?php echo site_url('main/dashboard_table_today_phd_updates')?>', function(data) {
			
				// console.log([myExampleData.tableWidgetData.aaData]);
				// console.log([data]);
				
				var tableWidgetData = {
					"aaData" : data,
					"aoColumns" : [{
						"sTitle" : "PHD NO"
					}, {
						"sTitle" : "STATUS"
					}, {
						"sTitle" : "ID"
					}],
					"iDisplayLength": 5,
					"aLengthMenu": [[1, 5, 25, 50, -1], [1, 5, 25, 50, "All"]],
					"bPaginate": true,
					"bAutoWidth": false
				};
			
				$("#myDashboard").sDashboard("addWidget", {
					widgetTitle : "Today PHD Updates",
					widgetId : "id3",
					widgetType : "table",
					setJqueryStyle : true,
					widgetContent : tableWidgetData
				});
			});
			
			$("#myDashboard").bind("sdashboardrowclicked", function(e, data) {
				
				window.open("<?php echo site_url('marketing/form_phd_mkt_ans_branch'); ?>/"+data.selectedRowData[2]);
			});
		} */
		
		/* if (company_id==1 && branch_id==1) {			
			$.getJSON('<?php echo site_url('main/dashboard_pie_total_phd_routes_all_monthly')?>', function(data) {
			
				$("#myDashboard").sDashboard("addWidget", {
					widgetTitle : "Total PHD (Head Office) This Month",
					widgetId : "id101",
					widgetType : "chart",
					widgetContent : {
						data : data,
						options : pieChartOptions
					}
				});
			});
		} */
		
		/* $.getJSON('<?php echo site_url('main/dashboard_pie_total_phd_routes_all_yearly')?>', function(data) {
		
			$("#myDashboard").sDashboard("addWidget", {
				widgetTitle : "Total PHD (Head Office) This Year",
				widgetId : "id102",
				widgetType : "chart",
				widgetContent : {
					data : data,
					options : pieChartOptions
				}
			});
		}); */
		
		// $("#myDashboard").sDashboard("removeWidget", "id000");

	});

			
</script>
<script>
	var sse = new EventSource('<?php echo site_url('shared/pull'); ?>');
	sse.onmessage = (function(e){
		data = $.parseJSON(e.data);

		if (!data.connected)
			console.log("disconected");
		else
			console.log("connected");
			
		switch(data.param1) {
			case 'sys_msg':
				alert(data.param2);
				break;
			case 'sys_reload':
				alert(data.param2);
				location.reload();
				break;
			case 'data_reload':
				if (data.param2=="") $('#grid').datagrid('reload'); 
				if (data.param2=="") $('#grid2').datagrid('reload'); 
				break;
		}
	});
</script>
