<?php
if (!defined('Theme_ROOT_URL')) {
	define('Theme_ROOT_URL', get_template_directory_uri());
}

if (!defined('Theme_ROOT_PATH')) {
	define('Theme_ROOT_PATH', get_template_directory());
}

if (!defined('THEME_VERSION')) {
	define('THEME_VERSION', '1.2.6');
}

require_once Theme_ROOT_PATH . '/vendor/autoload.php';

function starter_theme_setup()
{
	load_theme_textdomain('starter-theme', get_template_directory() . '/languages');

	add_theme_support('automatic-feed-links');

	add_theme_support('title-tag');

	add_theme_support('post-thumbnails');

	register_nav_menus(
		array(
			'primary' => esc_html__('Primary', 'starter-theme'),
			'secondary' => esc_html__('Secondary', 'starter-theme'),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'starter_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	add_theme_support('customize-selective-refresh-widgets');

	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);

	add_theme_support('woocommerce');

	if(alm_get_option('product_gallery_zoom_enabled')){
		add_theme_support('wc-product-gallery-zoom');
	}

	if(alm_get_option('product_gallery_lightbox_enabled')){
		add_theme_support('wc-product-gallery-lightbox');
	}

	if(alm_get_option('product_gallery_slider_enabled')){
		add_theme_support('wc-product-gallery-slider');
	}
}

add_action('after_setup_theme', 'starter_theme_setup');


function starter_theme_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('وبلاگ', 'alma'),
			'id' => 'blog-sidebar',
			'description' => esc_html__('سایدبار وبلاگ را مشخص کنید.', 'alma'),
			'before_widget' => '<section id="%1$s" class="alm-widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('فروشگاه', 'alma'),
			'id' => 'shop-sidebar',
			'description' => esc_html__('سایدبار فروشگاه را مشخص کنید.', 'alma'),
			'before_widget' => '<section id="%1$s" class="alm-widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}

add_action('widgets_init', 'starter_theme_widgets_init');

function starter_theme_scripts()
{
	$upload_dir = wp_upload_dir();
	$baseurl = $upload_dir['baseurl'];
	$basedir = $upload_dir['basedir'];
	$css_path = $basedir . '/alm-custom-fonts.css';
	$css_url = $baseurl . '/alm-custom-fonts.css';

	if(file_exists($css_path)){
		wp_enqueue_style('alm-custom-fonts',$css_url);
	}

	wp_enqueue_style('starter-theme-style', get_stylesheet_uri(), array(), THEME_VERSION);
	wp_style_add_data('starter-theme-style', 'rtl', 'replace');

	wp_enqueue_style('alma',get_template_directory_uri(). '/css/alma.css',array(), THEME_VERSION);

	wp_register_script('init-jquery', trailingslashit(Theme_ROOT_URL) . 'js/init-jquery.js', array('jquery'), null, true);

    wp_enqueue_style('swiper', trailingslashit(Theme_ROOT_URL) . 'lib/swiper/swiper-bundle.min.css');
    wp_enqueue_script('swiper', trailingslashit(Theme_ROOT_URL) . 'lib/swiper/swiper-bundle.min.js', array('init-jquery'), null, true);

	wp_enqueue_script('alma', trailingslashit(Theme_ROOT_URL) . 'js/alma.js', array('init-jquery','swiper'), THEME_VERSION, true);
	wp_localize_script('alma','alma_obj',[
		'ajax_url'=>admin_url( 'admin-ajax.php' ),
		'security' => wp_create_nonce('alma-theme-nonce'),
		'newletter_security' => wp_create_nonce('alm-ajax-nonce'),
		'translations'=>[
			'remove_text'=>esc_html__('حذف %s','alma'),
			'upload_main_text'=>esc_html__('برای بارگذاری یک عکس را اینجا بکشید و رها کنید','alma'),
			'upload_avatar_condition'=>esc_html__('تصویر باید مربع و سایز 100 در 100 پیکسل باشد','alma'),
			'failed'=>esc_html__('دوباره تلاش کنید...','alma-core'),
		]
	]);

	wp_enqueue_script('starter-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), THEME_VERSION, true);

	wp_enqueue_script('feather-icons', trailingslashit(Theme_ROOT_URL) . 'lib/feather-icons/dist/feather.min.js');
    wp_enqueue_script('init-feather', trailingslashit(Theme_ROOT_URL) . 'js/init-feather.js', array('feather-icons'), null, true);

	wp_register_script('alma-el-init-swiper',get_template_directory_uri(). '/js/elementor-init-swiper.js',array('swiper'), null,true);


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'starter_theme_scripts');

require get_template_directory() . '/inc/custom-header.php';

require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/template-functions.php';

require get_template_directory() . '/inc/customizer.php';

if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

require_once get_template_directory() . '/inc/tgm/starter-activation.php';

//require_once get_template_directory() . '/inc/demo-data/import.php';

function wpdocs_create_blocks_mysite_block_init()
{

	register_block_type(trailingslashit(Theme_ROOT_PATH) . 'todo-list/build',
		array(
			'icon' => 'admin-home', /* omit 'dashicons-' prefix */
		));

}

add_action('init', 'wpdocs_create_blocks_mysite_block_init');

function alm_get_option($key, $opt_name = 'alma_options')
{
    return $GLOBALS[$opt_name][$key] ?? null;
}

function alm_breadcrumb($separator = '<i data-feather="chevron-left"></i>')
{

    // Settings
    $breadcrums_id = 'breadcrumbs';
    $breadcrums_class = 'alm-breadcrumb-list';
    $breadcrums_list_class = 'alm-breadcrumb-list-item';
    $home_title = __('صفحه اصلی', 'alma');

    global $post, $wp_query;

    if (!is_front_page()) {

        $list_items = [];

        $list_items[] = '<li class="' . $breadcrums_list_class . '"><a href="' . get_home_url() . '">' . $home_title . '</a></li>';

        if (is_home()) {
            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item">' . alm_get_option('blog_title') . '</span></li>';
        } else if (is_archive() && !is_tax() && !is_category() && !is_tag()) {

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item">' . post_type_archive_title('', false) . '</span></li>';

        } else if (is_archive() && is_tax() && !is_category() && !is_tag()) {

            $custom_tax_name = get_queried_object()->name;
            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item">' . $custom_tax_name . '</span></li>';

        } else if (is_single()) {

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item">' . get_the_title() . '</span></li>';

        } else if (is_category()) {
            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item">' . single_cat_title('', false) . '</span></li>';

        } else if (is_page()) {
            if ($post->post_parent) {

                $anc = get_post_ancestors($post->ID);

                $anc = array_reverse($anc);

                foreach ($anc as $ancestor) {
                    $list_items[] = '<li class="' . $breadcrums_list_class . ' item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                }


                $list_items[] = '<li class="' . $breadcrums_list_class . ' item-current item-' . $post->ID . '"><span class="alm-breadcrumb-current-item">' . get_the_title() . '</span></li>';

            } else {

                $list_items[] = '<li class="' . $breadcrums_list_class . ' item-current item-' . $post->ID . '"><span class="alm-breadcrumb-current-item">' . get_the_title() . '</span></li>';

            }

        } else if (is_tag()) {

            $term_id = get_query_var('tag_id');
            $taxonomy = 'post_tag';
            $args = 'include=' . $term_id;
            $terms = get_terms($taxonomy, $args);
            $get_term_id = $terms[0]->term_id;
            $get_term_slug = $terms[0]->slug;
            $get_term_name = $terms[0]->name;

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item">' . $get_term_name . '</span></li>';

        } elseif (is_day()) {

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</span></li>';

        } else if (is_month()) {

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</span></li>';

        } else if (is_year()) {

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</span></li>';

        } else if (is_author()) {

            global $author;
            $userdata = get_userdata($author);

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item">' . 'Author: ' . $userdata->display_name . '</span></li>';

        } else if (get_query_var('paged')) {

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">' . __('صفحه','pezeshkyar') . ' ' . get_query_var('paged') . '</span></li>';

        } else if (is_search()) {

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item bread-current bread-current-' . get_search_query() . '" title="' . esc_html__('نتایج جستجوی ', 'pezeshkyar') . get_search_query() . '">' . esc_html__('نتایج جستجوی ', 'pezeshkyar') . get_search_query() . '</span></li>';

        } elseif (is_404()) {

            $list_items[] = '<li class="' . $breadcrums_list_class . '"><span class="alm-breadcrumb-current-item">' . 'Error 404' . '</span></li>';
        }

        echo '<nav id="'.$breadcrums_id.'" class="' . $breadcrums_class . '"><ul>';

        echo implode("<li class='alm-breadcrumb-separator'>$separator</li>", $list_items);

        echo '</ul></nav>';

    }

}

function alm_elementor_enabled()
{
    return is_plugin_active('elementor/elementor.php');
}
function alm_wc_enabled()
{
    return is_plugin_active('woocommerce/woocommerce.php');
}
function alm_wc_wishlist_enabled()
{
    return is_plugin_active('ti-woocommerce-wishlist/ti-woocommerce-wishlist.php');
}

function alm_check_is_page_edited_by_elementor($page_id=null){
	if(!alm_wc_enabled()){
		return false;
	}
	if(is_null($page_id)){
		$page_id = get_the_ID();
	}
	$is_page_edited_by_elementor = get_post_meta($page_id, '_elementor_edit_mode', true);
	return (bool)$is_page_edited_by_elementor;
}

function alm_load_elementor_location($location)
{
    if (function_exists('elementor_theme_do_location') && elementor_theme_do_location($location)) {
        return elementor_theme_do_location($location);
    }
    return false;
}

function alm_load_elementor_template($template_id)
{
    $posts = get_posts([
        'post_type' => 'elementor_library',
        'p' => $template_id,
    ]);

    if ($posts && did_action('elementor/loaded')) {
        try{
			$frontend = \Elementor\Plugin::instance()->frontend;

            // Render the content
            echo $frontend->get_builder_content($template_id, true);

            // Enqueue scripts and styles if in editor mode
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                $frontend->enqueue_scripts(); // Enqueue frontend scripts
            }
        }catch(Exception $e){
            error_log(esc_html__('مشکلی در بارگذاری المنتور پیش آمده است','pezeshkyar'));
        }
    }
}

function alm_register_elementor_locations( $elementor_theme_manager ) {

	$elementor_theme_manager->register_all_core_location();

}
add_action( 'elementor/theme/register_locations', 'alm_register_elementor_locations' );

function alm_inline_styles(){
	$style = '';
	$css_root_variables = '';

	$content_width = alm_get_option('content_width');
	$inner_content_width = alm_get_option('inner_content_width');
	if($content_width){
		$css_root_variables .= "--alm-content-width: {$content_width}px;";
		$css_root_variables .= "--alm-inner-content-width: {$inner_content_width}px;";
	}

	if($css_root_variables){
		$style .= ":root{" . $css_root_variables . "}";
	}

	if($style){
		echo "<style>$style</style>";
	}
}
add_action('wp_head', 'alm_inline_styles');

function reorder_comment_fields($fields)
{
    $comment_field = $fields['comment']??null;
    $cookies_field = $fields['cookies']??null;

	unset($fields['url']);
    unset($fields['comment']);
    unset($fields['cookies']);

    !is_null($comment_field) && $fields['comment'] = $comment_field;
    !is_null($cookies_field) && $fields['cookies'] = $cookies_field;


    return $fields;
}

add_filter('comment_form_fields', 'reorder_comment_fields');

function wpse250243_comment_form_default_fields( $fields ) {
    $commenter     = wp_get_current_commenter();
    $user          = wp_get_current_user();
    $req           = get_option( 'require_name_email' );
    $aria_req      = ( $req ? " aria-required='true'" : '' );
    $html_req      = ( $req ? " required='required'" : '' );
    $html5         = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : false;
	$checked_attribute  = ( $html5 ? ' checked' : ' checked="checked"' );


	if(isset($fields['author'])){
		$fields['author'] = '<p class="comment-form-author">' . '<label for="author">' . __( 'نام', 'alma'  ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>';
	}

	if(isset($fields['email'])){
		$fields['email'] = '<p class="comment-form-email"><label for="email">' . __( 'آدرس ایمیل', 'alma'  ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>';
	}

	if(isset($fields['url'])){
		$fields['url'] = '<p class="comment-form-url"><label for="url">' . __( 'آدرس وب سایت', 'alma'  ) . '</label> ' .
                    '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>';
	}

	if ( isset($fields['cookies']) ) {
		$consent = empty( $commenter['comment_author_email'] ) ? '' : $checked_attribute;

		$fields['cookies'] = sprintf(
			'<p class="comment-form-cookies-consent">%s %s</p>',
			sprintf(
				'<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />',
				$consent
			),
			sprintf(
				'<label for="wp-comment-cookies-consent">%s</label>',
				__( 'Save my name, email, and website in this browser for the next time I comment.' )
			)
		);
	}

    return $fields;
}
add_filter( 'comment_form_default_fields', 'wpse250243_comment_form_default_fields' );

function wpse250243_comment_form_defaults( $defaults ) {
	$defaults[ 'comment_field' ] = '<p class="comment-form-comment"><label for="comment">' . __( 'پیام شما', 'alma' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea></p>';
    return $defaults;
}
add_filter( 'comment_form_defaults', 'wpse250243_comment_form_defaults', 10, 1 );


add_action( 'comment_form_before_fields' ,function(){
	echo "<div class='alm-comment-form-fields'>";
} );

add_action( 'comment_form_after_fields' ,function(){
	echo "</div>";
} );

function alm_comments_callback($comment, $args, $depth)
{
	$even_depth = $depth % 2 == 0;
    if ('div' === $args['style']) {
        $tag = 'div ';
        $add_below = 'comment';
    } else {
        $tag = 'li ';
        $add_below = 'div-comment';
    } ?>
    <<?php echo $tag; ?><?php comment_class($even_depth?'alm-pretty-comment':''); ?> id="comment-<?php comment_ID() ?>"><?php
    if ('div' != $args['style']) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
    } ?>
    <div class="comment-information">
        <div class="comment-author-image"><?php
            if ($args['avatar_size'] != 0) {
                echo get_avatar($comment, $args['avatar_size']);
            }
            ?>
        </div>
        <div class="comment-metas">

            <?php
            printf('<cite class="fn comment-author">%s</cite>', get_comment_author_link());
            ?>

            <div class="comment-meta commentmetadata">
                <?php esc_html_e('تاریخ:', 'pezeshkyar'); ?>
                <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php
                    /* translators: 1: date, 2: time */
                    printf(
                        '%1$s %2$s',
                        get_comment_date('Y/m/d'),
                        get_comment_time('H:i')
                    ); ?>
                </a>
            </div>

			<?php
			if ($comment->comment_approved == '0') { ?>
                <em class="comment-awaiting-moderation"><?php _e('دیدگاه شما در انتظار بررسی است.', 'alma'); ?></em>
                <?php
            }
			?>
        </div>

		<div class="comment-actions">
			<div class="reply">
                <?php
                comment_reply_link(
                    array_merge(
                        $args,
                        array(
                            'add_below' => $add_below,
                            'depth' => $depth,
                            'max_depth' => $args['max_depth'],
                        )
                    )
                );

                ?>
            </div>
			<?php edit_comment_link(__('ویرایش', 'alma'), '  ', '');?>
		</div>
    </div>

	<div class="comment-content"><?php comment_text(); ?></div>

    <?php
    if ('div' != $args['style']) : ?>
        </div><?php
    endif;
}

function add_svg_to_comment_reply_link($link) {
    // Define the SVG icon
    $svg_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
					<path d="M5.47363 13.7325H11.4736C13.5436 13.7325 15.2236 12.0525 15.2236 9.98254C15.2236 7.91254 13.5436 6.23254 11.4736 6.23254H3.22363" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M4.94832 8.10746L3.02832 6.18746L4.94832 4.26746" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>';

    // Find the position of the closing tag </a> and insert SVG before the text inside the link
    $link = preg_replace('/(<a[^>]*>)(.*)(<\/a>)/i', '$1$2 ' . $svg_icon . '$3', $link);

    return $link;
}
add_filter('comment_reply_link', 'add_svg_to_comment_reply_link');

function alm_change_categories_widget_count_display($output) {
    $output = preg_replace('/<\/a> \(([0-9]+)\)/', ' </a><span class="alm-category-posts-count">$1</span>', $output);
    return $output;
}
add_filter('wp_list_categories', 'alm_change_categories_widget_count_display');

function alm_ordering_form($sort_options,$current_order = null){
	if(is_null($current_order))
		$current_order = isset($_GET['order_by']) ? sanitize_text_field($_GET['order_by']) : '';
	?>
		<div class="alm-archive-sort">
			<form method="get" class="alm-archive-sort-form">
				<input type="hidden" name="paged" value="1"/>

				<?php if(is_search()):?>
					<input type="hidden" name="s" value="<?php echo get_search_query()?>"/>
				<?php endif;?>

				<button class="alm-archive-sort-button" type="button">
					<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
						<path d="M3.81055 7H21.8105" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round"/>
						<path d="M6.81055 12H18.8105" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round"/>
						<path d="M10.8105 17H14.8105" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round"/>
					</svg>
					<?php esc_html_e('مرتب سازی','alma')?>
				</button>
				<select name="order_by" class="alm-archive-sort-select">
					<?php foreach($sort_options as $index=>$option):?>
						<option value="<?php echo $index ?>" <?php selected($index,$current_order)?>><?php echo $option?></option>
					<?php endforeach;?>
				</select>
			</form>
		</div>
	<?php
}

/* wc-modifications */

add_filter('woocommerce_catalog_orderby',function($options){
	isset($options['menu_order']) && $options['menu_order'] = __('پیش‌فرض','alma-core');
	isset($options['popularity']) && $options['popularity'] = __('محبوب‌ترین','alma-core');
	isset($options['rating']) && $options['rating'] = __('بیشترین امتیاز','alma-core');
	isset($options['date']) && $options['date'] = __('جدیدترین','alma-core');
	isset($options['price']) && $options['price'] = __('ارزانترین','alma-core');
	isset($options['price-desc']) && $options['price-desc'] = __('گرانترین','alma-core');
	return $options;
});

function add_display_type_to_product_taxonomies() {
    $taxonomies = get_object_taxonomies('product', 'names');

    foreach ($taxonomies as $taxonomy) {
        add_action("{$taxonomy}_add_form_fields", 'alm_wc_add_taxonomy_display_type_field');
        add_action("{$taxonomy}_edit_form_fields", 'alm_wc_edit_taxonomy_display_type_field');
        add_action("created_{$taxonomy}", 'alm_wc_save_taxonomy_display_type_field');
        add_action("edited_{$taxonomy}", 'alm_wc_save_taxonomy_display_type_field');
    }
}

add_action('init', 'add_display_type_to_product_taxonomies', 999);

function alm_wc_get_archive_display_types(){
	return array(
		'type1' => esc_html__('Type 1','alma'),
		'type2' => esc_html__('Type 2','alma'),
		'type3' => esc_html__('Type 3','alma'),
		'type4' => esc_html__('Type 4','alma'),
		'type5' => esc_html__('Type 5','alma'),
	);
}

function alm_wc_add_taxonomy_display_type_field() {
	$options = alm_wc_get_archive_display_types();
    ?>
    <div class="form-field">
        <label for="cart_display_type"><?php _e('نحوه نمایش کارت محصولات', 'alma'); ?></label>
        <select name="cart_display_type" id="cart_display_type">
            <option value=""><?php _e('پیش فرض', 'alma'); ?></option>
			<?php foreach($options as $value=>$label):?>
				<option value="<?php echo $value?>"><?php echo $label; ?></option>
			<?php endforeach?>
        </select>
    </div>
    <?php
}

// Edit taxonomy field
function alm_wc_edit_taxonomy_display_type_field($term) {
    $display_type = get_term_meta($term->term_id, 'cart_display_type', true);
	$options = alm_wc_get_archive_display_types();
    ?>
    <tr class="form-field">
        <th scope="row"><label for="cart_display_type"><?php _e('نحوه نمایش کارت محصولات', 'alma'); ?></label></th>
        <td>
            <select name="cart_display_type" id="cart_display_type">
				<option value=""><?php _e('پیش فرض', 'alma'); ?></option>
				<?php foreach($options as $value=>$label):?>
					<option value="<?php echo $value?>" <?php selected($display_type, $value); ?>><?php echo $label; ?></option>
				<?php endforeach?>
            </select>
        </td>
    </tr>
    <?php
}

function alm_wc_save_taxonomy_display_type_field($term_id) {
    if (isset($_POST['cart_display_type']) && $_POST['cart_display_type']) {
        update_term_meta($term_id, 'cart_display_type', sanitize_text_field($_POST['cart_display_type']));
    }else{
		delete_term_meta($term_id,'cart_display_type');
	}
}


remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);


function alm_wc_before_archive_main(){
	echo "<div class='alm-product-archive-before-row'>";

	do_action('alm_wc_before_archive_main_content');

	echo "</div>";
}

add_action('alm_wc_before_archive_main_content','woocommerce_product_taxonomy_archive_header');
add_action('alm_wc_before_archive_main_content','woocommerce_catalog_ordering');

remove_action('woocommerce_shop_loop_header','woocommerce_product_taxonomy_archive_header');
remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);

remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5);
add_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_link_close',50);
add_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_link_open',5);
add_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_link_close',50);

remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash');
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5);

remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price');
add_action('woocommerce_after_shop_loop_item','alm_wc_add_open_product_sell_info',6);

add_action('woocommerce_after_shop_loop_item',function(){
	echo "<div class='alm-product-sell-info-actions'>";
},7);
add_action('woocommerce_after_shop_loop_item',function(){
	echo "</div>";
},12);

add_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_price',12);
add_action('woocommerce_after_shop_loop_item','alm_wc_add_close_product_sell_info',16);


function alm_wc_product_add_to_cart_text($product){
	$display_type = alm_wc_get_loop_display_type();

	$cart_content = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"><g id="vuesax/linear/bag-2"><g id="bag-2"><path id="Vector" d="M7.5 8.59304V7.62304C7.5 5.37304 9.31 3.16304 11.56 2.95304C14.24 2.69304 16.5 4.80304 16.5 7.43304V8.81304" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_2" d="M8.99999 22.923H15C19.02 22.923 19.74 21.313 19.95 19.353L20.7 13.353C20.97 10.913 20.27 8.92303 16 8.92303H7.99999C3.72999 8.92303 3.02999 10.913 3.29999 13.353L4.04999 19.353C4.25999 21.313 4.97999 22.923 8.99999 22.923Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_3" d="M15.4955 12.923H15.5045" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_4" d="M8.49451 12.923H8.50349" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g></g></svg>';

	if(in_array($display_type,['type2'])){
		$cart_content = '<span class="alm-add-to-cart-text">'.esc_html__('خرید کن','alma').'</span>';
		$cart_content .= '<svg xmlns="http://www.w3.org/2000/svg" width="34" height="28" viewBox="0 0 34 28" fill="none"><g id="Group 1"><g id="vuesax/linear/arrow-left"><g id="arrow-left"><path id="Vector" d="M22.3861 26.3384C28.8002 26.3384 34 20.9658 34 14.3384C34 7.71096 28.8002 2.33838 22.3861 2.33838C15.9719 2.33838 10.7722 7.71096 10.7722 14.3384C10.7722 20.9658 15.9719 26.3384 22.3861 26.3384Z" fill="white" fill-opacity="0.2"></path><path id="Vector_2" d="M14.1387 25.6717C20.6458 25.6717 25.9208 20.4484 25.9208 14.005C25.9208 7.56172 20.6458 2.33838 14.1387 2.33838C7.63154 2.33838 2.35648 7.56172 2.35648 14.005C2.35648 20.4484 7.63154 25.6717 14.1387 25.6717Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_3" d="M18.2624 14.0049H11.1931" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path id="Vector_4" d="M13.5495 10.5049L10.0148 14.0049L13.5495 17.5049" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></g></g></g></svg>';
	}

	return $cart_content;
	// return esc_html($product->add_to_cart_text());
}

