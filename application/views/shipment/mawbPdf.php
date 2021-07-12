<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="utf-8" />
<title><?php echo 'MAWB_'.$shipInfo['waybill'];?></title>

<!-- Stylesheet
======================= -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/dist/css/pdf/bootstrap.min.css'; ?>"/>

<link href="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery-ui.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery-ui.js"></script>
	
<script src='<?php echo base_url().'assets/dist/js/pdf/jQuery.print.js';?>'></script>

<script type="text/javascript">
  $(document).ready(function(){
		jQuery(function($) { 'use strict';
            
            $("#p_holder").find('.print_button').on('click', function() {
                //Print ele4 with custom options
                $("#p_holder").print({
                    //Use Global styles
                    globalStyles : true,
                    //Add link with attrbute media=print
                    mediaPrint : true,
                    //Custom stylesheet
                    stylesheet : "<?php echo base_url().'assets/dist/css/pdf/stylesheet.css';?>",
                    //Print in a hidden iframe
                    iframe : false,
                    //Don't print this
                    noPrintSelector : ".avoid-normal-print",
                    //Add this at top
                    prepend : "",
                    //Add this on bottom
                    append : "",
                    //Log to console when printing is done via a deffered callback
                    deferred: $.Deferred().done(function() { 
						console.log('Printing done', arguments); 
						
					})
                });
            });
            // Fork https://github.com/sathvikp/jQuery.print for the full list of options
			
        });
				
	});
</script>

</head>

<body id="p_holder" style="margin: 0;">

<div id="p1" style="overflow: hidden; position: relative; background-color: white; width: 910px; height: 1286px;margin:0 auto;">

<!-- Begin shared CSS values -->
<style class="shared-css" type="text/css" >
.t {
	transform-origin: bottom left;
	z-index: 2;
	position: absolute;
	white-space: pre;
	overflow: visible;
	line-height: 1.5;
}
</style>
<!-- End shared CSS values -->


<!-- Begin inline CSS -->
<style type="text/css" >
@page {
   size: 7in 9.25in;
   margin:0;
   font-size:13pt;
}


#t1_1{left:80px;bottom:1226px;letter-spacing:0.08px;}
#t2_1{left:313px;bottom:1226px;letter-spacing:0.08px;}
#t3_1{left:476px;bottom:1226px;letter-spacing:0.08px;}
#t4_1{left:476px;bottom:1198px;letter-spacing:0.05px;}
#t5_1{left:476px;bottom:1170px;letter-spacing:0.08px;}
#t6_1{left:476px;bottom:1132px;letter-spacing:0.07px;}
#t7_1{left:80px;bottom:1116px;letter-spacing:0.09px;}
#t8_1{left:307px;bottom:1116px;letter-spacing:0.08px;}
#t9_1{left:476px;bottom:1111px;letter-spacing:0.08px;word-spacing:1.29px;}
#ta_1{left:476px;bottom:1100px;letter-spacing:0.1px;word-spacing:3.04px;}
#tb_1{left:476px;bottom:1089px;letter-spacing:0.11px;word-spacing:1.81px;}
#tc_1{left:476px;bottom:1079px;letter-spacing:0.11px;word-spacing:3.18px;}
#td_1{left:476px;bottom:1068px;letter-spacing:0.11px;word-spacing:2.37px;}
#te_1{left:476px;bottom:1057px;letter-spacing:0.11px;}
#tf_1{left:494px;bottom:1057px;letter-spacing:0.11px;}
#tg_1{left:542px;bottom:1057px;letter-spacing:0.09px;}
#th_1{left:563px;bottom:1057px;letter-spacing:0.1px;}
#ti_1{left:637px;bottom:1057px;letter-spacing:0.11px;}
#tj_1{left:691px;bottom:1057px;letter-spacing:0.11px;}
#tk_1{left:733px;bottom:1057px;letter-spacing:0.11px;}
#tl_1{left:771px;bottom:1057px;letter-spacing:0.11px;}
#tm_1{left:795px;bottom:1057px;letter-spacing:0.11px;}
#tn_1{left:843px;bottom:1057px;letter-spacing:0.12px;}
#to_1{left:476px;bottom:1047px;letter-spacing:0.1px;word-spacing:2.37px;}
#tp_1{left:476px;bottom:1036px;letter-spacing:0.08px;word-spacing:3px;}
#tq_1{left:476px;bottom:1025px;letter-spacing:0.07px;}
#tr_1{left:80px;bottom:1006px;letter-spacing:0.08px;}
#ts_1{left:476px;bottom:1006px;letter-spacing:0.08px;}
#tt_1{left:80px;bottom:933px;letter-spacing:0.08px;}
#tu_1{left:278px;bottom:933px;letter-spacing:0.08px;}
#tv_1{left:80px;bottom:896px;letter-spacing:0.07px;}
#tw_1{left:505px;bottom:896px;letter-spacing:0.09px;}
#tx_1{left:626px;bottom:896px;letter-spacing:0.08px;}
#ty_1{left:80px;bottom:859px;letter-spacing:0.1px;}
#tz_1{left:118px;bottom:859px;letter-spacing:0.07px;}
#t10_1{left:195px;bottom:859px;letter-spacing:0.08px;}
#t11_1{left:316px;bottom:859px;letter-spacing:0.07px;}
#t12_1{left:360px;bottom:859px;letter-spacing:0.09px;}
#t13_1{left:393px;bottom:859px;letter-spacing:0.07px;}
#t14_1{left:437px;bottom:859px;letter-spacing:0.09px;}
#t15_1{left:470px;bottom:859px;letter-spacing:0.08px;}
#t16_1{left:511px;bottom:861px;letter-spacing:-0.7px;}
#t17_1{left:513px;bottom:853px;letter-spacing:-0.22px;}
#t18_1{left:537px;bottom:860px;letter-spacing:0.11px;}
#t19_1{left:586px;bottom:860px;letter-spacing:0.09px;}
#t1a_1{left:536px;bottom:852px;letter-spacing:-0.23px;word-spacing:2.26px;}
#t1b_1{left:630px;bottom:859px;letter-spacing:0.08px;}
#t1c_1{left:761px;bottom:859px;letter-spacing:0.08px;}
#t1d_1{left:127px;bottom:822px;letter-spacing:0.07px;}
#t1e_1{left:322px;bottom:823px;letter-spacing:0.08px;}
#t1f_1{left:485px;bottom:823px;letter-spacing:0.08px;}
#t1g_1{left:594px;bottom:822px;letter-spacing:0.08px;word-spacing:3.09px;}
#t1h_1{left:594px;bottom:811px;letter-spacing:0.08px;word-spacing:0.95px;}
#t1i_1{left:594px;bottom:801px;letter-spacing:0.07px;}
#t1j_1{left:80px;bottom:786px;letter-spacing:0.08px;}
#t1k_1{left:811px;bottom:749px;letter-spacing:0.09px;}
#t1l_1{left:80px;bottom:712px;letter-spacing:0.07px;}
#t1m_1{left:79px;bottom:701px;letter-spacing:0.08px;}
#t1n_1{left:83px;bottom:691px;letter-spacing:0.12px;}
#t1o_1{left:141px;bottom:707px;letter-spacing:0.09px;}
#t1p_1{left:139px;bottom:697px;letter-spacing:0.09px;}
#t1q_1{left:193px;bottom:711px;letter-spacing:-0.19px;}
#t1r_1{left:194px;bottom:696px;letter-spacing:-0.14px;}
#t1s_1{left:220px;bottom:710px;letter-spacing:0.08px;}
#t1t_1{left:240px;bottom:695px;letter-spacing:0.09px;}
#t1u_1{left:246px;bottom:688px;letter-spacing:0.08px;}
#t1v_1{left:327px;bottom:707px;letter-spacing:0.09px;}
#t1w_1{left:337px;bottom:697px;letter-spacing:0.09px;}
#t1x_1{left:410px;bottom:710px;letter-spacing:0.09px;}
#t1y_1{left:449px;bottom:692px;letter-spacing:0.09px;}
#t1z_1{left:555px;bottom:701px;letter-spacing:0.07px;}
#t20_1{left:703px;bottom:707px;letter-spacing:0.08px;}
#t21_1{left:705px;bottom:697px;letter-spacing:0.08px;}
#t22_1{left:104px;bottom:419px;letter-spacing:0.08px;}
#t23_1{left:194px;bottom:419px;letter-spacing:0.09px;}
#t24_1{left:315px;bottom:419px;letter-spacing:0.07px;}
#t25_1{left:388px;bottom:419px;letter-spacing:0.08px;}
#t26_1{left:189px;bottom:383px;letter-spacing:0.08px;}
#t27_1{left:217px;bottom:346px;letter-spacing:0.09px;}
#t28_1{left:160px;bottom:309px;letter-spacing:0.08px;}
#t29_1{left:388px;bottom:307px;letter-spacing:0.07px;word-spacing:1.01px;}
#t2a_1{left:702px;bottom:307px;letter-spacing:0.08px;word-spacing:1.01px;}
#t2b_1{left:388px;bottom:296px;letter-spacing:0.08px;word-spacing:-0.07px;}
#t2c_1{left:388px;bottom:286px;letter-spacing:0.08px;}
#t2d_1{left:564px;bottom:214px;letter-spacing:0.07px;}
#t2e_1{left:158px;bottom:273px;letter-spacing:0.08px;}
#t2f_1{left:120px;bottom:199px;letter-spacing:0.08px;}
#t2g_1{left:276px;bottom:199px;letter-spacing:0.07px;}
#t2h_1{left:91px;bottom:163px;letter-spacing:0.08px;}
#t2i_1{left:240px;bottom:163px;letter-spacing:0.08px;}
#t2j_1{left:388px;bottom:141px;letter-spacing:0.08px;}
#t2k_1{left:558px;bottom:141px;letter-spacing:0.07px;}
#t2l_1{left:715px;bottom:141px;letter-spacing:0.07px;}
#t2m_1{left:103px;bottom:121px;letter-spacing:0.07px;}
#t2n_1{left:120px;bottom:110px;letter-spacing:0.07px;}
#t2o_1{left:255px;bottom:126px;letter-spacing:0.08px;}
#t2p_1{left:412px;bottom:126px;letter-spacing:0.08px;}
#t2q_1{left:71px;bottom:92px;letter-spacing:-0.24px;}

