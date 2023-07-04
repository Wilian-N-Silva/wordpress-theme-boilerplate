<?php

function create_custom_page($title)
{
  $isAlreadyCreated = get_page_by_title($title, 'OBJECT');

  if (!empty($isAlreadyCreated)) :
    return;
  endif;

  $post_details = array(
    'post_title'    => $title,
    'post_content'  => '',
    'post_status'   => 'publish',
    'post_author'   => 1,
    'post_type' => 'page'
  );
  wp_insert_post($post_details);
}

if (!function_exists('custom_theme_setup')) :
  function custom_theme_setup()
  {
    add_theme_support('post-thumbnails');

    create_custom_page('Home');

    $home = get_page_by_title('Home');
    update_option('page_on_front', $home->ID);
    update_option('show_on_front', 'page');

    if (!current_user_can('manage_options')) :
      show_admin_bar(false);
    endif;
  }
endif;

add_action('after_setup_theme', 'custom_theme_setup');
