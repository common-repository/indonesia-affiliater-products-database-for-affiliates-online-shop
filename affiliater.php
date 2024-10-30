<?php

/*
Plugin URI: http://affiliater.serverforceone.com/affiliater
Plugin Name: Affiliater
Description: Indonesia Affiliater, Products Database for Affiliates Online Shop. Display Products from Online Shop Database and display them with your affiliate ID. For affiliates, this plugin with replace the products link to your affiliates link.
Version: 3.1
Date: August 30,2017
Author: Daniel Fernando

Copyright 2017 DANIEL FERNANDO (email : danif98@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

ini_set('display_errors', 'Off');
error_reporting(0);

function affiliater_truncate($string, $limit, $break=".", $pad="") { 
    if(strlen($string) <= $limit) return $string;
    if (false !== ($breakpoint = strpos($string, $break, $limit))) {
      if($breakpoint < strlen($string) - 1) {
	    $string = substr($string, 0, $breakpoint) . $pad;
	  }
    }
    return $string;
}

function affiliater_strreplaceassoc(array $replace, $subject) { 
   return str_replace(array_keys($replace), array_values($replace), $subject);    
} 

function affiliater_shortcode( $atts ) {
	extract(shortcode_atts(array('filtertype' => 'category', 'filter' => 'exact', 'sort' => 'random', 'category' => 'none','description' => 'yes','column' => '2','maxitem' => '4', 'title' => ''), $atts));
	add_option( 'affiliater_pricecol', '' );  
	add_option( 'affiliater_bhinneka_affiliatecode', '' ); 
	add_option( 'affiliater_bhinneka_affiliateref', '' ); 
	add_option( 'affiliater_lazada_affiliatecode', '' ); 
	add_option( 'affiliater_lazada_affiliatename', '' ); 	
	add_option( 'affiliater_zalora_affiliatecode', '' ); 
	add_option( 'affiliater_zalora_affiliatename', '' ); 	
	add_option( 'affiliater_blibli_affiliatecode', '' ); 
	add_option( 'affiliater_blibli_affiliatename', '' ); 	
	add_option( 'affiliater_agoda_affiliatecode', '' ); 
	add_option( 'affiliater_belbuk_affiliatecode', '' ); 
	add_option( 'affiliater_orami_affiliateid', '' ); 
	add_option( 'affiliater_orami_affiliatesecret', '' ); 
	add_option( 'affiliater_pegipegi_affiliatecode', '' ); 
	
	$pricecol = get_option('affiliater_pricecol');
	$affiliater_bhinneka_affiliatecode = get_option('affiliater_bhinneka_affiliatecode');
	$affiliater_bhinneka_affiliateref = get_option('affiliater_bhinneka_affiliateref');
	$affiliater_lazada_affiliatecode = get_option('affiliater_lazada_affiliatecode');
	$affiliater_lazada_affiliatename = get_option('affiliater_lazada_affiliatename');	
	$affiliater_zalora_affiliatecode = get_option('affiliater_zalora_affiliatecode');
	$affiliater_zalora_affiliatename = get_option('affiliater_zalora_affiliatename');
	$affiliater_blibli_affiliatecode = get_option('affiliater_blibli_affiliatecode');
	$affiliater_blibli_affiliatename = get_option('affiliater_blibli_affiliatename');	
	$affiliater_agoda_affiliatecode = get_option('affiliater_agoda_affiliatecode');
	$affiliater_belbuk_affiliatecode = get_option('affiliater_belbuk_affiliatecode');
	$affiliater_orami_affiliateid = get_option('affiliater_orami_affiliateid');
	$affiliater_orami_affiliatesecret = get_option('affiliater_orami_affiliatesecret');
	$affiliater_pegipegi_affiliatecode = get_option('affiliater_pegipegi_affiliatecode');
	
	if ($pricecol == "") {$pricecol = "FF0000";}
	else {$pricecol = $pricecol;}
	
	$time = gmdate("Y-m-d\TH:i:s\Z");
	
	$uri = "category=".$atts['category'];
	$uri .= "&column=$column";
	$uri .= "&filtertype=$filtertype";
	$uri .= "&filter=$filter";
	$uri .= "&sort=$sort";
	$uri .= "&pricecol=$pricecol";
	$uri .= "&ip=".$_SERVER['REMOTE_ADDR'];
	$uri .= "&website=".$_SERVER['SERVER_NAME'];
	$uri .= "&full_website=".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$uri .= "&affiliater_bhinneka_affiliatecode=$affiliater_bhinneka_affiliatecode";
	$uri .= "&affiliater_bhinneka_affiliateref=$affiliater_bhinneka_affiliateref";
	$uri .= "&affiliater_lazada_affiliatecode=$affiliater_lazada_affiliatecode";
	$uri .= "&affiliater_lazada_affiliatename=$affiliater_lazada_affiliatename";
	$uri .= "&affiliater_zalora_affiliatecode=$affiliater_zalora_affiliatecode";
	$uri .= "&affiliater_zalora_affiliatename=$affiliater_zalora_affiliatename";
	$uri .= "&affiliater_blibli_affiliatecode=$affiliater_blibli_affiliatecode";
	$uri .= "&affiliater_blibli_affiliatename=$affiliater_blibli_affiliatename";
	$uri .= "&affiliater_agoda_affiliatecode=$affiliater_agoda_affiliatecode";
	$uri .= "&affiliater_belbuk_affiliatecode=$affiliater_belbuk_affiliatecode";
	$uri .= "&affiliater_orami_affiliateid=$affiliater_orami_affiliateid";
	$uri .= "&affiliater_orami_affiliatesecret=$affiliater_orami_affiliatesecret";
	$uri .= "&affiliater_pegipegi_affiliatecode=$affiliater_pegipegi_affiliatecode";
	$uri .= "&description=$description";
	$uri .= "&maxitem=$maxitem";
	$uri = str_replace(' ','%20', $uri);
	$uri = str_replace(',','%2C', $uri);
	$uri = str_replace(':','%3A', $uri);
	$uri = str_replace('*','%2A', $uri);
	$uri = str_replace('~','%7E', $uri);
	$uri = str_replace('+','%20', $uri);
	$sign = explode('&',$uri);
	
	$host = implode("&", $sign);
	//print_r($atts['category']); exit;
	//echo $atts['category'];
	$affiliater_gator = "http://affiliater.serverforceone.com/affiliater_gator.php?".$host.'&_wpnonce='.wp_create_nonce( 'my-nonce' );
		
	$host = "GET\naffiliater.serverforceone.com/affiliater_gator.php?".$host;
	$signed = urlencode(base64_encode(hash_hmac("sha256", $host, 'secret', True)));
	$uri .= "&Signature=$signed";
	
	$request = new WP_Http;
	$html = $request->request($affiliater_gator);	
	$html1 = $html['body'];		
	$pxml = simplexml_load_string($html1); 
	
	$breaklist=0;	

	$content = "";
	$content .= "<h2>".($title==''?$category:$title)."</h2>";
	foreach($pxml as $item) {
		$replace = array( 
		  '[id]' => $item->id, 
		  '[sku]' => $item->sku, 
		  '[title]' => $item->title,
		  '[link]' => $item->affiliate_url_text,
		  '[thumbnail]' => $item->thumbnail,
		  '[img]' => $item->thumbnail,
		  '[pricecol]' => $pricecol,
		  '[item_description]' => ($item->product_description==''?'':substr($item->product_description,0,150) . "..."),
		  '[price]' => $item->product_price,
		  '[product_price_ppn]' => $item->product_price_ppn,
		  '[manufacture_url]' => $item->manufacture_url,
		  '[avab]' => '',
		  '[seed]' => ''	     
		  );
		  
			
		//if ($item_description == "") {$item_description = "";} else { $item_description = $item_description . "...";}
		
		$avab = affiliater_truncate($avab, 69, " ");
		
		$content_1column_with_description = 
			'<div style="width:100%;display:inline-block;">
			<div style="float:left;width:15%;overflow:auto;">
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;"><img src="[img]" style="margin:0;padding:0;float:left;border:none;width:100%;" /></div>
			<div style="float:left;margin:0px 0 10px 10;width:75%;">
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;" target="_new">[title]</a><br>
			<span style="color: #[pricecol];font-size:11px;text-decoration:none;font-weight:500;">[price]</span> 
			<!--<strike style="color:#444;"><span style="font-size:11px;text-decoration:none;font-weight:500;">[lprice]</span></strike>--><br>
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;"><span style="font-size:10px;text-decoration:none;font-weight:500;">[item_description]</span>
			<div style="font-size:12px;clear:both;">[avab]</div><a href="[$link]" rel="nofollow" style="text-decoration:none;font-weight:600;">[seed]</a></div></div>';
	
		$content_1column_without_description = 
			'<div style="width:100%;display:inline-block;" >
			<div style="float:left;width:15%;overflow:auto;">
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;"><img src="[img]" style="margin:0;padding:0;float:left;border:none;width:100%;" /></div>
			<div style="float:left;margin:0px 0 10px 0;width:75%;">
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;" target="_new">[title]</a><br>
			<span style="color: #[pricecol];font-size:11px;text-decoration:none;font-weight:500;">[price]</span> 
			<!--<strike style="color:#444;"><span style="font-size:11px;text-decoration:none;font-weight:500;">[lprice]</span></strike>-->
			<div style="font-size:12px;clear:both;">[avab]</div><a href="[link]" rel="nofollow" style="text-decoration:none;font-weight:600;">[seed]</a></div></div>';
		
		$content_2column_with_description = 
			'<div style="margin-bottom:20px;float:right;width:48%;margin-right:2%;">
			<div style="width:100%;overflow:auto;" >
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;"><img src="[img]" style="margin:0;padding:0;float:left;border:none;width:100%;" /></div>
			<div style="float:left;margin:0px 0 10px 10; padding:5px; width:75%;">
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;">[title]</a><br>
			<span style="color: #[pricecol];font-size:11px;text-decoration:none;font-weight:500;">[price]</span>  
			<!--<strike style="color:#444;"><span style="font-size:11px;text-decoration:none;font-weight:500;">[lprice]</span></strike>--><br></div>
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;"><span style="font-size:10px;text-decoration:none;font-weight:500;">[item_description]</span>
			<div style="font-size:12px;clear:both;">[avab]</div><a href="[$link]" rel="nofollow" style="text-decoration:none;font-weight:600;">[seed]</a></div>';
	
		$content_2column_without_description = 
			'<div style="margin-bottom:20px;float:right;width:48%;margin-right:2%;">
			<div style="width:100%;overflow:auto;" >
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;"><img src="[img]" style="margin:0;padding:0;float:left;border:none;width:100%;" /></div>
			<div style="float:left;margin:0px 0 10px 10; padding:5px; width:75%;">
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;">[title]</a><br>
			<span style="color: #[pricecol];font-size:11px;text-decoration:none;font-weight:500;">[price]</span>  
			<!--<strike style="color:#444;"><span style="font-size:11px;text-decoration:none;font-weight:500;">[lprice]</span></strike>--><br></div>
			<div style="font-size:12px;clear:both;">[avab]</div><a href="[$link]" rel="nofollow" style="text-decoration:none;font-weight:600;">[seed]</a></div>';
			
		$content_3column_with_description = 
			'<div style="margin-bottom:20px;float:right;width:29%;margin-right:1%;">
			<div style="width:100%;overflow:auto;" >
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;"><img src="[img]" style="margin:0;padding:0;float:left;border:none;width:100%;" /></div>
			<div style="float:left;margin:0px 0 10px 10; padding:5px; width:75%;">
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;">[title]</a><br>
			<span style="color: #[pricecol];font-size:11px;text-decoration:none;font-weight:500;">[price]</span>  
			<!--<strike style="color:#444;"><span style="font-size:11px;text-decoration:none;font-weight:500;">[lprice]</span></strike>--><br></div>
			<div style="clear:both;"><a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;"><span style="font-size:10px;text-decoration:none;font-weight:500;">[item_description]</span></div>
			<div style="font-size:12px;clear:both;">[avab]</div><a href="[$link]" rel="nofollow" style="text-decoration:none;font-weight:600;">[seed]</a></div>';
	
		$content_3column_without_description = 
			'<div style="margin-bottom:20px;float:right;width:29%;margin-right:1%;">
			<div style="width:100%;overflow:auto;" >
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;"><img src="[img]" style="margin:0;padding:0;float:left;border:none;width:100%;" /></div>
			<div style="float:left;margin:0px 0 10px 10; padding:5px; width:75%;">
			<a href="[link]" rel="nofollow" style="font-size:12px;text-decoration:none;font-weight:600;float:left;">[title]</a><br>
			<span style="color: #[pricecol];font-size:11px;text-decoration:none;font-weight:500;">[price]</span>  
			<!--<strike style="color:#444;"><span style="font-size:11px;text-decoration:none;font-weight:500;">[lprice]</span></strike>--><br></div>
			<div style="font-size:12px;clear:both;">[avab]</div><a href="[$link]" rel="nofollow" style="text-decoration:none;font-weight:600;">[seed]</a></div>';
			
		if ($column == "1") {
			if ($description == "yes") { $content .= affiliater_strreplaceassoc($replace,$content_1column_with_description); }
			else { $content .= affiliater_strreplaceassoc($replace,$content_1column_without_description); }
		}
		if ($column == "2") {
			if ($description == "yes") {
				$content .= affiliater_strreplaceassoc($replace,$content_2column_with_description);	
			}
			else {
				$content .= affiliater_strreplaceassoc($replace,$content_2column_without_description);
			}
			$i++;
			if(($i % 2)==0){$content .= '<div style="clear:both"></div>';}
		}
		if ($column == "3") {
			if ($description == "yes") {
				$content .= affiliater_strreplaceassoc($replace,$content_3column_with_description);	
			}
			else {
				$content .= affiliater_strreplaceassoc($replace,$content_3column_without_description);
			}
			$i++;
			if(($i % 3)==0){$content .= '<div style="clear:both"><hr></div>';}
		}
	}
	return $content;
}



function add_affiliater_panel() {
	if (function_exists('add_options_page')) {
		add_options_page('Affiliater', 'Affiliater', 8, 'Affiliater', 'affiliater_admin_panel');
	}
}

function affiliater_admin_panel() { 
	if ($_POST["affiliater_\165pda\x74e\144"]){
		update_option('affiliater_pricecol',sanitize_text_field($_POST['affiliater_pricecol']));
		update_option('affiliater_bhinneka_affiliatecode',sanitize_text_field($_POST['affiliater_bhinneka_affiliatecode']));
		update_option('affiliater_bhinneka_affiliateref',sanitize_text_field($_POST['affiliater_bhinneka_affiliateref']));
		update_option('affiliater_lazada_affiliatecode',sanitize_text_field($_POST['affiliater_lazada_affiliatecode']));
		update_option('affiliater_lazada_affiliatename',sanitize_text_field($_POST['affiliater_lazada_affiliatename']));		
		update_option('affiliater_zalora_affiliatecode',sanitize_text_field($_POST['affiliater_zalora_affiliatecode']));
		update_option('affiliater_zalora_affiliatename',sanitize_text_field($_POST['affiliater_zalora_affiliatename']));
		update_option('affiliater_blibli_affiliatecode',sanitize_text_field($_POST['affiliater_blibli_affiliatecode']));
		update_option('affiliater_blibli_affiliatename',sanitize_text_field($_POST['affiliater_blibli_affiliatename']));		
		update_option('affiliater_agoda_affiliatecode',sanitize_text_field($_POST['affiliater_agoda_affiliatecode']));
		update_option('affiliater_belbuk_affiliatecode',sanitize_text_field($_POST['affiliater_belbuk_affiliatecode']));
		update_option('affiliater_orami_affiliateid',sanitize_text_field($_POST['affiliater_orami_affiliateid']));
		update_option('affiliater_orami_affiliatesecret',sanitize_text_field($_POST['affiliater_orami_affiliatesecret']));
		update_option('affiliater_pegipegi_affiliatecode',sanitize_text_field($_POST['affiliater_pegipegi_affiliatecode']));

		echo '<div id="message" style="padding:2px 2px 2px 4px; font-size:12px;" class="updated"><strong>affiliater settings updated</strong></div>';}?>
	<table><tr valign="top"><td>
        
        <h3 style="color:#0066cc;">Indonesia Affiliater Options</h3>	
        <form method="post" id="cj_options">
        <table cellspacing="10" cellpadding="5" > 
        	<tr valign="top">
                <td colspan="2"><strong>This is a free plugin, no limit on usage, product queries, number of domain, etc. 80% of affiliate impression will
				come from your code, but 20% chances will attributed to plugin developer :)</strong></td>
            </tr>    
            <tr valign="top">
                <td><strong>Price Color</strong></td>
                <td><input type="text" name="affiliater_pricecol" id="affiliater_pricecol" value="<?php echo get_option('affiliater_pricecol');?>" maxlength="7" style="width:100px;" />
                <p>Enter color code (6 characters). For example <strong>FFA500</strong> for orange or <strong>000000</strong> for black. You can find all the color codes <a href="http://quackit.com/html/html_color_codes.cfm" target="_blank">here</a> . *If left blank will be automaticaly set to red</br></td>
            </tr>  
            <tr valign="top">
                <td><strong>Bhinneka Affiliate code</strong></td>
                <td><input type="text" name="affiliater_bhinneka_affiliatecode" id="affiliater_bhinneka_affiliatecode" value="<?php echo get_option('affiliater_bhinneka_affiliatecode');?>" maxlength="40" style="width:300px;" />
                <p>Enter Bhinneka Affiliate code. You must register yourself <a href="http://www.bhinneka.com/Associate/Associate.aspx">here</a>.
                </td>
            </tr>      
			<tr valign="top">
                <td><strong>Bhinneka Affiliate Ref code</strong></td>
                <td><input type="text" name="affiliater_bhinneka_affiliateref" id="affiliater_bhinneka_affiliateref" value="<?php echo get_option('affiliater_bhinneka_affiliateref');?>" maxlength="40" style="width:300px;" />
                <p>Enter Bhinneka Affiliate Ref code. You must register yourself <a href="http://www.bhinneka.com/Associate/Associate.aspx">here</a>.
                </td>
            </tr>      
			<tr valign="top">
                <td><strong>Lazada Affiliate ID</strong></td>
                <td><input type="text" name="affiliater_lazada_affiliatecode" id="affiliater_lazada_affiliatecode" value="<?php echo get_option('affiliater_lazada_affiliatecode');?>" maxlength="40" style="width:300px;" />
                <p>Enter Lazada Affiliate ID. You must register yourself <a href="http://www.lazada.co.id/lazada-affiliate-program/signup/">here</a>.
                </td>
            </tr>  
			<tr valign="top">
                <td><strong>Lazada Affiliate name</strong></td>
                <td><input type="text" name="affiliater_lazada_affiliatename" id="affiliater_lazada_affiliatename" value="<?php echo get_option('affiliater_lazada_affiliatename');?>" maxlength="40" style="width:300px;" />
                <p>Enter Lazada Affiliate name. You must register yourself <a href="http://www.lazada.co.id/lazada-affiliate-program/signup/">here</a>.
                </td>
            </tr>  	
			
			<tr valign="top">
                <td><strong>Zalora Affiliate ID</strong></td>
                <td><input type="text" name="affiliater_zalora_affiliatecode" id="affiliater_zalora_affiliatecode" value="<?php echo get_option('affiliater_zalora_affiliatecode');?>" maxlength="40" style="width:300px;" />
                <p>Enter Zalora Affiliate ID. You must register yourself <a href="https://signup.performancehorizon.com/signup/en/zaloraasia">here</a>.
                </td>
            </tr>  
			<tr valign="top">
                <td><strong>Zalora Affiliate name (BAP)</strong></td>
                <td><input type="text" name="affiliater_zalora_affiliatename" id="affiliater_zalora_affiliatename" value="<?php echo get_option('affiliater_zalora_affiliatename');?>" maxlength="40" style="width:300px;" />
                <p>Enter Zalora Affiliate name. You must register yourself <a href="https://www.zalora.co.id/brand-ambassador-program/">here</a>.
                </td>
            </tr>  				
			<tr valign="top">
                <td><strong>Blibli Affiliate ID</strong></td>
                <td><input type="text" name="affiliater_blibli_affiliatecode" id="affiliater_blibli_affiliatecode" value="<?php echo get_option('affiliater_blibli_affiliatecode');?>" maxlength="40" style="width:300px;" />
                <p>Enter Blibli Affiliate ID. You must register yourself <a href="http://affiliateblibli.hasoffers.com/signup">here</a>.
                </td>
            </tr>  
			<tr valign="top">
                <td><strong>Blibli Affiliate name</strong></td>
                <td><input type="text" name="affiliater_blibli_affiliatename" id="affiliater_blibli_affiliatename" value="<?php echo get_option('affiliater_blibli_affiliatename');?>" maxlength="40" style="width:300px;" />
                <p>Enter Blibli Affiliate name. You must register yourself <a href="http://affiliateblibli.hasoffers.com/signup">here</a>.
                </td>
            </tr>  							
			<tr valign="top">
                <td><strong>Agoda Affiliate code</strong></td>
                <td><input type="text" name="affiliater_agoda_affiliatecode" id="affiliater_agoda_affiliatecode" value="<?php echo get_option('affiliater_agoda_affiliatecode');?>" maxlength="40" style="width:300px;" />
                <p>Enter Agoda Affiliate code. You must register yourself <a href="https://partners.agoda.com/register.html">here</a>.
                </td>
            </tr>   
			<tr valign="top">
                <td><strong>Belbuk Affiliate code</strong></td>
                <td><input type="text" name="affiliater_belbuk_affiliatecode" id="affiliater_belbuk_affiliatecode" value="<?php echo get_option('affiliater_belbuk_affiliatecode');?>" maxlength="40" style="width:300px;" />
                <p>Enter Belbuk Affiliate code. You must register yourself <a href="http://www.belbuk.com/afiliasi/pendaftaran.php">here</a>.
                </td>
            </tr>     	
			<tr valign="top">
                <td><strong>Orami Affiliate ID</strong></td>
                <td><input type="text" name="affiliater_orami_affiliateid" id="affiliater_orami_affiliateid" value="<?php echo get_option('affiliater_orami_affiliateid');?>" maxlength="40" style="width:300px;" />
                <p>Enter Orami Affiliate ID. You must register yourself <a href="https://www.orami.co.id/affiliate-program">here</a>.
                </td>
            </tr>  
			<tr valign="top">
                <td><strong>Orami Affiliate Secret</strong></td>
                <td><input type="text" name="affiliater_orami_affiliatesecret" id="affiliater_orami_affiliatesecret" value="<?php echo get_option('affiliater_orami_affiliatesecret');?>" maxlength="40" style="width:300px;" />
                <p>Enter Orami Affiliate Secret. You must register yourself <a href="https://www.orami.co.id/affiliate-program">here</a>.
                </td>
            </tr>  	
			<tr valign="top">
                <td><strong>Pegipegi Affiliate ID</strong></td>
                <td><input type="text" name="affiliater_pegipegi_affiliatecode" id="affiliater_pegipegi_affiliatecode" value="<?php echo get_option('affiliater_pegipegi_affiliatecode');?>" maxlength="40" style="width:300px;" />
                <p>Enter Pegipegi Affiliate ID. You must register yourself <a href="http://affiliate.pegipegi.com/index.php/registrasi">here</a>.
                </td>
            </tr>  
        </table>
        <p class="submit"><input type="submit" name="affiliater_updated" value="Update Settings &raquo;" /></p>
        </p>
        </form>
		
			<h3 style="color:#0066cc;">Please Read - How to use affiliater</h3>
			<strong>Category</strong>
        Select from <a href="http://affiliater.serverforceone.com/categories.html">this list</a> and put it in the shortcode
			<p style="margin:30px 0 0 0;">Code format: <strong>[affiliater filtertype='category' filter='exact' sort='latest' category='Micro Secure Digital / Micro SD Card' description='yes' column='2' maxitem='4' title='My Products']</strong></p>
			<ul style="list-style:square;padding: 0 0 10px 30px;">
			<li><strong>filtertype</strong> = Choose which elemen should be used as filter</li>
				<ul>
					<li>category = (default) Filter keyword based on category</li>
					<li>product = Filter keyword based on product name</li>
					<li>brand = Filter keyword based on brand</li>
				</ul>
			</li>
			<li><strong>filter</strong> = products will be filtered out by</li>
				<ul>
					<li>exact = (default) product name or categories filter by exactly typed keyword in categories or product field</li>
					<li>contain = product name or categories contains keyword in categories or product field</li>
				</ul>
			</li>
			<li><strong>sort</strong> = products will be sorted by
				<ul>
					<li>latest = order by latest update product data</li>
					<li>random = (default) no specific order, just display randomly</li>
				</ul>
			</li>
			<li><strong>category</strong> = products you would like to display. Please do not use special characters, like &, @ etc.</li>
			<li><strong>description</strong>
				<ul>
					<li>yes = (default) show description</li>
					<li>no = no description will be shown</li>
				</ul>
			</li>		
			<li><strong>column</strong> = products will be splitted to 1 to 3 columns.</li>
			<li><strong>maxitem</strong> = Maximum Item to be displayed per category</li>
			<li><strong>title</strong> = Title for this group of affiliater plugin.</li>
			<p><span style="font-weight:600;">Note</span> - In order the code to work properly you must set the values for the <strong>category</strong>. The other are optional.
			</ul>
			<p style="margin:30px 0 30px 0;font-size:15px;"><strong>For feature requests and more help <a href="http://wordpress.org/extend/plugins/affiliater/" target="_blank">visit plugin site</a></strong></p>
		
	</td></tr></table> 

<?php
}

add_shortcode('affiliater', 'affiliater_shortcode');
add_action('admin_menu', 'add_affiliater_panel'); ?>