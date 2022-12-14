<?php

use WP_SMS\Gateway;
use WP_SMS\Option;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * @return mixed
 */
function wp_sms_initial_gateway()
{
    require_once WP_SMS_DIR . 'includes/class-wpsms-option.php';

    return Gateway::initial();
}

/**
 * @param $array_or_string
 * @return mixed|string
 */
function wp_sms_sanitize_array($array_or_string)
{
    if (is_string($array_or_string)) {
        $array_or_string = sanitize_text_field($array_or_string);
    } elseif (is_array($array_or_string)) {
        foreach ($array_or_string as $key => &$value) {
            if (is_array($value)) {
                $value = wp_sms_sanitize_array($value);
            } else {
                $value = sanitize_text_field($value);
            }
        }
    }

    return $array_or_string;
}

/**
 * Get Add-Ons
 *
 * @return array
 */
function wp_sms_get_addons()
{
    return apply_filters('wp_sms_addons', array());
}

/**
 * Generate constant license by plugin slug.
 *
 * @param $plugin_slug
 * @return mixed
 * @example wp-sms-pro > WP_SMS_PRO_LICENSE
 */
function wp_sms_generate_constant_license($plugin_slug)
{
    $generateConstant = strtoupper(str_replace('-', '_', $plugin_slug)) . '_LICENSE';

    if (defined($generateConstant)) {
        return constant($generateConstant);
    }
}

/**
 * Get stored license key
 *
 * @param $addOnKey
 * @return mixed|string
 */
function wp_sms_get_license_key($addOnKey)
{
    $constantLicenseKey = wp_sms_generate_constant_license($addOnKey);

    return $constantLicenseKey ? $constantLicenseKey : Option::getOption("license_{$addOnKey}_key");
}

/**
 * Check the license with server
 *
 * @param $addOnKey
 * @param $licenseKey
 * @return bool|void
 */
function wp_sms_check_remote_license($addOnKey, $licenseKey)
{
    $response = wp_remote_get(add_query_arg(array(
        'plugin-name' => $addOnKey,
        'license_key' => $licenseKey,
        'website'     => get_bloginfo('url'),
    ), WP_SMS_SITE . '/wp-json/plugins/v1/validate'));

    if (is_wp_error($response)) {
        return;
    }

    $response = json_decode($response['body']);

    if (isset($response->status) and $response->status == 200) {
        return true;
    }
}

/**
 * @param $media
 * @return string|void
 */
function wp_sms_render_media_list($media)
{
    $allMedia = unserialize($media);

    if (!is_array($allMedia)) {
        return;
    }

    $htmlMedia = [];
    foreach ($allMedia as $media) {
        $htmlMedia[] = "<img width='80' src='{$media}'/>";
    }

    return implode(' ', $htmlMedia);
}

/**
 * Get countries by code
 *
 * @return string[]
 */