add_action('wp','alm_wc_modifications');
function alm_wc_modifications(){
	if(alm_is_otp_enabled()){
		add_action('wp_logout',function (){
			wp_redirect( home_url() );
			exit();
		});
	}

	add_filter( 'body_class', function( $classes ) {
		global $wp;
		if(is_account_page() && isset($wp->query_vars['wishlist'])){
			return array_merge( $classes, array( 'alm-myaccount-wishlist' ) );
		}
		return $classes;
	} );

	$product_rate_meta_enabled = alm_get_option('product_rate_meta_enabled');
	if(!$product_rate_meta_enabled){
		remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating',10);
	}

	$products_display_type = alm_wc_get_loop_display_type();

	if(in_array($products_display_type,['type1','type3','type4'])){
		$show_add_to_wishlist = alm_get_option('show_add_to_wishlist_' . $products_display_type . '_archive_carts');
		add_action('woocommerce_after_shop_loop_item',function()use($show_add_to_wishlist){
			if(alm_wc_wishlist_enabled() && $show_add_to_wishlist){
				echo do_shortcode('[ti_wishlists_addtowishlist]');
			}
		},11);
	}


	switch($products_display_type){
		case 'type2':
			add_action('woocommerce_before_shop_loop_item_title','alm_wc_add_open_first_section_content',80);
			add_action('alm_wc_loop_end_first_section','alm_wc_add_close_first_section_content',5);

			add_action('woocommerce_shop_loop_item_title','alm_wc_loop_show_categories',60);
			break;
		case 'type3':
			add_action('woocommerce_before_shop_loop_item_title','alm_wc_show_gallery',65);
			add_action('woocommerce_shop_loop_item_title',function()use($products_display_type){
				alm_wc_show_properties($products_display_type);
			},60);
			break;
		case 'type4':
			break;
		case 'type5':
			add_action('woocommerce_after_shop_loop_item','alm_show_product_statistics',4);
			$show_add_to_wishlist = alm_get_option('show_add_to_wishlist_' . $products_display_type . '_archive_carts');
			if(alm_wc_wishlist_enabled() && $show_add_to_wishlist){
				add_action('woocommerce_before_shop_loop_item_title','alm_wc_product_images_over_wishlist',69);
			}
			break;
		default:
			// add_action('woocommerce_before_shop_loop_item','alm_wc_add_open_first_section',1);
			// add_action('woocommerce_shop_loop_item_title','alm_wc_add_close_first_section',1);
	}

	remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);
	if(alm_enabled_breadcrumb()){
		add_action('alm_wc_before_archive','woocommerce_breadcrumb');
		add_action('alm_wc_before_single','woocommerce_breadcrumb');
	}

	add_action('alm_wc_before_archive','alm_wc_before_archive_main');


	if(is_product()){
		remove_action('woocommerce_sidebar','woocommerce_get_sidebar');
	}


	// move to theme functions.php
	remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash',10);
	remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_images',20);

	add_action('woocommerce_single_product_summary',function(){
		echo "<div class='alm-single-product-content'>";
	},1);

	add_action('woocommerce_single_product_summary','woocommerce_show_product_images',2);

	add_action('woocommerce_single_product_summary',function(){
		echo "<div class='alm-single-product-introduction'>";
	},3);

	add_action('woocommerce_single_product_summary',function(){
		echo "</div></div><div class='alm-single-product-sell'>";
	},70);

	add_action('woocommerce_single_product_summary',function(){
		echo "<div class='alm-single-sell-info-section'>";
	},71);

	add_action('woocommerce_single_product_summary',function(){
		if(function_exists('alm_get_option') && function_exists('alm_wc_single_get_shipping_description')){
			$product_sell_info_shipping_enabled = alm_get_option('product_sell_info_shipping_enabled');
			if($product_sell_info_shipping_enabled && $shipping_description = alm_wc_single_get_shipping_description()){
				echo "<div class='alm-single-sell-info'>$shipping_description</div>";
			}
		};
	},72);

	add_action('woocommerce_single_product_summary',function(){
		global $product;

		$product_sell_info_stock_enabled = alm_get_option('product_sell_info_stock_enabled');
		if(!$product_sell_info_stock_enabled){
			return;
		}

		$is_in_stock = $product->is_in_stock();

		echo "<div class='alm-single-sell-info " . ($is_in_stock?'in_stock':'out_of_stock') . "'>";
		if($product->is_in_stock()){
			?>
				<svg class="alm-single-stock-image" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#0C1B43" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M7.75 12L10.58 14.83L16.25 9.17" stroke="#0C1B43" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<div class="alm-single-stock-title"><?php esc_html_e('موجود است','alma')?></div>
			<?php
		}else{
			?>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M9.17139 9.17157L14.8282 14.8284" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M9.17176 14.8284L14.8286 9.17157" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#373254" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<div class="alm-single-stock-title"><?php esc_html_e('ناموجود','alma')?></div>
			<?php
		}
		echo "</div>";

	},73);

	add_action('woocommerce_single_product_summary',function(){
		echo "</div>";
	},74);

	add_action('woocommerce_single_product_summary',function(){
		global $product;
		if($product->is_type( 'simple' )){
			echo "<div class='alm-single-simple-product-sell'>";
	}
	},74);


	remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing',50);
	remove_action('woocommerce_single_product_summary','C_Structured_Data::generate_product_data()',60);

	add_action('woocommerce_single_product_summary','woocommerce_template_single_meta',7);

	add_action('woocommerce_single_product_summary',function(){
		global $product;

		add_action('woocommerce_single_product_summary',function(){
			global $product;

			if(!$product->is_type( 'variable' )){
				$price_html = alm_wc_price_html($product);
				$currency = get_woocommerce_currency_symbol();
				if($price_html){
					?>
						<div class="woocommerce-variation-price">
							<div class='alm-product-price-box'>
								<div class='alm-product-price'>
									<?php echo $price_html;?>
								</div>
								<?php if(alm_wc_enable_show_currency($product)):?>
									<div class='alm-product-price-currency'>
										<?php echo $currency;?>
									</div>
								<?php endif;?>
							</div>
						</div>
					<?php
				}
			}else{
				?>
					<div class='woocommerce-variation-price alm-empty-price'></div>
				<?php
			}
		},74);

	},73);

	add_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',75);

	add_action('woocommerce_single_product_summary',function(){
		global $product;
		if($product->is_type( 'simple' )){
			echo "</div>";
		}
	},76);

	add_filter('woocommerce_available_variation', function ($variation_data, $product, $variation) {
		$regular_price = $variation->get_regular_price();
        $price = $variation->get_price();
		$currency = get_woocommerce_currency_symbol(get_woocommerce_currency());

		$show_currency = true;

		$price_html = '';

		if($price != $regular_price){
			$price_html .=  '<span class="regular-price">' . custom_wc_price_without_symbol($regular_price) . '</span>';
		}

		$price_text = custom_wc_price_without_symbol($price);
		if($price === '0' && $zero_price_text = alm_get_option('zero_price_text')){
			$price_text = $zero_price_text;
			if(!$regular_price ||  $regular_price === "0"){
				$show_currency =false;
			}
		}elseif(empty($price) && $price !== '0'){
			$show_currency = false;
			$price_text = alm_get_option('no_price_text');
		}
		$price_html .= '<span class="sale-price">' . $price_text . '</span>';

		if($price_html){
			$variation_data_price_html = <<<EOL
				<div class='alm-product-price-box'>
					<div class='alm-product-price'>
						$price_html
EOL;;
			if($show_currency){
				$variation_data_price_html .= <<<EOL
					</div>
					<div class='alm-product-price-currency'>
						$currency
					</div>
EOL;
			}
			$variation_data_price_html .= "</div>";
			$variation_data['price_html'] = $variation_data_price_html;
		}
		return $variation_data;
	}, 10, 3);

	add_action('woocommerce_single_product_summary',function(){
		echo "</div>";
	},100);

	add_filter( 'woocommerce_single_product_carousel_options', function ( $options ) {
		$options['directionNav'] = true;
		$options['nextText'] = '<svg width="40" height="34" viewBox="0 0 40 34" fill="none" xmlns="http://www.w3.org/2000/svg">
<g id="Group 44">
<g id="vuesax/linear/arrow-right">
<g id="arrow-right">
<path id="Vector" d="M25.9649 31.1667C18.2135 31.1667 11.9298 24.8241 11.9298 17.0001C11.9298 9.17604 18.2135 2.8334 25.9649 2.8334C33.7163 2.8334 40 9.17604 40 17.0001C40 24.8241 33.7163 31.1667 25.9649 31.1667Z" fill="#F5683C" fill-opacity="0.1"/>
<path id="Vector_2" d="M16.8419 31.1667C9.0905 31.1667 2.80678 24.8241 2.80678 17C2.80678 9.17601 9.0905 2.83337 16.8419 2.83337C24.5932 2.83337 30.877 9.17601 30.877 17C30.877 24.8241 24.5932 31.1667 16.8419 31.1667Z" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path id="Vector_3" d="M21.7544 17H13.3333" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path id="Vector_4" d="M16.1401 21.25L11.9296 17L16.1401 12.75" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</g>
</g>
</g>
</svg>';
		$options['prevText']='<svg width="41" height="34" viewBox="0 0 41 34" fill="none" xmlns="http://www.w3.org/2000/svg">
<g id="Group 11254">
<g id="vuesax/linear/arrow-right">
<g id="arrow-right">
<path id="Vector" d="M14.7917 31.1667C22.6157 31.1667 28.9583 24.8241 28.9583 17.0001C28.9583 9.17604 22.6157 2.8334 14.7917 2.8334C6.96763 2.8334 0.625 9.17604 0.625 17.0001C0.625 24.8241 6.96763 31.1667 14.7917 31.1667Z" fill="#F5683C" fill-opacity="0.2"/>
<path id="Vector_2" d="M24.0002 31.1667C31.8242 31.1667 38.1668 24.8241 38.1668 17.0001C38.1668 9.17604 31.8242 2.8334 24.0002 2.8334C16.1761 2.8334 9.8335 9.17604 9.8335 17.0001C9.8335 24.8241 16.1761 31.1667 24.0002 31.1667Z" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path id="Vector_3" d="M19.0415 17H27.5415" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path id="Vector_4" d="M24.7085 21.25L28.9585 17L24.7085 12.75" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</g>
</g>
</g>
</svg>';
		return $options;
	} );


}

add_action('alm_wc_loop_start_first_section','alm_wc_loop_show_discount',5);

add_action('alm_wc_loop_start_first_section','alm_wc_add_open_first_section');
add_action('alm_wc_loop_end_first_section','alm_wc_add_close_first_section');

add_action('alm_wc_loop_end_first_section','alm_wc_loop_divider',20);

add_action('alm_wc_loop_start_second_section','alm_wc_add_open_second_section');
add_action('alm_wc_loop_end_second_section','alm_wc_add_close_second_section');

add_action('alm_wc_loop_start_first_section','alm_wc_add_open_product_images',12);
add_action('woocommerce_before_shop_loop_item_title','alm_wc_add_close_product_images',70);

