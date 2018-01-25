<?php
/*$query = $this->db->query("SELECT * FROM theme WHERE active='Y' LIMIT 1")->result();

foreach($query as $querys):
	include "themes/$querys->folder";
endforeach;*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

    <!-- Your Basic Site Informations -->
    <title><?php echo isset($title) ? $title : 'Sport Channel Indonesia' ; ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="" />
    <meta name="keywords" content="lqcms buat sendiri rasa webmu" />
    <meta http-equiv="Copyright" content="lqcms" />
    <meta name="author" content="LQCMS" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta name="language" content="Indonesia" />
    <meta name="revisit-after" content="7" />
    <meta name="webcrawlers" content="all" />
    <meta name="rating" content="general" />
    <meta name="spiders" content="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- <title>Sports Channel Indonesia</title> -->
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-cosmo.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/sci.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/video-js.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/video-skin-custom.min.css" rel="stylesheet">
    <link href="//amp.azure.net/libs/amp/latest/skins/amp-default/azuremediaplayer.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="sci-header-desktop desktop">
        <div class="container-fluid sci-header">
            <div class="row head-one">
                <div class="container pad-0">
                    <div class="kiri">
                        <span><i class="fa fa-map-marker"></i>&nbsp; Plaza Kemang 88 Lt. 2 Unit 2B DKI Jakarta, Indonesia</span>
                        <span class="ml-10"><i class="fa fa-envelope"></i>&nbsp; sportschannelindonesia@gmail.com</span>
                        <span class="ml-10"><i class="fa fa-phone"></i>&nbsp; +62 21 7193387 +62 82123848781</span>
                    </div>
                    <div class="kanan">
                        <a href="#">
                            <div style="background: #4D67A3;"><i class="fa fa-facebook"></i></div>
                        </a>
                        <a href="#">
                            <div style="background: #EB4823;"><i class="fa fa-google-plus"></i></div>
                        </a>
                        <a href="#">
                            <div style="background: #21769B;"><i class="fa fa-twitter"></i></div>
                        </a>
                        <a href="#">
                            <div style="background: #CE1616;"><i class="fa fa-youtube-play"></i></div>
                        </a>
                        <a href="#">
                            <div style="background: #F77E00;"><i class="fa fa-rss"></i></div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row head-two">
                <div class="container pad-0 head-two-content" style="line-height: 50px;">
                    <div class="col-md-12">
                        <div class="kiri">
                            <img class="img-responsive" src="<?php echo base_url() ?>assets/img/logoSCI.png">
                        </div>
                        <div class="kanan">
                            <div id="sb-search" class="sb-search ">
                                <form action="<?php echo base_url()?>search/" method="get">
                                    <input class="sb-search-input" onkeyup="buttonUp();" placeholder="Enter your search term..." onblur="monkey();" type="search" value="" name="s" id="search">
                                    <input class="sb-search-submit" type="submit" value="">
                                    <span class="sb-icon-search"><i class="fa fa-search"></i></span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-default container pad-0">
            <div class="container pad-0">
                <ul class="nav nav-justified">
                 <?php
                        // data main menu
                        //$this->db->order_by('birth_date', 'ASC')->get_where($this->tbl_name, $where);
                        $main_menu = $this->db->order_by('position', 'ASC')->get_where('menu', array('parent_id' => 0,'group_id' => 2,'active' => 'Y'));
                        foreach ($main_menu->result() as $main) {
                            // Query untuk mencari data sub menu
                            $sub_menu = $this->db->order_by('position', 'ASC')->get_where('menu', array('parent_id' => $main->id));
                            // periksa apakah ada sub menu
                            if ($sub_menu->num_rows() > 0) {
                                // main menu dengan sub menu
                                //anchor('#', 'Home', array('class' => 'top_parent'));
                                echo "<li class='dropdown'>" . anchor($main->url, '' . $main->title .
                                        '<i class="caret' . $main->class . '"></i>', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown','role' => 'button','aria-expanded' => 'false'));
                                // sub menu nya disini
                                echo "<ul class='dropdown-menu'>";
                                foreach ($sub_menu->result() as $sub) {
                                    echo "<li>" . anchor($sub->url, '<i class="fa ' . $sub->class . '"></i>' . $sub->title) . "</li>";
                                }
                                echo"</ul></li>";
                            } else {
                                // main menu tanpa sub menu
                                echo "<li>" . anchor($main->url, '<i class="fa ' . $main->class . '"></i>' . $main->title) . "</li>";
                            }
                        }
                    ?> 
                    <!-- <li><a href="home.html">HOME <span class="sr-only">(current)</span></a></li>
                    <li><a href="news.html">NEWS</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">KATEGORI <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="search.html">BASKET</a></li>
                            <li><a href="kategori.html">TAKWONDO</a></li>
                            <li><a href="#">MARTIAL ART</a></li>
                        </ul>
                    </li>
                    <li><a href="program.html">PROGRAM</a></li>
                    <li><a href="video.html">VIDEO</a></li>
                    <li><a href="streaming.html">LIVE STREAM</a></li>
                    <li><a href="columnist.html">KOLUMNIS</a></li>
                    <li><a href="medal.html">EVENT</a></li>
                    <li><a href="contact.html">KONTAK</a></li> -->
                </ul>
            </div>
        </div>
    </div>
    <!-- navbar for mobile version -->
    <div class="sci-header-mobile mobile">
        <div class="col-xs-12 bg-black pad-0">
            <div class="col-sm-2 col-xs-2 top bg-black pad-0 text-center">
                <div class="clickable" data-toggle="modal" data-target="#left-menu">
                    <i class="fa fa-bars fa-lg"></i>
                </div>
            </div>
            <div class="col-sm-8 col-xs-8 top bg-black text-center">
                <img src="<?php echo base_url() ?>assets/img/logoSCI.png" style="height: 40px;">
            </div>
            <div class="col-sm-2 col-xs-2 top bg-black text-center pad-0">
                <div class="clickable" id="search-btn">
                    <i class="fa fa-search fa-lg"></i>
                </div>
            </div>
        </div>
        <div class="col-xs-12 bg-black search-mobile-div">
            <div class="col-80-f">
                <input type="text" class="form-control" placeholder="Cari sesuatu..">
            </div>
            <div class="col-80">
                <a href="#" class="btn btn-default btn-block">Cari</a>
            </div>
        </div>
        <div class="col-xs-12 pad-0 mobile-nav">
            <ul class="nav" style="background: #fff;">
                <li class="active"><a href="<?php echo base_url(); ?>category/news">NEWS</a></li>
                <li><a href="<?php echo base_url(); ?>article-streaming/detailpost/live-tv-sport-football">LIVE STREAM</a></li>
                <li><a href="<?php echo base_url(); ?>category/video">VIDEO</a></li>
                <li><a href="<?php echo base_url(); ?>category/columnist">COLUMNIST</a></li>
            </ul>
        </div>
    </div>
    
    <div class="modal left fade" id="left-menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-xs-9 pad-0">
                        <img class="img-responsive" src="<?php echo base_url() ?>assets/img/logoSCI.png" />
                    </div>
                    <div class="col-xs-3 pad-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times font-white"></i></span></button>
                    </div>
                </div>
                <div class="modal-body">
                    <ul class="nav sidebar-nav">
                        <!-- <li><a href="home.html">HOME</a></li>
                        <li><a href="news.html">NEWS</a></li>
                        <li><a href="">CATEGORY</a></li>
                        <li><a href="program.html">PROGRAM</a></li>
                        <li><a href="video.html">VIDEO</a></li>
                        <li><a href="streaming.html">LIVE STREAM</a></li>
                        <li><a href="columnist.html">COLUMNIST</a></li>
                        <li><a href="event.html">EVENT</a></li>
                        <li><a href="contact.html">CONTACT US</a></li> -->
                        <?php
                        // data main menu
                        //$this->db->order_by('birth_date', 'ASC')->get_where($this->tbl_name, $where);
                        $main_menu = $this->db->order_by('position', 'ASC')->get_where('menu', array('parent_id' => 0,'group_id' => 2,'active' => 'Y'));
                        foreach ($main_menu->result() as $main) {
                            // Query untuk mencari data sub menu
                            $sub_menu = $this->db->order_by('position', 'ASC')->get_where('menu', array('parent_id' => $main->id));
                            // periksa apakah ada sub menu
                            if ($sub_menu->num_rows() > 0) {
                                // main menu dengan sub menu
                                //anchor('#', 'Home', array('class' => 'top_parent'));
                                echo "<li class='dropdown'>" . anchor($main->url, '' . $main->title .
                                        '<i class="caret' . $main->class . '"></i>', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown','role' => 'button','aria-expanded' => 'false'));
                                // sub menu nya disini
                                echo "<ul class='dropdown-menu'>";
                                foreach ($sub_menu->result() as $sub) {
                                    echo "<li>" . anchor($sub->url, '<i class="fa ' . $sub->class . '"></i>' . $sub->title) . "</li>";
                                }
                                echo"</ul></li>";
                            } else {
                                // main menu tanpa sub menu
                                echo "<li>" . anchor($main->url, '<i class="'.activate_menu('$main->url').' fa ' . $main->class . '"></i>' . $main->title) . "</li>";
                            }
                        }
                    ?> 
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end of mobile navbar -->
    <div class="container pad-0 mt-min-30">
    	<?=$contents?>
    </div>
    <div class="container-fluid sci-footer">
        <div class="container mt-10 pad-0 footer-mobile-swap">
            <div class="col-md-3 col-sm-3 col-xs-12 mb-10 pad-0">
                <div class="container-fluid">
                    <div class="menu-title">EXPLORE</div>
                    <ul class="footer-explore">
                        <li><a href="<?php echo base_url();?>">HOME</a></li>
                        <li><a href="<?php echo base_url();?>article-columnist">COLUMNIST</a></li>
                        <li><a href="<?php echo base_url();?>article-news">NEWS</a></li>
                        <li><a href="<?php echo base_url();?>event">EVENT</a></li>
                        <li><a href="<?php echo base_url();?>aticle-video">VIDEO</a></li>
                        <li><a href="<?php echo base_url();?>contact-us">CONTACT US</a></li>
                        <li><a href="<?php echo base_url();?>article-streaming">LIVE STREAM</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 pad-0 mt-10-m text-center footer-about">
                <div class="menu-title">FOLLOW US ON</div>
                <div class="row">
                    <ul class="footer-socmed">
                        <li><a href="http://facebook.com/pages/Sports-Channel-ID/752360088214796" class="btn-circle" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/sportschannelid" class="btn-circle" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="btn-circle"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#" class="btn-circle"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
                <div class="row"><img class="imm-responsive" src="<?php echo base_url() ?>assets/img/logoSCI.png"></div>
                <h6>© 2017, Copyrights Sports Channel Indonesia. All Rights Reserved</h6>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 mt-10-m mb-10-m pad-0 footer-contact">
                <div class="container-fluid">
                    <div class="menu-title">CONTACT US</div>
                    <div class="col-xs-1 pad-0">
                        <i class="fa fa-map-marker fa-fw"></i>
                    </div>
                    <div class="col-xs-11 pl-10 pad-0">
                        Plaza Kemang 88 Lt. 2 Unit 2B DKI Jakarta, Indonesia
                    </div>
                    <div class="col-xs-1 pad-0 mt-5">
                        <i class="fa fa-envelope fa-fw"></i>
                    </div>
                    <div class="col-xs-11 pad-0 pl-10 mt-5 ellipsis-text">
                        sportschannelindonesia@gmail.com
                    </div>
                    <div class="col-xs-1 pad-0 mt-5">
                        <i class="fa fa-phone fa-fw"></i>
                    </div>
                    <div class="col-xs-11 pad-0 pl-10 mt-5">
                        +62 21 7193387 +62 82123848781
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="#" class="scrollup"><i class="fa fa-chevron-up fa-lg"></i></a>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url() ?>assets/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/video.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.hc-sticky.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/sci.js"></script>
    <script src= "//amp.azure.net/libs/amp/latest/azuremediaplayer.min.js"></script>

    <div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.9&appId=1685286848396849";
        fjs.parentNode.insertBefore(js, fjs);
    }
    (document, 'script', 'facebook-jssdk'));
</script>
</body>

</html>