function wp_sms_get_countries()
{
    $countries = [
        '+93'  => 'Afghanistan (??????????????????) (+93)',
        '+355' => 'Albania (Shqip??ri) (+355)',
        '+213' => 'Algeria (??????????????) (+213)',
        '+1'   => 'American Samoa (+1)',
        '+376' => 'Andorra (+376)',
        '+244' => 'Angola (+244)',
        '+1'   => 'Anguilla (+1)',
        '+1'   => 'Antigua and Barbuda (+1)',
        '+54'  => 'Argentina (+54)',
        '+374' => 'Armenia (????????????????) (+374)',
        '+297' => 'Aruba (+297)',
        '+247' => 'Ascension Island (+247)',
        '+61'  => 'Australia (+61)',
        '+43'  => 'Austria (??sterreich) (+43)',
        '+994' => 'Azerbaijan (Az??rbaycan) (+994)',
        '+1'   => 'Bahamas (+1)',
        '+973' => 'Bahrain (??????????????) (+973)',
        '+880' => 'Bangladesh (????????????????????????) (+880)',
        '+1'   => 'Barbados (+1)',
        '+375' => 'Belarus (????????????????) (+375)',
        '+32'  => 'Belgium (Belgi??) (+32)',
        '+501' => 'Belize (+501)',
        '+229' => 'Benin (B??nin) (+229)',
        '+1'   => 'Bermuda (+1)',
        '+975' => 'Bhutan (???????????????) (+975)',
        '+591' => 'Bolivia (+591)',
        '+387' => 'Bosnia and Herzegovina (?????????? ?? ??????????????????????) (+387)',
        '+267' => 'Botswana (+267)',
        '+55'  => 'Brazil (Brasil) (+55)',
        '+246' => 'British Indian Ocean Territory (+246)',
        '+1'   => 'British Virgin Islands (+1)',
        '+673' => 'Brunei (+673)',
        '+359' => 'Bulgaria (????????????????) (+359)',
        '+226' => 'Burkina Faso (+226)',
        '+257' => 'Burundi (Uburundi) (+257)',
        '+855' => 'Cambodia (?????????????????????) (+855)',
        '+237' => 'Cameroon (Cameroun) (+237)',
        '+1'   => 'Canada (+1)',
        '+238' => 'Cape Verde (Kabu Verdi) (+238)',
        '+599' => 'Caribbean Netherlands (+599)',
        '+1'   => 'Cayman Islands (+1)',
        '+236' => 'Central African Republic (R??publique centrafricaine) (+236)',
        '+235' => 'Chad (Tchad) (+235)',
        '+56'  => 'Chile (+56)',
        '+86'  => 'China (??????) (+86)',
        '+61'  => 'Christmas Island (+61)',
        '+61'  => 'Cocos (Keeling) Islands (+61)',
        '+57'  => 'Colombia (+57)',
        '+269' => 'Comoros (?????? ??????????) (+269)',
        '+243' => 'Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo) (+243)',
        '+242' => 'Congo (Republic) (Congo-Brazzaville) (+242)',
        '+682' => 'Cook Islands (+682)',
        '+506' => 'Costa Rica (+506)',
        '+225' => 'C??te d???Ivoire (+225)',
        '+385' => 'Croatia (Hrvatska) (+385)',
        '+53'  => 'Cuba (+53)',
        '+599' => 'Cura??ao (+599)',
        '+357' => 'Cyprus (????????????) (+357)',
        '+420' => 'Czech Republic (??esk?? republika) (+420)',
        '+45'  => 'Denmark (Danmark) (+45)',
        '+253' => 'Djibouti (+253)',
        '+1'   => 'Dominica (+1)',
        '+1'   => 'Dominican Republic (Rep??blica Dominicana) (+1)',
        '+593' => 'Ecuador (+593)',
        '+20'  => 'Egypt (??????) (+20)',
        '+503' => 'El Salvador (+503)',
        '+240' => 'Equatorial Guinea (Guinea Ecuatorial) (+240)',
        '+291' => 'Eritrea (+291)',
        '+372' => 'Estonia (Eesti) (+372)',
        '+268' => 'Eswatini (+268)',
        '+251' => 'Ethiopia (+251)',
        '+500' => 'Falkland Islands (Islas Malvinas) (+500)',
        '+298' => 'Faroe Islands (F??royar) (+298)',
        '+679' => 'Fiji (+679)',
        '+358' => 'Finland (Suomi) (+358)',
        '+33'  => 'France (+33)',
        '+594' => 'French Guiana (Guyane fran??aise) (+594)',
        '+689' => 'French Polynesia (Polyn??sie fran??aise) (+689)',
        '+241' => 'Gabon (+241)',
        '+220' => 'Gambia (+220)',
        '+995' => 'Georgia (??????????????????????????????) (+995)',
        '+49'  => 'Germany (Deutschland) (+49)',
        '+233' => 'Ghana (Gaana) (+233)',
        '+350' => 'Gibraltar (+350)',
        '+30'  => 'Greece (????????????) (+30)',
        '+299' => 'Greenland (Kalaallit Nunaat) (+299)',
        '+1'   => 'Grenada (+1)',
        '+590' => 'Guadeloupe (+590)',
        '+1'   => 'Guam (+1)',
        '+502' => 'Guatemala (+502)',
        '+44'  => 'Guernsey (+44)',
        '+224' => 'Guinea (Guin??e) (+224)',
        '+245' => 'Guinea-Bissau (Guin?? Bissau) (+245)',
        '+592' => 'Guyana (+592)',
        '+509' => 'Haiti (+509)',
        '+504' => 'Honduras (+504)',
        '+852' => 'Hong Kong (??????) (+852)',
        '+36'  => 'Hungary (Magyarorsz??g) (+36)',
        '+354' => 'Iceland (??sland) (+354)',
        '+91'  => 'India (????????????) (+91)',
        '+62'  => 'Indonesia (+62)',
        '+98'  => 'Iran (??????????) (+98)',
        '+964' => 'Iraq (????????????) (+964)',
        '+353' => 'Ireland (+353)',
        '+44'  => 'Isle of Man (+44)',
        '+972' => 'Israel (??????????) (+972)',
        '+39'  => 'Italy (Italia) (+39)',
        '+1'   => 'Jamaica (+1)',
        '+81'  => 'Japan (??????) (+81)',
        '+44'  => 'Jersey (+44)',
        '+962' => 'Jordan (????????????) (+962)',
        '+7'   => 'Kazakhstan (??????????????????) (+7)',
        '+254' => 'Kenya (+254)',
        '+686' => 'Kiribati (+686)',
        '+383' => 'Kosovo (+383)',
        '+965' => 'Kuwait (????????????) (+965)',
        '+996' => 'Kyrgyzstan (????????????????????) (+996)',
        '+856' => 'Laos (?????????) (+856)',
        '+371' => 'Latvia (Latvija) (+371)',
        '+961' => 'Lebanon (??????????) (+961)',
        '+266' => 'Lesotho (+266)',
        '+231' => 'Liberia (+231)',
        '+218' => 'Libya (??????????) (+218)',
        '+423' => 'Liechtenstein (+423)',
        '+370' => 'Lithuania (Lietuva) (+370)',
        '+352' => 'Luxembourg (+352)',
        '+853' => 'Macau (??????) (+853)',
        '+389' => 'North Macedonia (????????????????????) (+389)',
        '+261' => 'Madagascar (Madagasikara) (+261)',
        '+265' => 'Malawi (+265)',
        '+60'  => 'Malaysia (+60)',
        '+960' => 'Maldives (+960)',
        '+223' => 'Mali (+223)',
        '+356' => 'Malta (+356)',
        '+692' => 'Marshall Islands (+692)',
        '+596' => 'Martinique (+596)',
        '+222' => 'Mauritania (??????????????????) (+222)',
        '+230' => 'Mauritius (Moris) (+230)',
        '+262' => 'Mayotte (+262)',
        '+52'  => 'Mexico (M??xico) (+52)',
        '+691' => 'Micronesia (+691)',
        '+373' => 'Moldova (Republica Moldova) (+373)',
        '+377' => 'Monaco (+377)',
        '+976' => 'Mongolia (????????????) (+976)',
        '+382' => 'Montenegro (Crna Gora) (+382)',
        '+1'   => 'Montserrat (+1)',
        '+212' => 'Morocco (????????????) (+212)',
        '+258' => 'Mozambique (Mo??ambique) (+258)',
        '+95'  => 'Myanmar (Burma) (??????????????????) (+95)',
        '+264' => 'Namibia (Namibi??) (+264)',
        '+674' => 'Nauru (+674)',
        '+977' => 'Nepal (???????????????) (+977)',
        '+31'  => 'Netherlands (Nederland) (+31)',
        '+687' => 'New Caledonia (Nouvelle-Cal??donie) (+687)',
        '+64'  => 'New Zealand (+64)',
        '+505' => 'Nicaragua (+505)',
        '+227' => 'Niger (Nijar) (+227)',
        '+234' => 'Nigeria (+234)',
        '+683' => 'Niue (+683)',
        '+672' => 'Norfolk Island (+672)',
        '+850' => 'North Korea (?????? ???????????? ?????? ?????????) (+850)',
        '+1'   => 'Northern Mariana Islands (+1)',
        '+47'  => 'Norway (Norge) (+47)',
        '+968' => 'Oman (??????????) (+968)',
        '+92'  => 'Pakistan (??????????????) (+92)',
        '+680' => 'Palau (+680)',
        '+970' => 'Palestine (????????????) (+970)',
        '+507' => 'Panama (Panam??) (+507)',
        '+675' => 'Papua New Guinea (+675)',
        '+595' => 'Paraguay (+595)',
        '+51'  => 'Peru (Per??) (+51)',
        '+63'  => 'Philippines (+63)',
        '+48'  => 'Poland (Polska) (+48)',
        '+351' => 'Portugal (+351)',
        '+1'   => 'Puerto Rico (+1)',
        '+974' => 'Qatar (??????) (+974)',
        '+262' => 'R??union (La R??union) (+262)',
        '+40'  => 'Romania (Rom??nia) (+40)',
        '+7'   => 'Russia (????????????) (+7)',
        '+250' => 'Rwanda (+250)',
        '+590' => 'Saint Barth??lemy (+590)',
        '+290' => 'Saint Helena (+290)',
        '+1'   => 'Saint Kitts and Nevis (+1)',
        '+1'   => 'Saint Lucia (+1)',
        '+590' => 'Saint Martin (Saint-Martin (partie fran??aise)) (+590)',
        '+508' => 'Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon) (+508)',
        '+1'   => 'Saint Vincent and the Grenadines (+1)',
        '+685' => 'Samoa (+685)',
        '+378' => 'San Marino (+378)',
        '+239' => 'S??o Tom?? and Pr??ncipe (S??o Tom?? e Pr??ncipe) (+239)',
        '+966' => 'Saudi Arabia (?????????????? ?????????????? ????????????????) (+966)',
        '+221' => 'Senegal (S??n??gal) (+221)',
        '+381' => 'Serbia (????????????) (+381)',
        '+248' => 'Seychelles (+248)',
        '+232' => 'Sierra Leone (+232)',
        '+65'  => 'Singapore (+65)',
        '+1'   => 'Sint Maarten (+1)',
        '+421' => 'Slovakia (Slovensko) (+421)',
        '+386' => 'Slovenia (Slovenija) (+386)',
        '+677' => 'Solomon Islands (+677)',
        '+252' => 'Somalia (Soomaaliya) (+252)',
        '+27'  => 'South Africa (+27)',
        '+82'  => 'South Korea (????????????) (+82)',
        '+211' => 'South Sudan (???????? ??????????????) (+211)',
        '+34'  => 'Spain (Espa??a) (+34)',
        '+94'  => 'Sri Lanka (??????????????? ???????????????) (+94)',
        '+249' => 'Sudan (??????????????) (+249)',
        '+597' => 'Suriname (+597)',
        '+47'  => 'Svalbard and Jan Mayen (+47)',
        '+46'  => 'Sweden (Sverige) (+46)',
        '+41'  => 'Switzerland (Schweiz) (+41)',
        '+963' => 'Syria (??????????) (+963)',
        '+886' => 'Taiwan (??????) (+886)',
        '+992' => 'Tajikistan (+992)',
        '+255' => 'Tanzania (+255)',
        '+66'  => 'Thailand (?????????) (+66)',
        '+670' => 'Timor-Leste (+670)',
        '+228' => 'Togo (+228)',
        '+690' => 'Tokelau (+690)',
        '+676' => 'Tonga (+676)',
        '+1'   => 'Trinidad and Tobago (+1)',
        '+216' => 'Tunisia (????????) (+216)',
        '+90'  => 'Turkey (T??rkiye) (+90)',
        '+993' => 'Turkmenistan (+993)',
        '+1'   => 'Turks and Caicos Islands (+1)',
        '+688' => 'Tuvalu (+688)',
        '+1'   => 'U.S. Virgin Islands (+1)',
        '+256' => 'Uganda (+256)',
        '+380' => 'Ukraine (??????????????) (+380)',
        '+971' => 'United Arab Emirates (???????????????? ?????????????? ??????????????) (+971)',
        '+44'  => 'United Kingdom (+44)',
        '+1'   => 'United States (+1)',
        '+598' => 'Uruguay (+598)',
        '+998' => 'Uzbekistan (O??zbekiston) (+998)',
        '+678' => 'Vanuatu (+678)',
        '+39'  => 'Vatican City (Citt?? del Vaticano) (+39)',
        '+58'  => 'Venezuela (+58)',
        '+84'  => 'Vietnam (Vi???t Nam) (+84)',
        '+681' => 'Wallis and Futuna (Wallis-et-Futuna) (+681)',
        '+212' => 'Western Sahara (?????????????? ??????????????) (+212)',
        '+967' => 'Yemen (??????????) (+967)',
        '+260' => 'Zambia (+260)',
        '+263' => 'Zimbabwe (+263)',
        '+358' => '??land Islands (+358)',
    ];

    return $countries;
}

