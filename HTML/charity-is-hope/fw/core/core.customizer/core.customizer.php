<?php
/**
 * Theme colors and fonts customization
 */


// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'charity_is_hope_core_customizer_theme_setup' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_core_customizer_theme_setup', 1 );
	function charity_is_hope_core_customizer_theme_setup() {

		// Load Color schemes then Theme Options are loaded
		add_action('charity_is_hope_action_load_main_options',					'charity_is_hope_core_customizer_load_options');

		// Recompile LESS and save CSS
		add_action('charity_is_hope_action_compile_less',						'charity_is_hope_core_customizer_compile_less');
		add_filter('charity_is_hope_filter_prepare_less',						'charity_is_hope_core_customizer_prepare_less');

		if ( is_admin() ) {
	
			// Ajax Save and Export Action handler
			add_action('wp_ajax_charity_is_hope_options_save', 				'charity_is_hope_core_customizer_save_options');
	
			// Ajax Delete color scheme Action handler
			add_action('wp_ajax_charity_is_hope_options_scheme_delete', 		'charity_is_hope_core_customizer_scheme_delete');

			// Ajax Copy color scheme Action handler
			add_action('wp_ajax_charity_is_hope_options_scheme_copy', 			'charity_is_hope_core_customizer_scheme_copy');
		}
		
	}
}

if ( !function_exists( 'charity_is_hope_core_customizer_theme_setup2' ) ) {
	add_action( 'charity_is_hope_action_before_init_theme', 'charity_is_hope_core_customizer_theme_setup2', 11 );
	function charity_is_hope_core_customizer_theme_setup2() {

		if ( is_admin() ) {

			// Add Theme Options in WP menu
			add_action('admin_menu', 								'charity_is_hope_core_customizer_admin_menu_item');
		}
		
	}
}

// Add 'Color Schemes' in the menu 'Theme Options'
if ( !function_exists( 'charity_is_hope_core_customizer_admin_menu_item' ) ) {
	//Handler of add_action('admin_menu', 'charity_is_hope_core_customizer_admin_menu_item');
	function charity_is_hope_core_customizer_admin_menu_item() {
		charity_is_hope_admin_add_menu_item('theme', array(
			'page_title' => esc_html__('Fonts & Colors', 'charity-is-hope'),
			'menu_title' => esc_html__('Fonts & Colors', 'charity-is-hope'),
			'capability' => 'manage_options',
			'menu_slug'  => 'charity_is_hope_options_customizer',
			'callback'   => 'charity_is_hope_core_customizer_page',
			'icon'		 => ''
			)
		);
	}
}


// Step 1: Load Font settings and Color schemes when Theme Options are loaded
if ( !function_exists( 'charity_is_hope_core_customizer_load_options' ) ) {
	//Handler of add_action( 'charity_is_hope_action_load_main_options', 'charity_is_hope_core_customizer_load_options' );
	function charity_is_hope_core_customizer_load_options() {
		$mode = isset($_POST['mode']) ? $_POST['mode'] : '';
		$override = isset($_POST['override']) ? $_POST['override'] : '';
		if ($mode!='reset' || $override!='customizer') {
			$storage = get_option( charity_is_hope_storage_get('options_prefix') . '_options_custom_colors' );
			if (!empty($storage)) charity_is_hope_storage_set('custom_colors', $storage);
			$storage = get_option( charity_is_hope_storage_get('options_prefix') . '_options_custom_fonts' );
			if (!empty($storage)) charity_is_hope_storage_set('custom_fonts', $storage);
		}
	}
}


// Ajax Save and Export Action handler
if ( !function_exists( 'charity_is_hope_core_customizer_save_options' ) ) {
	//Handler of add_action('wp_ajax_charity_is_hope_options_save', 'charity_is_hope_core_customizer_save_options');
	//Handler of add_action('wp_ajax_nopriv_charity_is_hope_options_save', 'charity_is_hope_core_customizer_save_options');
	function charity_is_hope_core_customizer_save_options() {

		$mode = $_POST['mode'];
		$override = empty($_POST['override']) ? '' : $_POST['override'];

		if (!in_array($mode, array('save', 'reset')) || !in_array($override, array('customizer')))
			return;

		if ( !wp_verify_nonce( charity_is_hope_get_value_gp('nonce'), admin_url('admin-ajax.php') ) || !current_user_can('manage_options'))
			wp_die();

		parse_str($_POST['data'], $data);

		// Refresh array with schemes from POST data
		$colors = charity_is_hope_storage_get('custom_colors');
		if ($mode == 'save') {
			if (is_array($colors) && count($colors) > 0) {
				$order = !empty($data['charity_is_hope_options_schemes_order']) ? explode(',', $data['charity_is_hope_options_schemes_order']) : array_keys($colors);
				$schemes = array();
				foreach ($order as $slug) {
					$new_slug = $data[$slug.'-slug'];
					if (empty($new_slug)) $new_slug = charity_is_hope_get_slug($scheme['title']);
					if (is_array($colors[$slug]) && count($colors[$slug]) > 0) {
						$schemes[$new_slug] = array();
						foreach ($colors[$slug] as $key=>$value) {
							$schemes[$new_slug][$key] = isset($data[$slug.'-'.$key]) ? $data[$slug.'-'.$key] : $value;
						}
					}
				}
				$colors = apply_filters('charity_is_hope_filter_save_custom_colors', $schemes);
				charity_is_hope_storage_set('custom_colors', $colors);
				update_option( charity_is_hope_storage_get('options_prefix') . '_options_custom_colors', $colors);
			}
		} else if ($mode == 'reset') {
			delete_option( charity_is_hope_storage_get('options_prefix') . '_options_custom_colors');
		}

		// Refresh array with fonts from POST data
		$fonts = charity_is_hope_storage_get('custom_fonts');
		if ($mode == 'save') {
			if (is_array($fonts) && count($fonts) > 0) {
				foreach ($fonts as $slug=>$font) {
					if (is_array($font) && count($font) > 0) {
						foreach ($font as $key=>$value) {
							if (isset($data[$slug.'-'.$key]))
								$fonts[$slug][$key] = charity_is_hope_is_inherit_option($data[$slug.'-'.$key]) ? '' : $data[$slug.'-'.$key];
						}
					}
				}
				$fonts = apply_filters('charity_is_hope_filter_save_custom_fonts', $fonts);
				charity_is_hope_storage_set('custom_fonts', $fonts);
				update_option( charity_is_hope_storage_get('options_prefix') . '_options_custom_fonts', $fonts);
			}
		} else if ($mode == 'reset') {
			delete_option( charity_is_hope_storage_get('options_prefix') . '_options_custom_fonts');
		}
		
		
		// Save theme.css with new fonts and colors
		if (charity_is_hope_get_theme_setting('less_compiler')=='no') {
			// Save custom css
			charity_is_hope_fpc( charity_is_hope_get_file_dir('css/theme.css'), charity_is_hope_get_custom_css() );
		} else {
			// Recompile theme.less
			do_action('charity_is_hope_action_compile_less');
		}
		
		wp_die();
	}
}


