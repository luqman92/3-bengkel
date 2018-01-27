                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Sparepart
                        <small>List Data Sparepart</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">List Data Sparepart</li>
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
                                <!-- <a class="btn btn-primary" href="<?php echo base_url() ?>admin/addmerk"><i class="fa fa-plus-circle"></i> Data Sparepart</a> -->
                                <br><br>
                                    <table id="listkat" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Supplier</th>
                                                <th>Diskripsi</th>
                                                <th>Harga Pokok</th>
                                                <th>Harga Jual</th>
                                                <th>Stok</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($spareparts as $sparepart) {
                                        ?>
                                            <tr>
                                                <td><?=$no;?></td>
                                                <td><?=$sparepart->kode?></td>
                                                <td><?=$sparepart->supplier?></td>
                                                <td><?=$sparepart->diskripsi?></td>
                                                <td><?=$sparepart->harga_pokok?></td>
                                                <td><?=$sparepart->harga_jual?></td>
                                                <td><?=$sparepart->qty?></td>
                                                <td><a href="<?php echo base_url(); ?>index.php/admin/editmerk/<?php echo $sparepart->key_id ?>"><i class="fa fa-pencil-square-o"></i></a> | <a href="<?php echo base_url(); ?>index.php/admin/delmerk/<?php echo $sparepart->key_id ?>" onclick="javascript: return confirm('Anda yakin hapus ?')"><i class="fa fa-trash-o"></i></a></td>
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
                                                <th>Supplier</th>
                                                <th>Diskripsi</th>
                                                <th>Harga Pokok</th>
                                                <th>Harga Jual</th>
                                                <th>Stok</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section>
