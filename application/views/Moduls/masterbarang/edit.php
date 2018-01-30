<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Edit Merk Motor
        <small>Edit Merk Motor panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('./'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Merk Motor</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <!-- <h3 class="box-title">Quick Example</h3> -->
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <?php 
                                    foreach ($merks as $merk) {
                                ?>
                                <form role="form" action="<?php echo site_url('admin/act_editmerk'); ?>" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="merk_id" name="merk_id" value="<?php echo $merk->merk_id; ?>">
                                            <label for="merk_motor">Merk Motor Name</label>
                                            <input type="text" class="form-control" id="merk_motor" name="merk_motor" value="<?php echo $merk->merk_motor; ?>">
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            <?php } ?>
                            </div><!-- /.box -->
        </div>
    </div>
</section>