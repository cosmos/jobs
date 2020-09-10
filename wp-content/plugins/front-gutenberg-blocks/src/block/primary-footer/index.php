<?php
/**
 * Server-side rendering of the `fgb/primary-footer` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/primary-footer` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_primary_footer_block' ) ) {
    function frontgb_render_primary_footer_block( $attributes ) {
        ob_start();
        if( function_exists( 'front_display_footer_primary' ) ) {
            front_display_footer_primary( $attributes );
        }
        return ob_get_clean();
    }
}

if ( ! function_exists( 'front_display_footer_primary' ) ) {
    function front_display_footer_primary( $args = array() ) {
        $defaults = array(
            'className'                 => '',
            'footerVersion'             => 'v1',
            'enableContainer'           => true,
            'isContainerFluid'          => false,
            'enableLightLogo'           => true,
            'enableLogoSiteTitle'       => false,
            'logoImageUrl'              => '',
            'customLogoWidth'           => '',
            'upArrowIconClass'          => 'fas fa-angle-double-up',
            'siteDescription'           => '',
            'enableCopyright'           => true,
            'copyRightText'             => '',
            'footerPrimaryMenuID'       => 0,
            'footerSocialMenuID'        => 0,
            'footerPrimaryMenuSlug'     => '',
            'footerSocialMenuSlug'      => '',
            'footerStaticContentId'     => '',
            'footerWidgetColumn1'       => '',
            'footerWidgetColumn2'       => '',
            'footerWidgetColumn3'       => '',
            'footerWidgetColumn4'       => '',
            'footerFormShortcode'       => '',
            'footerTitle'               => "We're here to help",
            'footerDescription'         => 'Find the right solution and get tailored pricing options. Or, find fast answers in our <a class="text-warning font-weight-medium" href="../pages/help.html">Help Center.</a>',
            'contactInfoLimit'          => 3,
            'enableBg'                  => false,
        );

        for ( $i = 1; $i <= apply_filters( 'frontgb.primary.footer-6.max.limit', 10  ); $i++ ) { 

            if ( $i % 3 == 1 ) {
                $default_icon = 'fas fa-envelope';
                $default_title = 'General enquiries';
                $default_desc = 'hello@htmlstream.com';
            } 
            else if ( $i % 3 == 2 ) {
                $default_icon = 'fas fa-phone';
                $default_title = 'Phone Number';
                $default_desc = '+1 (062) 109-9222';
            }
            else {
                $default_icon = 'fas fa-map-marker-alt';
                $default_title = 'Address';
                $default_desc = '153 Williamson Plaza, 09514';
            }

            $defaults[ "contact_icon{$i}" ]  = $default_icon;
            $defaults[ "contact_title{$i}" ] = $default_title;
            $defaults[ "contact_desc{$i}" ]  = $default_desc;
            $defaults[ "contact_link{$i}" ]  = '#';
        }

        $args = wp_parse_args( $args, $defaults );
        extract( $args );

        $container_class = '';

        if( $enableContainer ) {

            if ( $isContainerFluid == false ) {
                $container_class = 'container ';
            }
            else {
                $container_class = 'container-fluid ';
            }
        }

        if ( $enableLightLogo == true ) {
            add_filter( 'front_use_footer_svg_logo_light', '__return_true');
        } 
        else {
            add_filter( 'front_use_footer_svg_logo_light', '__return_false');
        }

        if ( $enableLogoSiteTitle == true ) {
            add_filter( 'front_use_footer_svg_logo_with_site_title', '__return_true');
        } 
        else {
            add_filter( 'front_use_footer_svg_logo_with_site_title', '__return_false');
        }

        $default_footer_primary_v6_form = '<form class="js-validate card border-0 shadow-soft p-5" novalidate="novalidate"><div class="mb-4"><h3 class="h5">Drop us a message</h3></div><div class="row mx-gutters-2"><div class="col-md-6 mb-3"><label class="sr-only">First name</label><div class="js-form-message"><div class="input-group"> <input type="text" class="form-control" name="firstName" placeholder="First name" aria-label="First name" required="" data-msg="Please enter your first name." data-error-class="u-has-error" data-success-class="u-has-success"></div></div></div><div class="col-md-6 mb-3"> <label class="sr-only">Last name</label><div class="js-form-message"><div class="input-group"> <input type="text" class="form-control" name="lasstName" placeholder="Last name" aria-label="Last name" required="" data-msg="Please enter your last name." data-error-class="u-has-error" data-success-class="u-has-success"></div></div></div><div class="w-100"></div><div class="col-md-6 mb-3"> <label class="sr-only">Country</label><div class="js-form-message"><div class="input-group"> <select class="form-control custom-select text-muted" required="" data-msg="Please select country." data-error-class="u-has-error" data-success-class="u-has-success"><option value="">Select country</option><option value="AF">Afghanistan</option><option value="AX">Åland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia, Plurinational State of</option><option value="BQ">Bonaire, Sint Eustatius and Saba</option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei Darussalam</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo</option><option value="CD">Congo, the Democratic Republic of the</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="CI">Côte d\'Ivoire</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CW">Curaçao</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands (Malvinas)</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island and McDonald Islands</option><option value="VA">Holy See (Vatican City State)</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran, Islamic Republic of</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KP">Korea, Democratic People\'s Republic of</option><option value="KR">Korea, Republic of</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Lao People\'s Democratic Republic</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MK">Macedonia, the former Yugoslav Republic of</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia, Federated States of</option><option value="MD">Moldova, Republic of</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestinian Territory, Occupied</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Réunion</option><option value="RO">Romania</option><option value="RU">Russian Federation</option><option value="RW">Rwanda</option><option value="BL">Saint Barthélemy</option><option value="SH">Saint Helena, Ascension and Tristan da Cunha</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin (French part)</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome and Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SX">Sint Maarten (Dutch part)</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia and the South Sandwich Islands</option><option value="SS">South Sudan</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syrian Arab Republic</option><option value="TW">Taiwan, Province of China</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania, United Republic of</option><option value="TH">Thailand</option><option value="TL">Timor-Leste</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VE">Venezuela, Bolivarian Republic of</option><option value="VN">Viet Nam</option><option value="VG">Virgin Islands, British</option><option value="VI">Virgin Islands, U.S.</option><option value="WF">Wallis and Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option> </select></div></div></div><div class="col-md-6 mb-3"> <label class="sr-only">Email address</label><div class="js-form-message"><div class="input-group"> <input type="text" class="form-control" name="email" placeholder="Email address" aria-label="Email address" required="" data-msg="Please enter a valid email address." data-error-class="u-has-error" data-success-class="u-has-success"></div></div></div><div class="w-100"></div><div class="col-md-6 mb-3"> <label class="sr-only">Company</label><div class="js-form-message"><div class="input-group"> <input type="text" class="form-control" name="company" placeholder="Company" aria-label="Company" required="" data-msg="Please enter company name." data-error-class="u-has-error" data-success-class="u-has-success"></div></div></div><div class="col-md-6 mb-3"> <label class="sr-only">Job title</label><div class="js-form-message"><div class="input-group"> <input type="text" class="form-control" name="jobTitle" placeholder="Job title" aria-label="Job title" required="" data-msg="Please enter a job title." data-error-class="u-has-error" data-success-class="u-has-success"></div></div></div></div><div class="mb-5"> <label class="sr-only">How can we help you?</label><div class="js-form-message input-group"><textarea class="form-control" rows="4" name="description" placeholder="Hi there, I would like to ..." aria-label="Hi there, I would like to ..." required="" data-msg="Please enter a reason." data-error-class="u-has-error" data-success-class="u-has-success"></textarea></div></div><div class="js-form-message mb-3"><div class="custom-control custom-checkbox d-flex align-items-center text-muted"> <input type="checkbox" class="custom-control-input" id="termsCheckbox" name="termsCheckbox" required="" data-msg="Please accept our Terms and Conditions." data-error-class="u-has-error" data-success-class="u-has-success"> <label class="custom-control-label" for="termsCheckbox"> <small> I agree to the <a class="link-muted" href="../pages/terms.html">Terms and Conditions</a> </small> </label></div></div><div class="js-form-message mb-5"><div class="custom-control custom-checkbox d-flex align-items-center text-muted"> <input type="checkbox" class="custom-control-input" id="newsletterCheckbox" name="newsletterCheckbox" required="" data-msg="Please accept our Terms and Conditions." data-error-class="u-has-error" data-success-class="u-has-success"> <label class="custom-control-label" for="newsletterCheckbox"> <small>I want to receive Front\'s Newsletters</small> </label></div></div><button type="submit" class="btn btn-primary btn-pill btn-wide transition-3d-hover">Submit</button></form>';

        switch ( $footerVersion ) {
            case 'v1':?>
               <footer class="site-footer site-footer__primary gradient-half-primary-v1 primary-bg style-v1<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>space-top-2 space-bottom-1">
                        <div class="row justify-content-lg-start mb-7">
                            <div class="column col-sm-9 col-lg-4 mb-7">
                                <?php if( ! empty( $logoImageUrl ) ) : ?>
                                    <a class="d-inline-flex align-items-center mb-3" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                                    </a><?php
                                    else :
                                        if ( function_exists( 'front_footer_logo' ) ) {
                                            front_footer_logo();
                                        } 
                                endif;
                                ?>
                                <p class="small text-white-70 mb-3">
                                    <?php 
                                    if ( ! empty( $siteDescription ) ) {
                                        echo wp_kses_post( $siteDescription );   
                                    }
                                    else {
                                        echo apply_filters( 'front_footer_site_description', esc_html( get_bloginfo( 'description' ) ) ); 
                                    }
                                    ?>
                                </p>
                            </div>
                            <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ): ?>
                                    <div class="column col-6 col-sm-4 col-lg-2 ml-lg-auto mb-4">
                                        <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                    </div>
                                <?php endif ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ): ?>
                                    <div class="column col-6 col-sm-4 col-lg-2 mb-4">
                                        <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                    </div>
                                <?php endif ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ): ?>
                                    <div class="column col-6 col-sm-4 col-lg-2 mb-4">
                                        <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                    </div>
                                <?php endif ?>
                            <?php endif; ?>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <?php 
                                    $nav_menu_args = array(
                                        'theme_location'  => 'footer_social_menu',
                                        'container'       => false,
                                        'menu_class'      => 'footer-social-menu list-inline mb-0',
                                        'icon_class'      => array( 'btn-icon__inner' ),
                                        'item_class'      => array( 'list-inline-item' ),
                                        'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                                        'depth'           => 0,
                                        'walker'          => new Front_Walker_Social_Media(),
                                    );

                                    if( $footerSocialMenuID > 0 ) {
                                        $nav_menu_args['menu'] = $footerSocialMenuID;
                                    } elseif( ! empty( $footerSocialMenuSlug ) ) {
                                        $nav_menu_args['menu'] = $footerSocialMenuSlug;
                                    }

                                    if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                                        wp_nav_menu( $nav_menu_args );
                                    } else {
                                        ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                                    }
                                ?>
                            </div>
                            <?php if ( $enableCopyright == true ): ?>
                            <div class="col-sm-6 text-sm-right">
                                <p class="small text-white-70 mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v2';?>
                <footer class="site-footer site-footer__primary style-v2 position-relative text-center mx-auto<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <a class="js-go-to" 
                        href="javascript:;"
                         data-type="absolute"
                        data-position='{
                            "bottom": 86,
                            "right": 0,
                            "left": 0
                        }'
                        data-compensation="#header"
                        data-show-effect="slideInUp"
                        data-hide-effect="slideOutDown">

                        <figure class="u-go-to-wave ie-go-to-wave">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 208 44" style="margin-bottom: -33px; enable-background:new 0 0 208 44;" xml:space="preserve">
                            <path class="fill-primary" d="M0,43c0,0,22.9,2.2,54-18.7S95.1,1.5,95.1,1.5s11.2-3.5,20.1,0.1s10.4,3.7,19.2,9.3c7.7,4.8,15,10.1,22.8,14.9
                            c10.1,6.2,21.5,11.7,33,14.8C191.6,41,208,44,208,43c0,0,0,1,0,1H0V43z"/>
                            </svg>
                            <span class="<?php echo esc_attr( $upArrowIconClass ); ?> text-white u-go-to-wave__icon"></span>
                        </figure>
                    </a>

                    <div class="bg-primary">
                        <div class="<?php echo esc_attr( $container_class ); ?>space-1">
                            <?php if ( $enableCopyright == true ): ?>
                                <p class="small text-white-70 mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </footer>
            <?php break;


            case 'v3': ?>
                <footer class="site-footer site-footer__primary style-v3 <?php echo esc_attr( $enableBg == true ? 'bg-primary' : 'u-sticky-footer' ); ?><?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?><?php echo esc_attr( $enableBg == true ? 'space-1' : 'space-bottom-1' ); ?>">
                        <div class="row justify-content-between align-items-center">
                            <?php if ( $enableCopyright == true ): ?>
                            <div class="col-sm-5 mb-3 mb-sm-0">
                                <p class="small text-white-70 mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                            </div>
                            <?php endif; ?>
                            <div class="col-sm-6 text-sm-right">
                                <?php 
                                    $nav_menu_args = array(
                                        'theme_location'  => 'footer_social_menu',
                                        'container'       => false,
                                        'menu_class'      => 'footer-social-menu list-inline mb-0',
                                        'icon_class'      => array( 'btn-icon__inner' ),
                                        'item_class'      => array( 'list-inline-item' ),
                                        'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                                        'depth'           => 0,
                                        'walker'          => new Front_Walker_Social_Media(),
                                    );

                                    if( $footerSocialMenuID > 0 ) {
                                        $nav_menu_args['menu'] = $footerSocialMenuID;
                                    } elseif( ! empty( $footerSocialMenuSlug ) ) {
                                        $nav_menu_args['menu'] = $footerSocialMenuSlug;
                                    }

                                    if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                                        wp_nav_menu( $nav_menu_args );
                                    } else {
                                        ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v4' ?>
                <footer class="site-footer site-footer__primary style-v4 gradient-half-primary-v4<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>">
                        <?php 
                        if( function_exists( 'front_is_mas_static_content_activated' ) && front_is_mas_static_content_activated() && ! empty( $footerStaticContentId ) ) {
                
                            $static_block = get_post( $footerStaticContentId );
                            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
                            echo '<div class="footer-static-content">' . apply_filters( 'the_content', $content ) . '</div>';
                            ?><hr class="opacity-md my-0"><?php
                        }
                        ?>
                        <div class="row justify-content-md-between space-2">
                            <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) || is_active_sidebar( $footerWidgetColumn4 ) ) : ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ): ?>
                                <div class="col-6 col-sm-4 col-lg-2 order-lg-2 mb-7 mb-lg-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                </div> 
                                <?php endif ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ): ?>
                                <div class="col-6 col-sm-4 col-lg-2 order-lg-3 mb-7 mb-lg-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                </div>
                                <?php endif ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ): ?>
                                <div class="col-sm-4 col-lg-2 order-lg-4 mb-7 mb-lg-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                </div>
                                <?php endif ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn4 ) ): ?>
                                <div class="col-sm-6 col-md-5 col-lg-3 order-lg-5 mb-6 mb-sm-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn4 ); ?>
                                </div>
                                <?php endif ?>
                            <?php endif; ?>

                            <div class="col-sm-6 col-md-5 col-lg-3 order-lg-1">
                                <div class="d-flex align-self-start flex-column h-100">
                                    <?php if( ! empty( $logoImageUrl ) ) : ?>
                                        <a class="d-flex align-items-center mb-3" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                            <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                                        </a><?php
                                        else :
                                            if ( function_exists( 'front_footer_logo' ) ) {
                                                front_footer_logo();
                                            } 
                                    endif;
                                    ?>
                                    <?php if ( $enableCopyright == true ): ?>
                                        <p class="small text-white-70 mt-lg-auto mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v5' ?>
                <footer id="SVGfooterTopShape" class="site-footer site-footer__primary style-v5 position-relative gradient-half-primary-v5<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>space-top-4 space-bottom-2">
                        <?php 
                        if( function_exists( 'front_is_mas_static_content_activated' ) && front_is_mas_static_content_activated() && ! empty( $footerStaticContentId ) ) {
                
                            $static_block = get_post( $footerStaticContentId );
                            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
                            echo '<div class="footer-static-content">' . apply_filters( 'the_content', $content ) . '</div>';
                            ?><hr class="opacity-md my-7"><?php
                        }
                        ?>
                        <div class="row align-items-lg-center">
                            <div class="col-lg-3 mb-4 mb-lg-0">
                                <?php if ( $enableCopyright == true ): ?>
                                    <p class="small text-white-70 mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8 col-lg-6 mb-4 mb-md-0">
                                <?php
                                    $nav_menu_args = array(
                                        'theme_location'     => 'footer_primary_menu',
                                        'depth'              => 0,
                                        'container'          => false,
                                        'menu_class'         => 'footer-primary-menu list-inline',
                                        'fallback_cb'        => 'Front_Walker_Bootstrap_Nav_Menu::fallback',
                                        'walker'             => new Front_Walker_Bootstrap_Nav_Menu(),
                                    );

                                    if( $footerPrimaryMenuID > 0 ) {
                                        $nav_menu_args['menu'] = $footerPrimaryMenuID;
                                    } elseif( ! empty( $footerPrimaryMenuSlug ) ) {
                                        $nav_menu_args['menu'] = $footerPrimaryMenuSlug;
                                    }


                                    wp_nav_menu( $nav_menu_args );
                                ?>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <?php 
                                    $nav_menu_args = array(
                                        'theme_location'  => 'footer_social_menu',
                                        'container'       => false,
                                        'menu_class'      => 'footer-social-menu list-inline mb-0',
                                        'icon_class'      => array( 'btn-icon__inner' ),
                                        'item_class'      => array( 'list-inline-item' ),
                                        'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                                        'depth'           => 0,
                                        'walker'          => new Front_Walker_Social_Media(),
                                    );

                                    if( $footerSocialMenuID > 0 ) {
                                        $nav_menu_args['menu'] = $footerSocialMenuID;
                                    } elseif( ! empty( $footerSocialMenuSlug ) ) {
                                        $nav_menu_args['menu'] = $footerSocialMenuSlug;
                                    }

                                    if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                                        wp_nav_menu( $nav_menu_args );
                                    } else {
                                        ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <figure class="position-absolute top-0 right-0 left-0">
                        <img class="js-svg-injector" src="<?php echo front_get_assets_url() . 'svg/components/wave-1-top-sm.svg'; ?>" alt="Svg" data-parent="#SVGfooterTopShape">
                    </figure>
                </footer>
            <?php break;

            case 'v6' ?>
                <footer id="SVGFooterExample24" class="site-footer site-footer__primary style-v6 gradient-half-primary-v4 position-relative<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>space-bottom-1 position-relative z-index-2">
                        <div class="row justify-content-lg-between mb-11">
                            <div class="col-lg-5 space-top-2 space-top-lg-3 text-white mb-7 mb-lg-0">
                                <div class="mb-7">
                                    <h2 class="h1 font-weight-medium text-white"><?php echo wp_kses_post( $footerTitle ); ?></h2>        
                                    <p class="text-white"><?php echo wp_kses_post( $footerDescription ); ?></p>
                                </div>
                                <div class="row">
                                    <?php 
                                    for ( $i = 1; $i <= $contactInfoLimit; $i++ ) { 
                                        ?>
                                        <div class="col-sm-6<?php echo esc_attr( $i == $contactInfoLimit ? '' : ' mb-5' ); ?>">
                                            <?php 
                                                $iconContent = false;

                                                if( ! empty( $args[ "contact_icon{$i}" ] ) ) {
                                                    $iconClasses = array();

                                                    $iconPrefix = substr( $args[ "contact_icon{$i}" ], 0, 3 );
                                                    if( $iconPrefix == "fgb" ) {
                                                        $iconClasses[] = 'ie-height-20';
                                                        $iconClasses[] = 'max-width-6';
                                                        $iconClasses[] = 'button-width';
                                                        $iconClasses[] = 'mb-3';
                                                        $buttonIconPath = function_exists( 'front_get_icon_path' ) ? front_get_icon_path( $args[ "contact_icon{$i}" ] ) : front_get_assets_url() . 'svg/icons/' . str_replace( substr( $args[ "contact_icon{$i}" ], 0, 4 ), '', $args[ "contact_icon{$i}" ] ) . '.svg';
                                                        $iconContent = '<figure class="' . esc_attr( implode( ' ', $iconClasses ) ) . '"><img class="js-svg-injector" src="' . esc_url( $buttonIconPath ) . '" alt="' . esc_attr__( 'SVG', FRONTGB_I18N ) . '" /></figure>';
                                                    } else {
                                                        $iconClasses[] = str_replace( $iconPrefix, $iconPrefix . ' fa', $args[ "contact_icon{$i}" ] );
                                                        $iconContent = '<span class="btn btn-icon btn-soft-white rounded-circle mb-3"><span class="' . esc_attr( implode( ' ', $iconClasses ) ) . ' btn-icon__inner"></span></span>';
                                                    }
                                                }
                                            ?>
                                            <?php echo wp_kses_post( $iconContent ); ?>

                                            <h4 class="h6 mb-0"><?php echo wp_kses_post( $args[ "contact_title{$i}" ] ); ?></h4>
                                            <a class="text-white-70 font-size-1" href="<?php echo esc_url( $args[ "contact_link{$i}" ] ); ?>"><?php echo wp_kses_post( $args[ "contact_desc{$i}" ] ); ?></a>
                                        </div><?php
                                    } 
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-lg-n11">
                                <?php echo do_shortcode( ! empty( $footerFormShortcode ) ? $footerFormShortcode : $default_footer_primary_v6_form, true ) ?>
                            </div>
                        </div>

                        <div class="text-center footer-logo-v6">
                            <?php if( ! empty( $logoImageUrl ) ) : ?>
                                <a class="d-inline-flex align-items-center mb-2" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                                </a><?php
                                else :
                                    if ( function_exists( 'front_footer_logo' ) ) {
                                        front_footer_logo();
                                    } 
                            endif;
                            ?>
                            <?php if ( $enableCopyright == true ): ?>
                                <p class="small text-white-70"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <figure class="w-100 position-absolute bottom-0 left-0">
                        <img class="js-svg-injector" src="<?php echo front_get_assets_url() . 'svg/illustrations/isometric-squares.svg'; ?>" alt="Svg" data-parent="#SVGFooterExample24">
                    </figure>
                </footer>
            <?php break;
        }
    }
}

if ( ! function_exists( 'frontgb_register_primary_footer_block' ) ) {
    /**
     * Registers the `fgb/primary-footer` block on server.
     */
    function frontgb_register_primary_footer_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        $attributes = array(
            'className' => array(
                'type' => 'string',
            ),
            'footerVersion' => array(
                'type' => 'string',
                'default' => 'v1',
            ),
            'enableContainer'  => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'isContainerFluid'  => array(
                'type' => 'boolean',
                'default' => false,
            ),
            'enableLightLogo' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'enableLogoSiteTitle' => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'logoImageUrl' => array(
                'type' => 'string',
            ),
            'customLogoWidth' => array(
                'type' => 'number',
            ),
            'upArrowIconClass' => array(
                'type' => 'string',
                'default' => 'fas fa-angle-double-up',
            ),
            'siteDescription'  => array(
                'type' => 'string',
            ),
            'enableCopyright'  => array(
                'type' => 'boolean',
                'default' => true,
            ),
            'copyRightText' => array(
                'type' => 'string',
            ),
            'footerPrimaryMenuID' => array(
                'type' => 'number',
                'default' => 0
            ),
            'footerSocialMenuID' => array(
                'type' => 'number',
                'default' => 0
            ),
            'footerStaticContentId'  => array(
                'type' => 'number',
            ),
            'footerWidgetColumn1' => array(
                'type' => 'string',
            ),
            'footerWidgetColumn2' => array(
                'type' => 'string',
            ),
            'footerWidgetColumn3' => array(
                'type' => 'string',
            ),
            'footerWidgetColumn4' => array(
                'type' => 'string',
            ),
            'footerFormShortcode'  => array(
                'type' => 'string',
            ),
            'footerTitle' => array(
                'type' => 'string',
                'default' => "We're here to help"
            ),
            'footerDescription'  => array(
                'type' => 'string',
                'default' => 'Find the right solution and get tailored pricing options. Or, find fast answers in our <a class="text-warning font-weight-medium" href="../pages/help.html">Help Center.</a>'
            ),
            'contactInfoLimit' => array(
                'type' => 'number',
                'default' => 3
            ),
            'enableBg'  => array(
                'type' => 'boolean',
                'default' => false,
            ),
        );

        for ( $i = 1; $i <= apply_filters( 'frontgb.primary.footer-6.max.limit', 10  ) ; $i++ ) { 
            if ( $i % 3 == 1 ) {
                $default_icon = 'fas fa-envelope';
                $default_title = 'General enquiries';
                $default_desc = 'hello@htmlstream.com';
            } 
            else if ( $i % 3 == 2 ) {
                $default_icon = 'fas fa-phone';
                $default_title = 'Phone Number';
                $default_desc = '+1 (062) 109-9222';
            }
            else {
                $default_icon = 'fas fa-map-marker-alt';
                $default_title = 'Address';
                $default_desc = '153 Williamson Plaza, 09514';
            }

            $attributes[ "contact_icon{$i}" ] = array(
                'type' => 'string',
                'default' => $default_icon
            );

            $attributes[ "contact_title{$i}" ] = array(
                'type' => 'string',
                'default' => $default_title
            );

            $attributes[ "contact_desc{$i}" ] = array(
                'type' => 'string',
                'default' => $default_desc
            );

            $attributes[ "contact_link{$i}" ] = array(
                'type' => 'string',
                'default' => '#'
            );
        }

        register_block_type(
            'fgb/primary-footer',
            array(
                'attributes' => $attributes,
                'render_callback' => 'frontgb_render_primary_footer_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_primary_footer_block' );
}