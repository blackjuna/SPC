
    <!-- Main content -->
    <section class="content">
      
      <!-- AREA CHART -->
      <div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Chart <?=$title_module?> XChart </h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="x-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Chart <?=$title_module?> RChart </h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="r-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

      <!-- AREA CHART -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?=$title_module?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        
          <div class="box-body form">
            <form action="#" id="form_export">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Date From:</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datef" name="datef">
                      </div>
                      <!-- /.input group -->
                  </div>

                  <div class="form-group">
                    <label>Date To:</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datet" name="datet">
                      </div>
                      <!-- /.input group -->
                  </div>
        
                  <div class="form-group">
                    <label class="control-label col-md-3">IR/OR</label>
                      <select name="ir_or" id="ir_or" class="form-control"><option></option>
                        <option value='1'>IR</option>
                        <option value='2'>OR</option>   
                      </select>
                  </div>


                </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">Diameter</label>
                      <select name="diameter" id="diameter" class="form-control"><option></option>
                        <option value='1'>d1</option>
                        <option value='2'>d2</option> 
                        <option value='3'>d3</option>
                        <option value='4'>d4</option>   
                      </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label class="control-label col-md-3">Size</label>
                    <select name="size" id="size" class="form-control"><option></option>
                      <?php $size = $this->qc_m->getsize();?>
                      <?php foreach($size as $rowsize){?>
                      <option value="<?=$rowsize->id?>"><?=$rowsize->code_size?></option>
                      <?php }?>
                    </select> 
                  </div>
                  <!-- /.form-group -->
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label class="control-label col-md-3">Class</label>
                        <select name="class" id="class" class="form-control"><option></option>
                          <?php $class = $this->qc_m->getclass();?>
                          <?php foreach($class as $rowclass){?>
                          <option value="<?=$rowclass->id?>"><?=$rowclass->code_class?></option>
                          <?php }?>  
                        </select>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button class="btn btn-success" onclick="add_blanking()"><i class="glyphicon glyphicon-plus"></i> Add</button>
            <button class="btn btn-success pull" id="btnexport" onclick="export_data_blanking()"><i class="glyphicon glyphicon-export"></i> EXPORT</button>

            <button class="btn btn-info pull-right" id="btnsearch" onclick="search_blanking()"><i class="glyphicon glyphicon glyphicon-search"></i> Search</button>
          </div>

        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?=$title?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table id="tables" class="display no-wrap" cellspacing="0" width="100%">
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
      
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">ALL DATA</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table id="tables3" class="display no-wrap" cellspacing="0" width="100%">
          </table>
          <table id="tables4" class="display no-wrap" cellspacing="0" width="100%">
          </table>
          <!-- <table id="tables5" class="display no-wrap" cellspacing="0" width="100%">
          </table> -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <!-- jQuery 2.2.0 -->
  <script src="<?= base_url();?>assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?= base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- date-range-picker -->
  <script src="<?= base_url();?>assets/plugins/moment.js/2.11.2/moment.min.js"></script>
  <script src="<?= base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Morris.js charts -->
  <script src="<?= base_url();?>assets/plugins/raphael/2.1.0/raphael-min.js"></script>
  <script src="<?= base_url();?>assets/plugins/morris/morris.min.js"></script>
  <!-- SlimScroll -->
  <script src="<?= base_url();?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?= base_url();?>assets/plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url();?>assets/dist/js/app.min.js"></script>
  
  <script src="<?= base_url();?>assets/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url();?>assets/datatables/DataTables-1.10.12/js/dataTables.bootstrap.js"></script>
  <script src="<?= base_url();?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="<?= base_url();?>assets/DataTables/select-1.2.0/js/datatables.select.min.js"></script>

  
<script type="text/javascript">
var save_method;
var id_blanking = "";
var id_blanking_time = "";
var table1 = "";
var id = "";

$(function () {
  // "use strict";
  var d = new Date(); d.setDate( d.getDate());
  $('#datet').datepicker({autoclose:true}).datepicker('setDate', d); 
  d = new Date(); d.setDate( d.getDate() - 30);
  $('#datef').datepicker({autoclose:true}).datepicker('setDate', d);

  $("#standar").hide();
  $("#lblstandar").hide();

  $('#flange_size').on('change', function() {
    if ( $('select[name=flange_size] option:selected').text() > 25)
    {
      $("#standar").show();
      $("#lblstandar").show();
    }
    else
    {
      $("#standar").hide();
      $("#lblstandar").hide();
    }
  });
});

