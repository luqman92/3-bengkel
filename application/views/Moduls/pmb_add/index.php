          <!-- http://mbahcoding.com/tutorial/php/codeigniter/codeigniter-ajax-crud-using-bootstrap-modals-and-datatable.html -->
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Form Pembelian Sparepart Motor
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
                                                        Data Invoice
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse">
                                                <div class="box-body">
                                                
                                                <?php
                                                    $supplier = "";
                                                    foreach($pmb_sps AS $pmb_sp){
                                                        $supplier = $pmb_sp->supplier;
                                                ?>
                                                <form action="<?php echo site_url('admin/pmb_addup')?>" method="post">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                           <div class="form-group">
                                                                <label>NO PMB</label>
                                                                <input class="form-control" type="text" name="id" value="<?=$NoTrxs?>" readonly>
                                                           </div>
                                                           <div class="form-group">
                                                                <label>NO SJ</label>
                                                                <input class="form-control" type="text" name="no_sj" value="<?=$pmb_sp->no_sj?>">
                                                           </div>
                                                           <div class="form-group">
                                                                <label>Supplier</label>
                                                                <input class="form-control" type="text" value="<?=$pmb_sp->supplier?>" readonly>
                                                           </div>
                                                           <div class="form-group">
                                                                <label>Cara Bayar</label>
                                                                <select class="form-control" name="cara">
                                                                    <option>-- Pilih Cara Bayar --</option>
                                                                    <?php
                                                                        foreach ($caras as $carabyr) {
                                                                        $selected="";
                                                                        if($pmb_sp->cara == $carabyr->cara){
                                                                            $selected = "selected";
                                                                        }
                                                                            ?>
                                                                                <option value="<?=$carabyr->cara?>" <?=$selected?>><?=$carabyr->cara?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                    <!-- <option value="LUNAS">LUNAS</option>
                                                                    <option value="HUTANG">HUTANG</option> -->
                                                                </select>
                                                           </div>
                                                           <div class="form-group">
                                                                <label>Keterangan</label>
                                                                <input class="form-control" type="text" name="keterangan" value="<?=$pmb_sp->keterangan?>">
                                                           </div>
                                                        <div class="form-group">
                                                            <input class="btn btn-success" type="submit" name="" value="Submit" />
                                                        </div>    
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Tanggal beli</label>
                                                                <input class="form-control" type="date" name="tgl" value="<?=$pmb_sp->tgl?>">
                                                           </div>
                                                           <div class="form-group">
                                                                <label>Jatuh tempo</label>
                                                                <input class="form-control" type="date" name="tgl_tempo" value="<?=$pmb_sp->tgl_tempo?>">
                                                           </div>
                                                           <div class="form-group">
                                                                <label>Tanggal Lunas</label>
                                                                <input class="form-control" type="date" name="tgl_lunas" value="<?=$pmb_sp->tgl_lunas?>">
                                                           </div>

                                                        </div>
                                                        <div class="col-md-2">
                                                            <br>
                                                            <br>
                                                            <center><h1 style="font-weight:bold;"><?=$pmb_sp->cara?></h1></center>
                                                        </div>
                                                          
                                                    </div>
                                                </div>
                                                </form>
                                                <?php } ?>
                                                
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
                                                <button class="btn btn-success" onclick="add_barang()"><i class="glyphicon glyphicon-plus"></i> Pembelian Barang</button>
                                                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                                                <br />
                                                <br />
                                                    <table id="tables" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Keterangan</th>
                                                                <th>@Harga (Rp)</th>
                                                                <th>Qty</th>
                                                                <!-- <th>Pot (%)</th> -->
                                                                <th>Jumlah (Rp)</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Keterangan</th>
                                                                <th>@Harga (Rp)</th>
                                                                <th>Qty</th>
                                                                <!-- <th>Pot (%)</th> -->
                                                                <th>Jumlah (Rp)</th>
                                                                <th>Action</th>
                                                                
                                                            </tr>
                                                        </tfoot>
                                                    </table>

                                                    <form action="<?=site_url('admin/add_pmba_act')?>" method="post">
                                                        <div class="form-group">
                                                            <label></label>
                                                            <input type="hidden" name="NomorTransaksi" value="<?=$NoTrxs?>"><br><br>
                                                            <button style="float:right" class="btn btn-success" type="submit">Simpan</button>
                                                        </div>
                                                    </form>
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
            "url": "<?php echo site_url('admin/ajax_list_pmba')?>",
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
            "url": "<?php echo site_url('admin/ajax_list_pmba')?>",
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
 
 
 
function add_barang()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Barang'); // Set Title to Bootstrap modal title
}
 
function edit_barang(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin/ajax_edit_pmba/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="key_id"]').val(data.key_id);
            $('[name="KodeBarang"]').val(data.kode);
            $('[name="harga"]').val(data.harga);
            $('[name="Masuk"]').val(data.qty);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Barang'); // Set title to Bootstrap modal title
 
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
    document.location.reload();
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('admin/ajax_add_pmba')?>";
    } else {
        url = "<?php echo site_url('admin/ajax_update_pmba')?>";
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
 
function delete_barang(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('admin/ajax_delete_pmba')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
                document.location.reload();
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Barang Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="key_id"/> 
                    <div type="hidden" class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Barang</label>
                            <div class="col-md-9">
                                <select name="KodeBarang" class="form-control" id="searchbrg">
                                    <option value="">--Select Barang--</option>
                                    <?php
                                    foreach ($mstrbrgs as $mstrbrg) {
                                       ?>  
                                       <option value="<?=$mstrbrg->KodeBarang?>"><?=$mstrbrg->NamaBarang?></option>
                                       <?php
                                    }
                                    ?>
                                </select>
                                
                            </div>  
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Jumlah</label>
                            <div class="col-md-9">
                                <input name="Masuk" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Harga</label>
                            <div class="col-md-9">
                                <input name="harga" placeholder="" class="form-control" type="text">
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
<script type="text/javascript">
    $(document).ready(function() {
    $('#searchbrg').select2();
});

    /*document.body.appendChild(
    document.createTextNode("select is "
      + window.getComputedStyle(document.getElementById("im1")).display
      + " by default"));*/
</script>