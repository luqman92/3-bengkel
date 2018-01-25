                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Merk Motor
                        <small>List Merk Motor</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">List Merk Motor</li>
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
                                <div class="box-body table-responsive"><!-- <?php echo base_url() ?>admin/addmerk -->
                                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#AddMerk"><i class="fa fa-plus-circle"></i> Merk Motor</a>
                                <br><br>
                                    <table id="listkat" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Merek</th>
                                                <th>Keterangan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($merks as $merk) {
                                        ?>
                                            <tr>
                                                <td><?=$no;?></td>
                                                <td><?=$merk->kode?></td>
                                                <td><?=$merk->merk_motor?></td>
                                                <td><?=$merk->keterangan?></td>
                                                <td><a href="<?php echo base_url(); ?>index.php/admin/editmerk/<?php echo $merk->merk_id ?>"><i class="fa fa-pencil-square-o"></i></a> | <a href="<?php echo base_url(); ?>index.php/admin/delmerk/<?php echo $merk->merk_id ?>" onclick="javascript: return confirm('Anda yakin hapus ?')"><i class="fa fa-trash-o"></i></a></td>
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
                                                <th>Merek</th>
                                                <th>Keterangan</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <!-- Modal -->
                                    <div class="modal fade" id="AddMerk" role="dialog" aria-labelledby="myModalLabel">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Add Merek</h4>
                                          </div>
                                          <div class="modal-body">
                                          <form action="<?php echo site_url('admin/act_addmerk'); ?>" method="post">
                                            <div class="form-group">
                                                <label>Kode</label>
                                                <input class="form-control" type="text" name="kode" autofocus="on">
                                            </div>
                                            <div class="form-group">
                                                <label>Merek Motor</label>
                                                <input class="form-control" type="text" name="merk_motor">
                                            </div>
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <input class="form-control" type="text" name="keterangan">
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
