          <!-- http://mbahcoding.com/tutorial/php/codeigniter/codeigniter-ajax-crud-using-bootstrap-modals-and-datatable.html -->
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Form Transaksi
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">List Form Transaksi</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <!-- <h3 class="box-title">Data Table With Full Features</h3> -->                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                <div class="box-group" id="accordion">
                                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                        <div class="panel box box-primary">
                                            <div class="box-header">
                                                <h4 class="box-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                        Informasi Order
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse">
                                                <div class="box-body">
                                    <?php
                                    foreach($pmb_sps AS $pmb_sp){
                                    ?>
                                <form action="<?php echo site_url('admin/pmb_addup')?>" method="post">
                                    <!-- <a class="btn btn-success" href="<?=site_url('admin/unsetcust')?>"><i class="glyphicon glyphicon-plus"></i> Pilih Customer</a> -->
                                         <br>
                                         <br>
                                         <br>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <label>No Trans #</label>
                                                <input class="form-control" type="text" name="id" value="<?=$NoTrxs?>" readonly>
                                            </div>
                                            <div class="col-xs-2">
                                                <label>Cara Bayar</label>
                                                <select class="form-control" name="cara">
                                                    <option value="TUNAI">TUNAI</option>
                                                    <option value="HUTANG">HUTANG</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-2">
                                                <label>Tgl Transaksi</label>
                                                <input class="form-control" type="text" name="tgl" value="<?=$pmb_sp->tgl?>">
                                            </div>
                                            <div class="col-xs-2">
                                                <label>Jatuh Tempo</label>
                                                <input class="form-control" type="text" name="tgl_tempo" value="<?=$pmb_sp->tgl_tempo?>">
                                            </div>
                                            <div class="col-xs-2">
                                                <label>Tgl Lunas</label>
                                                <input class="form-control" type="text" name="tgl_lunas" value="<?=$pmb_sp->tgl_lunas?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <label>Supplier</label>
                                                <input class="form-control" type="text" name="nama" value="<?=$pmb_sp->nama?>" readonly>
                                            </div>
                                            <div class="col-xs-8">
                                                <label>Keterangan</label>
                                                <textarea class="form-control" name="keterangan"><?=$pmb_sp->keterangan?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <input class="btn btn-success" type="submit" name="" value="Submit" />
                                            </div>
                                        </div>
                                    </div>                                    
                                    </form>
                                    <?php } ?>
                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel box box-danger">
                                            <div class="box-header">
                                                <h4 class="box-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                        Detail Order
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseTwo" class="panel-collapse collapse in">
                                                <div class="box-body">
                                                <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Pembelian Barang</button>
                                                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                                                <br />
                                                <br />
                                                    <table id="tables" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Kode</th>
                                                                <th>Jenis</th>
                                                                <th>Keterangan</th>
                                                                <th>@Harga (Rp)</th>
                                                                <th>Qty</th>
                                                                <th>Pot (%)</th>
                                                                <th>Jumlah (Rp)</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Kode</th>
                                                                <th>Jenis</th>
                                                                <th>Keterangan</th>
                                                                <th>@Harga (Rp)</th>
                                                                <th>Qty</th>
                                                                <th>Pot (%)</th>
                                                                <th>Jumlah (Rp)</th>
                                                                <th>Action</th>
                                                                
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section>


<script>
    $(document).ready(function(){
       $("#searchbrg").select2({
            placeholder:"Please Select"
       }); 
        $("#searchspp").select2({
            placeholder:"Please Select"
       }); 
    });
</script>

<script type="text/javascript">
 
var tables;
 
$(document).ready(function() {
 
    //datatables
    tables = $('#tables').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/ajax_list_trxbengkel')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
});
</script>
        <!-- SCRIPT -->
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
jQuery(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/ajax_list_trxbengkel')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
    //datepicker
   /* $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });*/
 
});
 
 
 
function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
}
 
function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin/ajax_edit_trxbengkel/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id);
            $('[name="kode"]').val(data.kode);
            $('[name="jenis"]').val(data.jenis);
            $('[name="keterangan"]').val(data.keterangan);
            $('[name="harga"]').val(data.harga);
            $('[name="qty"]').val(data.qty);
            $('[name="pot]').val(data.pot);
            $('[name="total"]').val(data.total);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function reload_table()
{
    //alert('TEST') ;
    table.ajax.reload(null,false); //reload datatable ajax 
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('admin/ajax_add_trxbengkel')?>";
    } else {
        url = "<?php echo site_url('admin/ajax_update_trxbengkel')?>";
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
 
function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('admin/ajax_delete_trxbengkel')?>/"+id,
            type: "POST",
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
<div class="modal fade" tabindex="-1" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Barang Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Barang</label>
                            <div class="col-md-9">
                                <select name="gender" class="form-control" id="searchbrg">
                                    <option value="">--Select Barang--</option>
                                    <?php
                                    foreach ($mstrbrgs as $mstrbrg) {
                                       ?>  
                                       <option value="<?=$mstrbrg->KodeBarang?>"><?=$mstrbrg->NamaBarang?></option>
                                       <?php
                                    }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>  
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Jumlah</label>
                            <div class="col-md-9">
                                <input name="dob" placeholder="" class="form-control datepicker" type="text">
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

<!-- SCRIPT -->