// Ajax Delete color scheme Action handler
if ( !function_exists( 'charity_is_hope_core_customizer_scheme_delete' ) ) {
	//Handler of add_action('wp_ajax_charity_is_hope_options_scheme_delete', 'charity_is_hope_core_customizer_scheme_delete');
	//Handler of add_action('wp_ajax_nopriv_charity_is_hope_options_scheme_delete', 'charity_is_hope_core_customizer_scheme_delete');
	function charity_is_hope_core_customizer_scheme_delete() {

		if ( !wp_verify_nonce( charity_is_hope_get_value_gp('nonce'), admin_url('admin-ajax.php') ) || !current_user_can('manage_options'))
			wp_die();

		$scheme = $_POST['scheme'];
		$colors = charity_is_hope_storage_get('custom_colors');
		$order = !empty($_POST['order']) ? explode(',', $_POST['order']) : array_keys($colors);
		$response = array( 'error' => '' );

		// Refresh array with schemes from POST data
		if (isset($colors[$scheme])) {
			if (count((array)$colors) > 1) {
				$schemes = array();
				foreach ($order as $slug) {
					if ($slug == $scheme) continue;
					if (is_array($colors[$slug]) && count($colors[$slug]) > 0) {
						$schemes[$slug] = $colors[$slug];
					}
				}
				$schemes = apply_filters('charity_is_hope_filter_save_custom_colors', $schemes);
				charity_is_hope_storage_set('custom_colors', $schemes);
				update_option( charity_is_hope_storage_get('options_prefix') . '_options_custom_colors', $schemes);
			} else
				$response['error'] = sprintf(esc_html__('You cannot delete last color scheme!', 'charity-is-hope'), $scheme);
		} else
			$response['error'] = sprintf(esc_html__('Color Scheme %s not found!', 'charity-is-hope'), $scheme);

		// Recompile LESS files with new fonts and colors
		do_action('charity_is_hope_action_compile_less');
		
		echo json_encode($response);
		wp_die();
	}
}


// Ajax Copy color scheme Action handler
if ( !function_exists( 'charity_is_hope_core_customizer_scheme_copy' ) ) {
	//Handler of add_action('wp_ajax_charity_is_hope_options_scheme_copy', 'charity_is_hope_core_customizer_scheme_copy');
	//Handler of add_action('wp_ajax_nopriv_charity_is_hope_options_scheme_copy', 'charity_is_hope_core_customizer_scheme_copy');
	function charity_is_hope_core_customizer_scheme_copy() {

		if ( !wp_verify_nonce( charity_is_hope_get_value_gp('nonce'), admin_url('admin-ajax.php') ) || !current_user_can('manage_options'))
			wp_die();

		$scheme = $_POST['scheme'];
		$colors = charity_is_hope_storage_get('custom_colors');
		$order = !empty($_POST['order']) ? explode(',', $_POST['order']) : array_keys($colors);
		$response = array( 'error' => '' );

		// Refresh array with schemes from POST data
		if (isset($colors[$scheme])) {
			// Generate slug for the scheme's copy
			$i = 0;
			do {
				$new_slug = $scheme.'_copy'.($i ? $i : '');
				$i++;
			} while (isset($colors[$new_slug]));
			// Copy schemes
			$schemes = array();
			foreach ($order as $slug) {
				if (is_array($colors[$slug]) && count($colors[$slug]) > 0) {
					$schemes[$slug] = $colors[$slug];
					if ($slug == $scheme) {
						$schemes[$new_slug] = $colors[$slug];
						$schemes[$new_slug]['title'] .= ' '.esc_html__('(Copy)', 'charity-is-hope');
					}
				}
			}
			$schemes = apply_filters('charity_is_hope_filter_save_custom_colors', $schemes);
			charity_is_hope_storage_set('custom_colors', $schemes);
			update_option( charity_is_hope_storage_get('options_prefix') . '_options_custom_colors', $schemes);
		} else
			$response['error'] = sprintf(esc_html__('Color Scheme %s not found!', 'charity-is-hope'), $scheme);

		// Recompile LESS files with new fonts and colors
		do_action('charity_is_hope_action_compile_less');
		
		echo json_encode($response);
		wp_die();
	}
}

// Recompile LESS files when color schemes or theme options are saved
if (!function_exists('charity_is_hope_core_customizer_compile_less')) {
	//Handler of add_action('charity_is_hope_action_compile_less', 'charity_is_hope_core_customizer_compile_less');
	function charity_is_hope_core_customizer_compile_less() {
		if (charity_is_hope_get_theme_setting('less_compiler')=='no') return;
		$files = array();
		if (file_exists(charity_is_hope_get_file_dir('css/_utils.less'))) 	$files[] = charity_is_hope_get_file_dir('css/_utils.less');
		$files = apply_filters('charity_is_hope_filter_compile_less', $files);
		if (count($files) > 0) charity_is_hope_compile_less($files);
	}
}






/* Customizer page builder
-------------------------------------------------------------------- */

