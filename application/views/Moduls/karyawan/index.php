                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Karyawan
                        <small>List Data Karyawan</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">List Data Karyawan</li>
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
                                <a class="btn btn-primary" href="<?php echo base_url() ?>admin/addmerk"><i class="fa fa-plus-circle"></i> Data Karyawan</a>
                                <br><br>
                                    <table id="listkat" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Telepon</th>
                                                <th>Jabatan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($karyawans as $Karyawan) {
                                        ?>
                                            <tr>
                                                <td><?=$no;?></td>
                                                <td><?=$Karyawan->nama?></td>
                                                <td><?=$Karyawan->tlp?></td>
                                                <td></td>
                                                <td><a href="<?php echo base_url(); ?>index.php/admin/editmerk/<?php echo $Karyawan->karyawan_id ?>"><i class="fa fa-pencil-square-o"></i></a> | <a href="<?php echo base_url(); ?>index.php/admin/delmerk/<?php echo $Karyawan->karyawan_id ?>" onclick="javascript: return confirm('Anda yakin hapus ?')"><i class="fa fa-trash-o"></i></a></td>
                                            </tr>
                                        <?php
                                        $no++;
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Merk Motor Name</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section>
