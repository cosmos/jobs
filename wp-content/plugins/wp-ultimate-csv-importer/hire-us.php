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
<div class="wrap">
	
<h1></h1><br />

	<div class="highlighter">
  <h4>Highlights of working with us!</h4>
    <ul style="font:italic;font-size:22px;">
    
				 	<li>Leading Agency with 9+ years of experience</li>				 	
				 	<li>Quick ticket support, quick solution</li>
				 	<li>Improve your online presence to drive revenue</li>
				 	<li>Quick solution via call, email & live chat</li>
	    </ul>
		
	</div>	
		

	<style>
		/* General */
h1,h2,h3,h4,h5,h6{cursor:pointer;}
.highlighter h4{
  color:#555;color: #00a699;font-weight: bold;font-size: 30px;text-align:left;margin-top:4px;margin-bottom:1px;
}
.highlighter {list-style-type:disc ; margin:10px 0 15px 20px;padding: 20px;
background:#fff; width:75%;
  min-height:240px;
  margin:3% auto 0 auto;
  max-width:1100px;
  border-radius: 5px;
  display: flex;
flex-direction: column;
align-items: center;
}	
.highlighter ul{
  margin-left:30px;
  margin-top: 35px;
}
.highlighter ul li{
  margin-bottom: 6px;
list-style: none;
padding: 10px 30px;
position: relative;
}
.highlighter ul li::before{
  position: absolute;
width: 30px;
height: 30px;
left: -10px;
content: "\f00c";
font: normal normal normal 14px/1 FontAwesome;
color: #00a699;
}
.intro{
  width:100%;
  height:30px;
}
.intro h1{
  font-family:'Oswald', sans-serif;
  letter-spacing:2px;
  font-weight:normal;
  font-size:14px;
  color:#fff;
  text-align:center;
  margin-top:10px;
}
.intro a{
  color:#fff;
  font-weight:bold;
  letter-spacing:0;
}
.intro img{
  width:20px;
  height:20px;
  margin-left:5px;
  margin-right:5px;
  position:relative;
  top:5px;
}

