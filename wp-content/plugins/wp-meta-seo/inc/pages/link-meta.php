<?php
/*
  Meta image
 */

if (!class_exists('MetaSeo_Link_List_Table')) {
    require_once( WPMETASEO_PLUGIN_DIR . '/inc/class.metaseo-link-list-table.php' );
}

$metaseo_list_table = new MetaSeo_Link_List_Table();
$metaseo_list_table->process_action();
$metaseo_list_table->prepare_items();

if (!empty($_REQUEST['_wp_http_referer'])) {
    wp_redirect(remove_query_arg(array('_wp_http_referer', '_wpnonce'), stripslashes($_SERVER['REQUEST_URI'])));
    exit;
}
?>

<div class="wrap seo_extended_table_page">
    <div id="icon-edit-pages" class="icon32 icon32-posts-page"></div>

    <?php echo '<h1>' . __('Link editor', 'wp-meta-seo') . '</h1>'; ?>

    <form id="wp-seo-meta-form" action="" method="post">
        
        <?php $metaseo_list_table->search_box1(); ?>
        
        <?php $metaseo_list_table->display(); ?>
    </form>

</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
            $('.metaseo_link_title').bind('input propertychange', function() {
                $(this).closest('tr').find('.wpms_update_link').show();
            });
            
            $('.wpms_update_link').on('click', function() {
                saveMetaLinkChanges(this);
            });
            
            $('.wpms_change_follow').on('click', function() {
                wpmsChangeFollow(this);
            });
            
            $('.btn_apply_follow').on('click',function(){
                wpmsUpdateFollow(this);
            });
            
            $('.wpms_scan_link').on('click',function(){
                var $this = $(this);
                wpms_scan_link($this);
            });
	});
        
</script>