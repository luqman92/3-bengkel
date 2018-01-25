                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Cabang
                        <small>List Data Cabang</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">List Data Cabang</li>
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
                                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#AddCabang"><i class="fa fa-plus-circle"></i> Data Cabang</a>
                                <br><br>
                                    <table id="listkat" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Cabang</th>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>Kota</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($cabangs as $cabang) {
                                        ?>
                                            <tr>
                                                <td><?=$no;?></td>
                                                <td><?=$cabang->cabang_id?></td>
                                                <td><?=$cabang->nama?></td>
                                                <td><?=$cabang->alamat?></td>
                                                <td><?=$cabang->kota?></td>
                                                <td><a href="<?php echo base_url(); ?>index.php/admin/editmerk/<?php echo $cabang->cabang_id ?>"><i class="fa fa-pencil-square-o"></i></a> | <a href="<?php echo base_url(); ?>index.php/admin/delcabang/<?php echo $cabang->cabang_id ?>" onclick="javascript: return confirm('Anda yakin hapus ?')"><i class="fa fa-trash-o"></i></a></td>
                                            </tr>
                                        <?php
                                        $no++;
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Cabang</th>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>Kota</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <!-- Modal -->
                                    <div class="modal fade" id="AddCabang" role="dialog" aria-labelledby="myModalLabel">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Add Cabang</h4>
                                          </div>
                                          <div class="modal-body">
                                          <form action="<?php echo site_url('admin/act_addcabang'); ?>" method="post">
                                            <div class="form-group">
                                                <label>Kode</label>
                                                <input class="form-control" type="text" name="cabang_id" value="<?=$kdcabang?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input class="form-control" type="text" name="nama">
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <input class="form-control" type="text" name="alamat">
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xs-4">
                                                        <label>Kota</label>
                                                        <input class="form-control" type="text" name="kota">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label>Kode Pos</label>
                                                        <input class="form-control" type="text" name="kodepos">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <label>Fax</label>
                                                        <input class="form-control" type="text" name="fax">
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <label>Telepon</label>
                                                        <input class="form-control" type="text" name="tlp">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" type="text" name="email">
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                          </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section>
