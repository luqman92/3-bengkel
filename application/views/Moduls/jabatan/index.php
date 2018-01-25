                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Jabatan
                        <small>List Data Jabatan</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">List Data Jabatan</li>
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
                                <a class="btn btn-primary" href="<?php echo base_url() ?>admin/addmerk"><i class="fa fa-plus-circle"></i> Data Jabatan</a>
                                <br><br>
                                    <table id="listkat" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Diskripsi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($jabatans as $jabatan) {
                                        ?>
                                            <tr>
                                                <td><?=$no;?></td>
                                                <td><?=$jabatan->kode?></td>
                                                <td><?=$jabatan->diskripsi?></td>
                                                <td><a href="<?php echo base_url(); ?>index.php/admin/editmerk/<?php echo $jabatan->jabatan_id ?>"><i class="fa fa-pencil-square-o"></i></a> | <a href="<?php echo base_url(); ?>index.php/admin/delmerk/<?php echo $jabatan->jabatan_id ?>" onclick="javascript: return confirm('Anda yakin hapus ?')"><i class="fa fa-trash-o"></i></a></td>
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
                                                <th>Action</th>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section>
