<!-- 0821-6186-9689 -->
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Laporan Omzet
                        <small>List Laporan Omzet</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">List Laporan Omzet</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                   <!--  <h3 class="box-title">Data Table With Full Features</h3> -->                                    
                                </div><!-- /.box-header -->
                           <div class="row">
                                <div class="col-md-3">

                                </div>

                                <div class="col-md-6">
                                    <form action="<?=site_url('admin/lapomzet')?>" method="post">
                                     <?php
                                     if(!empty($this->session->userdata('tgl_awal'))){
                                    ?>
                                    <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Tanggal Awal</span>
                                          <input type="date" class="form-control" placeholder="" aria-describedby="basic-addon1" name="tgl_awal" value="<?php echo $this->session->userdata('tgl_awal')?>">
                                          <span class="input-group-addon" id="basic-addon1">Tanggal Akhir</span>
                                          <input type="date" class="form-control" placeholder="" aria-describedby="basic-addon1" name="tgl_akhir" value="<?php echo $this->session->userdata('tgl_akhir')?>">
                                          <span class="input-group-btn">
                                            <button class="btn btn-success" type="submit" name="btn_tampil">Tampilkan!</button>
                                          </span>
                                          <span class="input-group-btn">
                                            <button class="btn btn-success" type="submit" name="btn_cetakPDF">Cetak PDF</button>
                                          </span>
                                    </div>
                                    <?php
                                     }else{                                     ?>
                                     <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Tanggal Awal</span>
                                          <input type="date" class="form-control" placeholder="" aria-describedby="basic-addon1" name="tgl_awal" value="<?=date('Y-m-d')?>">
                                          <span class="input-group-addon" id="basic-addon1">Tanggal Akhir</span>
                                          <input type="date" class="form-control" placeholder="" aria-describedby="basic-addon1" name="tgl_akhir" value="<?=date('Y-m-d')?>">
                                          <span class="input-group-btn">
                                            <button class="btn btn-success" type="submit" name="btn_tampil">Tampilkan!</button>
                                          </span>
                                          <span class="input-group-btn">
                                            <button class="btn btn-success" type="submit" name="btn_cetakPDF" target="_blank">Cetak PDF</button>
                                          </span>
                                    </div>
                                    <?php } ?>
                                    </form>
                                </div>
                                <div class="col-md-3">

                                </div>
                           </div>
                           <br>
                           <br>
                           <div class="row">
                                <div class="col-md-12">
                                    <?php
                                        if(isset($btn_tampil)){
                                            ?>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Laba Servis</th>
                                                        <th>Laba Part</th>
                                                        <th>Modal Part</th>
                                                        <th>Omzet</th>
                                                        <th>Unit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                error_reporting(0);
                                                $no = "1";
                                                $TLabaServis ="";
                                                $TLabaPart ="";
                                                $TModalPart ="";
                                                $Omzet ="";
                                                $Unit ="";
                                                foreach($selLabas AS $row){
                                                    $TLabaServis = $TLabaServis+$row->TLabaServis;
                                                    $TLabaPart = $TLabaPart+$row->TLabaPart;
                                                    $TModalPart = $TModalPart+$row->TModalPart;
                                                    $Omzet = $Omzet+$row->Omzet;
                                                    $Unit = $Unit+$row->Unit;
                                                ?>
                                                    <tr>
                                                        <td><?=$no?></td>
                                                        <td><?=$row->tgl_lunas?></td>
                                                        <td><?=format_angka($row->TLabaServis)?></td>
                                                        <td><?=format_angka($row->TLabaPart)?></td>
                                                        <td><?=format_angka($row->TModalPart)?></td>
                                                        <td><?=format_angka($row->Omzet)?></td>
                                                        <td><?=$row->Unit?></td>
                                                    </tr>
                                                <?php
                                                $no++;
                                                }
                                                ?>
                                                    <tr>
                                                        <td colspan="2" style="text-align:center; font-size:20px; font-weight:bold;">TOTAL</td>
                                                        <td style="font-size:20px; font-weight:bold;">Rp. <?=format_angka($TLabaServis)?></td>
                                                        <td style="font-size:20px; font-weight:bold;">Rp. <?=format_angka($TLabaPart)?></td>
                                                        <td style="font-size:20px; font-weight:bold;">Rp. <?=format_angka($TModalPart)?></td>
                                                        <td style="font-size:20px; font-weight:bold;">Rp. <?=format_angka($Omzet)?></td>
                                                        <td style="font-size:20px; font-weight:bold;"><?=$Unit?></td>
                                                    </tr>

                                                    <tr>
                                                        <td style="font-weight:bold;">LABA SERVIS</td>
                                                        <td>:</td>
                                                        <td colspan="5" style="font-weight:bold;">Rp. <?=format_angka($TLabaServis)?> <?="(".terbilang($TLabaServis).")"?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold;">LABA PART</td>
                                                        <td>:</td>
                                                        <td colspan="5" style="font-weight:bold;">Rp. <?=format_angka($TLabaPart)?> <?="(".terbilang($TLabaPart).")"?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold;">MODAL PART</td>
                                                        <td>:</td>
                                                        <td colspan="5" style="font-weight:bold;">Rp. <?=format_angka($TModalPart)?> <?="(".terbilang($TModalPart).")"?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold;">OMZET</td>
                                                        <td>:</td>
                                                        <td colspan="5" style="font-weight:bold;">Rp. <?=format_angka($Omzet)?> <?="(".terbilang($Omzet).")"?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold;">TOTAL UNIT</td>
                                                        <td>:</td>
                                                        <td colspan="5" style="font-weight:bold;"><?=$Unit?> <?="(".terbilang($Unit).")"?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <?php
                                        }
                                    ?>
                                </div>
                           </div>
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section>
<!-- SCRIPT -->
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/ajax_list_bo')?>",
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
 
 
 
function add_bo()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Biaya Operasional'); // Set Title to Bootstrap modal title
}
 
function edit_bo(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('admin/ajax_edit_bo/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id);
            $('[name="tgl"]').val(data.tgl);
            $('[name="kode"]').val(data.kode);
            $('[name="keterangan"]').val(data.keterangan);
            $('[name="diskripsi"]').val(data.diskripsi);
            $('[name="total"]').val(data.total);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Biaya Operasional'); // Set title to Bootstrap modal title
 
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
        url = "<?php echo site_url('admin/ajax_add_bo')?>";
    } else {
        url = "<?php echo site_url('admin/ajax_update_bo')?>";
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
                //document.location.reload();
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
 
function delete_bo(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('admin/ajax_delete_bo')?>/"+id,
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
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Cabang Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal</label>
                            <div class="col-md-9">
                                <input name="tgl" placeholder="" class="form-control" type="date">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Kode</label>
                            <div class="col-md-9">
                                <input name="kode" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Diskripsi</label>
                            <div class="col-md-9">
                                <input name="diskripsi" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan</label>
                            <div class="col-md-9">
                                <input name="keterangan" placeholder="" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">total</label>
                            <div class="col-md-9">
                                <input name="total" placeholder="" class="form-control" type="number">
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