add_action('alm_wc_loop_start_first_section','alm_wc_add_open_product_main_image',14);
add_action('woocommerce_before_shop_loop_item_title','alm_wc_add_close_product_main_image',60);

function alm_wc_product_images_over_wishlist(){
	echo do_shortcode('[ti_wishlists_addtowishlist]');
}

/* product loop structure functions*/
function alm_wc_loop_show_discount(){
	global $product;
	$discount = alm_wc_discount_percentage($product);
	if($discount){
	?>
		<div class="alm-product-discount-percentage">
			<?php echo alm_wc_discount_percentage($product)?>
		</div>
	<?php
	}
}

function alm_wc_loop_show_categories(){
	echo wc_get_product_category_list(get_the_ID(), '','<div class="alm-product-category">','</div>');
}

function alm_wc_add_open_first_section(){
	echo "<div class='alm-product-first-section'>";
}
function alm_wc_add_close_first_section(){
	echo "</div>";
}

function alm_wc_add_open_second_section(){
	echo "<div class='alm-product-second-section'>";
}
function alm_wc_add_close_second_section(){
	echo "</div>";
}

function alm_wc_add_open_product_images(){
	echo "<div class='alm-product-images " . (alm_get_option('product_archive_images_full_size')?'alm-product-full-images':'') . "'>";
}
function alm_wc_add_close_product_images(){
	echo "</div>";
}

function alm_wc_add_open_product_main_image(){
	echo "<div class='alm-product-main-image'>";
}
function alm_wc_add_close_product_main_image(){
	echo "</div>";
}

function alm_wc_add_open_product_sell_info(){
	echo "<div class='alm-product-sell-info'>";
}
function alm_wc_add_close_product_sell_info(){
	echo "</div>";
}

function alm_wc_add_open_first_section_content(){
	echo "<div class='alm-product-first-section-content'>";
}
function alm_wc_add_close_first_section_content(){
	echo "</div>";
}