#t2r_1{left:70px;bottom:1237px;letter-spacing:0.2px;word-spacing:6.11px;width:45px;overflow: hidden;text-align:center;}
#t2r_2{left:118px;bottom:1237px;letter-spacing:0.2px;word-spacing:6.11px;width:40px;overflow: hidden;text-align:center;}
#t2r_3{left:165px;bottom:1237px;letter-spacing:0.2px;word-spacing:6.11px;width:200px;overflow: hidden;text-align:left;}

#t2s_1{left:730px;bottom:1237px;letter-spacing:0.2px;}

#t2t_1{left:76px;bottom:1182px;letter-spacing:0.17px;width: 360px;overflow: hidden;}
#t2u_1{left:76px;bottom:1168px;letter-spacing:0.17px;width: 360px;overflow: hidden;}
#t2v_1{left:76px;bottom:1155px;letter-spacing:0.17px;width: 360px;overflow: hidden;}
#t2v_2{left:76px;bottom:1141px;letter-spacing:0.17px;width: 360px;overflow: hidden;}
#t2w_1{left:76px;bottom:1127px;letter-spacing:0.17px;width: 360px;overflow: hidden;}

#t2x_1{left:274px;bottom:1201px;letter-spacing:0.17px;}
#t2y_1{left:76px;bottom:1200px;letter-spacing:0.17px;}

#t2z_1{left:583px;bottom:1203px;letter-spacing:0.17px;width: 285px;overflow: hidden;}
#t30_1{left:583px;bottom:1189px;letter-spacing:0.17px;width: 285px;overflow: hidden;}
#t31_1{left:583px;bottom:1175px;letter-spacing:0.17px;width: 285px;overflow: hidden;}
#t32_1{left:583px;bottom:1161px;letter-spacing:0.17px;width: 285px;overflow: hidden;}

#t33_1{left:76px;bottom:1072px;letter-spacing:0.17px;width: 360px;overflow: hidden;}
#t34_1{left:76px;bottom:1058px;letter-spacing:0.17px;width: 360px;overflow: hidden;}
#t35_1{left:76px;bottom:1045px;letter-spacing:0.17px;width: 360px;overflow: hidden;}
#t35_2{left:76px;bottom:1030px;letter-spacing:0.17px;width: 360px;overflow: hidden;}
#t35_3{left:76px;bottom:1015px;letter-spacing:0.17px;width: 360px;overflow: hidden;}

#t36_1{left:274px;bottom:1091px;letter-spacing:0.17px;}

#t37_1{left:76px;bottom:987px;letter-spacing:0.17px;width: 360px;overflow: hidden;}
#t38_1{left:76px;bottom:974px;letter-spacing:0.17px;width: 360px;overflow: hidden;}

#t39_1{left:473px;bottom:987px;letter-spacing:0.17px;width:390px;overflow: hidden;}

