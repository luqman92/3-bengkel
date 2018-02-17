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
                                    <i class="fa fa-user"></i>
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
                                        $TLServis="";
                                        foreach($laba_servis AS $lbsp):
                                            $TLServis=$lbsp->tlaba_servis;
                                            if(!empty($lbsp->tgl_lunas)){
                                                echo "Rp. ".format_angka($lbsp->tlaba_servis);
                                            }else{
                                                echo "Rp. 0";
                                            }
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Laba Servis
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    LABA SERVIS
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        $TLpart="";
                                       foreach($laba_sparepart AS $lbspp):
                                        $TLpart = $lbspp->tlaba_part;
                                            if(!empty($lbspp->tgl_lunas)){
                                                echo "Rp. ".format_angka($lbspp->tlaba_part);
                                            }else{
                                                echo "Rp. 0";
                                            }
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Laba Sparepart
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    LABA SPAREPART
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        $TL = $TLServis+$TLpart;
                                            if(!empty($TL)){
                                                echo "Rp. ".format_angka($TL);
                                            }else{
                                                echo "Rp. 0";
                                            }
                                        ?>
                                    </h3>
                                    <p>
                                        Total Laba
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    TOTAL LABA
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        $TModalPart="";
                                       foreach($modal_part AS $mp):
                                        $TModalPart= $mp->TModalPart;
                                            if(!empty($mp->tgl_lunas)){
                                                echo "Rp. ".format_angka($mp->TModalPart);
                                            }else{
                                                echo "Rp. 0";
                                            }
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Modal Sparepart
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    MODAL SPAREPART
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
                                        $TOmzet = $TL+$TModalPart;
                                            if(!empty($TOmzet)){
                                                echo "Rp. ".format_angka($TOmzet);
                                            }else{
                                                echo "Rp. 0";
                                            }
                                        ?>
                                    </h3>
                                    <p>
                                        Omzet
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    OMZET
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php
                                       foreach($unit AS $Un):
                                            if(!empty($Un->tgl_lunas)){
                                                echo $Un->Unit;
                                            }else{
                                                echo "0";
                                            }
                                        endforeach;
                                        ?>
                                    </h3>
                                    <p>
                                        Unit
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-motorcycle"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    UNIT
                                </a>
                            </div>
                        </div><!-- ./col -->

                    </div><!-- /.row -->

                </section><!-- /.content -->