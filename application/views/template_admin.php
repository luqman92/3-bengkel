<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Administrator | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <!--<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" />-->
        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
        <!-- font Awesome -->
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo base_url(); ?>assets/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo base_url(); ?>assets/css/datepicker.css" rel="stylesheet" type="text/css" />

        <!-- DATA TABLES -->
        <!--<link href="<?php echo base_url(); ?>assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />-->
        <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/select2.min.css')?>" rel="stylesheet">

        <!-- <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
     -->

     <!-- CORE -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.js"></script>
        <!-- CORE -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.<?php echo base_url(); ?>assets/js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url(); ?>admin/index" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                E-Bengkel
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $this->session->userdata('username'); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo base_url(); ?>upload/user/<?php echo $this->session->userdata('picture'); ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $this->session->userdata('username'); ?><!--  - Web Developer
                                        <small>Member since Nov. 2012</small> -->
                                    </p>
                                </li>
                                
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <!-- <div class="pull-left">
                                        <a href="../" target="_blank" class="btn btn-default btn-flat">Ke Frontend</a>
                                    </div> -->
                                    <div class="pull-right">
                                        <a href="<?php echo site_url('login/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url(); ?>upload/user/<?php echo $this->session->userdata('picture'); ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Welcome, <?php echo $this->session->userdata('username'); ?></p>

                            <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                    <?php
                    if($this->session->userdata('level') == '1'){
                        // data main menu
                        //$this->db->order_by('birth_date', 'ASC')->get_where($this->tbl_name, $where);
                        $main_menu = $this->db->order_by('position', 'ASC')->get_where('menu', array('parent_id' => 0,'group_id' => 1,'active' => 'Y'));
                        foreach ($main_menu->result() as $main) {
                            // Query untuk mencari data sub menu
                            $sub_menu = $this->db->order_by('position', 'ASC')->get_where('menu', array('parent_id' => $main->id,'active' => 'Y'));
                            // periksa apakah ada sub menu
                            if ($sub_menu->num_rows() > 0) {
                                // main menu dengan sub menu
                                echo "<li class='treeview'>" . anchor($main->url, '<i class="fa ' . $main->class . '"></i>' . $main->title .
                                        '<span class="pull-right-container">
                                                <i class="fa fa-angle-left pull-right"></i>
                                            </span>');
                                // sub menu nya disini
                                echo "<ul class='treeview-menu'>";
                                foreach ($sub_menu->result() as $sub) {
                                    echo "<li>" . anchor($sub->url, '<i class="fa ' . $sub->class . '"></i>' . $sub->title) . "</li>";
                                }
                                echo"</ul></li>";
                            } else {
                                // main menu tanpa sub menu
                                echo "<li>" . anchor($main->url, '<i class="fa ' . $main->class . '"></i>' . $main->title) . "</li>";
                            }
                        }
                    }elseif ($this->session->userdata('level') == '2') {
                       // data main menu
                        //$this->db->order_by('birth_date', 'ASC')->get_where($this->tbl_name, $where);
                        $main_menu = $this->db->order_by('position', 'ASC')->get_where('menu', array('parent_id' => 0,'group_id' => 2,'active' => 'Y'));
                        foreach ($main_menu->result() as $main) {
                            // Query untuk mencari data sub menu
                            $sub_menu = $this->db->order_by('position', 'ASC')->get_where('menu', array('parent_id' => $main->id));
                            // periksa apakah ada sub menu
                            if ($sub_menu->num_rows() > 0) {
                                // main menu dengan sub menu
                                echo "<li class='treeview'>" . anchor($main->url, '<i class="fa ' . $main->class . '"></i>' . $main->title .
                                        '<span class="pull-right-container">
                                                <i class="fa fa-angle-left pull-right"></i>
                                            </span>');
                                // sub menu nya disini
                                echo "<ul class='treeview-menu'>";
                                foreach ($sub_menu->result() as $sub) {
                                    echo "<li>" . anchor($sub->url, '<i class="fa ' . $sub->class . '"></i>' . $sub->title) . "</li>";
                                }
                                echo"</ul></li>";
                            } else {
                                // main menu tanpa sub menu
                                echo "<li>" . anchor($main->url, '<i class="fa ' . $main->class . '"></i>' . $main->title) . "</li>";
                            }
                        }
                    }elseif ($this->session->userdata('level') == '3') {
                       // data main menu
                        //$this->db->order_by('birth_date', 'ASC')->get_where($this->tbl_name, $where);
                        $main_menu = $this->db->order_by('position', 'ASC')->get_where('menu', array('parent_id' => 0,'group_id' => 3,'active' => 'Y'));
                        foreach ($main_menu->result() as $main) {
                            // Query untuk mencari data sub menu
                            $sub_menu = $this->db->order_by('position', 'ASC')->get_where('menu', array('parent_id' => $main->id));
                            // periksa apakah ada sub menu
                            if ($sub_menu->num_rows() > 0) {
                                // main menu dengan sub menu
                                echo "<li class='treeview'>" . anchor($main->url, '<i class="fa ' . $main->class . '"></i>' . $main->title .
                                        '<span class="pull-right-container">
                                                <i class="fa fa-angle-left pull-right"></i>
                                            </span>');
                                // sub menu nya disini
                                echo "<ul class='treeview-menu'>";
                                foreach ($sub_menu->result() as $sub) {
                                    echo "<li>" . anchor($sub->url, '<i class="fa ' . $sub->class . '"></i>' . $sub->title) . "</li>";
                                }
                                echo"</ul></li>";
                            } else {
                                // main menu tanpa sub menu
                                echo "<li>" . anchor($main->url, '<i class="fa ' . $main->class . '"></i>' . $main->title) . "</li>";
                            }
                        }
                    }
                        
                    ?>  
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <?php echo $contents;?>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

<!-- <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
 -->
        
        <script src="<?php echo base_url(); ?>assets/js/moment.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <!--<script src="<?php echo base_url(); ?>assets/js/bootstrap.js" type="text/javascript"></script>-->
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
        <!-- DATA TABES SCRIPT -->
        <!--<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>-->
        <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
        <!--<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>-->
        <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
        <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>

        <!-- daterangepicker -->
        <script src="<?php echo base_url(); ?>assets/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/select2.min.js" type="text/javascript"></script>
        <!--<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js" type="text/javascript"></script>-->
        <!--<script type="text/javascript">
            $(document).ready(function(){
                $('#datetimepicker1').datepicker({
                    format: 'yyyy-mm-dd',    
                });
                
            });
        </script>-->
        
        <!-- AdminLTE App -->
        <script src="<?php echo base_url(); ?>assets/js/AdminLTE/app.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#listkat").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>




 
    </body>
</html>