function alm_wc_loop_divider(){
	?>
	<div class="alm-divider">
		<div class="alm-divider-line"></div>
			<div class="alm-divider-logo-container">
				<svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none"><g id="christianity--religion-jesus-christianity-christ-fish-culture" opacity="0.5" clip-path="url(#clip0_396_12642)"><g id="christianity--religion-jesus-christianity-christ-fish-culture_2"><path id="Vector" d="M7.27922 11.5762C7.27922 11.5762 3.3304 8.43049 3.33041 4.71906C3.32553 3.83745 3.50725 2.97113 3.85553 2.21513C4.20382 1.45913 4.70524 0.842659 5.30481 0.433349C5.90438 0.842659 6.40581 1.45913 6.75409 2.21513C7.10238 2.97113 7.28406 3.83745 7.27922 4.71906C7.27922 8.43049 3.3304 11.5762 3.3304 11.5762" stroke="#8D8D8D" stroke-linecap="round" stroke-linejoin="round"></path></g></g><defs><clipPath id="clip0_396_12642"><rect width="12" height="9.2139" fill="white" transform="translate(9.9117 0.00488281) rotate(90)"></rect></clipPath></defs></svg>
			</div>
		<div class="alm-divider-line"></div>
	</div>
	<?php
}

function alm_wc_show_properties($archive_type="type3"){
	global $product;

	$allowed_attributes = alm_get_option("archive_product_{$archive_type}_attributes")??[];

	$all_attributes = wc_get_attribute_taxonomies();
	$all_product_attributes_list = [];
	foreach($all_attributes as $attribute){
		$all_product_attributes_list[$attribute->attribute_name]=$attribute->attribute_label;
	}

	$product_attributes_list = [];
	foreach($allowed_attributes as $allowed_attribute){
		if(isset($all_product_attributes_list[$allowed_attribute])){
			$product_attributes_list[$allowed_attribute]=$all_product_attributes_list[$allowed_attribute];
		}
	}

	if(count($product_attributes_list)>0){
		echo "<ul class='alm-product-attributes'>";
		foreach($product_attributes_list as $atrribute){
			$attribute_value = $product->get_attribute( "pa_$atrribute" );
			$attribute_label = alm_wc_product_get_attribute_label($atrribute);
			if($attribute_value){
				echo "<li class='alm-product-attribute'>" . esc_html($attribute_label) . " " .esc_html( $attribute_value )."</li>";
			}
		}
		echo "</ul>";
	}
}

function alm_wc_show_gallery(){
	global $product;
	$attachment_ids = $product->get_gallery_image_ids();
	$attachment_ids = array_slice($attachment_ids, 0, 3);

	if(count($attachment_ids)>0){
		?>
		<div class="alm-product-gallery-images">
			<?php foreach($attachment_ids as $attachment_id){?>
				<div class="alm-product-gallery-image"><?php echo wp_get_attachment_image($attachment_id);?></div>
			<?php }?>
		</div>
		<?php
	}
}

function alm_show_product_statistics(){
	global $product;
	?>
		<div class="alm-product-metas">
			<div class="alm-product-meta">
				<span class="alm-product-meta-name"><?php esc_html_e('فروش','alma')?></span>
				<span class="alm-product-meta-value"><?php echo alm_wc_get_total_sales(get_the_ID())?></span>
			</div>
			<div class="alm-product-meta-divider"></div>
			<div class="alm-product-meta">
				<span class="alm-product-meta-name"><?php esc_html_e('رضایت','alma')?></span>
				<span class="alm-product-meta-value"><?php echo alm_wc_product_rate_percentage()?></span>
			</div>
			<div class="alm-product-meta-divider"></div>
			<div class="alm-product-meta">
				<span class="alm-product-meta-name"><?php esc_html_e('موجودی','alma')?></span>
				<span class="alm-product-meta-value"><?php echo alm_wc_product_stock_quantity();?></span>
			</div>
		</div>
	<?php
}

/* product loop structure functions*/

add_filter('woocommerce_pagination_args','alm_wc_customize_pagination_links',20);

function alm_wc_customize_pagination_links($args){
	$args['prev_text'] = esc_html__('قبلی','alma');
	$args['next_text'] = esc_html__('بعدی','alma');
	return $args;
}

function alm_wc_get_loop_display_type(){
    if (is_product_taxonomy()) {
        $queried_object = get_queried_object();
        if ($queried_object && isset($queried_object->term_id)) {
            $display_type = get_term_meta($queried_object->term_id, 'cart_display_type', true);
            if (!empty($display_type)) {
                return esc_attr($display_type);
            }
        }
    }
	return esc_attr(alm_get_option('products_display_type')??'type1');
}

add_filter('woocommerce_breadcrumb_defaults', 'al_wc_customize_breadcrumb');
function al_wc_customize_breadcrumb($defaults)
{
    // Change the breadcrumb delimeter from '/' to '>'
    $defaults['delimiter'] = '<li class="alm-breadcrumb-separator"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg></li>';
    $defaults['wrap_before'] = '<nav class="alm-breadcrumb-list"><ul>';
    $defaults['wrap_after'] = '</nav></ul>';
    $defaults['before'] = '<li class="alm-breadcrumb-list-item">';
    $defaults['after'] = '</li>';
    return $defaults;
}

add_filter('woocommerce_product_description_heading',function($heading){
	$heading = __('توضیحات','alma');
	return $heading;
},20);

add_filter('woocommerce_product_description_tab_title',function($title,$key){
	$title = __('توضیحات','alma');
	return $title;
},20,2);

add_filter('woocommerce_product_additional_information_heading',function($heading){
	$heading = __('مشخصات','alma');
	return $heading;
},20);

add_filter('woocommerce_product_additional_information_tab_title',function($title,$key){
	$title = __('مشخصات','alma');
	return $title;
},20,2);

add_filter('woocommerce_product_reviews_tab_title',function($title,$key){
	$title = __('نظرات کاربران','alma');
	return $title;
},20,2);

remove_action('woocommerce_review_before','woocommerce_review_display_gravatar');

add_action('woocommerce_review_meta','alm_wc_open_comment_information',5);

add_action('woocommerce_review_meta','alm_wc_open_comment_author_image_wrapper',6);
add_action('woocommerce_review_meta','woocommerce_review_display_gravatar',6);
add_action('woocommerce_review_meta','alm_wc_close_comment_author_image_wrapper',6);


add_action('woocommerce_review_meta','alm_wc_open_comment_meta_wrapper',8);

remove_action('woocommerce_review_before_comment_meta','woocommerce_review_display_rating');
add_action('woocommerce_review_meta','woocommerce_review_display_rating',12);
add_action('woocommerce_review_meta','alm_wc_close_comment_meta_wrapper',14);

add_action('woocommerce_review_meta','alm_wc_comment_review_actions',15);

add_action('woocommerce_review_meta','alm_wc_close_comment_information',16);

add_filter('woocommerce_review_gravatar_size','alm_wc_customize_review_gravatar_size',20);

function alm_wc_comment_review_actions(){
	?>
		<div class="comment-actions">
			<div class="reply">
                <?php
                comment_reply_link(

                );

                ?>
            </div>
			<?php edit_comment_link(__('ویرایش', 'alma'), '  ', '');?>
		</div>
	<?php
}

function alm_wc_customize_review_gravatar_size($size){
	return 57;
}

function alm_wc_open_comment_information(){
	echo "<div class='comment-information'>";
}

function alm_wc_close_comment_information(){
	echo "</div>";
}

function alm_wc_open_comment_author_image_wrapper(){
	echo "<div class='comment-author-image'>";
}
function alm_wc_close_comment_author_image_wrapper(){
	echo "</div>";
}

function alm_wc_open_comment_meta_wrapper(){
	echo "<div class='alm-product-review-meta-wrapper'>";
}

function alm_wc_close_comment_meta_wrapper(){
	echo "</div>";
}

add_filter('woocommerce_product_review_comment_form_args','alm_wc_customize_product_review_comment_form_args',20);
function alm_wc_customize_product_review_comment_form_args($comment_form){
	$comment_form['comment_field'] = '';
	$comment_field = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

	$submit_button_icon = '<svg width="35" height="28" viewBox="0 0 35 28" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path d="M22.5973 26.3384C29.0114 26.3384 34.2111 20.9658 34.2111 14.3384C34.2111 7.71096 29.0114 2.33838 22.5973 2.33838C16.1831 2.33838 10.9834 7.71096 10.9834 14.3384C10.9834 20.9658 16.1831 26.3384 22.5973 26.3384Z" fill="white" fill-opacity="0.2"/>
	<path d="M14.3496 25.6717C20.8567 25.6717 26.1317 20.4484 26.1317 14.005C26.1317 7.56172 20.8567 2.33838 14.3496 2.33838C7.84244 2.33838 2.56738 7.56172 2.56738 14.005C2.56738 20.4484 7.84244 25.6717 14.3496 25.6717Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
	<path d="M18.4736 14.0049H11.4043" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
	<path d="M13.7602 10.5049L10.2256 14.0049L13.7602 17.5049" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
	</svg>
	';

	$rating_field = '';
	if ( wc_review_ratings_enabled() ) {
		$rating_field = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
			<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
			<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
			<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
			<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
			<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
			<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
		</select></div>';
	}

	$comment_form['submit_button'] = '<span class="alm-submit-button"><input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />' . $submit_button_icon . '</span>';

	$comment_form['submit_field'] = '<div class="comment-field-wrapper">'.$comment_field.'<div class="form-submit">%1$s %2$s</div></div>' . $rating_field;


	return $comment_form;
}

add_filter('woocommerce_output_related_products_args','alm_wc_customize_output_related_products_args');
function alm_wc_customize_output_related_products_args($args){
	$args['posts_per_page']=5;
	return $args;
}

add_action('woocommerce_before_cart',function(){
	echo "<div class='alm-wc-classic-cart'>";
});

add_action('woocommerce_after_cart',function(){
	echo "</div>";
});

/* MyAccount Hook */
add_action('woocommerce_before_account_navigation', function () {
	$current_user = wp_get_current_user();
	?>
	<div class='alm-navigation-card'>
		<div class='alm-navigation-card-header'>
			<div class='alm-user-information'>
				<div class='alm-user-avatar'><?php echo get_avatar($current_user->ID);?></div>
				<div class='alm-user-title'><?php echo $current_user->display_name;?></div>
			</div>
		</div>
	<?php
});

add_action('woocommerce_after_account_navigation', function () {
	?>
		<button class='alm-close-navigation-modal'>
			<svg xmlns="http://www.w3.org/2000/svg" width="34" height="35" viewBox="0 0 34 35" fill="none">
				<path d="M12.728 21.7132L21.2133 13.2279" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
				<path d="M21.2133 21.7132L12.728 13.2279" stroke="#F5683C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>
		</button>
	</div>
	<?php
});

add_action('woocommerce_account_content', function () {
	?>
	<button class='alm-toggle-navigation'>
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
	</button>
	<?php
}, 9);

add_action('woocommerce_account_dashboard',function(){
	$statuses = [
		'wc-completed'=>[
			'title'=>esc_html__('سفارش تکمیل شده','alma'),
			'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M9.62012 16L11.1201 17.5L14.3701 14.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M8.81043 2L5.19043 5.63" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M15.1904 2L18.8104 5.63" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M2 7.85C2 6 2.99 5.85 4.22 5.85H19.78C21.01 5.85 22 6 22 7.85C22 10 21.01 9.85 19.78 9.85H4.22C2.99 9.85 2 10 2 7.85Z" stroke="white" stroke-width="1.5"/>
  <path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H14.89C18 22 18.46 20.64 18.82 18.76L20.5 10" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
</svg>',
		],
		'wc-pending'=>[
			'title'=>esc_html__('سفارش درانتظار پرداخت','alma'),
			'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M12 19C14.2091 19 16 17.2091 16 15C16 12.7909 14.2091 11 12 11C9.79086 11 8 12.7909 8 15C8 17.2091 9.79086 19 12 19Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M12.25 13.75V14.68C12.25 15.03 12.07 15.36 11.76 15.54L11 16" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M8.99983 22H14.9998C19.0198 22 19.7398 20.39 19.9498 18.43L20.6998 12.43C20.9698 9.99 20.2698 8 15.9998 8H7.99983C3.72983 8 3.02983 9.99 3.29983 12.43L4.04983 18.43C4.25983 20.39 4.97983 22 8.99983 22Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M7.5 7.67V6.7C7.5 4.45 9.31 2.24 11.56 2.03C14.24 1.77 16.5 3.88 16.5 6.51V7.89" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
</svg>'
		],
		'wc-processing'=>[
			'title'=>esc_html__('سفارش درحال انجام','alma'),
			'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M16.8203 2H7.18031C5.05031 2 3.32031 3.74 3.32031 5.86V19.95C3.32031 21.75 4.61031 22.51 6.19031 21.64L11.0703 18.93C11.5903 18.64 12.4303 18.64 12.9403 18.93L17.8203 21.64C19.4003 22.52 20.6903 21.76 20.6903 19.95V5.86C20.6803 3.74 18.9503 2 16.8203 2Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M9.58984 11L11.0898 12.5L15.0898 8.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>'
		],
		'wc-on-hold'=>[
			'title'=>esc_html__('سفارش درانتظار بررسی','alma'),
			'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M8.81043 2L5.19043 5.63" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M15.1904 2L18.8104 5.63" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M2 7.85C2 6 2.99 5.85 4.22 5.85H19.78C21.01 5.85 22 6 22 7.85C22 10 21.01 9.85 19.78 9.85H4.22C2.99 9.85 2 10 2 7.85Z" stroke="white" stroke-width="1.5"/>
  <path d="M9.75977 14V17.55" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
  <path d="M14.3604 14V17.55" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
  <path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H14.89C18 22 18.46 20.64 18.82 18.76L20.5 10" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
</svg>'
		],
		'wc-cancelled'=>[
			'title'=>esc_html__('سفارش لغو شده','alma'),
			'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M13.3896 17.36L10.6396 14.61" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M13.3604 14.64L10.6104 17.39" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M8.81043 2L5.19043 5.63" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M15.1904 2L18.8104 5.63" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M2 7.85C2 6 2.99 5.85 4.22 5.85H19.78C21.01 5.85 22 6 22 7.85C22 10 21.01 9.85 19.78 9.85H4.22C2.99 9.85 2 10 2 7.85Z" stroke="white" stroke-width="1.5"/>
  <path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H14.89C18 22 18.46 20.64 18.82 18.76L20.5 10" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
</svg>'
		],
	];

	$statuses = apply_filters('alm_woocommerce_account_order_statuses',$statuses);
	$valid_statuses = array_keys(wc_get_order_statuses());
	$user = wp_get_current_user();
	echo "<div class='alm-account-dashboard-orders'>";
	foreach($statuses as $index=>$status){
		if(!in_array($index,$valid_statuses)){
			continue;
		}
		$args = array(
			'customer_id' => $user->ID,
			'post_status' => $index,
			'post_type' => 'shop_order',
			'return' => 'ids',
		);
		$count = count(wc_get_orders($args));
		echo "<div class='alm-account-dashboard-order alm-account-dashboard-orders-$index'>";
		if(isset($status['icon'])){
			echo "<span class='alm-account-dashboard-order-icon'>" . alm_safe_svg($status['icon']) ."</span>";
		}
		echo "<span class='alm-account-dashboard-order-count'>$count</span>" ;
		if(isset($status['title'])){
			echo "<span class='alm-account-dashboard-order-title'>" . esc_html($status['title']) ."</span>";
		}
		echo "</div>";
	}
	echo "</div>";
});

add_action('woocommerce_account_dashboard',function(){
	$user = wp_get_current_user();
	$user_email = $user->user_email;
	$user_registered = $user->user_registered;
	if($user_registered){
		$user_registered = date_i18n( 'Y/m/d', strtotime($user_registered));
	}
	$user_id = $user->ID;
	$user_info = get_userdata($user_id);
	$first_name = $user_info->first_name;
	$last_name = $user_info->last_name;
	$full_name = "$first_name $last_name";
	$phone_number = get_user_meta($user_id,'billing_phone',true);
	$postcode = get_user_meta( $user_id, 'billing_postcode', true );
	$city = get_user_meta( $user_id, 'billing_city', true );

	$address_1 = get_user_meta( $user_id, 'billing_address_1', true );
	$address_2 = get_user_meta( $user_id, 'billing_address_2', true );
	$address = "$address_1 $address_2";

	?>
	<div class="alm-account-information-wrapper">
		<div class="alm-account-information-header">
			<h2 class="alm-account-information-title"><?php esc_html_e('اطلاعات شخصی','alma')?></h2>
			<a href="<?php echo wc_customer_edit_account_url()?>" class="alm-account-information-link alm-account-information-edit-link">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
					<path opacity="0.4" d="M10.3197 2H5.01301C2.71301 2 1.33301 3.37333 1.33301 5.68V10.98C1.33301 13.2933 2.71301 14.6667 5.01301 14.6667H10.313C12.6197 14.6667 13.993 13.2933 13.993 10.9867V5.68C13.9997 3.37333 12.6197 2 10.3197 2Z" fill="#E76941"/>
					<path d="M14.013 1.98666C12.8197 0.786665 11.653 0.759998 10.4263 1.98666L9.67299 2.73333C9.60632 2.8 9.58632 2.89333 9.61299 2.98C10.0797 4.61333 11.3863 5.92 13.0197 6.38666C13.0397 6.39333 13.073 6.39333 13.093 6.39333C13.1597 6.39333 13.2263 6.36666 13.273 6.32L14.013 5.57333C14.6197 4.96666 14.9197 4.38666 14.9197 3.79333C14.9197 3.19333 14.6197 2.6 14.013 1.98666Z" fill="#E76941"/>
					<path d="M11.9071 6.94667C11.7271 6.86 11.5537 6.77333 11.3937 6.67333C11.2604 6.59333 11.1271 6.50667 11.0004 6.41333C10.8937 6.34667 10.7737 6.24667 10.6537 6.14667C10.6404 6.14 10.6004 6.10667 10.5471 6.05333C10.3404 5.88667 10.1204 5.66 9.91373 5.41333C9.90039 5.4 9.86039 5.36 9.82706 5.3C9.76039 5.22667 9.66039 5.1 9.57373 4.96C9.50039 4.86667 9.41373 4.73333 9.33373 4.59333C9.23373 4.42667 9.14706 4.26 9.06706 4.08667C8.98039 3.9 8.91373 3.72667 8.85373 3.56L5.26706 7.14667C5.03373 7.38 4.80706 7.82 4.76039 8.14667L4.47373 10.1333C4.41373 10.5533 4.52706 10.9467 4.78706 11.2067C5.00706 11.4267 5.30706 11.54 5.64039 11.54C5.71373 11.54 5.78706 11.5333 5.86039 11.5267L7.84039 11.2467C8.16706 11.2 8.60706 10.98 8.84039 10.74L12.4271 7.15333C12.2604 7.1 12.0937 7.02667 11.9071 6.94667Z" fill="#E76941"/>
				</svg>
				<?php esc_html_e('ویرایش اطلاعات','alma')?>
			</a>
		</div>
		<div class="alm-account-information">
			<div class="alm-account-information-item alm-account-information-text">
				<span class="alm-account-information-item-label-divider">
					<span class="alm-account-information-item-label"><?php esc_html_e('نام و نام خانوادگی','alma')?></span>
					<span class="alm-account-information-item-divider"></span>
				</span>
				<span class="alm-account-information-item-value"><?php echo $full_name;?></span>
			</div>
			<div class="alm-account-information-item alm-account-information-text">
				<span class="alm-account-information-item-label-divider">
					<span class="alm-account-information-item-label"><?php esc_html_e('شماره موبایل','alma')?></span>
					<span class="alm-account-information-item-divider"></span>
				</span>
				<span class="alm-account-information-item-value"><?php echo $phone_number?></span>
			</div>
			<div class="alm-account-information-item alm-account-information-text">
				<span class="alm-account-information-item-label-divider">
					<span class="alm-account-information-item-label"><?php esc_html_e('ایمیل','alma')?></span>
					<span class="alm-account-information-item-divider"></span>
				</span>
				<span class="alm-account-information-item-value"><?php echo $user_email;?></span>
			</div>
			<div class="alm-account-information-item alm-account-information-text">
				<span class="alm-account-information-item-label-divider">
					<span class="alm-account-information-item-label"><?php esc_html_e('عضویت','alma')?></span>
					<span class="alm-account-information-item-divider"></span>
				</span>
				<span class="alm-account-information-item-value"><?php echo date( "Y/m/d", strtotime( $user_registered ) );?></span>
			</div>
			<div class="alm-account-information-item alm-account-information-text">
				<span class="alm-account-information-item-label-divider">
					<span class="alm-account-information-item-label"><?php esc_html_e('شهر','alma')?></span>
					<span class="alm-account-information-item-divider"></span>
				</span>
				<span class="alm-account-information-item-value"><?php echo $city;?></span>
			</div>
			<div class="alm-account-information-item alm-account-information-text">
				<span class="alm-account-information-item-label-divider">
					<span class="alm-account-information-item-label"><?php esc_html_e('کدپستی','alma')?></span>
					<span class="alm-account-information-item-divider"></span>
				</span>
				<span class="alm-account-information-item-value"><?php echo $postcode?></span>
			</div>
			<div class="alm-account-information-item alm-account-information-textarea">
				<span class="alm-account-information-item-label-divider">
					<span class="alm-account-information-item-label"><?php esc_html_e('آدرس','alma')?></span>
					<span class="alm-account-information-item-divider"></span>
				</span>
				<span class="alm-account-information-item-value"><?php echo $address?></span>
			</div>
		</div>
	</div>
	<?php
});

add_filter( 'woocommerce_form_field_args', function($args, $key, $value){
	$field_class = 'alm-woocommerce-form-field';
	$full_form_fields = [
		'billing_address_1',
		'billing_address_2',
		'shipping_address_1',
		'shipping_address_2'
	];
	if(in_array($key,$full_form_fields)){
		$field_class .= " alm-woocommerce-full-form-field";
	}
	$args['class'] = $field_class;
	return $args;
},10,3 );

add_filter('alm_woocommerce_account_menu_item_icon',function($icons){
	$icons['tickets'] = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <path d="M2.75195 1.875V10.8525C2.75195 11.5875 3.09695 12.285 3.68945 12.7275L7.59695 15.6525C8.42945 16.275 9.57695 16.275 10.4094 15.6525L14.3169 12.7275C14.9094 12.285 15.2544 11.5875 15.2544 10.8525V1.875H2.75195Z" stroke="white" stroke-miterlimit="10"/>
  <path d="M1.5 1.875H16.5" stroke="white" stroke-miterlimit="10" stroke-linecap="round"/>
  <path d="M6 6H12" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M6 9.75H12" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
</svg>';
	$icons['wishlist']='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
  <path d="M8.465 14.6075C8.21 14.6975 7.79 14.6975 7.535 14.6075C5.36 13.865 0.5 10.7675 0.5 5.51745C0.5 3.19995 2.3675 1.32495 4.67 1.32495C6.035 1.32495 7.2425 1.98495 8 3.00495C8.7575 1.98495 9.9725 1.32495 11.33 1.32495C13.6325 1.32495 15.5 3.19995 15.5 5.51745C15.5 10.7675 10.64 13.865 8.465 14.6075Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
</svg>';
	return $icons;
});

remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
add_action('alm_woocommerce_after_checkout_row','woocommerce_checkout_payment');


// remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form' );
// add_action('alm_woocommerce_before_checkout_form','woocommerce_checkout_coupon_form');

function alm_wc_print_buy_process($step='cart'){
	?>
	<div class="alm-woocommerce-buy-process">
	<a class="alm-woocommerce-step <?php echo $step=='cart'?'alm-woocommerce-current-step':'';?>" href="<?php echo wc_get_cart_url()?>">
		<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
			<path d="M9.30945 2L5.68945 5.63" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M15.6895 2L19.3095 5.63" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M2.5 7.84998C2.5 5.99998 3.49 5.84998 4.72 5.84998H20.28C21.51 5.84998 22.5 5.99998 22.5 7.84998C22.5 9.99998 21.51 9.84998 20.28 9.84998H4.72C3.49 9.84998 2.5 9.99998 2.5 7.84998Z" stroke="white" stroke-width="1.5"/>
			<path d="M10.2598 14V17.55" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
			<path d="M14.8594 14V17.55" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
			<path d="M4 10L5.41 18.64C5.73 20.58 6.5 22 9.36 22H15.39C18.5 22 18.96 20.64 19.32 18.76L21 10" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
		</svg>
		<?php esc_html_e('سبدخرید','alma')?>
	</a>
	<a class="alm-woocommerce-step <?php echo $step=='checkout'?'alm-woocommerce-current-step':'';?>" href="<?php echo wc_get_checkout_url()?>">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
			<path d="M9.25 9.05005C11.03 9.70005 12.97 9.70005 14.75 9.05005" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M16.8203 2H7.18031C5.05031 2 3.32031 3.74 3.32031 5.86V19.95C3.32031 21.75 4.61031 22.51 6.19031 21.64L11.0703 18.93C11.5903 18.64 12.4303 18.64 12.9403 18.93L17.8203 21.64C19.4003 22.52 20.6903 21.76 20.6903 19.95V5.86C20.6803 3.74 18.9503 2 16.8203 2Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M16.8203 2H7.18031C5.05031 2 3.32031 3.74 3.32031 5.86V19.95C3.32031 21.75 4.61031 22.51 6.19031 21.64L11.0703 18.93C11.5903 18.64 12.4303 18.64 12.9403 18.93L17.8203 21.64C19.4003 22.52 20.6903 21.76 20.6903 19.95V5.86C20.6803 3.74 18.9503 2 16.8203 2Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
		<?php esc_html_e('جزئیات پرداخت','alma')?>
	</a>
	<a class="alm-woocommerce-step" href="#">
		<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
			<path d="M2.5 12.61H19.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M19.5 10.28V17.43C19.47 20.28 18.69 21 15.72 21H6.28003C3.26003 21 2.5 20.2501 2.5 17.2701V10.28C2.5 7.58005 3.13 6.71005 5.5 6.57005C5.74 6.56005 6.00003 6.55005 6.28003 6.55005H15.72C18.74 6.55005 19.5 7.30005 19.5 10.28Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M22.5 6.73V13.72C22.5 16.42 21.87 17.29 19.5 17.43V10.28C19.5 7.3 18.74 6.55 15.72 6.55H6.28003C6.00003 6.55 5.74 6.56 5.5 6.57C5.53 3.72 6.31003 3 9.28003 3H18.72C21.74 3 22.5 3.75 22.5 6.73Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M5.75 17.8101H7.46997" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M9.60938 17.8101H13.0494" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
		<?php esc_html_e('تکمیل سفارش','alma')?>
	</a>
</div>

	<?php
}

add_action('woocommerce_before_checkout_form',function(){
	alm_wc_print_buy_process('checkout');
},1);

add_action('woocommerce_before_cart',function(){
	alm_wc_print_buy_process('cart');
},1);

add_filter('woocommerce_thankyou_order_received_text',function($message,$order){
	$icon = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
  <path opacity="0.4" d="M14.6124 2.74666L7.27909 5.49333C5.87909 6.02666 4.73242 7.68 4.73242 9.18666V19.9867C4.73242 21.0667 5.43909 22.4933 6.30576 23.1333L13.6391 28.6133C14.9324 29.5867 17.0524 29.5867 18.3458 28.6133L25.6791 23.1333C26.5458 22.48 27.2524 21.0667 27.2524 19.9867V9.18666C27.2524 7.69333 26.1058 6.02666 24.7058 5.50666L17.3724 2.76C16.6258 2.46666 15.3724 2.46666 14.6124 2.74666Z" fill="#373254"/>
  <path d="M14.2136 18.9733C13.9603 18.9733 13.707 18.88 13.507 18.68L11.3603 16.5333C10.9736 16.1467 10.9736 15.5067 11.3603 15.12C11.747 14.7333 12.387 14.7333 12.7736 15.12L14.2136 16.56L19.2403 11.5333C19.627 11.1467 20.267 11.1467 20.6536 11.5333C21.0403 11.92 21.0403 12.56 20.6536 12.9467L14.9203 18.68C14.7203 18.88 14.467 18.9733 14.2136 18.9733Z" fill="#373254"/>
</svg>';
	return $icon . $message;
},10,2);

add_action('woocommerce_order_details_after_customer_details', function () {
	echo "<div class='alm-woocommerce-order-details-buttons'><a class='button alm-woocommerce-order-details-return' href='" . home_url() . "'>" . __("بازگشت به صفحه اصلی", "alma") . "</a></div>";
});

add_action('woocommerce_before_lost_password_form',function(){
	echo "<div id='alm-lost-password' class='u-columns col2-set'><div class='u-column2'>";
});
add_action('woocommerce_after_lost_password_form',function(){
	echo "</div></div>";
});
add_action('woocommerce_before_reset_password_form',function(){
	echo "<div id='alm-reset-password' class='u-columns col2-set'><div class='u-column2'>";
});
add_action('woocommerce_after_reset_password_form',function(){
	echo "</div></div>";
});


/* wc-modifications */

/* edit-account */
add_action('woocommerce_edit_account_form_tag','alm_add_enctype_edit_account_form');

function alm_add_enctype_edit_account_form(){
    echo 'enctype="multipart/form-data"';
}

add_action( 'woocommerce_edit_account_form_start','alm_add_profile_image' );

function abstractFilename($filename, $maxLength = 15) {
    if (strlen($filename) <= $maxLength) return $filename;

    $extIndex = strrpos($filename, ".");
    $namePart = substr($filename, 0, $extIndex);
    $extension = substr($filename, $extIndex);

    $visibleChars = floor(($maxLength - 3) / 2);
    return substr($namePart, 0, $visibleChars) . "..." . substr($namePart, -$visibleChars) . $extension;
}

function alm_add_profile_image(){
	$user_id = get_current_user_id();
    $image = get_user_meta($user_id, 'profile_image', true);

    ?>
    <div class="alm-img-field">
		<p class="alm-img-field-title"><?php esc_html_e( 'عکس پروفایل', 'alma' ); ?></p>
		<div class="alm-img-field-preview">
			<label>
				<input type="file" class="alm-img-field-input" name="profile_image" id="profile_image" accept="image/*" />
				<div class="alm-img-field-preview-items">
					<?php if($image){?>
						<?php
							$filename = basename($image);
							$filename = abstractFilename($filename);
							$remove_text = sprintf(esc_html__('حذف %s','alma'), $filename);
						?>
						<div class="alm-img-field-preview-item">
							<?php echo '<img src="' . esc_url($image) . '" style="max-width: 100px; height: auto;" />';?>
							<button class="alm-img-field-remove-button"><?php echo $remove_text;?></button>
						</div>
					<?php }else{?>
						<div class="alm-img-field-upload-button">
							<h3 class="alm-upload-main-text"><?php esc_html_e('برای بارگذاری یک عکس را اینجا بکشید و رها کنید','alma')?></h3>
							<h4 class="alm-upload-avatar-condition"><?php esc_html_e('تصویر باید مربع و سایز 100 در 100 پیکسل باشد','alma')?></h4>
						</div>
					<?php }?>
				</div>
				<input type='checkbox' name="use_default_avatar">
				<input type='checkbox' name="keep_avatar" checked>
			</label>
		</div>
	</div>
    <?php
}
function save_account_details_custom( $user_id ) {

	if(!isset($_POST['keep_avatar'])){
		if(isset($_POST['use_default_avatar'])){
			delete_user_meta( $user_id, 'profile_image');
		}elseif ( isset( $_FILES['profile_image'] ) ) {

			if ( !is_user_logged_in() || !current_user_can( 'edit_user', $user_id ) ) {
				wp_die( 'You do not have permission to upload files.' );
			}

			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );

			// Define allowed mime types
			$allowed_mime_types = array('image/jpeg', 'image/png', 'image/gif');

			// Check file type
			$file_info = wp_check_filetype( $_FILES['profile_image']['name'] );
			if ( !in_array( $file_info['type'], $allowed_mime_types ) ) {
				wp_die( 'Invalid file type. Only JPG, PNG and GIF are allowed.' );
			}


			// Check file size (e.g., 2MB limit)
			if ( $_FILES['profile_image']['size'] > 2 * 1024 * 1024 ) {
				wp_die( 'File is too large. Maximum size is 2MB.' );
			}

			// Sanitize file name
			$_FILES['profile_image']['name'] = sanitize_file_name( $_FILES['profile_image']['name'] );


			// Handle file upload
			$attachment_id = media_handle_upload( 'profile_image', 0 );

			if ( is_wp_error( $attachment_id ) ) {
				wp_die( $attachment_id->get_error_message() );
			} else {
				update_user_meta( $user_id, 'profile_image', wp_get_attachment_url( $attachment_id ) );
			}
		}
	}

	$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

    if ( isset( $_POST['account_mobile_number'] ) && !empty( $_POST['account_mobile_number'] ) ) {
        $otp_input = sanitize_text_field( $_POST['account_mobile_number'] );

        try {
            // Parse and validate phone number
            $phoneNumber = $phoneUtil->parse( $otp_input, "IR" );
            $otp_input = $phoneUtil->format( $phoneNumber, \libphonenumber\PhoneNumberFormat::E164 );

            // Update the phone number if valid
            update_user_meta( $user_id, 'otp_mobile_number', $otp_input );
        } catch ( \libphonenumber\NumberParseException $e ) {
            // Handle parse exception if needed
        }
    }

	if ( isset( $_POST['account_national_code'] ) && !empty( $_POST['account_national_code'] ) ) {
		$national_code = sanitize_text_field( $_POST['account_national_code'] );
		update_user_meta( $user_id, 'national_code', $national_code );
	}

}
add_action( 'woocommerce_save_account_details', 'save_account_details_custom' );