function search_blanking()
{
  var url;
  url = "<?php echo site_url('qc/search_blanking')?>";
  $.ajax({
    url : url,
    type: "POST",
    data: $('#form_export').serialize(),
    dataType: "JSON",
    success: function(data)
    {
        if ( $.fn.DataTable.isDataTable('#tables') ) { 
          $("#tables").DataTable().destroy();
        }
        $("#tables").empty();
        table = $('#tables').DataTable({ 
            "destroy": true,
            "autoWidth": false,
            "paging":false,
            "processing": true, //Feature control the processing indicator.
            // "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "data":data.data,
            "columns": [
            { "data":"action","title": "ACTION","width":"10%"  },
            { "data":"date_process","title": "DATE","width":"10%"  },
            { "data":"dim_name","title": "DIMENSION","width":"10%"  },
            { "data":"code_size","title": "SIZE","width":"5%"  },
            { "data":"code_class","title": "CLASS","width":"5%"  },
            { "data":"or_ir","title": "OR/IR","width":"5%"  },
            { "data":"diameter","title": "DIAMETER","width":"5%"  },
            { "data":"sample","title": "SAMPLE","width":"5%"  },
            { "data":"A3","title": "A2","width":"5%"  },
            { "data":"D3","title": "D3","width":"5%"  },
            { "data":"D4","title": "D4","width":"5%"  },
            { "data":"d1lsl","title": "D1(LSL)","width":"5%"  },
            { "data":"d1usl","title": "D1(USL)","width":"5%"  },
            { "data":"d2lsl","title": "D2(LSL)","width":"5%"  },
            { "data":"d2usl","title": "D2(USL)","width":"5%"  },
            { "data":"d3lsl","title": "D3(LSL)","width":"5%"  },
            { "data":"d3usl","title": "D3(USL)","width":"5%"  },
            { "data":"d4lsl","title": "D4(LSL)","width":"5%"  },
            { "data":"d4usl","title": "D4(USL)","width":"5%"  }
            ],

            // Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            }
            ],
            // "scrollY":"300px",
            "scrollX": true,
            "sScrollX":"100%",
            "sScrollXInner": "110%",
            "bScrollCollapse": true
        });

        $('#tables tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
            id_blanking = table.row( this ).data().id;
            blanking_xchart(id_blanking);
            blanking_all(id_blanking);
        } ); 
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error Searching data');
        $('#btnexport').text('EXPORT'); //change button text
        $('#btnexport').attr('disabled',false); //set button enable 
    }
  });
}

function blanking_xchart(id)
{
  $.ajax({
    "url": "<?php echo site_url('qc/blanking_chart_all')?>/"+id,
    "dataType": "json",
    "cache": false,
    "type": "POST",
    "timeout":3000,

    success : function (data) {
    //console.log(data); alert(JSON.stringify(data));
      $('#x-chart').empty();
      $('#r-chart').empty();

      Morris.Line({
      element: 'x-chart',
      data: data,
      parseTime:false,
      xkey: 'time',
      ykeys: ['lsl','xlcl', 'xcl','xucl','usl','avg'],
      labels: ['lsl','xlcl', 'xcl','xucl','usl','avg'],
      lineColors: ['#00008B', '#800080','#2E8B57','#000000','#8B0000','#006400'],
      resize: true,
      hideHover: 'auto',
      ymin: 'auto',
      ymax: 'auto',
      numLines: 10,
      yLabelFormat: function(y) {
        return y.toFixed(2);
      }
      });

      Morris.Line({
      element: 'r-chart',
      data: data,
      parseTime:false,
      xkey: 'time',
      ykeys: ['rlcl', 'rcl','rucl','range'],
      labels: ['rlcl', 'rcl','rucl','range'],
      lineColors: ['#800080','#2E8B57','#000000','#006400'],
      resize: true,
      hideHover: 'auto',
      ymin: 'auto',
      ymax: 'auto',
      numLines: 10,
      yLabelFormat: function(y) {
        return y.toFixed(2);
      }
      });
  }
  });
}