#t3a_1{left:76px;bottom:908px;letter-spacing:0.17px;width:180px;overflow: hidden;}
#t3b_1{left:274px;bottom:908px;letter-spacing:0.17px;width:180px;overflow: hidden;}

#t3c_1{left:76px;bottom:871px;letter-spacing:0.17px;}

#t3d_1{left:473px;bottom:871px;letter-spacing:0.17px;width:150px;overflow: hidden;}
#t3e_1{left:626px;bottom:871px;letter-spacing:0.17px;width:250px;overflow: hidden;}

#t3f_1{left:758px;bottom:871px;letter-spacing:0.17px;}

#t3g_1{left:76px;bottom:835px;letter-spacing:0.17px;width:35px;overflow: hidden;}
#t3h_1{left:120px;bottom:835px;letter-spacing:0.17px;width:190px;overflow: hidden;}
#t3i_1{left:318px;bottom:835px;letter-spacing:0.17px;width:35px;overflow: hidden;}

#t3j_1{left:360px;bottom:845px;letter-spacing:-0.13px;width:30px;overflow: hidden;}
#t3k_1{left:363px;bottom:837px;}
#t3l_1{left:395px;bottom:835px;letter-spacing:0.17px;width:35px;overflow: hidden;}
#t3m_1{left:437px;bottom:845px;letter-spacing:-0.13px;width:30px;overflow: hidden;}

#t3n_1{left:439px;bottom:837px;}

#t3o_1{left:469px;bottom:835px;letter-spacing:0.17px;width:40px;overflow: hidden;text-align:center;}
#t3p_1{left:513px;bottom:832px;letter-spacing:0.17px;width:22px;overflow: hidden;} 
#t3q_1{left:539px;bottom:832px;}
#t3q_2{left:562px;bottom:832px;}
#t3r_0{left:584px;bottom:832px;}
#t3r_1{left:606px;bottom:832px;}

#t3s_1{left:625px;bottom:835px;letter-spacing:0.17px;width:125px;overflow: hidden;text-align:center;}
#t3t_1{left:755px;bottom:835px;letter-spacing:0.17px;width:125px;overflow: hidden;text-align:center;}

#t3u_1{left:76px;bottom:798px;letter-spacing:0.17px;width:190px;overflow: hidden;}
#t3v_1{left:271px;bottom:798px;letter-spacing:0.17px;width:95px;overflow: hidden;text-align:center;}

#t3w_1{left:373px;bottom:798px;letter-spacing:0.17px;}
#t3x_1{left:470px;bottom:798px;letter-spacing:0.17px;width:115px;overflow: hidden;text-align:center;}

#t3y_1{left: 76px;bottom: 720px;letter-spacing: 0.17px;height: 65px;width: 675px;overflow: hidden;white-space: normal;font-size: 12px;line-height: 1;}

#t3z_1{left:755px;bottom:729px;width:128px;overflow: hidden;text-align:center;}

#t40_1{left:70px;bottom:664px;width:45px;overflow: hidden;text-align:center;}
#t41_1{left:115px;bottom:664px;letter-spacing:0.17px;width:75px;overflow: hidden;text-align:right;}
#t42_1{left:193px;bottom:664px;width:10px;overflow: hidden;text-align:center;}
#t43_1{left:214px;bottom:664px;width:10px;overflow: hidden;text-align:center;}
#t44_1{left:227px;bottom:664px;letter-spacing:0.17px;width:74px;overflow: hidden;text-align:center;}
#t45_1{left:315px;bottom:664px;letter-spacing:0.17px;width:74px;overflow: hidden;text-align:left;}
#t46_1{left:402px;bottom:664px;letter-spacing:0.17px;width:85px;overflow: hidden;text-align:left;}
#t47_1{left:505px;bottom:664px;letter-spacing:0.17px;width:122px;overflow: hidden;text-align:right;}
#t48_1{left:648px;bottom:664px;letter-spacing:0.17px;width:235px;overflow: hidden;text-align:left;}

#t49_1{left:91px;bottom:643px;letter-spacing:0.17px;}
#t4a_1{left:159px;bottom:643px;letter-spacing:0.16px;word-spacing:2.9px;}
#t4b_1{left:214px;bottom:643px;letter-spacing:0.16px;word-spacing:2.9px;}
#t4c_1{left:356px;bottom:643px;letter-spacing:0.17px;}
#t4d_1{left:406px;bottom:643px;}
#t4e_1{left:599px;bottom:643px;letter-spacing:0.17px;}
#t4f_1{left:648px;bottom:643px;letter-spacing:0.17px;}
#t4g_1{left:648px;bottom:629px;letter-spacing:0.17px;}

#t4h_1{left:68px;bottom:440px;letter-spacing:0.17px;width:48px;overflow: hidden;text-align:center;}
#t4i_1{left:116px;bottom:440px;letter-spacing:0.16px;word-spacing:2.9px;width:75px;overflow: hidden;text-align:right;}
#t4j_1{left:505px;bottom:440px;letter-spacing:0.17px;width:122px;overflow: hidden;text-align:right;}

#t4k_1{left:75px;bottom:395px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4l_1{left:75px;bottom:358px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4k_2{left:228px;bottom:395px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4m_1{left:228px;bottom:358px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4n_1{left:75px;bottom:321px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4o_1{left:228px;bottom:321px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4p_0{left:75px;bottom:285px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4p_1{left:228px;bottom:285px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4p_2{left:75px;bottom:247px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4p_3{left:228px;bottom:247px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}

#t4q_1{left:191px;bottom:175px;letter-spacing:0.17px;}

#t4r_1{left:75px;bottom:175px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4r_2{left:228px;bottom:175px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}

#t4s_1{left:75px;bottom:138px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4t_1{left:228px;bottom:138px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}

#t4u_1{left:228px;bottom:101px;letter-spacing:0.17px;width:148px;overflow: hidden;text-align:right;}
#t4v_1{left:382px;bottom:101px;width:148px;overflow: hidden;text-align:right;}

#t4w_1{left:384px;bottom:394px;letter-spacing:0.17px;}
#t4x_1{left:723px;bottom:394px;letter-spacing:0.17px;}
#t4y_1{left:753px;bottom:394px;}
#t4z_1{left:400px;bottom:227px;letter-spacing:0.17px;width:465px;overflow: hidden;text-align:center;}
#t50_1{left:384px;bottom:153px;letter-spacing:0.17px;}
#t51_1{left:510px;bottom:153px;letter-spacing:0.17px;width:150px;overflow: hidden;text-align:center;}
#t52_1{left:656px;bottom:153px;letter-spacing:0.17px;width:225px;overflow: hidden;text-align:right;}
#t53_1{left:600px;bottom:112px;letter-spacing:0.2px;width:285px;overflow: hidden;text-align:right;}
#t54_1{left:50%;bottom:50px;letter-spacing:0.17px;}

