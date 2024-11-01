<?php
/*
 * Plugin Name: Twitter QR Code Signatures
 * Version: 1.4
 * Plugin URI: http://wordpress.org/extend/plugins/twitter-qr-code-signatures
 * Description: With twitHut.com's free Twitter QR Code Signatures Wordpress widget, you can now have a show-off of your Twitter latest tweet or Twitter URL in QR Code form. Visitors can use QR Scanner (i.e. in iPhone, Android phones) to scan directly your Twitter QR Code signature display on your Wordpress website and automatically they can browse it from their mobile phone. Most important thing of this plugin is to increase popularity to your online profile and increase your followers. 
 * Author: Sunento Agustiar Wu
 * Author URI: http://www.twithut.com
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
class TwitterQRCodeSignatures extends WP_Widget
{
	/**
	* Declares the TwitterQRCodeSignatures class.
	*
	*/
	function TwitterQRCodeSignatures(){
		$widget_ops = array('classname' => 'widget_TwitterQRCodeSignatures', 'description' => __( "With twitHut.com free Twitter QR Code Signatures Wordpress widget, you can now have a show-off of your Twitter latest tweet or Twitter URL in QR Code form. Visitors can use QR Scanner (i.e. in iPhone, Android phones) to scan directly your Twitter QR Code signature display on your Wordpress website and automatically they can browse it from their mobile phone. Most important thing of this plugin is to increase popularity to your online profile and increase your followers with TwitHut's Hall of Fame & Top Member Feature section."));
		$control_ops = array('width' => 300, 'height' => 300);
		$this->WP_Widget('TwitterQRCodeSignatures', __('Twitter QR Code Signatures Widget'), $widget_ops, $control_ops);
	}
	
	/**
	* Displays the Widget
	*
	*/
	function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Twitter QR Code Signatures' : $instance['title']);
		$twitterUserName = empty($instance['twitterUserName']) ? 'twithut' : $instance['twitterUserName'];
		$signatureStyle = empty($instance['signatureStyle']) ? '222' : $instance['signatureStyle'];
		$interstitial = empty($instance['interstitial']) ? 'no' : $instance['interstitial'];
		
		# Before the widget
		echo $before_widget;
		
		# The title
		if ( $title )
			echo $before_title . $title . $after_title;
		
		# Render the Widget
		if ($interstitial == 'yes') {
			echo '<a href="http://twithut.com/follow/' . $twitterUserName . '" title="Follow ' . $twitterUserName . ' - Scan with QR Scanner"><img src="http://twithut.com/twitsigs/' . $signatureStyle . '/' . $twitterUserName . '.png' .   '" border=0></a>';
		} else {
			echo '<a href="http://twitter.com/' . $twitterUserName . '" title="Follow ' . $twitterUserName . ' - Scan with QR Scanner"><img src="http://twithut.com/twitsigs/' . $signatureStyle . '/' . $twitterUserName . '.png' .   '" border=0></a>';
		}

		# After the widget
		echo $after_widget;
	}
	
	/**
	* Saves the widgets settings.
	*
	*/
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['twitterUserName'] = strip_tags(stripslashes($new_instance['twitterUserName']));
		$instance['signatureStyle'] = strip_tags(stripslashes($new_instance['signatureStyle']));
		$instance['interstitial'] = strip_tags(stripslashes($new_instance['interstitial']));
				
		return $instance;
	}
	
	/**
	* Creates the edit form for the widget.
	*
	*/
	function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'', 'twitterUserName'=>'twithut', 'interstitial'=>'no', 'signatureStyle'=>'70') );
		
		$title = htmlspecialchars($instance['title']);
		$twitterUserName = htmlspecialchars($instance['twitterUserName']);
		$signatureStyle = htmlspecialchars($instance['signatureStyle']);
		$interstitial = htmlspecialchars($instance['interstitial']);
			
		#Some intro for this widget
		echo '<p style="text-align:left;">Please visit <a href="http://www.twithut.com" target="_blank">our main website</a> and login once using Twitter OAuth before you start using this plugin. (You need to follow Step 1 and Step 2 and you do not have to register to start using it.)</p><hr/>';
		# Output the options
		echo '<p style="text-align:right;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input style="width: 250px;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';
		# Fill TwitterQRCodeSignatures ID
		echo '<p style="text-align:right;"><label for="' . $this->get_field_name('twitterUserName') . '">' . __('Twitter Username:') . ' <input style="width: 100px;" id="' . $this->get_field_id('twitterUserName') . '" name="' . $this->get_field_name('twitterUserName') . '" type="text" value="' . $twitterUserName . '" /></label></p>';
		
		# Fill Twitter QR Code Signatures Style Selection
		echo '<p style="text-align:right;"><label for="' . $this->get_field_name('signatureStyle') . '">' . __('Signature Style:') . ' <select name="' . $this->get_field_name('signatureStyle')  . '" id="' . $this->get_field_id('signatureStyle')  . '">"';
?>
		<option value="222" <?php if ($signatureStyle == '222') echo 'selected="yes"'; ?> >Twitter URL (Free)</option>
		<option value="221" <?php if ($signatureStyle == '221') echo 'selected="yes"'; ?> >Latest Twit (Premium)</option>
<?php
		echo '</select></label>';
		# Interstitial Feature : option to select YEs or No 
		echo '<p style="text-align:right;"><label for="' . $this->get_field_name('interstitial') . '">' . __('Turn On Interstitial Feature (Premium Member)') . ' <select name="' . $this->get_field_name('interstitial')  . '" id="' . $this->get_field_id('interstitial')  . '">"';
?>
		<option value="no" <?php if ($interstitial == 'no') echo 'selected="yes"'; ?> >No</option>
		<option value="yes" <?php if ($interstitial == 'yes') echo 'selected="yes"'; ?> >Yes</option>			 
<?php
		echo '</select></label>';
		echo '<p style="text-align:right;">Questions, more features you can visit : <a target="_blank" href="http://www.twithut.com">TwitHut.com</a></p>';
			
	}

}// END class
	
	/**
	* Register  widget.
	*
	* Calls 'widgets_init' action after widget has been registered.
	*/
	function TwitterQRCodeSignaturesInit() {
	register_widget('TwitterQRCodeSignatures');
	}	
	add_action('widgets_init', 'TwitterQRCodeSignaturesInit');
?>