/* Body */
body{
  font-family: arial, verdana;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
#container{
  width:80%;
  min-height:500px;
  margin:3% auto 0 auto;
  max-width:1100px;
}
.pricetab{
  width:32%;
  min-width:220px;
  background:#FFFFFF ;
  float:left;
  margin-top:2%;
  
}
.pricetabmid{
  width:35%;
  min-width:220px;
  background:#FFFFFF;
  float:left;
  box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
  position:relative;
}
.priceheader{
  width:100%;
  height:60px;
  background-image: -o-linear-gradient(bottom ,#444 , #555); 
  background-image: -webkit-linear-gradient(bottom ,#444 , #555);
  background-image: -o-linear-gradient(bottom ,#444 , #555); 
  background-image: -moz-linear-gradient(bottom ,#444 , #555); 
  background-image: linear-gradient(to bottom , #444 , #555); 
  box-shadow:0 2px 12px rgba(0, 0, 0, .5);
}
.price{
  width:120px;
  height:120px;
  border-radius:50%;
  border:2px solid #00a699;
  margin:5% auto 0 auto;
  text-align:center;
  display: flex;
justify-content: center;
align-items: center;
}
.pricemid{
  width:120px;
  height:120px;
  border-radius:50%;
  border:1px solid #444;
  margin:5% auto 0 auto;
  text-align:center;
  background-color: #00a699;
  display: flex;
justify-content: center;
align-items: center;
}
.infos{
  margin-top:10%;
}
.pricefooter{
  width:100%;
  height:50px;
  margin-top:10%;
  background:#333; 
}
.pricefootermid{
  width:100%;
  height:50px;
  margin-top:10%;
  background:#FFFFFF; 
 
}
.author{
  width:10%;
  min-width:150px;
  height:40px;
  background:rgba(0, 0, 0, .5);
  overflow:hidden;
  clear:both;
  float:right;
  position:fixed;
  bottom:0;
  right:0;
  -moz-transition: all 0.4s ease-in-out;
  -o-transition: all 0.4s ease-in-out;
  -ms-transition: all 0.4s ease-in-out;
  transition: all 0.4s ease-in-out;
}
.author:hover{
  background:rgba(0, 0, 0, .8);
}
.author:hover .credit{
  margin-left:10%;
}
/* Typo */ 
.title{
  font-family:arial;
  color:#555;;
  font-size:38px;
  font-weight:normal;
  text-align:center;
  text-transform:uppercase;
  text-shadow: 1px 2px 5px rgba(0,0,5,0.2);
  margin:auto;
}
h1{
  font-size:18px;
  color:#00a699;
  text-align:center;
  line-height:3;
}
h2{
  text-align:center;
  font-size:42px;
  color:#000000;
}
sub{
  text-transform: uppercase;
  font-size: 14px;
  font-weight: bold;
}
h3{
  font-size:14px;
  font-weight:normal;
  text-align:center;
  color: #000000;
  line-height:2;
  padding:10px 0;
  background: #F7FAFC;
}
.button a{
  color:#fff;
  font-size:14px;
  font-weight:bold;
  text-decoration:none;
  line-height:3;
}

.credit{
  font-family:arial;
  color:#fff;
  font-size:16px;
  font-weight:normal;
  text-align:left;
  text-shadow: 1px 2px 5px rgba(0,0,5,0.2);
  margin-left:5%;
  line-height:1.3;
  -moz-transition: all 0.4s ease-in-out;
  -o-transition: all 0.4s ease-in-out;
  -ms-transition: all 0.4s ease-in-out;
  transition: all 0.4s ease-in-out;
}
/* Buttons */ 
.button{
  width:50%;
  height:50px;
  margin:0 auto 0 auto;
  background:#ff9547;
  text-align:center; 
  cursor:pointer;
  -moz-transition: all 0.4s ease-in-out;
  -o-transition: all 0.4s ease-in-out;
  -ms-transition: all 0.4s ease-in-out;
  transition: all 0.4s ease-in-out;
  
}
.button:hover{
  width:60%;
}
.buttonmid{
  width:50%;
  height:50px;
  margin:0 auto 0 auto;
  background:#00a699;
  text-align:center; 
  cursor:pointer;
  -moz-transition: all 0.4s ease-in-out;
  -o-transition: all 0.4s ease-in-out;
  -ms-transition: all 0.4s ease-in-out;
  transition: all 0.4s ease-in-out;
  color:#fff;
  font-size:14px;
  font-weight:bold;
  text-decoration:none;
  line-height:3;
}
.buttonmid:hover{
  width:60%;
}

	</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<body>
  <div id="container">
   
    <div class="pricetab">
      <h1> Hire us for 8 Hours</h1>
      <div class="price"> 
        <h2> $120 </h2> 
      </div>
      <div class="infos">
        <h3> Website Development </h3>
        <h3> Plug-in Development </h3>
      <h3>Third Party Integration</h3>
        <h3> Theme Development </h3>
        <h3> Custom Development</h3>
      </div>
     
      <div class="pricefootermid">
      <a href="https://www.smackcoders.com/checkout.html?add-to-cart=132944337&quantity=8#product-checkout"target="_blank" style="text-decoration: none;">
        <div class="buttonmid">
          Hire us
        </div>
       </a>
      </div>
      
    </div>
    <div class="pricetabmid">
      <h1> Hire us for 30 Hours </h1>
      <div class="pricemid"> 
        <h2 style="color:#fff"> $450 </h2> 
      </div>
      <div class="infos">
        <h3> Website Development </h3>
        <h3> Plug-in Development </h3>
      <h3>Third Party Integration</h3>
        <h3> Theme Development </h3>
        <h3> Custom Development</h3>
      </div>
      <div class="pricefootermid" style="margin-bottom: 30px;" >
      <a href="https://www.smackcoders.com/checkout.html?add-to-cart=132944337&quantity=30#product-checkout"target="_blank" style="text-decoration: none;">
        <div class="buttonmid">
          Hire us
        </div>
       </a>
      </div>
    </div>
    <div class="pricetab">
      <h1>  Hire us for 40 Hours</h1>
      <div class="price"> 
        <h2 style="font-size: 36px;"> $1200 </h2> 
      </div>
      <div class="infos">
      <h3> Blockchain solutions </h3>
        <h3> Big Data Solutions </h3>
        <h3> Data Science/ Deep Learning </h3>
        <h3> Machine Learning</h3>
        <h3> Mobile App Development</h3>
      </div>
      <div class="pricefootermid">
      <a href="https://www.smackcoders.com/checkout.html?add-to-cart=334671636&quantity=40#product-checkout"target="_blank" style="text-decoration: none;">
        <div class="buttonmid">
          Hire us
        </div>
       </a>
      </div>
    </div>
  </div>
</body>
</div>