function blanking_all(id)
{
  $.ajax({
    "url": "<?php echo site_url('qc/blankingall')?>/"+id,
    "dataType": "json",
    "success": function(json) {
        var tableHeaders;

        // $("#tables3").find('thead tr th').remove();
        $.each(json.columns, function(i, val){
            tableHeaders += "<th>" + val + "</th>";
        });

        if ( $.fn.DataTable.isDataTable('#tables3') ) { 
          $("#tables3").DataTable().destroy();
        }

        $("#tables3").empty();
        $("#tables3").append('<thead><tr>' + tableHeaders + '</tr></thead>');
        $('#tables3').DataTable({"paging":false,"searching":false,"data":json.data,"sorting":false});
    }
  });

  $.ajax({
    "url": "<?php echo site_url('qc/blankingall_dt')?>/"+id,
    "dataType": "json",
    "success": function(json) {
        var tableHeaders1;
        // $("#tables4").find('thead tr th').remove();
        $.each(json.columns, function(i, val){
            tableHeaders1 += "<th>" + val + "</th>";
        });

        if ( $.fn.DataTable.isDataTable('#tables4') ) { 
          $("#tables4").DataTable().destroy();
        }

        $("#tables4").empty();
        $("#tables4").append('<thead><tr>' + tableHeaders1 + '</tr></thead>');
        $("#tables4").DataTable({"paging":false,"searching":false,"data":json.data,"sorting":false});  
    }
  });
}

function add_blanking()
{
    save_method = 'add';
    $('#form_add')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Blanking'); // Set Title to Bootstrap modal title
    $('#date_process').datepicker({autoclose:true}).datepicker('setDate', new Date());
    $('#standar').hide();
    $('#lblstandar').hide();
    $(".dataa").remove();
    $(".datalabel").remove();
}

function add_blanking_data()
{
    save_method = 'add_data';
    $('#form_add_dt')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#edit_blanking_dt_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Blanking Data'); // Set Title to Bootstrap modal title
    $(".dataa").remove();
    $(".datalabel").remove();
    getdata_edit();
    $('[name="id_blanking"]').val($('#form_edit_blanking').find('input[name="id"]').val());
}

function export_data_blanking()
{
  $('#btnexport').text('exporting data...'); //change button text
  $('#btnexport').attr('disabled',true); //set button disable 
  var url;
  url = "<?php echo site_url('qc/export_blanking')?>";

  $.ajax({
    url : url,
    type: "POST",
    data: $('#form_export').serialize(),
    dataType: "JSON",
    success: function(data)
    {
        // window.open(url);
        
        var $a = $("<a>");
        $a.attr("href",data.file);
        $("body").append($a);
        $a.attr("download","Blanking.xls");
        $a[0].click();
        $a.remove();

        $('#btnexport').text('EXPORT'); //change button text
        $('#btnexport').attr('disabled',false); //set button enable 
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error Export data');
        $('#btnexport').text('EXPORT'); //change button text
        $('#btnexport').attr('disabled',false); //set button enable 

    }
  });
}

function edit_blanking(id)
{
    save_method = 'update';
    $('#form_edit_blanking')[0].reset(); // reset form on modals
    // $('.form-group').removeClass('has-error'); // clear error class
    // $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('qc/blanking_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="date_process"]').val(data.date_process);
            // $('[name="date_process"]').prop('disabled', true);
            $('[name="flange_size"]').val(data.id_flang_size);
            $('[name="class"]').val(data.id_class);
            $('[name="standar"]').val(data.id_dimension);
            $('[name="sample"]').val(data.id_sample);
            $('[name="ir_or"]').val(data.or_ir);
            $('[name="diameter"]').val(data.diameter);
            $("#form_edit_blanking :input").prop("disabled", true);

            table5 = $('#tables5').DataTable({ 
              "destroy": true,
              "autoWidth": false,
              "processing": true, //Feature control the processing indicator.
              "serverSide": true, //Feature control DataTables' server-side processing mode.
              "order": [], //Initial no order.
              // Load data for the table's content from an Ajax source
              "ajax": {
                  "url": "<?php echo site_url('qc/blanking_time_edit')?>/" + data.id,
                  "type": "POST"
              },
              "columns": [
              // { "data":"tes","title": "ACTION","width":"10%"  },
              { "data":"time","title": "DATE","width":"10%"  },
              { "data":"id","title": "ID","width":"10%"  }
              ],

              //Set column definition initialisation properties.
              "columnDefs": [
              { 
                  "targets": [ -1 ], //last column
                  "orderable": false, //set not orderable
              }
              ],
              // "scrollY":"300px",
              "paging":false,
              "searching":false,
              "sorting":false,
              "scrollX": true,
              "sScrollX":"100%",
              "sScrollXInner": "110%",
              "bScrollCollapse": true
            });

            $('#tables5 tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    table5.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
                id_blanking = table5.row( this ).data().id;
                blanking_data(id_blanking);
            } );

            $('#edit_blanking_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Blanking'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function blanking_data(id)
{
  table6 = $('#tables6').DataTable({ 
    // "retrieve": true,
    "destroy":true,
    "autoWidth": false,
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [], //Initial no order.
    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": "<?php echo site_url('qc/blanking_dt_edit')?>/" + id,
        "type": "POST"
    },
    "columns": [
    // { "data":"tes","title": "ACTION","width":"10%"  },
    { "data":"value","title": "DATE","width":"10%"  },
    { "data":"id","title": "ID","width":"10%"  }
    ],

    //Set column definition initialisation properties.
    "columnDefs": [
    { 
        "targets": [ -1 ], //last column
        "orderable": false, //set not orderable
    }
    ],
    // "scrollY":"300px",
    "paging":false,
    "searching":false,
    "sorting":false,
    "scrollX": true,
    "sScrollX":"100%",
    "sScrollXInner": "110%",
    "bScrollCollapse": true
  });
}

