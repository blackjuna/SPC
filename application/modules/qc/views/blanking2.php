
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
          <button class="btn btn-success" onclick="add_blanking()"><i class="glyphicon glyphicon-plus"></i> Add</button>
          <button class="btn btn-primary" onclick=""><i class="glyphicon glyphicon-pencil"></i> Edit</button>
          <button class="btn btn-danger" onclick=""><i class="glyphicon glyphicon-remove"></i> Delete</button>
          <button class="btn btn-danger" onclick=""><i class="glyphicon glyphicon-print"></i> Print</button>
          <button class="btn btn-default" onclick=""><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">BLANKING DETAIL</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table id="tables1" class="display no-wrap" cellspacing="0" width="100%">
          </table>
        </div>
      </div>
      <!-- /.box -->
      
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">DATA</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table id="tables2" class="display no-wrap" cellspacing="0" width="100%">
          </table>
        </div>
        <!-- /.box-body -->
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

      if ( this.value > 19)
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

$(document).ready(function() {

  //datatables
  var table = $('#tables').DataTable({ 
      "autoWidth": false,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "<?php echo site_url('qc/blanking/r')?>",
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
      { "data":"tes","title": "ACTION","width":"10%"  }],

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
      id_blanking = table.row( this ).data().id;
      blanking_time(id_blanking);
      blanking_data(null);
      blanking_all(id_blanking);
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

function blanking_time(id)
{
    var table1 = $('#tables1').DataTable({ 
        "searching": false,
        "autoWidth": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('qc/blanking_dt')?>/"+id,
            "type": "POST"
        },
        'destroy': true,
        "columns": [
        { "data":"id","title": "ID"  },
        { "data":"id_blanking","title": "BLANKING"  },
        { "data":"time","title": "DATE"  }],

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
       //Ajax Load data from ajax
      $('#tables1 tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table1.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        id_blanking_time = table1.row( this ).data().id;
        blanking_data(id_blanking_time);
      });
}

function blanking_data(id)
{
    var table2 = $('#tables2').DataTable({ 
        "searching": false,
        "autoWidth": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('qc/blanking_data')?>/"+id,
            "type": "POST"
        },
        'destroy': true,
        "columns": [
        { "data":"id","title": "ID"  },
        { "data":"id_blanking_time","title": "BLANKING TIME"  },
        { "data":"value","title": "VALUE"  }],

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
    //Ajax Load data from ajax
}


function blanking_all(id)
{
  // console.log("<?php echo site_url('qc/blankingall')?>/"+id);

  $.ajax({
    "url": "<?php echo site_url('qc/blankingall')?>/"+id,
    "dataType": "json",
    "success": function(json) {
        var tableHeaders;
        $.each(json.columns, function(i, val){
            tableHeaders += "<th>" + val + "</th>";
        });

        $("#tables3").empty();
        $("#tables3").append('<thead><tr>' + tableHeaders + '</tr></thead>');
        $('#tables3').DataTable({"data":json.data});
        console.log(json.data);
    }
  });

  // console.log('tes');

    /*var table3 = $('#tables3').DataTable({ 
        // "fixedHeader": true,
        "searching": false,
        "autoWidth": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('qc/blankingall')?>/"+id,
            // "url": "<?php echo site_url('qc/tes')?>",
            "type": "POST"
        },
        // "columns": data,
        // 'destroy': true,
        "fixedcoloumns":true,
        "scrollX": true,
        "sScrollX":"100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true
    });*/
    //Ajax Load data from ajax
}



function add_blanking()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Blanking'); // Set Title to Bootstrap modal title
        setdata();
}

function setdata() {
  $(".dataa").remove();
  $(".datalabel").remove();
  console.log('removeee');
}

function getdata() {
  var i=0;
  len1=document.getElementById('data').value;
  for(i;i<=len1;i++)
  {
    //Create the label element
    // var lblid = "#" + $(this).attr("id") + "_lbl";
    var $label = $("<label>").text('Data ' + (i+1) + ' :').attr({for: 'labelfrom', name: 'labelfrom', class: 'datalabel'});
    //Create the input element
    var $input = $('<input type="text">').attr({id: 'from'+ (i+1), name: 'from'+ (i+1), class: 'dataa'});

    //Insert the input into the label
    $input.appendTo($label);
    //Insert the label into the DOM - replace body with the required position
    $('form').append($label);

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
                <form action="#" id="form" name="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Date</label>
                            <div class="col-md-9">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker">
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
                                <select name="data" id="data" onchange="getdata()" class="form-control"><option></option>
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
</body>
</html>