/**
 * Show SMS newsletter form.
 *
 * @deprecated 4.0 Use wp_sms_subscribes()
 * @see wp_sms_subscribes()
 *
 */
function wp_subscribes()
{
    _deprecated_function(__FUNCTION__, '4.0', 'wp_sms_subscribes()');
    wp_sms_subscribes();
}

/**
 * Show SMS newsletter form.
 *
 */
function wp_sms_subscribes()
{
    _deprecated_function(__FUNCTION__, '5.7');
}

/**
 * Get option value.
 *
 * @param $option_name
 * @param bool $pro
 * @param string $setting_name
 *
 * @return string
 */
function wp_sms_get_option($option_name, $pro = false, $setting_name = '')
{
    return Option::getOption($option_name, $pro, $setting_name);
}

/**
 * Send SMS.
 *
 * @param array $to
 * @param $msg $pro
 * @param bool $is_flash
 * @param array $mediaUrls
 *
 * @param bool $from
 *
 * @return string | WP_Error
 */
function wp_sms_send($to, $msg, $is_flash = false, $from = null, $mediaUrls = [])
{
    global $sms;

    $sms->isflash = $is_flash;
    $sms->to      = $to;
    $sms->msg     = $msg;
    $sms->media   = $mediaUrls;

    if ($from) {
        $sms->from = $from;
    }

    return $sms->SendSMS();
}

