<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
	<style>

/* 
- make mobile switch sticky
*/
*{
  box-sizing:border-box;
  padding:0;
  margin:0;
   outline: 0;
}
article {
  width:100%;
  margin:0 auto;
  height:1000px;
  position:relative;
}
.upgrade .ul {
  display:flex;
  top:0px;
  z-index:10;
  padding-bottom:14px;
}
li {
  list-style:none;
  flex:1;
}
li:last-child {
  border-right:1px solid #DDD;
}
button {
  width:100%;
  border: 1px solid #DDD;
  border-right:0;
  border-top:0;
  padding: 10px;
  background:#FFF;
  font-size:14px;
  font-weight:bold;
  height:60px;
  color:#999
}
li.active button {
  background:#F5F5F5;
  color:#000;
}
table { border-collapse:collapse; table-layout:fixed; width:100%; }
th { background:#F5F5F5; display:none; }
td, th {
  height:53px
}
td,th { border:1px solid #DDD; padding:10px; empty-cells:show; }
td,th {
  text-align:left;
}
td+td, th+th {
  text-align:center;
  display:none;
}
td.default {
  display:table-cell;
}
.defaults{
  border-bottom:3px solid #00a699;
}
/* .bg-purple {
  
} */
.bg-blue {
 font-size:25px; border-top:10px solid #00a699;border-left: 10px solid#00a699;
border-right: 10px solid#00a699;
}
.sep {
  background:#F5F5F5;
  font-weight:bold;
}
.txt-l { font-size:28px; font-weight:bold;color:#00a699 }
.txt-top { position:relative; top:-9px; left:-2px; }
.tick { font-size:22px; color:#2CA01C; }
.text{border-left: 10px solid#00a699;
border-right: 10px solid#00a699; }
.bottom{border-left: 10px solid#00a699;
border-right: 10px solid#00a699;border-bottom: 10px solid#00a699;
}
.hide {
  border:0;
  background:none;
}
.pro{
  background-color: #FFF;margin-left:56px;padding-bottom: 125px;;
}

@media (min-width: 640px) {
  .upgrade .ul {
    display:none;
  }
  td,th {
    display:table-cell !important;
  }
  td,th {
    width: 370px;
  
  }
  td+td, th+th {
    width: auto;
  }
}
	</style>
	
  <div class="wrap">
    <h1></h1>
  <h2>Features Of Ultimate CSV Importer</h2><br />	
  <div class='pro'>
<article class='upgrade'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<table>
  <thead>
    <tr>
      <th class="hide"></th>
      <th class="bg-purple">FREE</th>
      <th class="bg-blue">PREMIUM</th>
       <th class="bg-purple default">CUSTOM FIELDS</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="font-weight:bold;">Price</td>
      <td><span class="txt-top"></span><span class="txt-l">$0</span></td>
      <td class="text"><span class="txt-top"></span><span class="txt-l">$149</span></td>
      <td class="default"><span class="txt-top"></span><span class="txt-l">$99</span></td>
    </tr>
    <tr>
      <td>Import</td>
     <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
     <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>Post, Page, Comments, Users</td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>Custom Post</td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>Default Wordpress custom fields</td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>All-in-One SEO</td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>WP eCommerce, MarketPress</td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>WooCommerce: Product,Custom Attribute</td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>WP Customer Reviews</td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 24px;color: #2CA01C;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>Import from Google Sheets & Dropbox</td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>Update/Schedule</td>
      <td ><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>Custom Fields: ACF, Types, Pods, CMB2, CFS, Custom Press</td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>YoastSEO</td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
    </tr>
    <tr>
      <td>Data Export</td>
      <td ><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
    </tr>
    <tr>
      <td>Users: WP-Members, Members</td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
    </tr>
    <tr>
      <td>WPML</td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
    </tr>
    <tr>
      <td>QTranslateX</td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
    </tr>
    <tr>
      <td>WooCommerce:Variations, Orders, Coupons</td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
    </tr>
    <tr>
      <td>5 Woocommerce Add-ons</td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="text"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
    </tr>
    <tr>
      <td>Events Manager</td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
      <td class="bottom"><i class="fa fa-check" aria-hidden="true" style="font-size: 26px;color: #2CA01C;"></i></td>
      <td><i class="fa fa-times" aria-hidden="true" style="color: #ea1010;font-size: 19px;"></i></td>
    </tr>
    
  </tbody>
</table>
</article>
</div>
</div>