// Show Customizer page
if ( !function_exists( 'charity_is_hope_core_customizer_page' ) ) {
	function charity_is_hope_core_customizer_page() {

		$options = array();

		$start_partition = true;

		// Default color schemes
		$colors = charity_is_hope_storage_get('custom_colors');
		if (is_array($colors) && count($colors) > 0) {
			
			$demo_block = '';
			if (charity_is_hope_get_theme_setting('customizer_demo') && file_exists(CHARITY_IS_HOPE_FW_PATH . 'core/core.customizer/core.customizer.demo.php')) {
				ob_start();
				require_once CHARITY_IS_HOPE_FW_PATH . 'core/core.customizer/core.customizer.demo.php';
				$demo_block = ob_get_contents();
				ob_end_clean();
			}
			$options["partition_schemes"] = array(
				"title" => esc_html__('Color schemes', 'charity-is-hope'),
				"override" => "customizer",
				"icon" => "iconadmin-palette",
				"type" => "partition");
			if ($start_partition) {
				$options["partition_schemes"]["start"] = "partitions";
				$start_partition = false;
			}

			$start_tab = true;
						
			foreach ($colors as $slug=>$scheme) {

				$options["tab_{$slug}"] = array(
					"title" => $scheme['title'],
					"override" => "customizer",
					"icon" => "iconadmin-palette",
					"type" => "tab");
				if ($start_tab) {
					$options["tab_{$slug}"]["start"] = "tabs";
					$start_tab = false;
				}

				$options["{$slug}-description"] = array(
					"title" => sprintf(esc_html__('Color scheme "%s"', 'charity-is-hope'), $scheme['title']),
					"desc" => wp_kses_data( sprintf(__('Specify the color for each element in the scheme "%s". After that you will be able to use your color scheme for the entire page, any part thereof and/or for the shortcodes!', 'charity-is-hope'), $scheme['title']) ),
					"override" => "customizer",
					"type" => "info");




				// Buttons
				$options["{$slug}-buttons_label"] = array(
					"desc" => wp_kses_data( __("You can duplicate current color scheme (appear on new tab) or delete it (if not last scheme)", 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "4_6 first",
					"type" => "label");
	
				$options["{$slug}-button_copy"] = array(
					"title" => esc_html__('Copy',  'charity-is-hope'),
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_6",
					"icon" => "iconadmin-docs",
					"action" => "scheme_copy",
					"type" => "button");
	
				$options["{$slug}-button_delete"] = array(
					"title" => esc_html__('Delete',  'charity-is-hope'),
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_6 last",
					"icon" => "iconadmin-trash",
					"action" => "scheme_delete",
					"type" => "button");





				// Scheme name and slug
				$options["{$slug}-title_label"] = array(
					"title" => esc_html__('Scheme names', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Specify scheme title (to represent this color scheme in the lists) and scheme slug (to use this color scheme in the shortcodes).<br>Attention! If you change scheme title or slug - you must save options (press Save), then reload the page (press F5) after the success saving message appear!', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");

				$options["{$slug}-title"] = array(
					"title" => esc_html__('Title',  'charity-is-hope'),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5",
					"std" => "",
					"val" => $scheme['title'],
					"type" => "text");

				$options["{$slug}-slug"] = array(
					"title" => esc_html__('Slug',  'charity-is-hope'),
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5 last",
					"std" => "",
					"val" => $slug,
					"type" => "text");



				// Demo block
				if ($demo_block) {
					$options["{$slug}-demo"] = array(
						"title" => esc_html__('Usage demo', 'charity-is-hope'),
						"desc" => wp_kses_data( __('Below you can see the example of decoration of the page with selected colors.', 'charity-is-hope') )
									. trim($demo_block),
						"override" => "customizer",
						"type" => "info");
				}



if (isset($scheme['bg_color'])) {
				// Page/Block colors
				$options["{$slug}-block_info"] = array(
					"title" => esc_html__('Page/Block decoration', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Specify border and background to decorate whole page (if scheme accepted to the page) or entire block/section.', 'charity-is-hope') ),
					"override" => "customizer",
					"type" => "info");
	
				// Border
				$options["{$slug}-bd_color_label"] = array(
					"title" => esc_html__('Border color', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select the border color and it hover state', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-bd_color"] = array(
					"title" => esc_html__('Color', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['bd_color'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				$options["{$slug}-bd_color_empty"] = array(
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5",
					"type" => "label");
	
				// Background color
				$options["{$slug}-bg_color_label"] = array(
					"title" => esc_html__('Background color', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select the background color and it hover state', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-bg_color"] = array(
					"title" => esc_html__('Color', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['bg_color'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				$options["{$slug}-bg_color_empty"] = array(
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5",
					"type" => "label");
}


if (isset($scheme['bg_image'])) {
				// Background image 1
				$options["{$slug}-bg_image_label"] = array(
					"title" => esc_html__('Background image', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select first background image and it display parameters', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-bg_image"] = array(
					"title" => esc_html__('Image', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['bg_image'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "3_5",
					"type" => "media");

				$options["{$slug}-bg_image_label2"] = array(
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");

				$options["{$slug}-bg_image_position"] = array(
					"title" => esc_html__('Position', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['bg_image_position'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"options" => charity_is_hope_get_list_bg_image_positions(),
					"type" => "select");
		
				$options["{$slug}-bg_image_repeat"] = array(
					"title" => esc_html__('Repeat', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['bg_image_repeat'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"options" => charity_is_hope_get_list_bg_image_repeats(),
					"type" => "select");

				$options["{$slug}-bg_image_attachment"] = array(
					"title" => esc_html__('Attachment', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['bg_image_attachment'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"options" => charity_is_hope_get_list_bg_image_attachments(),
					"type" => "select");
	
				// Background image 2
				$options["{$slug}-bg_image2_label"] = array(
					"title" => esc_html__('Background image 2', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select second background image and it display parameters', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-bg_image2"] = array(
					"title" => esc_html__('Image', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['bg_image2'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "3_5",
					"type" => "media");

				$options["{$slug}-bg_image2_label2"] = array(
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");

				$options["{$slug}-bg_image2_position"] = array(
					"title" => esc_html__('Position', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['bg_image2_position'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"options" => charity_is_hope_get_list_bg_image_positions(),
					"type" => "select");
		
				$options["{$slug}-bg_image2_repeat"] = array(
					"title" => esc_html__('Repeat', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['bg_image2_repeat'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"options" => charity_is_hope_get_list_bg_image_repeats(),
					"type" => "select");

				$options["{$slug}-bg_image2_attachment"] = array(
					"title" => esc_html__('Attachment', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['bg_image2_attachment'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5 last",
					"options" => charity_is_hope_get_list_bg_image_attachments(),
					"type" => "select");
}


				// Accent colors
if (isset($scheme['accent2'])) {

				$options["{$slug}-accent_info"] = array(
					"title" => esc_html__('Accented colors', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Specify colors for the accented areas in your site.', 'charity-is-hope') ),
					"override" => "customizer",
					"type" => "info");

				// Accent 2 color
				$options["{$slug}-accent2_label"] = array(
					"title" => esc_html__('Accent 2', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select color for accented elements and their hover state', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");

				$options["{$slug}-accent2"] = array(
					"std" => "",
					"val" => $scheme['accent2'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-accent2_hover"] = array(
					"std" => "",
					"val" => $scheme['accent2_hover'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
}

if (isset($scheme['accent3'])) {
				// Accent 3 color
				$options["{$slug}-accent3_label"] = array(
					"title" => esc_html__('Accent 3', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select color for accented elements and their hover state', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");

				$options["{$slug}-accent3"] = array(
					"std" => "",
					"val" => $scheme['accent3'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-accent3_hover"] = array(
					"std" => "",
					"val" => $scheme['accent3_hover'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5 last",
					"style" => "tiny",
					"type" => "color");
}


if (isset($scheme['text'])) {
				// Text colors
				$options["{$slug}-text_info"] = array(
					"title" => esc_html__('Text and Headers', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Specify colors for the plain text, post info blocks and headers', 'charity-is-hope') ),
					"override" => "customizer",
					"type" => "info");
	
				// Text - simple text, links in the text and their hover state
				$options["{$slug}-text_label"] = array(
					"title" => esc_html__('Text', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select colors for the text: normal text color, light text (for example - post info) and dark text (headers, bold text, etc.)', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-text"] = array(
					"title" => esc_html__('Text', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['text'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-text_light"] = array(
					"title" => esc_html__('Light', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['text_light'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-text_dark"] = array(
					"title" => esc_html__('Dark', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['text_dark'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
}

if (isset($scheme['text_link'])) {

				// Text links
				$options["{$slug}-text_link_label"] = array(
					"title" => esc_html__('Text links', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select color for the links and their hover state', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");


				$options["{$slug}-text_link"] = array(
					"title" => esc_html__('Link', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['text_link'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-text_hover"] = array(
					"title" => esc_html__('Hover', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['text_hover'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
}

if (isset($scheme['inverse_text'])) {
				// Inverse blocks
				$options["{$slug}-inverse_info"] = array(
					"title" => esc_html__('Inverse blocks', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Specify colors for the headers, plain text, links and post info blocks in the accented areas (with background color equal to text link)', 'charity-is-hope') ),
					"override" => "customizer",
					"type" => "info");

				// Inverse text
				$options["{$slug}-inverse_label"] = array(
					"title" => esc_html__('Inverse text', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select colors for inversed text (text on accented background)', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-inverse_text"] = array(
					"title" => esc_html__('Text', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['inverse_text'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-inverse_light"] = array(
					"title" => esc_html__('Light', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['inverse_light'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-inverse_dark"] = array(
					"title" => esc_html__('Dark', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['inverse_dark'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				$options["{$slug}-inverse_label2"] = array(
					"title" => esc_html__('Inverse links', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select colors for inversed links (links on accented background)', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-inverse_link"] = array(
					"title" => esc_html__('Link', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['inverse_link'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-inverse_hover"] = array(
					"title" => esc_html__('Hover', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['inverse_hover'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5 last",
					"style" => "tiny",
					"type" => "color");
}


if (isset($scheme['input_text'])) {
				// Form field's colors
				$options["{$slug}-input_info"] = array(
					"title" => esc_html__('Input colors: form fields and textareas', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Specify colors to decorate input fields in the forms', 'charity-is-hope') ),
					"override" => "customizer",
					"type" => "info");
	
				// Text in the inputs
				$options["{$slug}-input_text_label"] = array(
					"title" => esc_html__('Text', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Specify colors for the input fields for all states: disabled, inactive, active', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-input_text"] = array(
					"title" => esc_html__('Inactive', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['input_text'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				$options["{$slug}-input_light"] = array(
					"title" => esc_html__('Disabled', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['input_light'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				$options["{$slug}-input_dark"] = array(
					"title" => esc_html__('Active', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['input_dark'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
				
				// Border
				$options["{$slug}-input_bd_color_label"] = array(
					"title" => esc_html__('Border color', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select the border colors for the normal state and for active (focused) field', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-input_bd_color"] = array(
					"title" => esc_html__('Color', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['input_bd_color'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				$options["{$slug}-input_bd_hover"] = array(
					"title" => esc_html__('Hover', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['input_bd_hover'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				// Background Color
				$options["{$slug}-input_bg_color_label"] = array(
					"title" => esc_html__('Background Color', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select the background colors for the normal state and for active (focused) field', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-input_bg_color"] = array(
					"title" => esc_html__('Color', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['input_bg_color'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				$options["{$slug}-input_bg_hover"] = array(
					"title" => esc_html__('Hover', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['input_bg_hover'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
}

if (isset($scheme['alter_text'])) {
				// Alternative colors (highlight blocks, form fields, etc.)
				$options["{$slug}-alter_info"] = array(
					"title" => esc_html__('Alternative colors: Highlighted areas, submenu items, etc.', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Specify colors to decorate highlighted blocks in the text, submenu items, etc.', 'charity-is-hope') ),
					"override" => "customizer",
					"type" => "info");
	
				// Text in the highlight block
				$options["{$slug}-alter_text_label"] = array(
					"title" => esc_html__('Text and Headers', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Specify colors for the plain text, post info blocks and headers in the highlight blocks', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-alter_text"] = array(
					"title" => esc_html__('Text', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_text'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-alter_light"] = array(
					"title" => esc_html__('Light', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_light'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-alter_dark"] = array(
					"title" => esc_html__('Dark', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_dark'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				// Links in the highlight block
				$options["{$slug}-alter_link_label"] = array(
					"title" => esc_html__('Links', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Specify colors for the links in the highlight blocks', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-alter_link"] = array(
					"title" => esc_html__('Color', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_link'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
				$options["{$slug}-alter_hover"] = array(
					"title" => esc_html__('Hover', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_hover'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
				
				// Border
				$options["{$slug}-alter_bd_color_label"] = array(
					"title" => esc_html__('Border color', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select the border colors for the normal and hovered state', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-alter_bd_color"] = array(
					"title" => esc_html__('Color', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_bd_color'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				$options["{$slug}-alter_bd_hover"] = array(
					"title" => esc_html__('Hover', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_bd_hover'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				// Background Color
				$options["{$slug}-alter_bg_color_label"] = array(
					"title" => esc_html__('Background Color', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select the background colors for the normal and hovered state', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-alter_bg_color"] = array(
					"title" => esc_html__('Color', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_bg_color'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");

				$options["{$slug}-alter_bg_hover"] = array(
					"title" => esc_html__('Hover', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_bg_hover'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"style" => "tiny",
					"type" => "color");
	
if (isset($scheme['alter_bg_image'])) {
				// Background image
				$options["{$slug}-alter_bg_image_label"] = array(
					"title" => esc_html__('Background image', 'charity-is-hope'),
					"desc" => wp_kses_data( __('Select alter background image and it display parameters', 'charity-is-hope') ),
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");
	
				$options["{$slug}-alter_bg_image"] = array(
					"title" => esc_html__('Image', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_bg_image'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "3_5",
					"type" => "media");

				$options["{$slug}-alter_bg_image_label2"] = array(
					"override" => "customizer",
					"divider" => false,
					"columns" => "2_5 first",
					"type" => "label");

				$options["{$slug}-alter_bg_image_position"] = array(
					"title" => esc_html__('Position', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_bg_image_position'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"options" => charity_is_hope_get_list_bg_image_positions(),
					"type" => "select");
		
				$options["{$slug}-alter_bg_image_repeat"] = array(
					"title" => esc_html__('Repeat', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_bg_image_repeat'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"options" => charity_is_hope_get_list_bg_image_repeats(),
					"type" => "select");

				$options["{$slug}-alter_bg_image_attachment"] = array(
					"title" => esc_html__('Attachment', 'charity-is-hope'),
					"std" => "",
					"val" => $scheme['alter_bg_image_attachment'],
					"override" => "customizer",
					"divider" => false,
					"columns" => "1_5",
					"options" => charity_is_hope_get_list_bg_image_attachments(),
					"type" => "select");
}
}
			}
		}


		// Default fonts settings
		$fonts = charity_is_hope_storage_get('custom_fonts');
		if (is_array($fonts) && count($fonts) > 0) {

			$options["partition_fonts"] = array(
				"title" => esc_html__('Fonts', 'charity-is-hope'),
				"override" => "customizer",
				"icon" => "iconadmin-font",
				"type" => "partition");
			if ($start_partition) {
				$options["partition_fonts"]["start"] = "partitions";
				$start_partition = false;
			}

			$options["info_fonts_1"] = array(
				"title" => esc_html__('Typography settings', 'charity-is-hope'),
				"desc" => wp_kses_data( __('Select fonts, sizes and styles for the headings and paragraphs. You can use Google fonts and custom fonts.<br><br>How to install custom @font-face fonts into the theme?<br>All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!<br>Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.<br>Create your @font-face kit by using Fontsquirrel @font-face Generator (or any other) and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install.', 'charity-is-hope') ),
				"type" => "info");

			$show_titles = true;
			
			$list_fonts = charity_is_hope_get_list_fonts(true);
			$list_styles = charity_is_hope_get_list_fonts_styles(false);
			$list_weight = array(
				'inherit' => esc_html__("Inherit", 'charity-is-hope'), 
				'100' => esc_html__('100 (Light)', 'charity-is-hope'), 
				'300' => esc_html__('300 (Thin)',  'charity-is-hope'),
				'400' => esc_html__('400 (Normal)', 'charity-is-hope'),
				'500' => esc_html__('500 (Semibold)', 'charity-is-hope'),
				'600' => esc_html__('600 (Semibold)', 'charity-is-hope'),
				'700' => esc_html__('700 (Bold)', 'charity-is-hope'),
				'900' => esc_html__('900 (Black)', 'charity-is-hope')
			);

			foreach ($fonts as $slug=>$font) {
				if (isset($font['font-family'])) {
					$options["{$slug}-font-family"] = array(
						"title" => isset($font['title']) ? $font['title'] : charity_is_hope_strtoproper($slug),
						"desc" => isset($font['description']) ? $font['description'] : '',
						"divider" => false,
						"columns" => "2_8 first",
						"std" => "",
						"val" => $font['font-family'] ? $font['font-family'] : 'inherit',
						"options" => $list_fonts,
						"type" => "fonts");
				}
				if (isset($font['font-size'])) {
					$options["{$slug}-font-size"] = array(
						"title" => $show_titles ? esc_html__('Size', 'charity-is-hope') : '',
						"desc" => '',
						"divider" => false,
						"columns" => "1_8",
						"std" => "",
						"val" => charity_is_hope_is_inherit_option($font['font-size']) ? '' : $font['font-size'],
						"type" => "text");
				}
				if (isset($font['line-height'])) {
					$options["{$slug}-line-height"] = array(
						"title" => $show_titles ? esc_html__('Line height', 'charity-is-hope') : '',
						"desc" => '',
						"divider" => false,
						"columns" => "1_8",
						"std" => "",
						"val" => charity_is_hope_is_inherit_option($font['line-height']) ? '' : $font['line-height'],
						"type" => "text");
				} else {
					$options["{$slug}-line-height"] = array(
						"title" => $show_titles ? esc_html__('Line height', 'charity-is-hope') : '',
						"desc" => '',
						"divider" => false,
						"columns" => "1_8",
						"type" => "label");
				}
				if (isset($font['font-weight'])) {
					$options["{$slug}-font-weight"] = array(
						"title" => $show_titles ? esc_html__('Weight', 'charity-is-hope') : '',
						"desc" => '',
						"divider" => false,
						"columns" => "1_8",
						"std" => "",
						"val" => $font['font-weight'] ? $font['font-weight'] : 'inherit',
						"options" => $list_weight,
						"type" => "select");
				}
				if (isset($font['font-style'])) {
					$options["{$slug}-font-style"] = array(
						"title" => $show_titles ? esc_html__('Style', 'charity-is-hope') : '',
						"desc" => '',
						"divider" => false,
						"columns" => "1_8",
						"std" => "",
						"val" => $font['font-style'] ? $font['font-style'] : 'inherit',
						"multiple" => true,
						"options" => $list_styles,
						"type" => "checklist");
				}
				if (isset($font['margin-top'])) {
					$options["{$slug}-margin-top"] = array(
						"title" => $show_titles ? esc_html__('Margin Top', 'charity-is-hope') : '',
						"desc" => '',
						"divider" => false,
						"columns" => "1_8",
						"std" => "",
						"val" => charity_is_hope_is_inherit_option($font['margin-top']) ? '' : $font['margin-top'],
						"type" => "text");
				} else {
					$options["{$slug}-margin-top"] = array(
						"title" => $show_titles ? esc_html__('Margin Top', 'charity-is-hope') : '',
						"desc" => '',
						"divider" => false,
						"columns" => "1_8",
						"type" => "label");
				}
				if (isset($font['margin-bottom'])) {
					$options["{$slug}-margin-bottom"] = array(
						"title" => $show_titles ? esc_html__('Margin Bottom', 'charity-is-hope') : '',
						"desc" => '',
						"divider" => false,
						"columns" => "1_8",
						"std" => "",
						"val" => charity_is_hope_is_inherit_option($font['margin-bottom']) ? '' : $font['margin-bottom'],
						"type" => "text");
				} else {
					$options["{$slug}-margin-bottom"] = array(
						"title" => $show_titles ? esc_html__('Margin Bottom', 'charity-is-hope') : '',
						"desc" => '',
						"divider" => false,
						"columns" => "1_8",
						"type" => "label");
				}

				$show_titles = false;
			}
		}

		// Load required styles and scripts for this page
		charity_is_hope_core_customizer_load_scripts();
		// Prepare javascripts global variables
		charity_is_hope_core_customizer_prepare_scripts();
		
		// Build Options page
		charity_is_hope_options_page_start(array(
			'title' => esc_html__('Fonts & Colors', 'charity-is-hope'),
			"icon" => "iconadmin-cog",
			"subtitle" => esc_html__('Fonts settings & Color schemes', 'charity-is-hope'),
			"description" => wp_kses_data( __('Customize fonts and colors for your site.', 'charity-is-hope') ),
			'data' => $options,
			'create_form' => true,
			'buttons' => array('save', 'reset'),
			'override' => 'customizer'
		));

		if (is_array($options) && count($options) > 0) {
			foreach ($options as $id=>$option) { 
				charity_is_hope_options_show_field($id, $option);
			}
		}
	
		charity_is_hope_options_page_stop();
	}
}



// Prepare LESS variables before LESS files compilation
// Duplicate rules set for each color scheme
if (!function_exists('charity_is_hope_core_customizer_prepare_less')) {
	//Handler of add_filter('charity_is_hope_filter_prepare_less', 'charity_is_hope_core_customizer_prepare_less');
	function charity_is_hope_core_customizer_prepare_less() {

		// Prefix for override rules
		$prefix = charity_is_hope_get_theme_setting('less_prefix');
		// Use nested selectors: increase .css size, but allow use nested color schemes
		$nested = charity_is_hope_get_theme_setting('less_nested');

		$out = '';

		// Custom fonts
		$fonts_list = charity_is_hope_get_list_fonts(false);
		$custom_fonts = charity_is_hope_get_custom_fonts();
		if (is_array($custom_fonts) && count($custom_fonts) > 0) {
		foreach ($custom_fonts as $slug => $font) {
			
			// Prepare variables with separate font rules
			if (!empty($font['font-family']) && !charity_is_hope_is_inherit_option($font['font-family'])) {
				$out .= "@{$slug}_ff: \"" . str_replace(' ('.esc_html__('uploaded font', 'charity-is-hope').')', '', $font['font-family']) . '"' 
							. (isset($fonts_list[$font['font-family']]['family']) 
									? ',' . $fonts_list[$font['font-family']]['family'] 
									: '' 
								) 
							. ";\n";
			} else
				$out .= "@{$slug}_ff: inherit;\n";

			if (!empty($font['font-size']) && !charity_is_hope_is_inherit_option($font['font-size']))
				$out .= "@{$slug}_fs: " . charity_is_hope_prepare_css_value($font['font-size']) . ";\n";
			else
				$out .= "@{$slug}_fs: inherit;\n";
			
			if (!empty($font['line-height']) && !charity_is_hope_is_inherit_option($font['line-height']))
				$out .= "@{$slug}_lh: " . charity_is_hope_prepare_css_value($font['line-height']) . ";\n";
			else
				$out .= "@{$slug}_lh: inherit;\n";

			if (!empty($font['font-weight']) && !charity_is_hope_is_inherit_option($font['font-weight']))
				$out .= "@{$slug}_fw: " . trim($font['font-weight']) . ";\n";
			else
				$out .= "@{$slug}_fw: inherit;\n";

			if (!empty($font['font-style']) && !charity_is_hope_is_inherit_option($font['font-style']) && charity_is_hope_strpos($font['font-style'], 'i')!==false)
				$out .= "@{$slug}_fl: italic;\n";
			else
				$out .= "@{$slug}_fl: inherit;\n";

			if (!empty($font['font-style']) && !charity_is_hope_is_inherit_option($font['font-style']) && charity_is_hope_strpos($font['font-style'], 'u')!==false)
				$out .= "@{$slug}_td: underline;\n";
			else
				$out .= "@{$slug}_td: inherit;\n";

			if (!empty($font['margin-top']) && !charity_is_hope_is_inherit_option($font['margin-top']))
				$out .= "@{$slug}_mt: " . charity_is_hope_prepare_css_value($font['margin-top']) . ";\n";
			else
				$out .= "@{$slug}_mt: inherit;\n";

			if (!empty($font['margin-bottom']) && !charity_is_hope_is_inherit_option($font['margin-bottom']))
				$out .= "@{$slug}_mb: " . charity_is_hope_prepare_css_value($font['margin-bottom']) . ";\n";
			else
				$out .= "@{$slug}_mb: inherit;\n";

			$out .= "\n";


			// Prepare less-function with summary font settings
			$out .= ".{$slug}_font() {\n";
			if (!empty($font['font-family']) && !charity_is_hope_is_inherit_option($font['font-family']))
				$out .= "\tfont-family:\"" . str_replace(' ('.esc_html__('uploaded font', 'charity-is-hope').')', '', $font['font-family']) . '"' 
							. (isset($fonts_list[$font['font-family']]['family']) 
								? ',' . $fonts_list[$font['font-family']]['family'] 
								: '' ) 
							. ";\n";
			if (!empty($font['font-size']) && !charity_is_hope_is_inherit_option($font['font-size']))
				$out .= "\tfont-size:" . charity_is_hope_prepare_css_value($font['font-size']) . ";\n";
			if (!empty($font['line-height']) && !charity_is_hope_is_inherit_option($font['line-height']))
				$out .= "\tline-height: " . charity_is_hope_prepare_css_value($font['line-height']) . ";\n";
			if (!empty($font['font-weight']) && !charity_is_hope_is_inherit_option($font['font-weight']))
				$out .= "\tfont-weight: " . trim($font['font-weight']) . ";\n";
			if (!empty($font['font-style']) && !charity_is_hope_is_inherit_option($font['font-style']) && charity_is_hope_strpos($font['font-style'], 'i')!==false)
				$out .= "\tfont-style: italic;\n";
			if (!empty($font['font-style']) && !charity_is_hope_is_inherit_option($font['font-style']) && charity_is_hope_strpos($font['font-style'], 'u')!==false)
				$out .= "\ttext-decoration: underline;\n";
			$out .= "}\n\n";

			$out .= ".{$slug}_margins() {\n";
			if (!empty($font['margin-top']) && !charity_is_hope_is_inherit_option($font['margin-top']))
				$out .= "\tmargin-top: " . charity_is_hope_prepare_css_value($font['margin-top']) . ";\n";
			if (!empty($font['margin-bottom']) && !charity_is_hope_is_inherit_option($font['margin-bottom']))
				$out .= "\tmargin-bottom: " . charity_is_hope_prepare_css_value($font['margin-bottom']) . ";\n";
			$out .= "}\n\n";
		}
		}

		$out .= "\n";


	
		// Prepare variables with separate colors
		$custom_colors = charity_is_hope_get_custom_colors();
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				if (is_array($data) && count($data) > 0) {
					foreach ($data as $key => $value) {
						if ($key == 'title' || charity_is_hope_strpos($key, 'bg_image')!==false) continue;
						$out .= "@{$scheme}_{$key}: " . esc_attr(
							!empty($value) 
								? $value
								: (charity_is_hope_strpos($key, 'bg_image')!==false
									? 'none'
									: 'inherit'
									)
							) . ";\n";
					}
				}
			}
		}
			
		$out .= "\n";
			

		// Prepare less-function with summary color settings

		// .scheme_color(text_hover)
		$out .= ".scheme_color(@color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "color: @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_color(text_hover, @alpha)
		$out .= ".scheme_color(@color_name, @alpha) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "@r: red(@@color_var);\n"
					. "@g: green(@@color_var);\n"
					. "@b: blue(@@color_var);\n"
					. "color: rgba(@r, @g, @b, @alpha);\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_bg_color(text_hover)
		$out .= ".scheme_bg_color(@color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "background-color: @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_bg_color(text_hover, @alpha)
		$out .= ".scheme_bg_color(@color_name, @alpha) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "@r: red(@@color_var);\n"
					. "@g: green(@@color_var);\n"
					. "@b: blue(@@color_var);\n"
					. "background-color: rgba(@r, @g, @b, @alpha);\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_bg_color_self(text_hover)
		$out .= ".scheme_bg_color_self(@color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . "&.scheme_{$scheme}" . ($nested ? ", [class*=\"scheme_\"] &.scheme_{$scheme}" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "background-color: @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_bg_color_self(text_hover, @alpha)
		$out .= ".scheme_bg_color_self(@color_name, @alpha) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . "&.scheme_{$scheme}" . ($nested ? ", [class*=\"scheme_\"] &.scheme_{$scheme}" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "@r: red(@@color_var);\n"
					. "@g: green(@@color_var);\n"
					. "@b: blue(@@color_var);\n"
					. "background-color: rgba(@r, @g, @b, @alpha);\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_bg(text_hover)
		$out .= ".scheme_bg(@color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "background: @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_bg(text_hover, @alpha)
		$out .= ".scheme_bg(@color_name, @alpha) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "@r: red(@@color_var);\n"
					. "@g: green(@@color_var);\n"
					. "@b: blue(@@color_var);\n"
					. "background: rgba(@r, @g, @b, @alpha);\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_bg_image()
		$out .= ".scheme_bg_image() {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				if (!empty($data['bg_image']) || !empty($data['bg_image2'])) {
					$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n";
					$comma = '';
					if (!empty($data['bg_image2'])) {
						$out .= "background: url(".esc_url($data['bg_image2']).') '.esc_attr($data['bg_image2_repeat']).' '.esc_attr($data['bg_image2_position']).' '.esc_attr($data['bg_image2_attachment']);
						$comma = ',';
					}
					if (!empty($data['bg_image'])) {
						$out .= ($comma ? $comma : "background:") . "url(".esc_url($data['bg_image']).') '.esc_attr($data['bg_image_repeat']).' '.esc_attr($data['bg_image_position']).' '.esc_attr($data['bg_image_attachment']);
					}
					$out .= ";\n";
					$out .= "}\n";
				}
			}
		}
		$out .= "}\n";

		// .scheme_alter_bg_image()
		$out .= ".scheme_alter_bg_image() {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				if (!empty($data['alter_bg_image'])) {
					$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n";
					$out .= "background: url(".esc_url($data['alter_bg_image']).') '.esc_attr($data['alter_bg_image_repeat']).' '.esc_attr($data['alter_bg_image_position']).' '.esc_attr($data['alter_bg_image_attachment']);
					$out .= "}\n";
				}
			}
		}
		$out .= "}\n";

		// .scheme_bd_color(text_hover)
		$out .= ".scheme_bd_color(@color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "border-color: @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_bd_color(text_hover, @alpha)
		$out .= ".scheme_bd_color(@color_name, @alpha) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "@r: red(@@color_var);\n"
					. "@g: green(@@color_var);\n"
					. "@b: blue(@@color_var);\n"
					. "border-color: rgba(@r, @g, @b, @alpha);\n"
					. "}\n";
			}
		}
		$out .= "}\n";
			
		// .scheme_bdt_color(text_hover)
		$out .= ".scheme_bdt_color(@color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "border-top-color: @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";
			
		// .scheme_bdb_color(text_hover)
		$out .= ".scheme_bdb_color(@color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "border-bottom-color: @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";
			
		// .scheme_bdl_color(text_hover)
		$out .= ".scheme_bdl_color(@color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "border-left-color: @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";
			
		// .scheme_bdr_color(text_hover)
		$out .= ".scheme_bdr_color(@color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "border-right-color: @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_stroke_color(text_hover)
		$out .= ".scheme_stroke_color(@color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "stroke: @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_stroke_color(text_hover, @alpha)
		$out .= ".scheme_stroke_color(@color_name, @alpha) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "@r: red(@@color_var);\n"
					. "@g: green(@@color_var);\n"
					. "@b: blue(@@color_var);\n"
					. "stroke: rgba(@r, @g, @b, @alpha);\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_gradient_top(text_link, 0%, text_hover, 70%);
		$out .= ".scheme_gradient_top(@color_name, @color_percent, @color2_name, @color2_percent) {\n";	// when (@color_percent <= @color2_percent) {\n
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "@color2_var: '{$scheme}_@{color2_name}';\n"
					. "background: -webkit-gradient(linear, left top, left bottom, color-stop(@color_percent, @@color_var), color-stop(@color2_percent, @@color2_var));\n"
					. "background: -webkit-linear-gradient(top, @@color_var @color_percent, @@color2_var @color2_percent);\n"
					. "background:    -moz-linear-gradient(top, @@color_var @color_percent, @@color2_var @color2_percent);\n"
					. "background:     -ms-linear-gradient(top, @@color_var @color_percent, @@color2_var @color2_percent);\n"
					. "background:      -o-linear-gradient(top, @@color_var @color_percent, @@color2_var @color2_percent);\n"
					. "background:         linear-gradient(to bottom, @@color_var @color_percent, @@color2_var @color2_percent);\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_gradient_left(text_link, 0%, text_hover, 70%);
		$out .= ".scheme_gradient_left(@color_name, @color_percent, @color2_name, @color2_percent) {\n";	// when (@color_percent <= @color2_percent) {\n
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "@color2_var: '{$scheme}_@{color2_name}';\n"
					. "background: -webkit-gradient(linear, left top, right top, color-stop(@color_percent, @@color_var), color-stop(@color2_percent, @@color2_var));\n"
					. "background: -webkit-linear-gradient(left, @@color_var @color_percent, @@color2_var @color2_percent);\n"
					. "background:    -moz-linear-gradient(left, @@color_var @color_percent, @@color2_var @color2_percent);\n"
					. "background:     -ms-linear-gradient(left, @@color_var @color_percent, @@color2_var @color2_percent);\n"
					. "background:      -o-linear-gradient(left, @@color_var @color_percent, @@color2_var @color2_percent);\n"
					. "background:         linear-gradient(to right, @@color_var @color_percent, @@color2_var @color2_percent);\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_box_shadow(x, y, spread, size, color)
		$out .= ".scheme_box_shadow(@x, @y, @spread, @size, @color_name) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "-webkit-box-shadow: @x @y @spread @size @@color_var;\n"
					. "   -moz-box-shadow: @x @y @spread @size @@color_var;\n"
					. "    -ms-box-shadow: @x @y @spread @size @@color_var;\n"
					. "        box-shadow: @x @y @spread @size @@color_var;\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		// .scheme_box_shadow(x, y, spread, size, color, alpha)
		$out .= ".scheme_box_shadow(@x, @y, @spread, @size, @color_name, @alpha) {\n";
		if (is_array($custom_colors) && count($custom_colors) > 0) {
			foreach ($custom_colors as $scheme => $data) {
				$out .= $prefix . ".scheme_{$scheme} &" . ($nested ? ", [class*=\"scheme_\"] .scheme_{$scheme} &" : '') . " {\n"
					. "@color_var: '{$scheme}_@{color_name}';\n"
					. "@c: @@color_var;\n"
					. "@r: red(@c);\n"
					. "@g: green(@c);\n"
					. "@b: blue(@c);\n"
					. "-webkit-box-shadow: @x @y @spread @size rgba(@r, @g, @b, @alpha);\n"
					. "   -moz-box-shadow: @x @y @spread @size rgba(@r, @g, @b, @alpha);\n"
					. "    -ms-box-shadow: @x @y @spread @size rgba(@r, @g, @b, @alpha);\n"
					. "        box-shadow: @x @y @spread @size rgba(@r, @g, @b, @alpha);\n"
					. "}\n";
			}
		}
		$out .= "}\n";

		return $out;
	}
}




/* Customizer scripts
-------------------------------------------------------------------- */

// Add customizer scripts
if (!function_exists('charity_is_hope_core_customizer_load_scripts')) {
	function charity_is_hope_core_customizer_load_scripts() {
		if (file_exists(charity_is_hope_get_file_dir('core/core.customizer/core.customizer.css')))
			wp_enqueue_style( 'charity-is-hope-core-customizer-style',	charity_is_hope_get_file_url('core/core.customizer/core.customizer.css'), array(), null);
		if (file_exists(charity_is_hope_get_file_dir('core/core.customizer/core.customizer.js')))
			wp_enqueue_script( 'charity-is-hope-core-customizer-script', charity_is_hope_get_file_url('core/core.customizer/core.customizer.js'), array(), null );
	}
}


// Prepare javascripts global variables for customizer admin page
if ( !function_exists( 'charity_is_hope_core_customizer_prepare_scripts' ) ) {
	function charity_is_hope_core_customizer_prepare_scripts() {
		charity_is_hope_storage_set_array2('js_vars', 'to_strings', 'scheme_delete', 			esc_html__("Delete color scheme", 'charity-is-hope'));
		charity_is_hope_storage_set_array2('js_vars', 'to_strings', 'scheme_delete_confirm',	esc_html__("Do you really want to delete this color scheme?", 'charity-is-hope'));
		charity_is_hope_storage_set_array2('js_vars', 'to_strings', 'scheme_delete_complete',	esc_html__("Current color scheme is successfully deleted!", 'charity-is-hope'));
		charity_is_hope_storage_set_array2('js_vars', 'to_strings', 'scheme_delete_failed',	esc_html__("Error while delete color scheme! Try again later.", 'charity-is-hope'));
		charity_is_hope_storage_set_array2('js_vars', 'to_strings', 'scheme_copy', 			esc_html__("Copy color scheme", 'charity-is-hope'));
		charity_is_hope_storage_set_array2('js_vars', 'to_strings', 'scheme_copy_confirm', 	esc_html__("Duplicate this color scheme?", 'charity-is-hope'));
		charity_is_hope_storage_set_array2('js_vars', 'to_strings', 'scheme_copy_complete', 	esc_html__("Current color scheme is successfully duplicated!", 'charity-is-hope'));
		charity_is_hope_storage_set_array2('js_vars', 'to_strings', 'scheme_copy_failed', 		esc_html__("Error while duplicate color scheme! Try again later.", 'charity-is-hope'));
	}
}




/* Typography utilities
-------------------------------------------------------------------- */

// Return fonts parameters for customization
if ( !function_exists( 'charity_is_hope_get_custom_fonts' ) ) {
	function charity_is_hope_get_custom_fonts() {
		return apply_filters('charity_is_hope_filter_get_custom_fonts', !charity_is_hope_storage_empty('custom_fonts') ? charity_is_hope_storage_get('custom_fonts') : array());
	}
}

// Add custom font parameters
if (!function_exists('charity_is_hope_add_custom_font')) {
	function charity_is_hope_add_custom_font($key, $data) {
		if (charity_is_hope_storage_empty('custom_fonts', $key)) charity_is_hope_storage_set_array('custom_fonts', $key, $data);
	}
}

// Return one or all font settings
if (!function_exists('charity_is_hope_get_custom_font_settings')) {
	function charity_is_hope_get_custom_font_settings($key, $param_name='') {
		return charity_is_hope_storage_get_array('custom_fonts', $key, $param_name);
	}
}

// Return fonts for css generator
if ( !function_exists( 'charity_is_hope_get_custom_fonts_properties' ) ) {
	function charity_is_hope_get_custom_fonts_properties() {
		$fnt = charity_is_hope_get_custom_fonts();
		$rez = array();
		foreach ($fnt as $k=>$f) {
			foreach ($f as $prop=>$val) {
				if ($prop == 'font-style') {
					if (charity_is_hope_strpos($val, 'i')!==false)
						$rez[$k.'_fl'] = 'italic';
					if (charity_is_hope_strpos($val, 'u')!==false)
						$rez[$k.'_td'] = 'underline';
				} else {
					$p = str_replace(
						array(
							'font-family',
							'font-size',
							'font-weight',
							'line-height',
							'margin-top',
							'margin-bottom'
						),
						array(
							'ff', 'fs', 'fw', 'lh', 'mt', 'mb'
						),
						$prop);
					$rez[$k.'_'.$p] = $val ? $val : 'inherit';
				}
			}
		}
		return $rez;
	}
}

// Return fonts for css generator
if ( !function_exists( 'charity_is_hope_get_custom_font_css' ) ) {
	function charity_is_hope_get_custom_font_css($fnt) {
		$css = '';
		$fnt = charity_is_hope_storage_get_array('custom_fonts', $fnt);
		if (is_array($fnt)) {
			foreach ($fnt as $prop=>$val) {
				if (empty($val) || (charity_is_hope_strpos($prop, 'font-')===false && charity_is_hope_strpos($prop, 'line-')===false)) continue;
				if ($prop=='font-style') {
					if (charity_is_hope_strpos($val, 'i')!==false)
						$css .= ($css ? ';' : '') . $prop . ':italic';
					if (charity_is_hope_strpos($val, 'u')!==false)
						$css .= ($css ? ';' : '') . 'text_decoration:underline';
				} else
					$css .= ($css ? ';' : '') . $prop . ':' . $val;
			}
		}
		return $css;
	}
}

// Return fonts for css generator
if ( !function_exists( 'charity_is_hope_get_custom_margins_css' ) ) {
	function charity_is_hope_get_custom_margins_css($fnt) {
		$css = '';
		$fnt = charity_is_hope_storage_get_array('custom_fonts', $fnt);
		if (is_array($fnt)) {
			foreach ($fnt as $prop=>$val) {
				if (empty($val) || charity_is_hope_strpos($prop, 'margin-')===false) continue;
				$css .= ($css ? ';' : '') . $prop . ':' . $val;
			}
		}
		return $css;
	}
}






/* Color Scheme utilities
-------------------------------------------------------------------- */

// Add color scheme
if (!function_exists('charity_is_hope_add_color_scheme')) {
	function charity_is_hope_add_color_scheme($key, $data) {
		if (charity_is_hope_storage_empty('custom_colors', $key)) charity_is_hope_storage_set_array('custom_colors', $key, $data);
	}
}

// Return color schemes
if ( !function_exists( 'charity_is_hope_get_custom_colors' ) ) {
	function charity_is_hope_get_custom_colors() {
		return apply_filters('charity_is_hope_filter_get_custom_colors', !charity_is_hope_storage_empty('custom_colors') ? charity_is_hope_storage_get('custom_colors') : array());
	}
}

// Return color schemes list, prepended inherit
if ( !function_exists( 'charity_is_hope_get_list_color_schemes' ) ) {
	function charity_is_hope_get_list_color_schemes($prepend_inherit=false) {
		$list = array();
		$colors = charity_is_hope_storage_get('custom_colors');
		if (!empty($colors) && is_array($colors)) {
			foreach ($colors as $k=>$v) {
				$list[$k] = $v['title'];
			}
		}
		return $prepend_inherit ? charity_is_hope_array_merge(array('inherit' => esc_html__("Inherit", 'charity-is-hope')), $list) : $list;
	}
}

// Return scheme color
if (!function_exists('charity_is_hope_get_scheme_color')) {
	function charity_is_hope_get_scheme_color($clr_name='', $clr='') {
		if (empty($clr)) {
			$scheme = charity_is_hope_get_custom_option('body_scheme');
			if (empty($scheme) || charity_is_hope_storage_empty('custom_colors', $scheme)) $scheme = 'original';
			$clr = charity_is_hope_storage_get_array('custom_colors', $scheme, $clr_name);
		}
		return apply_filters('charity_is_hope_filter_get_scheme_color', $clr, $clr_name, $scheme);
	}
}

// Return scheme colors
if (!function_exists('charity_is_hope_get_scheme_colors')) {
	function charity_is_hope_get_scheme_colors($scheme='') {
		if (empty($scheme)) $scheme = charity_is_hope_get_custom_option('body_scheme');
		if (empty($scheme) || charity_is_hope_storage_empty('custom_colors', $scheme)) $scheme = 'original';
		return charity_is_hope_storage_get_array('custom_colors', $scheme);
	}
}
?>