/**
 * Short URL generator
 *
 * @param string $longUrl
 * @return string
 */
if (!function_exists('wp_sms_shorturl')) {
    function wp_sms_shorturl($longUrl = '')
    {
        return apply_filters('wp_sms_shorturl', $longUrl);
    }
}

/**
 * @return void
 */
function wp_sms_render_mobile_field($args)
{
    $defaults = array(
        'type'        => 'text',
        'placeholder' => wp_sms_get_option('mobile_terms_field_place_holder'),
        'min'         => '',
        'max'         => '',
        'required'    => false,
        'id'          => 'wpsms-mobile',
        'value'       => '',
        'name'        => '',
        'class'       => array(),
        'attributes'  => array(),
    );

    $args = wp_parse_args($args, $defaults);

    if (wp_sms_get_option('international_mobile')) {
        $args['class'] = array_merge(['wp-sms-input-mobile'], $args['class']);
    } else {
        $args['min'] = wp_sms_get_option('mobile_terms_minimum');
        $args['max'] = wp_sms_get_option('mobile_terms_maximum');
    }

    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo sprintf(
        '<input id="%s" type="text" name="%s" placeholder="%s" class="%s" value="%s" required="%s" minlength="%s" maxlength="%s" %s/>',
        $args['id'],
        $args['name'],
        $args['placeholder'],
        implode(' ', $args['class']),
        esc_attr($args['value']),
        $args['required'],
        $args['min'],
        $args['max'],
        implode(' ', $args['attributes'])
    );
}

