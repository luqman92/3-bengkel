                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>0
                                        <?php
                                        /*foreach($articles AS $article):
                                            echo $article->jml;
                                        endforeach;*/
                                        ?>
                                    </h3>
                                    <p>
                                        Transaksi Bengkel
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="<?php echo base_url() ?>admin/article" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>0
                                        <?php
                                       /* foreach($programs AS $program):
                                            echo $program->jml;
                                        endforeach;*/
                                        ?>
                                    </h3>
                                    <p>
                                        Data Customer
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="<?php echo base_url()?>admin/albumvod" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>0
                                        <?php
                                        /*foreach($labels AS $label):
                                            echo $label->jml;
                                        endforeach;*/
                                        ?>
                                    </h3>
                                    <p>
                                        Data Karyawan
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-tasks fa-fw"></i>
                                </div>
                                <a href="<?php echo base_url()?>admin/label" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>0
                                        <?php
                                        /*foreach($kolumniss AS $kolumnis):
                                            echo $kolumnis->jml;
                                        endforeach;*/
                                        ?>
                                    </h3>
                                    <p>
                                        Data User
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="<?php echo base_url()?>admin/user" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->

                    </div><!-- /.row -->

                </section><!-- /.content -->