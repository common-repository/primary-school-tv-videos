<?php
/*
Plugin Name: Primary School TV and Video clips
Plugin URI: http://mclear.co.uk
Description: Displays the latest videos from Primary School TV on your blog
Author: John McLear
Version: 0.1
Author URI: http://mclear.co.uk

	My Widget is released under the GNU General Public License (GPL)
	http://www.gnu.org/licenses/gpl.txt

	This is a WordPress plugin (http://wordpress.org) and widget
	(http://automattic.com/code/widgets/).
*/

// We're putting the plugin's functions in one big function we then
// call at 'plugins_loaded' (add_action() at bottom) to ensure the
// required Sidebar Widget functions are available.
function widget_ptvwidget_init() {

	// Check to see required Widget API functions are defined...
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return; // ...and if not, exit gracefully from the script.

	// This function prints the sidebar widget--the cool stuff!
	function widget_ptvwidget($args) {

		// $args is an array of strings which help your widget
		// conform to the active theme: before_widget, before_title,
		// after_widget, and after_title are the array keys.
		extract($args);

		// Collect our widget's options, or define their defaults.
		$options = get_option('widget_ptvwidget');
		$title = empty($options['title']) ? 'Videos' : $options['title'];
$color = empty($options['text']) ? '#ffffff' : $options['text'];
//$color = $options['text'];

		$text = '<div><center><iframe frameborder=0 src="http://primaryschool.tv/last3.php?font=black&bg=' . $color . '" 
		width="190" height="715"></iframe></center></div>';
 		// It's important to use the $before_widget, $before_title,
 		// $after_title and $after_widget variables in your output.
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo $text;
		echo $after_widget;
	}

	// This is the function that outputs the form to let users edit
	// the widget's title and so on. It's an optional feature, but
	// we'll use it because we can!
	function widget_ptvwidget_control() {

		// Collect our widget's options.
		$options = get_option('widget_ptvwidget');

		// This is for handing the control form submission.
		if ( $_POST['ptvwidget-submit'] ) {
			// Clean up control form submission options
			$newoptions['title'] = strip_tags(stripslashes($_POST['ptvwidget-title']));
			$newoptions['text'] = strip_tags(stripslashes($_POST['ptvwidget-text']));
		}

		// If original widget options do not match control form
		// submission options, update them.
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_ptvwidget', $options);
		}

		// Format options as valid HTML. Hey, why not.
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$text = htmlspecialchars($options['text'], ENT_QUOTES);

// The HTML below is the control form for editing options.
?>
		<div>
		<label for="ptvwidget-title" style="line-height:35px;display:block;">Widget title: <input type="text" id="ptvwidget-title" name="ptvwidget-title" value="<?php echo $title; ?>" /></label>
		<label for="ptvwidget-text" style="line-height:35px;display:block;">Background colour: <input type="text" id="ptvwidget-text" 
		name="ptvwidget-text" value="<?php echo $text; ?>" /></label>
		<input type="hidden" name="ptvwidget-submit" id="ptvwidget-submit" value="1" />
		</div>
	<?php
	// end of widget_ptvwidget_control()
	}

	// This registers the widget. About time.
	register_sidebar_widget('Primary School TV Videos', 'widget_ptvwidget');

	// This registers the (optional!) widget control form.
	register_widget_control('Primary School TV Videos', 'widget_ptvwidget_control');
}

// Delays plugin execution until Dynamic Sidebar has loaded first.
add_action('plugins_loaded', 'widget_ptvwidget_init');
?>
