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
                                    $customer_id = "";
                                    $Jenis = "";
                                    foreach($dtrxs AS $dtrx){
                                        $customer_id = $dtrx->customer_id;
                                        $Jenis = $dtrx->jenis;
                                    ?>
                                <form action="<?php echo site_url('admin/trxbengkelup')?>" method="post">
                                    <a class="btn btn-success" href="<?=site_url('admin/unsetcust')?>"><i class="glyphicon glyphicon-plus"></i> Pilih Customer</a>
                                         <br>
                                         <br>
                                         <br>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <label>No Trans #</label>
                                                <input class="form-control" type="text" name="id" value="<?=$KdTrx?>" readonly>
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
                                                <input class="form-control" type="date" name="tgl" value="<?=$dtrx->tgl?>">
                                            </div>
                                            <div class="col-xs-2">
                                                <label>Jatuh Tempo</label>
                                                <input class="form-control" type="date" name="tgl_tempo" value="<?=$dtrx->tgl_tempo?>">
                                            </div>
                                            <div class="col-xs-2">
                                                <label>Tgl Lunas</label>
                                                <input class="form-control" type="date" name="tgl_lunas" value="<?=$dtrx->tgl_lunas?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <label>No Pol #</label>
                                                <input class="form-control" type="text" name="nopol" value="<?=$dtrx->no_polisi?>" readonly>
                                            </div>
                                            <div class="col-xs-2">
                                                <label>KM Motor</label>
                                                <input class="form-control" type="number" name="km" value="<?=$dtrx->km?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <label>Keluhan</label>
                                                <textarea class="form-control" name="keluhan"><?=$dtrx->keluhan?></textarea>
                                            </div>
                                            <div class="col-xs-5">
                                                <label>Keterangan</label>
                                                <textarea class="form-control" name="keterangan"><?=$dtrx->keterangan?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <label>Mekanik</label>
                                                <select class="form-control" name="id_mekanik">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach($mekaniks AS $mekanik){
                                                        $selected="";
                                                        if($mekanik->nama){
                                                            $selected = "selected";
                                                        }
                                                        ?>
                                                        <option value="<?=$mekanik->karyawan_id?>" <?=$selected?>><?=$mekanik->nama?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <input class="btn btn-success" type="submit" name="btnaddinfo" value="Submit" />
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
                                                <button class="btn btn-success" onclick="add_trxbengkel()"><i class="glyphicon glyphicon-plus"></i> JASA/SERVICE</button>
                                                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                                                <br />
                                                <br />
                                                    <table id="tables" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Jenis</th>
                                                                <th>Keterangan</th>
                                                                <th>@Harga (Rp)</th>
                                                                <th>Qty</th>
                                                                <th>Jumlah (Rp)</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Jenis</th>
                                                                <th>Keterangan</th>
                                                                <th>@Harga (Rp)</th>
                                                                <th>Qty</th>
                                                                <th>Jumlah (Rp)</th>
                                                                <th>Action</th>
                                                                
                                                            </tr>
                                                        </tfoot>
                                                    </table>
<div class="row">
<div class="col-md-9"></div>
<div class="col-md-3">

                                                    <form id='form1' action="<?=site_url('admin/act_trxbengkelup')?>" method="post">
                                                        <!-- <div class="form-group">
                                                            <label>Total</label>
                                                            <input class="txt form-control" type="text" id="total" onchange="hitung()" value="10000">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Dibayar</label> 
                                                            <input class="txt form-control" type="text" id="dibayar" onchange="hitung()" value="5000">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Kembalian</label>
                                                            <input class="form-control" type="text" id="kembalian">
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label></label>
                                                            <input type="hidden" name="NomorTransaksi" value="<?=$KdTrx?>"><br><br>
                                                            <input type="hidden" name="Jenis" value="<?=$Jenis?>"><br><br>
                                                            <button style="float:right" class="btn btn-success" type="submit">Simpan</button>
                                                        </div>
                                                    </form>
</div>
</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section>

<script type="text/javascript">
    function hitung() {
    var a = $("#total").val();
    var b = $("#dibayar").val();
    c = a - b; //a kali b
    $("#kembalian").val();
}        
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
 
});
 
 
 
function add_trxbengkel()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Jasa/Service'); // Set Title to Bootstrap modal title
}
 
function edit_trxbengkel(id)
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
            $('.modal-title').text('Edit Jasa/Service'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function reload_table()
{
    
    table.ajax.reload(null,false); //reload datatable ajax 
    document.location.reload();
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
 
function delete_trxbengkel(id)
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


/*function myFunction() {
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}*/
</script>
 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Jasa/Service Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="key"/>
                    <input type="hidden" value="<?=$KdTrx?>" name="NomorTransaksi"/>
                    <input type="hidden" value="<?=$customer_id?>" name="CustomerId"/>
                    <div class="form-body">

                        <!-- <div class="form-group">
                            <label class="control-label col-md-3">Part / Service</label>
                            <div class="col-md-9">
                                <label>Part</label>
                                <input class="form-control" type="radio" name="jenis" value="PART"> &nbsp;&nbsp;
                            <label>Service</label>
                                <input class="form-control" type="radio" name="jenis" value="SERVIS">
                            </div>
                        </div> -->
                        <div class="form-group">
                        <label class="control-label col-md-3">Part / Service</label>
                            <div class="col-md-9">
                            <select class="form-control" name="jenis">
                                <option value="">-- Pilih --</option>
                                <option value="PART">PART</option>
                                <option value="SERVIS">SERVIS</option>
                            </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-3">Nama Barang</label>
                            <div class="col-md-9">
                                <select name="KodeBarang" class="form-control">
                                    <option value="">--Select Barang--</option>
                                    <?php
                                    foreach($dtmbs AS $dtmb){
                                        ?>
                                        <option value="<?=$dtmb->KodeBarang?>"><?=$dtmb->NamaBarang?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label class="control-label col-md-3">Keterangan Jasa</label>
                            <div class="col-md-9">
                                <input name="Keterangan" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="control-label col-md-3">Harga Jasa</label>
                            <div class="col-md-9">
                                <input name="harga" placeholder="" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Jumlah</label>
                            <div class="col-md-2">
                                <input name="Keluar" placeholder="" class="form-control" type="number" value="1">
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