function getdata_edit() {
  $(".dataa").remove();
  $(".datalabel").remove();
  var i=0;
  len1=document.getElementById('sample').value;
  for(i;i<=len1;i++)
  {
    //Create the label element
    // var lblid = "#" + $(this).attr("id") + "_lbl";
    var $label = $("<label>").text('Data ' + (i+1) + ' :').attr({for: 'labelfrom', name: 'labelfrom', class: 'datalabel'});
    //Create the input element
    var $input = $('<input type="text">').attr({id: 'datafe'+ (i+1), name: 'datafe[]',value:'', class: 'dataa'});

    //Insert the input into the label
    $input.appendTo($label);
    //Insert the label into the DOM - replace body with the required position
    $('#form_add_dt').append($label);

  }
}

function getdata() {
  $(".dataa").remove();
  $(".datalabel").remove();
  var i=0;
  len1=document.getElementById('sample').value;
  for(i;i<=len1;i++)
  {
    //Create the label element
    // var lblid = "#" + $(this).attr("id") + "_lbl";
    var $label = $("<label>").text('Data ' + (i+1) + ' :').attr({for: 'labelfrom', name: 'labelfrom', class: 'datalabel'});
    //Create the input element
    var $input = $('<input type="text">').attr({id: 'dataf'+ (i+1), name: 'dataf[]',value:'', class: 'dataa'});

    //Insert the input into the label
    $input.appendTo($label);
    //Insert the label into the DOM - replace body with the required position
    $('#form_add').append($label);

  }
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function reload_table3()
{
    table3.ajax.reload(null,false); //reload datatable ajax 
}
function reload_table4()
{
    table4.ajax.reload(null,false); //reload datatable ajax 
}
function reload_table5()
{
    table5.ajax.reload(null,false); //reload datatable ajax 
}

function reload_table6()
{
    table6.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('qc/blanking/c')?>";
    }else {
        url = "<?php echo site_url('qc/blanking/u')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_add').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                search_blanking();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function save_dt()
{
    $('#btnSavedt').text('saving...'); //change button text
    $('#btnSavedt').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add_data') {
        url = "<?php echo site_url('qc/blanking_dt/c')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_add_dt').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#edit_blanking_dt_form').modal('hide');
                reload_table5();
                // reload_table6();
                // reload_table();
            }
            else
            {
              alert('Please fill data !!');
            }

            $('#btnSavedt').text('save'); //change button text
            $('#btnSavedt').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSavedt').text('save'); //change button text
            $('#btnSavedt').attr('disabled',false); //set button enable 

        }
    });
}

function delete_blanking(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('qc/blanking/d')?>/",
            type: "POST",
            data: { id: id, locale: 'en-US' },
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                search_blanking();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
    }
}

