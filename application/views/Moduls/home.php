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
                                    <h3>
                                        <?php
                                        foreach($trxbengkels AS $trxbengkel):
                                            echo $trxbengkel->jml;
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Transaksi Bengkel
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php
                                       foreach($customers AS $customer):
                                            echo $customer->jml;
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Data Customer
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        foreach($karyawans AS $karyawan):
                                            echo $karyawan->jml;
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Data Karyawan
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-tasks fa-fw"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        foreach($users AS $user):
                                            echo $user->jml;
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Data User
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->

                    </div><!-- /.row -->

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        foreach($laba_servis AS $lbsp):
                                            echo $lbsp->tlaba_servis;
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Laba Servis
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    <!-- More info <i class="fa fa-arrow-circle-right"></i> -->
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php
                                       foreach($laba_sparepart AS $lbspp):
                                            echo $lbspp->tlaba_part;
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Laba Sparepart
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    <!-- More info <i class="fa fa-arrow-circle-right"></i> -->
                                </a>
                            </div>
                        </div><!-- ./col -->
<!--                         <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        foreach($modal_part AS $mp):
                                            echo $mp->TModalPart;
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Modal Sparepart
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-tasks fa-fw"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div> -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        foreach($omzet AS $om):
                                            echo $om->TOmzet;
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Omzet
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    <!-- More info <i class="fa fa-arrow-circle-right"></i> -->
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        foreach($unit AS $Un):
                                            echo $Un->Unit;
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Unit
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    <!-- More info <i class="fa fa-arrow-circle-right"></i> -->
                                </a>
                            </div>
                        </div><!-- ./col -->

                    </div><!-- /.row -->

                </section><!-- /.content -->