.s1{font-size:9px;font-family:NimbusSanL-Regu_9;color:#000;}
.s2{font-size:19px;font-family:NimbusSanL-Bold_d;color:#000;}
.s3{font-size:8px;font-family:NimbusSanL-Regu_9;color:#000;}
.s4{font-size:9px;font-family:NimbusSanL-Bold_d;color:#000;}
.s5{font-size:18px;font-family:Courier New;color:#000;}
.s6{font-size:12pt;font-family:Courier New;color:#000;text-transform:capitalize;}
.s7{font-size:9px;font-family:NimbusMonL-Regu_l;color:#000;}
.s8{font-size:15px;font-family:NimbusMonL-Bold_h;color:#000;}
.t.v0_1{transform:scaleX(0.9);}
.t.v1_1{transform:scaleX(0.959);}
</style>
<!-- End inline CSS -->

<!-- Begin embedded font definitions -->
<style id="fonts1" type="text/css" >

@font-face {
	font-family: NimbusMonL-Bold_h;
	src: url("<?php echo base_url().'assets/pdf/fonts/'; ?>NimbusMonL-Bold_h.woff") format("woff");
}

@font-face {
	font-family: NimbusMonL-Regu_l;
	src: url("<?php echo base_url().'assets/pdf/fonts/'; ?>NimbusMonL-Regu_l.woff") format("woff");
}

@font-face {
	font-family: NimbusSanL-Bold_d;
	src: url("<?php echo base_url().'assets/pdf/fonts/'; ?>NimbusSanL-Bold_d.woff") format("woff");
}

@font-face {
	font-family: NimbusSanL-Regu_9;
	src: url("<?php echo base_url().'assets/pdf/fonts/'; ?>NimbusSanL-Regu_9.woff") format("woff");
}

</style>
<!-- End embedded font definitions -->

<!-- Begin page background -->
<div id="pg1Overlay" style="width:100%; height:100%; position:absolute; z-index:1; background-color:rgba(0,0,0,0); -webkit-user-select: none;"></div>
<div id="pg1" style="-webkit-user-select: none;"><object width="910" height="1286" data="<?php echo base_url().'assets/pdf/svg/1.svg';?>" type="image/svg+xml" id="pdf1" style="width:910px; height:1286px; -moz-transform:scale(1); z-index: 0;"></object></div>
<!-- End page background -->


<!-- Begin text definitions (Positioned/styled in CSS) -->
<div id="t1_1" class="t s1">Shipper's Name and Address</div>
<div id="t2_1" class="t s1">Shipper's Account Number</div>
<div id="t3_1" class="t s1">Not Negotiable</div>
<div id="t4_1" class="t s2">Air Waybill</div>
<div id="t5_1" class="t s1">Issued by</div>
<div id="t6_1" class="t s1">Copies 1, 2 and 3 of this Air Waybill are originals and have the same validity.</div>
<div id="t7_1" class="t s1">Consignee's Name and Address</div>
<div id="t8_1" class="t s1">Consignee's Account Number</div>
<div id="t9_1" class="t s1">It is agreed that the goods described herein are accepted in apparent good order and condition</div>
<div id="ta_1" class="t s1">(except as noted) for carriage SUBJECT TO THE CONDITIONS OF CONTRACT ON THE</div>
<div id="tb_1" class="t s1">REVERSE HEREOF. ALL GOODS MAY BE CARRIED BY ANY OTHER MEANS INCLUDING</div>
<div id="tc_1" class="t s1">ROAD OR ANY OTHER CARRIER UNLESS SPECIFIC CONTRARY INSTRUCTIONS ARE</div>
<div id="td_1" class="t s1">GIVEN HEREON BY THE SHIPPER, AND SHIPPER AGREES THAT THE SHIPMENT MAY</div>
<div id="te_1" class="t s1">BE</div>
<div id="tf_1" class="t s1">CARRIED</div>
<div id="tg_1" class="t s1">VIA</div>
<div id="th_1" class="t s1">INTERMEDIATE</div>
<div id="ti_1" class="t s1">STOPPING</div>
<div id="tj_1" class="t s1">PLACES</div>
<div id="tk_1" class="t s1">WHICH</div>
<div id="tl_1" class="t s1">THE</div>
<div id="tm_1" class="t s1">CARRIER</div>
<div id="tn_1" class="t s1">DEEMS</div>
<div id="to_1" class="t s1">APPROPRIATE. THE SHIPPER'S ATTENTION IS DRAWN TO THE NOTICE CONCERNING</div>
<div id="tp_1" class="t s1">CARRIER'S LIMITATION OF LIABILITY. Shipper may increase such limitation of liability by</div>
<div id="tq_1" class="t s1">declaring a higher value for carriage and paying a supplemental charge if required.</div>
<div id="tr_1" class="t s1">Issuing Carrier's Agent Name and City</div>
<div id="ts_1" class="t s1">Accounting Information</div>
<div id="tt_1" class="t s1">Agent's IATA Code</div>
<div id="tu_1" class="t s1">Account No.</div>
<div id="tv_1" class="t s1">Airport of Departure (Addr. of First Carrier) and Requested Routing</div>
<div id="tw_1" class="t s1">Reference Number</div>
<div id="tx_1" class="t s1">Optional Shipping Information</div>
<div id="ty_1" class="t s1">To</div>
<div id="tz_1" class="t s1">By First Carrier</div>
<div id="t10_1" class="t s1">Routing and Destination</div>
<div id="t11_1" class="t s1">to</div>
<div id="t12_1" class="t s1">by</div>
<div id="t13_1" class="t s1">to</div>
<div id="t14_1" class="t s1">by</div>
<div id="t15_1" class="t s1">Currency</div>
<div id="t16_1" class="t s3">CHGS</div>
<div id="t17_1" class="t s3">Code</div>
<div id="t18_1" class="t s4">WT/VAL</div>
<div id="t19_1" class="t s4">Other</div>
<div id="t1a_1" class="t s3">PPD COLL PPD COLL</div>
<div id="t1b_1" class="t s1">Declared Value for Carriage</div>
<div id="t1c_1" class="t s1">Declared Value for Customs</div>
<div id="t1d_1" class="t s1">Airport of Destination</div>
<div id="t1e_1" class="t s1">Requested Flight/Date</div>
<div id="t1f_1" class="t s1">Amount of Insurance</div>
<div id="t1g_1" class="t s1">INSURANCE – If carrier offers insurance, and such insurance is</div>
<div id="t1h_1" class="t s1">requested in accordance with the conditions thereof, indicate amount</div>
<div id="t1i_1" class="t s1">to be insured in figures in box marked "Amount of Insurance".</div>
<div id="t1j_1" class="t s1">Handling Information</div>
<div id="t1k_1" class="t s1">SCI</div>
<div id="t1l_1" class="t s1">No. of</div>
<div id="t1m_1" class="t s1">Pieces</div>
<div id="t1n_1" class="t s1">RCP</div>
<div id="t1o_1" class="t s1">Gross</div>
<div id="t1p_1" class="t s1">Weight</div>
<div id="t1q_1" class="t s3">kg</div>
<div id="t1r_1" class="t s3">lb</div>
<div id="t1s_1" class="t s1">Rate Class</div>
<div id="t1t_1" class="t s1">Commodity</div>
<div id="t1u_1" class="t s1">Item No.</div>
<div id="t1v_1" class="t s1">Chargeable</div>
<div id="t1w_1" class="t s1">Weight</div>
<div id="t1x_1" class="t s1">Rate</div>
<div id="t1y_1" class="t s1">Charge</div>
<div id="t1z_1" class="t s1">Total</div>
<div id="t20_1" class="t s1">Nature and Quantity of Goods</div>
<div id="t21_1" class="t s1">(incl. Dimensions or Volume)</div>
<div id="t22_1" class="t s1">Prepaid</div>
<div id="t23_1" class="t s1">Weight Charge</div>
<div id="t24_1" class="t s1">Collect</div>
<div id="t25_1" class="t s1">Other Charges</div>
<div id="t26_1" class="t s1">Valuation Charge</div>
<div id="t27_1" class="t s1">Tax</div>
<div id="t28_1" class="t s1">Total Other Charges Due Agent</div>
<div id="t29_1" class="t s1">Shipper certifies that the particulars on the face hereof are correct and that</div>
<div id="t2a_1" class="t s4">insofar as any part of the consignment</div>
<div id="t2b_1" class="t s4">contains dangerous goods, such part is properly described by name and is in proper condition for carriage by air</div>
<div id="t2c_1" class="t s4">according to the applicable Dangerous Goods Regulations.</div>
<div id="t2d_1" class="t s1">Signature of Shipper or his Agent</div>
<div id="t2e_1" class="t s1">Total Other Charges Due Carrier</div>
<div id="t2f_1" class="t s1">Total Prepaid</div>
<div id="t2g_1" class="t s1">Total Collect</div>
<div id="t2h_1" class="t s1">Currency Conversion Rates</div>
<div id="t2i_1" class="t s1">CC Charges in Dest. Currency</div>
<div id="t2j_1" class="t s1">Executed on (date)</div>
<div id="t2k_1" class="t s1">at (place)</div>
<div id="t2l_1" class="t s1">Signature of Issuing Carrier or its Agent</div>
<div id="t2m_1" class="t s1">For Carrier's Use only</div>
<div id="t2n_1" class="t s1">at Destination</div>
<div id="t2o_1" class="t s1">Charges at Destination</div>
<div id="t2p_1" class="t s1">Total Collect Charges</div>
<div id="t2q_1" class="t s3"></div>

<div id="t2r_1" class="t s5"><?php echo $mawb_first;?></div>
<div id="t2r_2" class="t s5"><?php echo (isset($aRecords['a_data']['agent_airport']) ? $aRecords['a_data']['agent_airport'] : $shipInfo['origin_airport_code']); ?></div>
<div id="t2r_3" class="t s5"><?php echo $mawb_second;?></div>

<div id="t2s_1" class="t s5"><?php echo $mawb_full;?></div>
<div id="t2t_1" class="t s6"><?php echo (isset($aRecords['s_data']['s_name']) ? $aRecords['s_data']['s_name'] : 'Fastline Logistics LLC'); ?></div>
<div id="t2u_1" class="t s6"><?php echo (isset($aRecords['s_data']['s_address_1']) ? $aRecords['s_data']['s_address_1'] : 'P.O Box 266'); ?></div>
<div id="t2v_1" class="t s6"><?php 
	if(isset($aRecords['s_data']['s_address_2']) && !empty($aRecords['s_data']['s_address_2'])){	
		echo (isset($aRecords['s_data']['s_address_2']) ? $aRecords['s_data']['s_address_2'] : ''); 
	}else{ 
		if(isset($aRecords['s_data']['country_name'])){
			echo (isset($aRecords['s_data']['s_city']) ? $aRecords['s_data']['s_city'].', ' : ''). (isset($aRecords['s_data']['state_name']) ? $aRecords['s_data']['state_name'] : ''). (isset($aRecords['s_data']['s_zip']) ? ' '.$aRecords['s_data']['s_zip'].', ' : '').(isset($aRecords['s_data']['country_name']) ? $aRecords['s_data']['country_name'] : '');
		}
	}?></div>
<?php 
	if(isset($aRecords['s_data']['s_address_2']) && !empty($aRecords['s_data']['s_address_2'])){
		if(isset($aRecords['s_data']['country_name'])){
			echo '<div id="t2v_2" class="t s6">'.(isset($aRecords['s_data']['s_city']) ? $aRecords['s_data']['s_city'].', ' : ''). (isset($aRecords['s_data']['state_name']) ? $aRecords['s_data']['state_name'] : ''). (isset($aRecords['s_data']['s_zip']) ? ' '.$aRecords['s_data']['s_zip'].', ' : '').(isset($aRecords['s_data']['country_name']) ? $aRecords['s_data']['country_name'] : '').'</div>';
		}else{
			echo '<div id="t2v_2" class="t s6">Centerton, AR 72719, US</div>';
		}
	}
?>
<div id="t2w_1" class="t s6"><?php echo (isset($aRecords['s_data']['s_contact']) ? $aRecords['s_data']['s_contact'] : 'Chris Ringhausen'); ?> <?php echo (isset($aRecords['s_data']['s_phone']) ? $aRecords['s_data']['s_phone'] : '1-800-540-6100'); ?></div>
<div id="t2x_1" class="t s6"><?php echo substr((isset($aRecords['s_data']['customer_data']['account_no']) ? $aRecords['s_data']['customer_data']['account_no'] : ''), 0, 20); ?></div>
<div id="t2y_1" class="t s6"></div>
<div id="t2z_1" class="t s6"><?php echo (isset($aRecords['issued_by_data']['customer_name']) ? $aRecords['issued_by_data']['customer_name'] : ''); ?></div>
<div id="t30_1" class="t s6"><?php echo (isset($aRecords['issued_by_data']['c_address_1']) ? $aRecords['issued_by_data']['c_address_1'] : ''); ?></div>
<div id="t31_1" class="t s6"><?php 
if(isset($aRecords['issued_by_data']['c_address_2']) && !empty($aRecords['issued_by_data']['c_address_2'])){
	echo (isset($aRecords['issued_by_data']['c_address_2']) ? $aRecords['issued_by_data']['c_address_2'] : '');
}else{
	echo (isset($aRecords['issued_by_data']['c_city']) ? $aRecords['issued_by_data']['c_city'].', ' : ''). (isset($aRecords['issued_by_data']['state_name']) ? $aRecords['issued_by_data']['state_name'] : ''). (isset($aRecords['issued_by_data']['c_zip']) ? ' '.$aRecords['issued_by_data']['c_zip'].', ' : '').(isset($aRecords['issued_by_data']['country_name']) ? $aRecords['issued_by_data']['country_name'] : '');
}
?></div>
<?php 
if(isset($aRecords['issued_by_data']['c_address_2']) && !empty($aRecords['issued_by_data']['c_address_2'])){
	echo '<div id="t32_1" class="t s6">'.(isset($aRecords['issued_by_data']['c_city']) ? $aRecords['issued_by_data']['c_city'].', ' : ''). (isset($aRecords['issued_by_data']['state_name']) ? $aRecords['issued_by_data']['state_name'] : ''). (isset($aRecords['issued_by_data']['c_zip']) ? ' '.$aRecords['issued_by_data']['c_zip'].', ' : '').(isset($aRecords['issued_by_data']['country_name']) ? $aRecords['issued_by_data']['country_name'] : '').'</div>';
}
?>
<div id="t33_1" class="t s6"><?php echo (isset($aRecords['c_data']['c_name']) ? $aRecords['c_data']['c_name'] : ''); ?></div>
<div id="t34_1" class="t s6"><?php echo (isset($aRecords['c_data']['c_address_1']) ? $aRecords['c_data']['c_address_1'] : ''); ?></div>

<div id="t35_1" class="t s6"><?php 
		if(isset($aRecords['c_data']['c_address_2']) && !empty($aRecords['c_data']['c_address_2'])){
			echo (isset($aRecords['c_data']['c_address_2']) ? $aRecords['c_data']['c_address_2'] : ''); 
		}else{
			if(isset($aRecords['c_data']['country_name'])){
				echo (isset($aRecords['c_data']['c_city']) ? $aRecords['c_data']['c_city'] : ''). (isset($aRecords['c_data']['state_name']) ? ', '.$aRecords['c_data']['state_name'] : ''). (isset($aRecords['c_data']['c_zip']) ? ' '.$aRecords['c_data']['c_zip'] : '').(isset($aRecords['c_data']['country_name']) ? ', '.$aRecords['c_data']['country_name'] : '');
			}
		}
?></div>

<?php 
	if(isset($aRecords['c_data']['c_address_2']) && !empty($aRecords['c_data']['c_address_2'])){
		if(isset($aRecords['c_data']['country_name'])){
			echo '<div id="t35_2" class="t s6">'.(isset($aRecords['c_data']['c_city']) ? $aRecords['c_data']['c_city'] : ''). (isset($aRecords['c_data']['state_name']) ? ', '.$aRecords['c_data']['state_name'] : ''). (isset($aRecords['c_data']['c_zip']) ? ' '.$aRecords['c_data']['c_zip'] : '').(isset($aRecords['c_data']['country_name']) ? ', '.$aRecords['c_data']['country_name'] : '').'</div>';
		}
	}
?>

<div id="t35_3" class="t s6"><?php echo (isset($aRecords['c_data']['c_phone']) ? $aRecords['c_data']['c_phone'] : ''); ?></div>

<div id="t36_1" class="t s6"><?php echo substr((isset($aRecords['c_data']['customer_data']['account_no']) ? $aRecords['c_data']['customer_data']['account_no'] : ''), 0, 20); ?></div>
<div id="t37_1" class="t s6"><?php echo (isset($aRecords['a_data']['a_name']) ? $aRecords['a_data']['a_name'] : 'Fastline Logistics'); ?></div>
<div id="t38_1" class="t s6"><?php echo (isset($aRecords['a_data']['a_city']) ? $aRecords['a_data']['a_city'] : 'Centerton'); ?></div>
<div id="t39_1" class="t s6"><?php echo (isset($aRecords['account_information']) ? $aRecords['account_information'] : ''); ?></div>
<div id="t3a_1" class="t s6"><?php echo (isset($aRecords['a_data']['iata_code']) ? $aRecords['a_data']['iata_code'] : ''); ?></div>
<div id="t3b_1" class="t s6"><?php echo ((isset($aRecords['a_data']['iata_code']) && !empty($aRecords['a_data']['iata_code']))  ? $aRecords['a_data']['iata_code'] : $agent_account_no); ?></div>
<div id="t3c_1" class="t s6"><?php echo ((isset($aRecords['a_data']['agent_address_carrier']) && !empty($aRecords['a_data']['agent_address_carrier'])) ? $aRecords['a_data']['agent_address_carrier'] : $agent_address_carrier); ?></div>
<div id="t3d_1" class="t s6"><?php echo (isset($aRecords['reference_number']) ? $aRecords['reference_number'] : $issued_ref_no); ?></div>
<div id="t3e_1" class="t s6"><?php echo (isset($aRecords['opt_shipp_info']) ? $aRecords['opt_shipp_info'] : ''); ?></div>
<div id="t3f_1" class="t s6"></div>
<div id="t3g_1" class="t s6"><?php echo (isset($aRecords['ap_data']['ap_dest']) ? $aRecords['ap_data']['ap_dest'] : $shipInfo['dest_airport_code']); ?></div>
<div id="t3h_1" class="t s6"><?php echo $vendor_name; ?></div>
<div id="t3i_1" class="t s6"><?php echo (isset($aRecords['ap_data']['to_airport_2']) ? $aRecords['ap_data']['to_airport_2'] : ''); ?></div>
<div id="t3j_1" class="t s7"><?php echo (isset($aRecords['ap_data']['by_name_2']) ? $aRecords['ap_data']['by_name_2'] : ''); ?></div>
<div id="t3k_1" class="t s7"></div>
<div id="t3l_1" class="t s6"><?php echo (isset($aRecords['ap_data']['to_airport_3']) ? $aRecords['ap_data']['to_airport_3'] : ''); ?></div>
<div id="t3m_1" class="t s7"><?php echo (isset($aRecords['ap_data']['by_name_3']) ? $aRecords['ap_data']['by_name_3'] : ''); ?></div>
<div id="t3n_1" class="t s7"></div>
<div id="t3o_1" class="t s6"><?php if(!empty($currencies)){
		foreach ($currencies as $cur)
		{
			if($cur['currency_id'] == (isset($aRecords['ap_data']['ap_currency']) ? $aRecords['ap_data']['ap_currency'] : '1')) {
				echo $cur['currency_code'];
			} 
		}
	}
	?></div>
<div id="t3p_1" class="t v0_1 s6"><?php echo (isset($aRecords['ap_data']['cghs_code']) ? $aRecords['ap_data']['cghs_code'] : ''); ?></div>
<div id="t3q_1" class="t s6"><?php echo ((isset($aRecords['ap_data']['wt_vall']) && $aRecords['ap_data']['wt_vall'] == 1) ? 'X' : ''); ?></div>
<div id="t3q_2" class="t s6"><?php echo ((isset($aRecords['ap_data']['wt_vall']) && $aRecords['ap_data']['wt_vall'] == 2) ? 'X' : ''); ?></div>
<div id="t3r_0" class="t s6"><?php echo ((isset($aRecords['ap_data']['other_vall']) && $aRecords['ap_data']['other_vall'] == 1) ? 'X' : ''); ?></div>
<div id="t3r_1" class="t s6"><?php echo ((isset($aRecords['ap_data']['other_vall']) && $aRecords['ap_data']['other_vall'] == 2) ? 'X' : ''); ?></div>
<div id="t3s_1" class="t s6"><?php echo (isset($aRecords['ap_data']['d_v_carriage']) ? $aRecords['ap_data']['d_v_carriage'] : $shipInfo['insured_value']); ?></div>
<div id="t3t_1" class="t s6"><?php echo (isset($aRecords['ap_data']['d_v_customs']) ? $aRecords['ap_data']['d_v_customs'] : $shipInfo['insured_value']); ?></div>
<div id="t3u_1" class="t s6"><?php echo $shipInfo['dest_airport_city']; ?></div>
<div id="t3v_1" class="t s6"><?php echo (isset($req_flight_no) ? $req_flight_no : ''); ?></div>
<div id="t3w_1" class="t v1_1 s6"><?php echo ((isset($req_flight_date)  && !empty($req_flight_date)) ? date('d/m/Y',strtotime($req_flight_date)) : ''); ?></div> 
<div id="t3x_1" class="t s6"><?php echo (isset($aRecords['ap_data']['insurance_amount']) ? $aRecords['ap_data']['insurance_amount'] : ''); ?></div>
<div id="t3y_1" class="t s6"><?php echo (isset($aRecords['handling_info']) ? $aRecords['handling_info'] : ''); ?></div>
<div id="t3z_1" class="t s6"><?php echo (isset($aRecords['opt_sci_info']) ? $aRecords['opt_sci_info'] : ''); ?></div>


<?php 
	$bottompx = 664;										
	$minuspx = 35;										
	$totalpieces = $totalweight = $totalcharge = 0;
	if(empty($aRecords) || empty($aRecords['fr_data'])){
	if(isset($shipInfo['freight_datas']) && !empty($shipInfo['freight_datas'])){
		
		foreach($shipInfo['freight_datas'] as $key => $frdata){
		$removepixel = $minuspx*$key;
		$currentBotPxl=$bottompx-$removepixel;
		
		
		$frdata = (array) $frdata;
		
		$totalpieces = $totalpieces + ((isset($frdata['pieces']) && !empty($frdata['pieces'])) ? (int) $frdata['pieces'] : 0);
		$totalweight = $totalweight + ((isset($frdata['weight']) && !empty($frdata['weight'])) ? (float) $frdata['weight'] : 0);
		
		$pTxt = (isset($frdata['description']) ? $frdata['description'] ."\n" : '').(isset($frdata['length']) ? $frdata['length'] : '') . (isset($frdata['width']) ? 'x'.$frdata['width'] : 'x') . (isset($frdata['height']) ? 'x'.$frdata['height'] : 'x').(isset($frdata['pieces']) ? '/'.$frdata['pieces'] : '');
		if(strpos($pTxt, "\n") !== FALSE) {
		  $currentBotTxtPxl=$bottompx-$removepixel-20;
		}else {
		  $currentBotTxtPxl=$bottompx-$removepixel;
		}
		
?>
<div id="t40_1" class="t s6 tabldiv pieces_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo (isset($frdata['pieces']) ? $frdata['pieces'] : ''); ?></div>

<div id="t41_1" class="t s6 tabldiv weight_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo (isset($frdata['weight']) ? $frdata['weight'] : ''); ?></div>

<div id="t42_1" class="t s6 tabldiv lb_kg_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>>L</div>


<div id="t43_1" class="t s6 tabldiv rate_class_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>></div>

<div id="t44_1" class="t s6 tabldiv item_no_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>></div>

<div id="t45_1" class="t s6 tabldiv dim_weight_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo (($frdata['t_dim_weight'] > $frdata['weight']) ? $frdata['t_dim_weight'] : $frdata['weight']); ?></div>

<div id="t46_1" class="t s6 tabldiv r_charge_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>></div>

<div id="t47_1" class="t s6 tabldiv r_total_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>></div>

<div id="t48_1" class="t s6 tabldiv n_goods_div" <?php echo "style='bottom:".$currentBotTxtPxl."px'";?>><?php echo $pTxt; ?></div>

<?php
		}
	}
	}elseif(isset($aRecords['fr_data']) && !empty($aRecords['fr_data'])){
	
	foreach($aRecords['fr_data'] as $key => $frdata){
	
	$removepixel = $minuspx*$key;
	$currentBotPxl=$bottompx-$removepixel;
	
	$totalpieces = $totalpieces + ((isset($frdata['fr_pieces']) && !empty($frdata['fr_pieces'])) ? (int)$frdata['fr_pieces'] : 0);
	$totalweight = $totalweight + ((isset($frdata['fr_weight']) && !empty($frdata['fr_weight'])) ? (float)$frdata['fr_weight'] : 0);
												
	$totalcharge = $totalcharge + (isset($frdata['fr_total']) ? (int)$frdata['fr_total'] : 0);
	
	$pTxt = (isset($frdata['n_q_goods']) ? $frdata['n_q_goods'] : '');
	if(strpos($pTxt, "\n") !== FALSE) {
	  $currentBotTxtPxl=$bottompx-$removepixel-20;
	}else {
	  $currentBotTxtPxl=$bottompx-$removepixel;
	}
?>

<div id="t40_1" class="t s6 tabldiv pieces_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo (isset($frdata['fr_pieces']) ? $frdata['fr_pieces'] : ''); ?></div>
<div id="t41_1" class="t s6 tabldiv weight_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo (isset($frdata['fr_weight']) ? $frdata['fr_weight'] : ''); ?></div>
<div id="t42_1" class="t s6 tabldiv lb_kg_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo ((isset($frdata['lb_kg']) && $frdata['lb_kg'] == 'lb') ?  "L" : 'K');?></div>
<div id="t43_1" class="t s6 tabldiv rate_class_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo ((isset($frdata['rate_class']) && $frdata['rate_class'] == 1) ?  "R" : '');?></div>
<div id="t44_1" class="t s6 tabldiv item_no_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo (isset($frdata['item_no']) ? $frdata['item_no'] : ''); ?></div>
<div id="t45_1" class="t s6 tabldiv dim_weight_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo (isset($frdata['chargeable_wt']) ? $frdata['chargeable_wt'] : ''); ?></div>
<div id="t46_1" class="t s6 tabldiv r_charge_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo (isset($frdata['r_charge']) ? $frdata['r_charge'] : ''); ?></div>
<div id="t47_1" class="t s6 tabldiv r_total_div" <?php echo "style='bottom:".$currentBotPxl."px'";?>><?php echo (isset($frdata['fr_total']) ? $frdata['fr_total'] : ''); ?></div>
<div id="t48_1" class="t s6 tabldiv n_goods_div" <?php echo "style='bottom:".$currentBotTxtPxl."px'";?>><?php echo $pTxt; ?></div>

<?php }	
	}
?>	
											



<!-- total -->
<div id="t4h_1" class="t s6"><?php echo $totalpieces;?></div>
<div id="t4i_1" class="t s6"><?php echo $totalweight;?></div>
<div id="t4j_1" class="t s6"><?php echo $totalcharge;?></div>

<div id="t4k_1" class="t s6"><?php echo (isset($aRecords['charge_data']['w_charge_p']) ? $aRecords['charge_data']['w_charge_p'] : ''); ?></div>
<div id="t4k_2" class="t s6"><?php echo (isset($aRecords['charge_data']['w_charge_c']) ? $aRecords['charge_data']['w_charge_c'] : ''); ?></div>
<div id="t4l_1" class="t s6"><?php echo (isset($aRecords['charge_data']['v_charge_p']) ? $aRecords['charge_data']['v_charge_p'] : ''); ?></div>
<div id="t4m_1" class="t s6"><?php echo (isset($aRecords['charge_data']['v_charge_c']) ? $aRecords['charge_data']['v_charge_c'] : ''); ?></div>
<div id="t4n_1" class="t s6"><?php echo (isset($aRecords['charge_data']['tax_p']) ? $aRecords['charge_data']['tax_p'] : ''); ?></div>
<div id="t4o_1" class="t s6"><?php echo (isset($aRecords['charge_data']['tax_c']) ? $aRecords['charge_data']['tax_c'] : ''); ?></div>
<div id="t4p_0" class="t s6"><?php echo (isset($aRecords['charge_data']['t_o_c_agent_p']) ? $aRecords['charge_data']['t_o_c_agent_p'] : ''); ?></div>
<div id="t4p_1" class="t s6"><?php echo (isset($aRecords['charge_data']['t_o_c_agent_c']) ? $aRecords['charge_data']['t_o_c_agent_c'] : ''); ?></div>
<div id="t4p_2" class="t s6"><?php echo (isset($aRecords['charge_data']['t_o_c_car_p']) ? $aRecords['charge_data']['t_o_c_car_p'] : ''); ?></div>
<div id="t4p_3" class="t s6"><?php echo (isset($aRecords['charge_data']['t_o_c_car_c']) ? $aRecords['charge_data']['t_o_c_car_c'] : ''); ?></div>
<div id="t4r_1" class="t s6"><?php echo (isset($aRecords['charge_data']['t_total_p']) ? $aRecords['charge_data']['t_total_p'] : ''); ?></div>
<div id="t4r_2" class="t s6"><?php echo (isset($aRecords['charge_data']['t_total_c']) ? $aRecords['charge_data']['t_total_c'] : ''); ?></div>
<div id="t4s_1" class="t s6"><?php echo (isset($aRecords['charge_data']['c_conversion_rate']) ? $aRecords['charge_data']['c_conversion_rate'] : ''); ?></div>
<div id="t4t_1" class="t s6"><?php echo (isset($aRecords['charge_data']['cc_charge_dest_currency']) ? $aRecords['charge_data']['cc_charge_dest_currency'] : ''); ?></div>
<div id="t4u_1" class="t s6"><?php echo (isset($aRecords['charge_data']['charges_dest']) ? $aRecords['charge_data']['charges_dest'] : ''); ?></div>
<div id="t4v_1" class="t s6"><?php echo (isset($aRecords['charge_data']['t_collect_charge']) ? $aRecords['charge_data']['t_collect_charge'] : ''); ?></div>
<div id="t4w_1" class="t s6"><?php echo (isset($aRecords['charge_data']['other_charges']) ? $aRecords['charge_data']['other_charges'] : ''); ?></div>
<div id="t4x_1" class="t s6"></div>
<div id="t4y_1" class="t s6"></div>
<div id="t4z_1" class="t s6"><?php echo $sysname; ?></div>
<div id="t50_1" class="t s6"><?php echo ((isset($aRecords['charge_data']['executed_date'])  && !empty($aRecords['charge_data']['executed_date'])) ? date('m/d/Y',strtotime($aRecords['charge_data']['executed_date'])) : ''); ?></div>
<div id="t51_1" class="t s6"><?php echo (isset($aRecords['charge_data']['executed_at']) ? $aRecords['charge_data']['executed_at'] : ''); ?></div>
<div id="t52_1" class="t s6"><?php echo (isset($aRecords['charge_data']['sign_carrier']) ? $aRecords['charge_data']['sign_carrier'] : 'Fastline Logistics LLC'); ?></div>
<div id="t53_1" class="t s5"><?php echo $mawb_first;?> <?php echo (isset($aRecords['a_data']['agent_airport']) ? ' '.$aRecords['a_data']['agent_airport'] : ' '.$shipInfo['origin_airport_code']); ?> <?php echo ' '.$mawb_second;?></div>
<div id="t54_1" class="t s8"></div>

<!-- End text definitions -->

<div id="t54_1" class="t  btn-group-sm d-print-none text-center avoid-normal-print"> 
	<a href="javascript:void(0);" class="btn btn-light border text-black-50 shadow-none print_button"><i class="fa fa-print"></i> PRINT</a> 
</div>
  
</div>
</body>
</html>