/**
 * @param $number
 * @param $group_id
 * @return string
 */
function wp_sms_render_quick_reply($number, $group_id = false)
{
    add_thickbox();
    wp_enqueue_script('wpsms-quick-reply');

    $numbers = explode(',', $number);
    $result  = '';

    if (count($numbers) > 1) {
        $i = 0;
        foreach ($numbers as $item) {
            if (++$i == count($numbers)) {
                $result .= sprintf('<a href="#TB_inline?&width=500&height=500&inlineId=wpsms-quick-reply" class="number thickbox js-replyModalToggle" name="Quick Reply" data-number="%1$s"><span class="dashicons dashicons-redo quick-reply-icon"></span> %1$s</a>', esc_html($item));
            } else {
                $result .= sprintf('<a href="#TB_inline?&width=500&height=500&inlineId=wpsms-quick-reply" class="number thickbox js-replyModalToggle" name="Quick Reply" data-number="%1$s"><span class="dashicons dashicons-redo quick-reply-icon"></span> %1$s</a>, ', esc_html($item));
            }
        }
    } else {
        $result = sprintf('<a href="#TB_inline?&width=500&height=500&inlineId=wpsms-quick-reply" class="number thickbox js-replyModalToggle" name="Quick Reply" data-number="%1$s" data-group-id="%2$s"><span class="dashicons dashicons-redo quick-reply-icon"></span> %1$s</a>', esc_html($number), $group_id);
    }

    return $result;
}