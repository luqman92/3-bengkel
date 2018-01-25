                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Retur
                        <small>List Data Retur</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">List Data Retur</li>
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
                                <a class="btn btn-primary" href="<?php echo base_url() ?>admin/addmerk"><i class="fa fa-plus-circle"></i> Data Retur</a>
                                <br><br>
                                    <table id="listkat" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Diskripsi</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($returs as $retur) {
                                        ?>
                                            <tr>
                                                <td><?=$no;?></td>
                                                <td><?=$retur->kode?></td>
                                                <td><?=$retur->diskripsi?></td>
                                                <td><?=$retur->qty?></td>
                                                <td><?=$retur->total?></td>
                                                <td><?=$retur->keterangan?></td>
                                                <td><?=$retur->status?></td>
                                                <td><a href="<?php echo base_url(); ?>index.php/admin/editmerk/<?php echo $retur->key_id ?>"><i class="fa fa-pencil-square-o"></i></a> | <a href="<?php echo base_url(); ?>index.php/admin/delmerk/<?php echo $retur->key_id ?>" onclick="javascript: return confirm('Anda yakin hapus ?')"><i class="fa fa-trash-o"></i></a></td>
                                            </tr>
                                        <?php
                                        $no++;
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Diskripsi</th>
                                                <th>Keterangan</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>Tanggal</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section>
