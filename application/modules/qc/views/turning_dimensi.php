
    <!-- Main content -->
    <section class="content">
      
      <!-- AREA CHART -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Chart <?=$title_module?></h3>
        </div>
        <div class="box-body chart-responsive">
          <div class="chart" id="revenue-chart" style="height: 300px;"></div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- AREA CHART -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?=$title_module?></h3>
        </div>
        <div class="box-body chart-responsive">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Date Range:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="reservation">
                </div>
              </div>

    
              <div class="form-group">
                <label class="control-label col-md-3">IR/OR</label>
                  <select name="ir_or" id="ir_or" class="form-control"><option></option>
                    <option value='1'>IR</option>
                    <option value='2'>OR</option>   
                  </select>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3">Diameter</label>
                  <select name="diameter" id="diameter" class="form-control"><option></option>
                    <option value='1'>d1</option>
                    <option value='2'>d2</option> 
                    <option value='3'>d3</option>
                    <option value='4'>d4</option>   
                  </select>
              </div>

            </div>
            <!-- /.col -->
            <div class="col-md-6">
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
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-info pull-right" onclick="add_turning_dimensi()"><i class="glyphicon glyphicon-search"></i> SEARCH</button>
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
          <button class="btn btn-success" onclick="add_turning_dimensi()"><i class="glyphicon glyphicon-plus"></i> Add</button>
          <button class="btn btn-danger" onclick=""><i class="glyphicon glyphicon-print"></i> Print</button>
          <button class="btn btn-default" onclick=""><i class="glyphicon glyphicon-refresh"></i> Reload</button>
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
var id_turning_dimensi = "";
var id_turning_dimensi_time = "";
var table1 = "";
// var table="";

$(function () {
  "use strict";

  // AREA CHART
  var area = new Morris.Area({
    element: 'revenue-chart',
    resize: true,
    data: [
      {y: '2011 Q1', item1: 2666, item2: 2666},
      {y: '2011 Q2', item1: 2778, item2: 2294},
      {y: '2011 Q3', item1: 4912, item2: 1969},
      {y: '2011 Q4', item1: 3767, item2: 3597},
      {y: '2012 Q1', item1: 6810, item2: 1914},
      {y: '2012 Q2', item1: 5670, item2: 4293},
      {y: '2012 Q3', item1: 4820, item2: 3795},
      {y: '2012 Q4', item1: 15073, item2: 5967},
      {y: '2013 Q1', item1: 10687, item2: 4460},
      {y: '2013 Q2', item1: 8432, item2: 5713}
    ],
    xkey: 'y',
    ykeys: ['item1', 'item2'],
    labels: ['Item 1', 'Item 2'],
    lineColors: ['#a0d0e0', '#3c8dbc'],
    hideHover: 'auto'
  });

  //Date range picker
    $('#reservation').daterangepicker();

      //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    $("#standar").hide();
    $("#lblstandar").hide();

  $('#flange_size').on('change', function() {
    // alert(' ');

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
    // console.log($('select[name=flange_size] option:selected').text());
  });
});

$(document).ready(function() {
  //datatables
  table = $('#tables').DataTable({ 
      "autoWidth": false,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "<?php echo site_url('qc/turning_dimensi/r')?>",
          "type": "POST"
      },
      "columns": [
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
      { "data":"d4usl","title": "D4(USL)","width":"5%"  },
      { "data":"id","title": "ID","width":"10%"  },
      { "data":"action","title": "ACTION","width":"10%"  }],

      //Set column definition initialisation properties.
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
      id_turning_dimensi = table.row( this ).data().id;
      // blanking_time(id_blanking);
      // blanking_data(null);
      turning_dimensi_all(id_turning_dimensi);
  } );

  $("input").change(function(){
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
  });
  $("textarea").change(function(){
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
  });  
});

function turning_dimensi_all(id)
{
  $.ajax({
    "url": "<?php echo site_url('qc/turning_dimensi_all')?>/"+id,
    "dataType": "json",
    // "bDestroy":"true",
    // "retrieve": true,
    "success": function(json) {
        var tableHeaders;
        // var table3 = $('#tables3').DataTable();
        $.each(json.columns, function(i, val){
            tableHeaders += "<th>" + val + "</th>";
        });

        $("#tables3").empty();
        $("#tables3").append('<thead><tr>' + tableHeaders + '</tr></thead>');
        table3 =$('#tables3').DataTable({"retrieve": true,"paging":false,"searching":false,"data":json.data,"sorting":false});
        table3.destroy();

        table3 =$('#tables3').DataTable({"retrieve": true,"paging":false,"searching":false,"data":json.data,"sorting":false});
        // console.log(json.data);
    }
  });

  $.ajax({
    "url": "<?php echo site_url('qc/turning_dimensi_all_dt')?>/"+id,
    "dataType": "json",
    // "bDestroy":"true",
    // "retrieve": true,
    "success": function(json) {
        var tableHeaders1;
        // var table3 = $('#tables3').DataTable();
        $.each(json.columns, function(i, val){
            tableHeaders1 += "<th>" + val + "</th>";
        });

        $("#tables4").empty();
        $("#tables4").append('<thead><tr>' + tableHeaders1 + '</tr></thead>');
        table4 = $("#tables4").DataTable({"retrieve": true,"paging":false,"searching":false,"data":json.data,"sorting":false});
        table4.destroy();

        table4 = $("#tables4").DataTable({"retrieve": true,"paging":false,"searching":false,"data":json.data,"sorting":false});
        // console.log(json.data);
    }
  });
}

function add_turning_dimensi()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Turning Dimensi'); // Set Title to Bootstrap modal title
    $(".dataa").remove();
    $(".datalabel").remove();
}

function edit_turning_dimensi()
{
  table = $('#tables4').DataTable({ 
      "autoWidth": false,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "<?php echo site_url('qc/turning_dimensi/r')?>",
          "type": "POST"
      },
      "columns": [
      { "data":"time","title": "TIME","width":"10%"  },
      { "data":"action","title": "ACTION","width":"10%"  }],

      //Set column definition initialisation properties.
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
  // save_method = 'add';
  // $('#form')[0].reset(); // reset form on modals
  // $('.form-group').removeClass('has-error'); // clear error class
  // $('.help-block').empty(); // clear error string
  $('#edit_blanking_form').modal('show'); // show bootstrap modal
  $('.modal-title').text('Edit Turning Dimensi'); // Set Title to Bootstrap modal title
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
    $('form').append($label);

  }
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('qc/turning_dimensi/c')?>";
    } else {
        url = "<?php echo site_url('qc/turning_dimensi/u')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
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


</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Turning Dimensi Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" name="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Date</label>
                            <div class="col-md-9">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="date">
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
<div class="modal fade" id="edit_turning_dimensi_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Turning Dimensi Form</h3>
            </div>
            <div class="modal-body form">
              <table id="tables4" class="display no-wrap" cellspacing="0" width="100%">
              </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="delete_time()" class="btn btn-danger">Delete</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>