function custom_woocommerce_save_account_details_required_fields( $args ) {
	$user_id = get_current_user_id();
    if ( empty( $_POST['account_mobile_number'] ) ) {
        wc_add_notice( __( 'وارد کردن شماره موبایل الزامی است.', 'alma' ), 'error' );
    }else{
		$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
		try {
			$otp_input = sanitize_text_field($_POST['account_mobile_number']);
			$phoneNumber = $phoneUtil->parse($otp_input, "IR");
			if(!$phoneUtil->isValidNumber($phoneNumber)){
				wc_add_notice(esc_html__('شماره وارد شده نامعتبر است','alma-core'),'error');
			}else{
				// Format the phone number in E164 format
				$otp_input = $phoneUtil->format( $phoneNumber, \libphonenumber\PhoneNumberFormat::E164 );

				// Check for duplicate number
				$args = array(
					'meta_key' => 'otp_mobile_number',
					'meta_value' => $otp_input,
					'exclude' => array( $user_id ) // Exclude the current user from the search
				);
				$user_query = new WP_User_Query( $args );

				// If any other user has the same phone number, show an error
				if ( !empty( $user_query->get_results() ) ) {
					wc_add_notice( esc_html__( 'شماره موبایل وارد شده قبلاً توسط کاربر دیگری استفاده شده است.', 'alma' ), 'error' );
				}
			}
		} catch (\libphonenumber\NumberParseException $e) {
			wc_add_notice(esc_html__('شماره وارد شده نامعتبر است','alma-core'),'error');
		}
	}

	if ( empty( $_POST['account_national_code'] ) ) {
        wc_add_notice( __( 'وارد کردن کد ملی الزامی است.', 'alma' ), 'error' );
    }else{
		$national_code = sanitize_text_field($_POST['account_national_code']);

		if ( strlen( $national_code ) !== 10 || !ctype_digit( $national_code ) ) {
			wc_add_notice( esc_html__( 'کد ملی وارد شده نامعتبر است.', 'alma' ), 'error' );
		}

		// Check for duplicate number
		$args = array(
			'meta_key' => 'national_code',
			'meta_value' => $national_code,
			'exclude' => array( $user_id ) // Exclude the current user from the search
		);
		$user_query = new WP_User_Query( $args );

		// If any other user has the same phone number, show an error
		if ( !empty( $user_query->get_results() ) ) {
			wc_add_notice( esc_html__( 'کد ملی وارد شده قبلاً توسط کاربر دیگری استفاده شده است.', 'alma' ), 'error' );
		}
	}
}
add_action( 'woocommerce_save_account_details_errors', 'custom_woocommerce_save_account_details_required_fields' );

