

    <!-- Main content -->
    <section class="content">

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
          <button class="btn btn-primary" onclick="add_blanking()"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
          <button class="btn btn-danger" onclick="add_blanking()"><i class="glyphicon glyphicon-remove"></i> Delete</button>
          <button class="btn btn-danger" onclick="add_blanking()"><i class="glyphicon glyphicon-print"></i> Print</button>
          <button class="btn btn-default" onclick="reload_table_blanking()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
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
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-success" onclick="add_blanking()"><i class="glyphicon glyphicon-plus"></i> Add</button>
          <button class="btn btn-primary" onclick="add_blanking()"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
          <button class="btn btn-danger" onclick="add_blanking()"><i class="glyphicon glyphicon-remove"></i> Delete</button>
          <button class="btn btn-default" onclick="reload_table_blanking()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        </div>
        <!-- /.box-footer-->
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
        <div class="box-footer">
          <button class="btn btn-success" onclick="add_blanking()"><i class="glyphicon glyphicon-plus"></i> Add</button>
          <button class="btn btn-primary" onclick="add_blanking()"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
          <button class="btn btn-danger" onclick="add_blanking()"><i class="glyphicon glyphicon-remove"></i> Delete</button>
          <button class="btn btn-default" onclick="reload_table_blanking()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        </div>
        <!-- /.box-footer-->
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
  // var selected = [];
 // var table;

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
        { "data":"proc_name","title": "PROCESS","width":"10%"  },
        { "data":"ctq","title": "CTQ","width":"100%"  },
        { "data":"dim_name","title": "DIMENSION","width":"10%"  },
        { "data":"code_size","title": "SIZE","width":"5%"  },
        { "data":"code_class","title": "CLASS","width":"5%"  },
        { "data":"lsl","title": "LSL","width":"5%"  },
        { "data":"usl","title": "USL","width":"5%"  },
        { "data":"d1lsl","title": "D1(LSL)","width":"5%"  },
        { "data":"d1usl","title": "D1(USL)","width":"5%"  },
        { "data":"d2lsl","title": "D2(LSL)","width":"5%"  },
        { "data":"d2usl","title": "D2(USL)","width":"5%"  },
        { "data":"d3lsl","title": "D3(LSL)","width":"5%"  },
        { "data":"d3usl","title": "D3(USL)","width":"5%"  },
        { "data":"d4lsl","title": "D4(LSL)","width":"5%"  },
        { "data":"d4usl","title": "D4(USL)","width":"5%"  },
        { "data":"id","title": "ID","width":"10%"  }],

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

    var detailsTableOpt = {
      'serverSide': true,
      'processing': true,
      'ajax': {
          'url': '<?php echo site_url('qc/blanking_dt')?>',
          "type": "POST",
          'data': function (d) {
              d.id_blanking = id_blanking;
          }
      },
      'destroy': true,
      'columns': [
            { 'data': 'id' },
            { 'data': 'id_blanking' },
            { 'data': 'time' }
      ]
    };

    $('#tables tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        // var rowIndex =  $.map(table.rows('.selected').data(), function (item) {
        //   return item['id']
        // });
        id_blanking = table.row( this ).data().id;
        edit_aclass(id_blanking);
        // $('#tables1').DataTable(detailsTableOpt).draw()
        // alert( 'You clicked on '+id_blanking+'\'s row' );
    } );

    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    // $("select").change(function(){
    //     $(this).parent().parent().removeClass('has-error');
    //     $(this).next().empty();
    // });
  });

function edit_aclass(id)
{
    var table = $('#tables1').DataTable({ 
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
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Code Chart</label>
                            <div class="col-md-9">
                                <input name="codeChart" placeholder="Code Charts" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Name Chart</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="Name Charts" class="form-control" type="text">
                                <span class="help-block"></span>
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