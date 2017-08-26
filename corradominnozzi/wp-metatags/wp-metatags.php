<?php
/*
Plugin Name: WP Metatags
Description: A plugin that adds fields to insert meta tags.
Version: 1.0.0
Author: Minnozzi Corrado
Author URI: http://www.corradominnozzi.it
License: GPL2
*/

add_action("admin_menu", "add_menu_items_metatags");
add_action("add_meta_boxes", "add_metatags_form_fields");
add_action("wp_head", "show_metatags_homepage");
add_action("save_post", "save_metatags");
add_action("wp_head", "show_metatags");

//Aggiunge la voce nel menu
function add_menu_items_metatags()
{
    add_menu_page("WP Metatags Plugin", "WP Metatags", 0, "meta-tags", "metatags_form_fields_homepage");
}

function add_metatags_form_fields()
{
	add_meta_box('post_meta_tags', 'Add Metatags', 'metatags_form_fields', 'post', 'normal', 'default');
	add_meta_box('post_meta_tags', 'Add Metatags', 'metatags_form_fields', 'page', 'normal', 'default');
}

//Mostra i campi del form per inserire i metatags per l'homepage
function metatags_form_fields_homepage()
{
	if(isset($_POST['save']))
	{
		$homepage_id = get_option('page_on_front');
		$tags = get_post_meta($homepage_id, 'wp_post_meta_tags', true);
		
		update_post_meta($homepage_id, 'wp_post_meta_tags', array(
				'wp_post_meta_tag_title' => esc_attr($_POST['meta_tag_title_homepage']),
				'wp_post_meta_tag_description' => esc_attr($_POST['meta_tag_description_homepage']),
				'wp_post_meta_tag_keywords' => esc_attr($_POST['meta_tag_keywords_homepage'])
			));
	}
	
	$homepage_id = get_option('page_on_front');
	$tags = get_post_meta($homepage_id, 'wp_post_meta_tags', true);
	
	if(!$tags)
	{
		$tags = array();
	}
	
	$width = 600;
?>
	<div class="form-field"><h3>Add Metatags Homepage</h3></div>
	<form method="post" action="">
	<div class="form-field" style="width: <?php echo $width; ?>px;"><label>Title: </label> <input type="text" name="meta_tag_title_homepage" value="<?php echo esc_attr($tags['wp_post_meta_tag_title']); ?>"></div>
	<div class="form-field" style="width: <?php echo $width; ?>px;"><label>Description: </label> <textarea rows="10" name="meta_tag_description_homepage"><?php echo esc_attr($tags['wp_post_meta_tag_description']); ?></textarea></div>
	<div class="form-field" style="width: <?php echo $width; ?>px;"><label>Keywords: </label> <input type="text" name="meta_tag_keywords_homepage" value="<?php echo esc_attr($tags['wp_post_meta_tag_keywords']); ?>"></div>
	<br><div class="form-field"><input type="submit" value="Save" name="save"></div>
	</form>
<?php
}

//Mostra i metatags nell'homepage
function show_metatags_homepage()
{
	if(is_home())
	{
		$homepage_id = get_option('page_on_front');
		$tags = get_post_meta($homepage_id, 'wp_post_meta_tags', true);
		
		if (isset($tags) && is_array($tags))
		{
			if (isset($tags['wp_post_meta_tag_title']) && (esc_attr($tags['wp_post_meta_tag_title']) != ''))
			{
				echo '<meta name="title" content="'.esc_attr($tags['wp_post_meta_tag_title']).'" />'."\r\n";
			}
				
			if (isset($tags['wp_post_meta_tag_description']) && (esc_attr($tags['wp_post_meta_tag_description']) != ''))
			{
				echo '<meta name="description" content="'.esc_attr($tags['wp_post_meta_tag_description']).'" />'."\r\n";
			}
				
			if (isset($tags['wp_post_meta_tag_keywords']) && (esc_attr($tags['wp_post_meta_tag_keywords']) != ''))
			{
				echo '<meta name="keywords" content="'.esc_attr($tags['wp_post_meta_tag_keywords']).'" />'."\r\n";
			}
		}
	}
}

//Mostra i campi del form per inserire i metatags
function metatags_form_fields()
{
    global $post;
	$tags = get_post_meta($post->ID, 'wp_post_meta_tags', true);
	
	if(!$tags)
	{
		$tags = array();
	}
	
	$width = 600;
?>
	<div class="form-field" style="width: <?php echo $width; ?>px;"><label>Title: </label> <input type="text" name="meta_tag_title" value="<?php echo esc_attr($tags['wp_post_meta_tag_title']); ?>"></div>
	<div class="form-field" style="width: <?php echo $width; ?>px;"><label>Description: </label> <textarea rows="10" name="meta_tag_description"><?php echo esc_attr($tags['wp_post_meta_tag_description']); ?></textarea></div>
	<div class="form-field" style="width: <?php echo $width; ?>px;"><label>Keywords: </label> <input type="text" name="meta_tag_keywords" value="<?php echo esc_attr($tags['wp_post_meta_tag_keywords']); ?>"></div>
<?php
}

//Salva i metatags
function save_metatags()
{
	global $post;
	update_post_meta($post->ID, 'wp_post_meta_tags', array(
			'wp_post_meta_tag_title' => esc_attr($_POST['meta_tag_title']),
			'wp_post_meta_tag_description' => esc_attr($_POST['meta_tag_description']),
			'wp_post_meta_tag_keywords' => esc_attr($_POST['meta_tag_keywords'])
		));
}

//Mostra i metatags in pagina/post
function show_metatags()
{
	global $post;	
			
	if(is_single() || is_page())
	{
		$tags = get_post_meta($post->ID, 'wp_post_meta_tags', true);
			
		if (isset($tags) && is_array($tags))
		{
			if (isset($tags['wp_post_meta_tag_title']) && (esc_attr($tags['wp_post_meta_tag_title']) != ''))
			{
				echo '<meta name="title" content="'.esc_attr($tags['wp_post_meta_tag_title']).'" />'."\r\n";
			}
				
			if (isset($tags['wp_post_meta_tag_description']) && (esc_attr($tags['wp_post_meta_tag_description']) != ''))
			{
				echo '<meta name="description" content="'.esc_attr($tags['wp_post_meta_tag_description']).'" />'."\r\n";
			}
				
			if (isset($tags['wp_post_meta_tag_keywords']) && (esc_attr($tags['wp_post_meta_tag_keywords']) != ''))
			{
				echo '<meta name="keywords" content="'.esc_attr($tags['wp_post_meta_tag_keywords']).'" />'."\r\n";
			}
		}
	}
}
?>