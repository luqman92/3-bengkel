                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Registrasi
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Registrasi Customer
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
                                    <form action="<?php echo site_url('admin/act_rkunjungan'); ?>" method="POST">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-8">
                                                    <label>Search</label>
                                                    <div class="input-group">
                                                    <select id="searchreg" class="form-control" name="customer_id">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach($regs AS $reg){
                                                        ?>
                                                        <option value="<?=$reg->customer_id?>"><?=$reg->no_polisi." | ".$reg->nama." | ".$reg->alamat." | ".$reg->hp?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>    
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="submit">Kunjungan</button>
                                                    </span>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button"><i class="fa fa-plus-circle"></i> Registrasi baru</button>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section>


<script>
    $(document).ready(function(){
       $("#searchreg").select2({
            placeholder:"Please Select"
       }); 
    });
</script>