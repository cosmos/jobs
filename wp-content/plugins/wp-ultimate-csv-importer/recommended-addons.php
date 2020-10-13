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
  <div class="settings dark">
   
  <?php  
 
      delete_option("WP_ULTIMATE_RECENT_SELECTED_ADDONS");
      $get_user_addon_selected = get_option("WP_ULTIMATE_SELECTED_ADDON_Users");
      if(empty($get_user_addon_selected) || $get_user_addon_selected == 'checked'){
        $user_checked = 'checked';
      }
      elseif($get_user_addon_selected == 'unchecked'){
        $user_checked = '';
      }
  
      $get_woocom_addon_selected = get_option("WP_ULTIMATE_SELECTED_ADDON_WooCommerce");
      if(empty($get_woocom_addon_selected) || $get_woocom_addon_selected == 'checked'){
        $woocom_checked = 'checked';
      }
      elseif($get_woocom_addon_selected == 'unchecked'){
        $woocom_checked = '';
      }
     
      $get_export_addon_selected = get_option("WP_ULTIMATE_SELECTED_ADDON_Exporter");
      
      if(empty($get_export_addon_selected) || $get_export_addon_selected == 'checked'){
        $export_checked = 'checked';
      }
      elseif($get_export_addon_selected == 'unchecked'){
        $export_checked = '';
      }
  ?>
    
    <div class="row">
    <section class="music">
    <div class="logo">
    <img src="https://cdn.smackcoders.com/wp-content/uploads/2018/03/CSV-Importer-Logo.png" alt="Paris" style="max-width: 16%;margin-top: 10px;margin-right: 0px;">
      <h1>WP ULTIMATE CSV IMPORTER</h1>
  </div>
      <h2><a href="https://wordpress.org/plugins/import-users/" target="_blank">IMPORT USERS</a></h2><span class="slider"><input type="checkbox" name="offline" id="offline" value="Users" <?php echo $user_checked; ?>><label for="offline"></label></span>
      <p>Import your user records available in the CSV/XML file with custom fields, Woocommerce Shipping and Billing details.</p>
      <h2><a href="https://wordpress.org/plugins/import-woocommerce/" target="_blank">IMPORT WOOCOMMERCE</a></h2><span class="slider"><input type="checkbox" name="offline" id="notifications" value="WooCommerce" <?php echo $woocom_checked; ?>><label for="notifications"></label></span>
      <p>Import your WooCommerce Products records with attributes, categories, tags, and images available in the CSV/XML file.</p>
      <h2><a href="https://wordpress.org/plugins/wp-ultimate-exporter/" target="_blank">EXPORT WORDPRESS DATA</a></h2><span class="slider"><input type="checkbox" name="offline" id="export" value="Exporter" <?php echo $export_checked; ?>><label for="export"></label></span>
      <p>Export your Posts, Pages, Custom Posts, Users, Comments, and WooCommerce Products data as CSV files from the WordPress.</a></p>

    </section>
  
        <div input type="button" class="buttonmid" id="click_get_started">
         Get started
        </div>
      
    
      </div>
  </div>
<style>
*, *:before, *:after {
  box-sizing: border-box;
}





.music a {
  text-decoration: none;
  font-size: 17px;
    color: #00a699;
    font-family:Cambria;
    font-weight: bold;
}

.container {
  display: flex;
  justify-content: center;
  margin: 10% 5%; 
}

.logo{
   display:flex;
}

.settings {
  width: 400px;
  height: 520px;
  margin: 0 auto;
  padding: 5px 15px;
  border-radius:10px;
  
}

.row {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
}

header {
  display: inline-flex;
  width: 100%;
  margin: 25px 0 15px;
  justify-content: space-between;
}


section h1 {
  font-size: 17px;
    font-weight: bold;
    color: #00a699;
    margin-top: 32px;
    font-family: Cambria;
    max-width: 84%;
    margin-left: 34px;
}



.buttonmid{
  width: 166px;
    height: 39px;
    margin: 0 auto 0 auto;
    margin-top: 18px;
    background: #00a699;
    text-align: center;
    cursor: pointer;
    -moz-transition: all 0.4s ease-in-out;
    -o-transition: all 0.4s ease-in-out;
    -ms-transition: all 0.4s ease-in-out;
    transition: all 0.4s ease-in-out;
    color: #fff;
    font-size: 15px;
    font-weight: bold;
    text-decoration: none;
    line-height: 2.5;
    border-radius: 7px;
}
.buttonmid:hover{
  width:40%;
}

header .profile {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 2px solid #666886;
}

.profile img {
  width: 100%;
  border-radius: 50%;
}