function custom_user_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;

    if ( is_numeric( $id_or_email ) ) {
        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );
    } elseif ( is_object( $id_or_email ) ) {
        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }
    } else {
        $user = get_user_by( 'email', $id_or_email );
    }

    if ( $user && is_object( $user ) ) {
        $custom_avatar = get_user_meta( $user->ID, 'profile_image', true );
        if ( $custom_avatar ) {
            $avatar = "<img alt='{$alt}' src='{$custom_avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }
    }

    return $avatar;
}
add_filter( 'get_avatar', 'custom_user_avatar', 10, 5);

add_action('woocommerce_edit_account_form_fields','alm_wc_edit_account_additional_fields');

function alm_wc_edit_account_additional_fields(){
	$national_code = get_user_meta(get_current_user_id(),'national_code',true);
	$mobile_number = get_user_meta(get_current_user_id(),'otp_mobile_number',true);
	$mobile_number = ltrim($mobile_number,'+');
	?>
	<p class="alm-woocommerce-form-field form-row">
		<label for="account_national_code"><?php esc_html_e( 'کدملی', 'alma' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_national_code" id="account_national_code" value="<?php echo esc_attr( $national_code ); ?>" />
	</p>

	<p class="alm-woocommerce-form-field form-row">
		<label for="account_mobile_number"><?php esc_html_e( 'شماره موبایل', 'alma' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--email input-text" name="account_mobile_number" id="account_mobile_number" value="<?php echo esc_attr( $mobile_number ); ?>" />
	</p>
	<?php
}

remove_action( 'woocommerce_edit_account_form', 'wast_woocommerce_edit_account_form' );
add_action('woocommerce_edit_account_form_fields',function () {
	$user_id = get_current_user_id();
	$mobile  = get_user_meta( $user_id, '_wast_mobile', true );
	?>
    <p class="alm-woocommerce-form-field form-row">
        <label for="wast-mobile">
			شماره همراه
        </label>
        <input type="text" class="wast-form-control woocommerce-Input woocommerce-Input--password input-text" id="wast-mobile" name="wast-mobile" value="<?php echo esc_attr( $mobile ); ?>">
		<span>
			<em>(جهت دریافت اعلانات تیکت شماره همراه خود را وارد نمایید.)</em>
		</span>
    </p>
	<?php
});
/* edit-account */

function alm_post_share_socials($url = null){
	if(is_null($url)){
		$url = get_permalink();
	}
	$socials = [
		'instagram' => [
            'url' => '' . esc_url($url),
			'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
					<path d="M12.0003 29.3333H20.0003C26.667 29.3333 29.3337 26.6667 29.3337 20V12C29.3337 5.33332 26.667 2.66666 20.0003 2.66666H12.0003C5.33366 2.66666 2.66699 5.33332 2.66699 12V20C2.66699 26.6667 5.33366 29.3333 12.0003 29.3333Z" stroke="#8D8D8D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M15.9997 20.6667C18.577 20.6667 20.6663 18.5773 20.6663 16C20.6663 13.4227 18.577 11.3333 15.9997 11.3333C13.4223 11.3333 11.333 13.4227 11.333 16C11.333 18.5773 13.4223 20.6667 15.9997 20.6667Z" stroke="#8D8D8D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M23.5152 9.33332H23.5306" stroke="#8D8D8D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>'
        ],
        'whatsapp' => [
            'url' => 'whatsapp://send?text=' . esc_url($url),
			'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
					<path d="M9.20033 27.4667C11.2003 28.6667 13.6003 29.3333 16.0003 29.3333C23.3337 29.3333 29.3337 23.3333 29.3337 16C29.3337 8.66666 23.3337 2.66666 16.0003 2.66666C8.66699 2.66666 2.66699 8.66666 2.66699 16C2.66699 18.4 3.33366 20.6667 4.40033 22.6667L3.10743 27.6393C2.91271 28.3882 3.60592 29.0651 4.34998 28.8525L9.20033 27.4667Z" stroke="#8D8D8D" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M22 19.798C22 20.014 21.9519 20.236 21.8498 20.452C21.7476 20.668 21.6154 20.872 21.4412 21.064C21.1467 21.388 20.8222 21.622 20.4557 21.772C20.0951 21.922 19.7046 22 19.2839 22C18.671 22 18.016 21.856 17.325 21.562C16.634 21.268 15.9429 20.872 15.2579 20.374C14.5669 19.87 13.9119 19.312 13.2869 18.694C12.668 18.07 12.1092 17.416 11.6104 16.732C11.1177 16.048 10.7211 15.364 10.4326 14.686C10.1442 14.002 10 13.348 10 12.724C10 12.316 10.0721 11.926 10.2163 11.566C10.3605 11.2 10.5889 10.864 10.9074 10.564C11.2919 10.186 11.7126 10 12.1572 10C12.3255 10 12.4937 10.036 12.644 10.108C12.8002 10.18 12.9384 10.288 13.0466 10.444L14.4407 12.406C14.5488 12.556 14.6269 12.694 14.681 12.826C14.7351 12.952 14.7651 13.078 14.7651 13.192C14.7651 13.336 14.7231 13.48 14.639 13.618C14.5608 13.756 14.4467 13.9 14.3025 14.044L13.8458 14.518C13.7797 14.584 13.7496 14.662 13.7496 14.758C13.7496 14.806 13.7556 14.848 13.7677 14.896C13.7857 14.944 13.8037 14.98 13.8157 15.016C13.9239 15.214 14.1102 15.472 14.3746 15.784C14.645 16.096 14.9334 16.414 15.2459 16.732C15.5704 17.05 15.8828 17.344 16.2013 17.614C16.5138 17.878 16.7722 18.058 16.9765 18.166C17.0065 18.178 17.0426 18.196 17.0846 18.214C17.1327 18.232 17.1808 18.238 17.2349 18.238C17.337 18.238 17.4151 18.202 17.4812 18.136L17.9379 17.686C18.0881 17.536 18.2323 17.422 18.3706 17.35C18.5088 17.266 18.647 17.224 18.7972 17.224C18.9114 17.224 19.0315 17.248 19.1637 17.302C19.2959 17.356 19.4342 17.434 19.5844 17.536L21.5734 18.946C21.7296 19.054 21.8378 19.18 21.9039 19.33C21.9639 19.48 22 19.63 22 19.798Z" stroke="#8D8D8D" stroke-width="1.5" stroke-miterlimit="10"/>
				</svg>',
        ],
		'facebook' => [
            'url' => 'https://www.facebook.com/sharer.php?u=' . esc_url($url),
			'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
					<path d="M18.6667 12.4V16.2667H22.1333C22.4 16.2667 22.5333 16.5333 22.5333 16.8L22 19.3333C22 19.4667 21.7333 19.6 21.6 19.6H18.6667V29.3333H14.6667V19.7333H12.4C12.1333 19.7333 12 19.6 12 19.3333V16.8C12 16.5333 12.1333 16.4 12.4 16.4H14.6667V12C14.6667 9.73333 16.4 8 18.6667 8H22.2667C22.5333 8 22.6667 8.13333 22.6667 8.4V11.6C22.6667 11.8667 22.5333 12 22.2667 12H19.0667C18.8 12 18.6667 12.1333 18.6667 12.4Z" stroke="#8D8D8D" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
					<path d="M20.0003 29.3333H12.0003C5.33366 29.3333 2.66699 26.6667 2.66699 20V12C2.66699 5.33332 5.33366 2.66666 12.0003 2.66666H20.0003C26.667 2.66666 29.3337 5.33332 29.3337 12V20C29.3337 26.6667 26.667 29.3333 20.0003 29.3333Z" stroke="#8D8D8D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>',
        ],
        'telegram' => [
            'url' => 'tg://msg_url?url=' . esc_url($url),
			'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
					<path d="M9.86625 8.42669L21.1862 4.65336C26.2662 2.96002 29.0262 5.73336 27.3462 10.8134L23.5729 22.1334C21.0396 29.7467 16.8796 29.7467 14.3462 22.1334L13.2262 18.7734L9.86625 17.6534C2.25292 15.12 2.25292 10.9734 9.86625 8.42669Z" stroke="#8D8D8D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M13.4805 18.2L18.2538 13.4133" stroke="#8D8D8D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>',
        ],
    ];
	$post_share_socials = alm_get_option('post_share_socials')??[];
	$post_share_socials = array_filter($post_share_socials,function($social)use($socials){
		return array_key_exists($social,$socials);
	});
	$output = '';
	ob_start();
	if($post_share_socials){
		?>
			<div class="alm-post-socials">
				<?php foreach($post_share_socials as $social_name):$social=$socials[$social_name];?>
					<a href="<?php echo $social['url']??'#'?>" class="alm-post-social alm-post-social-<?php echo $social_name?>">
						<?php echo $social['icon']??'';?>
					</a>
				<?php endforeach;?>
			</div>
		<?php
	}
	$output .= ob_get_clean();
	return $output;
}

/* filter blog posts */
function alm_is_enable_filter_posts_by_point(){
	return is_plugin_active('posts-like-dislike/posts-like-dislike.php');
}

function alm_is_enable_filter_posts_by_view(){
	return is_plugin_active('wp-statistics/wp-statistics.php');
}

function alm_blog_order_options(){
	$order_options = [
		'update'=>esc_html__('جدیدترین','alma'),
	];
	if(alm_is_enable_filter_posts_by_point()){
		$order_options['uppoint'] = esc_html__('محبوب ترین','alma');
	}
	if(alm_is_enable_filter_posts_by_view()){
		$order_options['upview'] = esc_html__('پر بازدید ترین','alma');
	}
	return $order_options;
}

function alm_sort_posts($query){
    global $wpdb;

	if (is_admin() || !$query->is_main_query() || (!$query->is_archive() && !$query->is_search() && !$query->is_home())) {
        return;
    }

	$order_by = isset($_GET['order_by']) ? sanitize_text_field($_GET['order_by']) : 'update';
	switch($order_by){
		case 'upview':
			if(!alm_is_enable_filter_posts_by_view()){
				return;
			}
			add_filter('posts_join', 'alm_custom_upview_join');
            add_filter('posts_orderby', 'alm_custom_upview_orderby');
            add_filter('posts_groupby', 'alm_custom_upview_groupby');
			break;
		case 'uppoint':
			if(!alm_is_enable_filter_posts_by_point()){
				return;
			}
			// $query->set('meta_query', [
            //     'relation' => 'OR',
            //     [
            //         'key' => 'pld_like_count',
            //         'compare' => 'EXISTS',
            //     ],
            //     [
            //         'key' => 'pld_dislike_count',
            //         'compare' => 'EXISTS',
            //     ]
            // ]);

			add_filter('posts_join', 'alm_custom_uppoint_join');
			add_filter('posts_orderby', 'alm_custom_uppoint_orderby');
			break;
		default:
			$query->set('orderby', 'date');
			$query->set('order', 'DESC');
	}
}
add_filter('pre_get_posts', 'alm_sort_posts');

function alm_custom_uppoint_join($join) {
    global $wpdb;

    $join .= " LEFT JOIN {$wpdb->postmeta} meta_like ON ({$wpdb->posts}.ID = meta_like.post_id AND meta_like.meta_key = 'pld_like_count')";
    $join .= " LEFT JOIN {$wpdb->postmeta} meta_dislike ON ({$wpdb->posts}.ID = meta_dislike.post_id AND meta_dislike.meta_key = 'pld_dislike_count')";

    return $join;
}

// Custom order by (like - dislike)
function alm_custom_uppoint_orderby($orderby) {
    // Use COALESCE to treat missing meta values as 0
    $orderby = "
        (COALESCE(CAST(meta_like.meta_value AS SIGNED), 0) - COALESCE(CAST(meta_dislike.meta_value AS SIGNED), 0)) DESC,
        COALESCE(CAST(meta_like.meta_value AS SIGNED), 0) DESC
    ";

    return $orderby;
}

function alm_custom_upview_join($join) {
    global $wpdb;

    // Get all public post types
    $public_post_types = get_post_types(['public' => true], 'names');

	$public_post_types[]="home";

    // Prepare a list of post types for the SQL query
    $post_types_list = "'" . implode("', '", $public_post_types) . "'";

    // Join the wp_statistics_pages table based on post ID and filter by public post types
    $join .= " LEFT JOIN al_statistics_pages views ON (views.id = {$wpdb->posts}.ID AND views.type IN ($post_types_list))";

    return $join;
}

// Custom order by view count
function alm_custom_upview_orderby($orderby) {
    // Order by the sum of view counts
    $orderby = " SUM(views.count) DESC ";

    return $orderby;
}

// Custom group by to aggregate view counts per post
function alm_custom_upview_groupby($groupby) {
    global $wpdb;

    // Group by post ID to ensure correct aggregation
    $groupby = "{$wpdb->posts}.ID";

    return $groupby;
}

// add_filter('posts_request', 'debug_query_output', 10, 2);
// function debug_query_output($query, $wp_query) {
//     if ($wp_query->is_main_query()) {
//         // Only print the query for the main query
//         error_log($query); // Log the query to the debug log
//         echo '<pre>' . esc_html($query) . '</pre>'; // Print the query on the screen
//     }
//     return $query;
// }
/* filter blog posts */
function alm_enabled_breadcrumb(){
	if(function_exists('alm_get_option') && alm_get_option('breadcrumb_enabled')){
		return true;
	}
	return false;
}

add_action('admin_enqueue_scripts', 'alm_enqueue_admin_scripts');
function alm_enqueue_admin_scripts()
{
    wp_enqueue_style('alm-admin', trailingslashit(Theme_ROOT_URL) . 'admin/assets/style.css');
	    wp_register_script('init-jquery', trailingslashit(Theme_ROOT_URL) . 'js/init-jquery.js', array('jquery'), null, true);


	wp_enqueue_style('persian-datepicker', trailingslashit(Theme_ROOT_URL) . 'lib/persian-datepicker/dist/css/persian-datepicker.min.css');
    wp_enqueue_script('persian-date', trailingslashit(Theme_ROOT_URL) . 'lib/persian-date/dist/persian-date.min.js', array('init-jquery'), null, true);
    wp_enqueue_script('persian-datepicker', trailingslashit(Theme_ROOT_URL) . 'lib/persian-datepicker/dist/js/persian-datepicker.js', array('init-jquery', 'persian-date'), null, true);

	wp_enqueue_script(
        'alm-admin',
        trailingslashit(Theme_ROOT_URL) . 'admin/assets/main.js',
        array('init-jquery', 'persian-datepicker'),
        null,
        true
    );
}

if(alm_elementor_enabled()){
    add_action('elementor/editor/before_enqueue_scripts', 'alm_enqueu_elementor_persian_styles');
    add_action('elementor/preview/enqueue_styles', 'alm_enqueu_elementor_persian_styles');
    add_action('elementor/app/init', 'alm_enqueu_elementor_persian_styles');
    add_action('admin_enqueue_scripts', 'alm_enqueu_elementor_persian_styles');
}

function alm_enqueu_elementor_persian_styles(){
    wp_enqueue_style('alm-persian-elementor', trailingslashit(Theme_ROOT_URL) . 'admin/assets/alm-persian-elementor.css');
}

function mgs_update_fonts() {
	$custom_fonts = alm_custom_fonts();
	$font_faces = '';

	if ($custom_fonts) {
		$upload_dir = wp_upload_dir();
		$baseurl = $upload_dir['baseurl']; // Full uploads URL
		$basedir = $upload_dir['basedir']; // Full uploads directory

		foreach ($custom_fonts as $font) {
			if (isset($font['face'])) {
				// Replace full site URL with relative path
				$face = str_replace($baseurl, '.', $font['face']);

				// Replace font-display: auto; with font-display: swap;
				$face = str_replace('font-display: auto;', 'font-display: swap;', $face);

				$font_faces .= $face;
			}
		}

		// Save to CSS file
		$css_path = $basedir . '/alm-custom-fonts.css';
		file_put_contents($css_path, $font_faces);
	}
}

add_action( 'save_post_elementor_font', 'save_post_elementor_font_callback', 20, 2 );
function save_post_elementor_font_callback( $post_id, $post ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	mgs_update_fonts();
}

add_action( 'deleted_post_elementor_font', 'deleted_post_elementor_font_callback', 20, 2 );
function deleted_post_elementor_font_callback( $post_id, $post ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	mgs_update_fonts();
}


/* menu functions */
function almRenderMobileMenu($menu_location){
	$exist_menu = false;
	$menu_items = [];

	if (($menu_location) && ($locations = get_nav_menu_locations()) && isset($locations[$menu_location])) {
		$menu = get_term($locations[$menu_location], 'nav_menu');
		if ($menu && !is_wp_error($menu)) {
			$all_menu_items = wp_get_nav_menu_items($menu->term_id);
			$exist_menu = true;

			$menu_items = almGetTreeModeMenuItems($all_menu_items);
			if(count($menu_items)>0){
				echo "<div class='alm-mobile-menu'>";
				almRenderMenuItems($menu_items);
				echo "</div>";
			}
		}

	}
}

function almRenderMenuItems($menu_items,$level=1){
	echo "<ul>";
	foreach (array_values($menu_items) as $index=>$menu_item) {
		echo "<li>";
		echo "<a href='{$menu_item->url}'>";

		echo "<span class='alm-link-content'>{$menu_item->title}</span>";

		if(count($menu_item->children) > 0){
			echo "<div class='alm-toggle-icon'>";
			echo '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="21" viewBox="0 0 26 21" fill="none"><path opacity="0.15" d="M17.1948 18.8451C21.7972 18.8451 25.5282 15.1142 25.5282 10.5118C25.5282 5.90943 21.7972 2.17847 17.1948 2.17847C12.5925 2.17847 8.86151 5.90943 8.86151 10.5118C8.86151 15.1142 12.5925 18.8451 17.1948 18.8451Z" fill="#8D8D8D"></path><path d="M10.5618 19.1437C15.1641 19.1437 18.8951 15.4128 18.8951 10.8104C18.8951 6.20801 15.1641 2.47705 10.5618 2.47705C5.95938 2.47705 2.22842 6.20801 2.22842 10.8104C2.22842 15.4128 5.95938 19.1437 10.5618 19.1437Z" stroke="#8D8D8D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M13.4784 10.8104H8.47842" stroke="#8D8D8D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M10.1451 8.31039L7.64511 10.8104L10.1451 13.3104" stroke="#8D8D8D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
			echo "</div>";
			// todo show toggle icon
		}

		echo "</a>";

		if(count($menu_item->children) > 0){
			almRenderMenuItems($menu_item->children,1+$level);
		}

		if($level <= 1 && 1+$index<count($menu_items)){
			echo "<div class='alm-mobile-list-divider'></div>";
		}

		echo "</li>";
	}
	echo "</ul>";
}

function almGetTreeModeMenuItems($menu_items)
{
	$mainItems = almGetMenuItemChildren($menu_items, 0);
	if ($mainItems) {
		foreach ($mainItems as $mainItem) {
			$mainItem->children = almGetRecursiveMenuItemChildren($menu_items, $mainItem->ID);
		}
	}
	return $mainItems;
}

function almGetMenuItemChildren($menu_items, $menu_item_parent = 0)
{
	return array_filter($menu_items, function ($item) use ($menu_item_parent) {
		return $item->menu_item_parent == $menu_item_parent;
	});
}

function almGetRecursiveMenuItemChildren($menu_items, $menu_item_parent = 0)
{
	$direct_children = almGetMenuItemChildren($menu_items, $menu_item_parent);
	foreach ($direct_children as $child) {
		$child->children = almGetRecursiveMenuItemChildren($menu_items, $child->ID);
	}
	return $direct_children;
}

add_filter('woocommerce_single_product_image_gallery_classes',function($classes){
	if(alm_get_option('product_gallery_full_size')){
		$classes[]='alm-full-size-gallery';
	}
	return $classes;
});

remove_action('woocommerce_archive_description','woocommerce_taxonomy_archive_description');
remove_action('woocommerce_archive_description','woocommerce_product_archive_description');
add_action('alm_wc_after_archive','woocommerce_taxonomy_archive_description');
add_action('alm_wc_after_archive','woocommerce_product_archive_description');