function delete_blanking_dt(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('qc/blanking_dt/d')?>/",
            type: "POST",
            data: { id: id, locale: 'en-US' },
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
    }
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Blanking Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_add" name="form_add">
                  <input type="hidden" value="" name="id"/> 
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-3">Date</label>
                          <div class="col-md-9">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="date_process" name="date_process">
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3">Size</label>
                          <div class="col-md-9">
                            <select name="flange_size" id="flange_size" class="form-control"><option></option>
                              <?php $size = $this->qc_m->getsize();?>
                              <?php foreach($size as $rowsize){?>
                              <option value="<?=$rowsize->id?>"><?=$rowsize->code_size?></option>
                              <?php }?>
                            </select> 
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3">Class</label>
                          <div class="col-md-9">
                              <select name="class" id="class" class="form-control"><option></option>
                                <?php $class = $this->qc_m->getclass();?>
                                <?php foreach($class as $rowclass){?>
                                <option value="<?=$rowclass->id?>"><?=$rowclass->code_class?></option>
                                <?php }?>  
                              </select>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label id="lblstandar" class="control-label col-md-3">Standar</label>
                          <div class="col-md-9">
                              <select name="standar" id="standar" class="form-control"><option></option>
                                <option value='2'>Asme A</option>
                                <option value='3'>Asme B</option>
                              </select>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3">Data</label>
                          <div class="col-md-9">
                              <select name="sample" id="sample" onchange="getdata()" class="form-control"><option></option>
                                <?php $data = $this->qc_m->getcontrolchart();?>
                                <?php foreach($data as $rowdata){?>
                                <option value="<?=$rowdata->id?>"><?=$rowdata->sample?></option>
                                <?php }?>  
                              </select>
                          </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">IR/OR</label>
                        <div class="col-md-9">
                          <select name="ir_or" id="ir_or" class="form-control"><option></option>
                            <option value='1'>IR</option>
                            <option value='2'>OR</option>   
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Diameter</label>
                        <div class="col-md-9">
                          <select name="diameter" id="diameter" class="form-control"><option></option>
                            <option value='1'>d1</option>
                            <option value='2'>d2</option> 
                            <option value='3'>d3</option>
                            <option value='4'>d4</option>   
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="edit_blanking_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Blanking Form</h3>
            </div>
            <div class="modal-body form">
              <form action="#" id="form_edit_blanking" >
                <!-- <input type="text" name="id"/> -->
                <input type="hidden" value="" name="id"/> 
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Date</label>
                        <div class="col-md-9">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="date_process" name="date_process">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Size</label>
                        <div class="col-md-9">
                          <select name="flange_size" id="flange_size" class="form-control"><option></option>
                            <?php $size = $this->qc_m->getsize();?>
                            <?php foreach($size as $rowsize){?>
                            <option value="<?=$rowsize->id?>"><?=$rowsize->code_size?></option>
                            <?php }?>
                          </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Class</label>
                        <div class="col-md-9">
                            <select name="class" id="class" class="form-control"><option></option>
                              <?php $class = $this->qc_m->getclass();?>
                              <?php foreach($class as $rowclass){?>
                              <option value="<?=$rowclass->id?>"><?=$rowclass->code_class?></option>
                              <?php }?>  
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label id="lblstandar" class="control-label col-md-3">Standar</label>
                        <div class="col-md-9">
                            <select name="standar" id="standar" class="form-control"><option></option>
                              <option value='1'>asmeb.16</option>
                              <option value='2'>asme.b.16_47a</option>
                              <option value='3'>asme.b.16_47B</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Data</label>
                        <div class="col-md-9">
                            <select name="sample" id="sample" onchange="getdata()" class="form-control"><option></option>
                              <?php $data = $this->qc_m->getcontrolchart();?>
                              <?php foreach($data as $rowdata){?>
                              <option value="<?=$rowdata->id?>"><?=$rowdata->sample?></option>
                              <?php }?>  
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">IR/OR</label>
                      <div class="col-md-9">
                        <select name="ir_or" id="ir_or" class="form-control"><option></option>
                          <option value='1'>IR</option>
                          <option value='2'>OR</option>   
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">Diameter</label>
                      <div class="col-md-9">
                        <select name="diameter" id="diameter" class="form-control"><option></option>
                          <option value='1'>d1</option>
                          <option value='2'>d2</option> 
                          <option value='3'>d3</option>
                          <option value='4'>d4</option>   
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <div>
              <br>
              </div>
                <table id="tables5" class="display no-wrap" cellspacing="0" width="100%">
                </table>
                <button class="btn btn-success" onclick="add_blanking_data()"><i class="glyphicon glyphicon-plus"></i> Add</button>
                <button class="btn btn-danger" onclick="delete_blanking_dt(id_blanking)"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                <table id="tables6" class="display no-wrap" cellspacing="0" width="100%">
                </table>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" id="btnSave" onclick="delete_time()" class="btn btn-danger">Delete</button> -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="edit_blanking_dt_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Blanking Form</h3>
            </div>
            <div class="modal-body form">
              <form action="#" id="form_add_dt" name="form_add_dt">
                <input type="hidden" value="" name="id"/> 
                <input type="hidden" value="" name="id_blanking"/> 
              </form>
              <div>
              <br>
              </div>
                <button class="btn btn-primary" id="btnSavedt" onclick="save_dt()"><i class="glyphicon glyphicon-plus"></i>Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" id="btnSave" onclick="delete_time()" class="btn btn-danger">Delete</button> -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>