section {
  display: flex;
  flex-flow: row wrap;
  width: 100%;
}

section h2 {
  font-size: 32px;
  color: #00a699;
  font-family:Cambria;
  margin: 13px 0px;
}

section p {
  font-size: 12px;
  width: 60%;
  margin-top: 0px;
  margin-bottom: 0px;
  letter-spacing: 0.05rem;
  color:#000000;
  font-family:'Times New Roman', Times, serif;

}
section span  {
  margin-top: 10px;
  
}

.music {
  justify-content: space-between;
}

.music .quality {
    cursor: pointer;
}



.music span{
  text-align: right;
  margin-right: 120px;
}

.music > .slider {
  display: block;
  width: 2.5rem;
  height: 1rem;
  position: relative;
  margin-right: 10px;
 
}

.music > .slider input {
  opacity: 0;
  
}

.music > .slider label {
  content: 'off';
    position: absolute;
    background-color: rgb(241, 241, 241);
    width: 39px;
    height: 17px;
    margin-top: 10px;
    top: 0;
    left: 0;
    border-radius: 1.5rem;
    -webkit-transition: background-color .2s ease-in-out;
    transition: background-color .2s ease-in-out;
}


.music > .slider label:after {
  content: '';
    position: absolute;
    display: block;
    width: 15px;
    height: 15px;
    border-radius: 1.5rem;
    margin-top: 1px;
    cursor: pointer;
    top: 0;
    z-index: 1;
    left: .15rem;
    background-color: #00a699;
    -webkit-transition: left .2s ease-in-out;
    transition: left .2s ease-in-out;
}

.music > .slider input[type=checkbox]:checked ~ label {
  background-color: rgb(0,225,225);
}
.music > .slider input[type=checkbox]:checked ~ label:after{
  left: 1.5rem;
}

#theme {
  cursor: pointer;
}





/* dark theme */
.dark {
  background-color: #ffffff;
  color: #e1e1e1;
  margin: 10% 30%;
}

.dark h2, .dark span {
  color: f3e8e8;
}

.dark .user input {
  background-color: rgba(0,0,0,.2);
  color: #e1e1e1;
}
.dark .user input:focus {
  outline: -webkit-focus-ring-color auto 2px;
  outline-color: rgb(0,252,252);
}


/* light theme */
.light {
  color: #1a1f2b;
  background-color: #e1e1e1;
}

.light .social > .sm label:after {
  color: #a1a1a1;
}

</style>

<script>

  jQuery(document).ready(function(){
      document.getElementById('click_get_started').onclick = function () { 
       jQuery(this).html('<img src="<?php echo esc_url(plugins_url());?>/wp-ultimate-csv-importer/assets/images/ajax-loader.gif" />');
        var addons = [];
        
        jQuery.each(jQuery("input[name='offline']:checked"), function(){
            addons.push(jQuery(this).val());
        });

        if(addons.length == 0){
          <?php
              update_option("WP_ULTIMATE_SELECTED_ADDON_Users", "unchecked");
              update_option("WP_ULTIMATE_SELECTED_ADDON_WooCommerce", "unchecked");
              update_option("WP_ULTIMATE_SELECTED_ADDON_Exporter", "unchecked");
          ?>
        }
        if(addons.length == 0){
          jQuery('#click_get_started').html('Get Started')
          window.location.replace("<?php echo esc_url(admin_url());?>admin.php?page=com.smackcoders.csvimporternew.menu");
        }
          jQuery.each(addons, function (index, value) {
            var isLastElement = index == addons.length -1;
            var last_iteration = '';
            if (isLastElement) {
              last_iteration = 'yes';
            }
            jQuery.ajax({
              type: 'POST',
              url: ajaxurl,
              data: {
                'action' : 'install_plugins',
                'addons' : value,
                'last_iteration' : last_iteration,
                'all_addons' : addons,
              },

              success: function(data){

                <?php 
                    $message = '';
                    $check_failed_addon_status = get_option('WP_ULTIMATE_ADDONS_FAILED');
                    if(!empty($check_failed_addon_status)){
                      $message = $check_failed_addon_status . " addon Installation Failed. Please check folder permissions";
                    }
                ?>

                var mess = '<?php echo $message; ?>';
                if(mess === ''){
                 // no alert box
                }else{
                  alert(mess);
                }

                if ( last_iteration == 'yes') {
                  
                  jQuery('#click_get_started').html('Get Started')
                  window.location.replace("<?php echo esc_url(admin_url());?>admin.php?page=com.smackcoders.csvimporternew.menu");
                }
              },
              error: function(errorThrown){
              }
            });
          });
      }
  });
  
</script>