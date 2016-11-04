<?php
/*
 * Comments to come later
 *
 *
 */

if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
wp_enqueue_style('metaseo-google-icon');
class MetaSeo_Link_List_Table extends WP_List_Table {

    function __construct() {
        parent::__construct(array(
            'singular' => 'metaseo_image',
            'plural' => 'metaseo_images',
            'ajax' => true
        ));
    }

    function display_tablenav($which) {
        $post_types = get_post_types( array('public' => true, 'exclude_from_search' => false) ) ;
        if(!empty($post_types['attachment'])) unset($post_types['attachment']);
        $p_type = "('".implode("','", $post_types)."')";
        ?>
        <div class="tablenav <?php echo esc_attr($which); ?>">

            <?php if ($which == 'top'): ?>
                <input type="hidden" name="page" value="metaseo_image_meta" />
                <div class="alignleft actions bulkactions">
                    <?php $this->months_fillter($p_type, 'sldate', 'filter_date_action'); ?>
                    <?php $this->link_source_fillter(); ?>
                </div>
                
            <?php elseif ($which == 'bottom'): ?>
                <input type="hidden" name="page" value="metaseo_image_meta" />
                <div class="alignleft actions bulkactions">
                    <?php $this->months_fillter($p_type, 'sldate1', 'filter_date_action'); ?>
                    <?php $this->link_source_fillter(); ?>
                </div>
            <?php endif ?>

            <input type="hidden" name="page" value="metaseo_image_meta" />
            <?php if (!empty($_REQUEST['post_status'])): ?> 
                <input type="hidden" name="post_status" value="<?php echo esc_attr($_REQUEST['post_status']); ?>" />
            <?php endif ?>

            <?php //$this->extra_tablenav($which); ?>

            <div style="float:right;margin-left:8px;">
                <input type="number" required min="1" value="<?php echo $this->_pagination_args['per_page'] ?>" maxlength="3" name="metaseo_link_per_page" class="metaseo_imgs_per_page screen-per-page" max="999" min="1" step="1">
                <input type="submit" name="btn_perpage" class="button_perpage button" id="button_perpage" value="Apply" >
            </div>
            
            <?php if ($which == 'top'): ?>
                <div class="alignleft actions bulkactions">
                    <?php $this->follow_action(); ?>
                </div>
            <?php elseif ($which == 'bottom'): ?>
                <div class="alignleft actions bulkactions">
                    <?php $this->follow_action(); ?>
                </div>
            <?php endif ?>    
            
            <?php $this->pagination($which); ?>                
            <br class="clear" />
        </div>

        <?php
    }

    function get_views() {
        global $wpdb;


        $status_links = array();

        $post_types = get_post_types(array('public' => true, 'exclude_from_search' => false));
        $post_types = "'" . implode("', '", $post_types) . "'";

        $states = get_post_stati(array('show_in_admin_all_list' => true));
        $states['trash'] = 'trash';
        $all_states = "'" . implode("', '", $states) . "'";

        $total_posts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status IN ($all_states) AND post_type IN ($post_types)");

        $class = empty($_REQUEST['post_status']) ? ' class="current"' : '';
        $status_links['all'] = "<a href='admin.php?page=metaseo_image_meta'$class>" . sprintf(_nx('All <span class="count">(%s)</span>', 'All <span class="count">(%s)</span>', $total_posts, 'posts'), number_format_i18n($total_posts)) . '</a>';

        foreach (get_post_stati(array('show_in_admin_all_list' => true), 'objects') as $status) {

            $status_name = $status->name;

            $total = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status IN ('$status_name') AND post_type IN ($post_types)");

            if ($total == 0) {
                continue;
            }

            if (isset($_REQUEST['post_status']) && $status_name == $_REQUEST['post_status']) {
                $class = ' class="current"';
            } else {
                $class = '';
            }

            $status_links[$status_name] = "<a href='admin.php?page=metaseo_image_meta&amp;post_status=$status_name'$class>" . sprintf(translate_nooped_plural($status->label_count, $total), number_format_i18n($total)) . '</a>';
        }
        $trashed_posts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status IN ('trash') AND post_type IN ($post_types)");
        $class = ( isset($_REQUEST['post_status']) && 'trash' == $_REQUEST['post_status'] ) ? 'class="current"' : '';
        $status_links['trash'] = "<a href='admin.php?page=metaseo_image_meta&amp;post_status=trash'$class>" . sprintf(_nx('Trash <span class="count">(%s)</span>', 'Trash <span class="count">(%s)</span>', $trashed_posts, 'posts'), number_format_i18n($trashed_posts)) . '</a>';

        return $status_links;
    }

    function extra_tablenav($which) {

        #if ('top' == $which) {        
        echo '<div class="alignleft actions">';
        global $wpdb;

        $post_types = get_post_types(array('public' => true, 'exclude_from_search' => false));
        $post_types = "'" . implode("', '", $post_types) . "'";

        $states = get_post_stati(array('show_in_admin_all_list' => true));
        $states['trash'] = 'trash';
        $all_states = "'" . implode("', '", $states) . "'";

        $query = "SELECT DISTINCT post_type FROM $wpdb->posts WHERE post_status IN ($all_states) AND post_type IN ($post_types) ORDER BY 'post_type' ASC";
        $post_types = $wpdb->get_results($query);

        $selected = !empty($_REQUEST['post_type_filter']) ? $_REQUEST['post_type_filter'] : -1;

        $options = '<option value="-1">Show All Post Types</option>';

        foreach ($post_types as $post_type) {
            $obj = get_post_type_object($post_type->post_type);
            $options .= sprintf('<option value="%2$s" %3$s>%1$s</option>', $obj->labels->name, $post_type->post_type, selected($selected, $post_type->post_type, false));
        }

        echo "</div>";
        #echo "</form>";
        #}
    }

    function get_columns() {
        return $columns = array(
            'cb' => '<input id="cb-select-all-1" type="checkbox">',
            'post_id' => __('Source', 'wp-meta-seo'),
            'col_link_url' => __('URL', 'wp-meta-seo'),
            'col_link_title' => __('Link title', 'wp-meta-seo'),
            'col_link_label' => __('Link text', 'wp-meta-seo'),
            'col_follow' => __('Follow', 'wp-meta-seo')
        );
    }

    function get_sortable_columns() {
        return $sortable = array(
            'post_id' => array('post_title', true),
            'col_link_url' => array('col_link_url', true),
            'col_link_title' => array('col_link_title', true),
            'col_follow' => array('col_follow', true),
        );
    }

    /**
     * Print column headers, accounting for hidden and sortable columns.
     *
     * @since 3.1.0
     * @access public
     *
     * @param bool $with_id Whether to set the id attribute or not
     */
    public function print_column_headers($with_id = true) {
        list( $columns, $hidden, $sortable ) = $this->get_column_info();

        $current_url = set_url_scheme('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $current_url = remove_query_arg('paged', $current_url);

        if (isset($_GET['orderby']))
            $current_orderby = $_GET['orderby'];
        else
            $current_orderby = '';

        if (isset($_GET['order']) && 'desc' == $_GET['order'])
            $current_order = 'desc';
        else
            $current_order = 'asc';

        if (!empty($columns['cb'])) {
            static $cb_counter = 1;
            $columns['cb'] = '<label class="screen-reader-text" for="cb-select-all-' . $cb_counter . '">' . __('Select All') . '</label>'
                    . '<input id="cb-select-all-' . $cb_counter . '" type="checkbox" style="margin:0;" />';
            $cb_counter++;
        }

        foreach ($columns as $column_key => $column_display_name) {
            $class = array('manage-column', "column-$column_key");

            $style = '';
            if (in_array($column_key, $hidden))
                $style = 'display:none;';

            $style = ' style="' . $style . '"';

            if ('cb' == $column_key)
                $class[] = 'check-column';
            elseif (in_array($column_key, array('posts', 'comments', 'links')))
                $class[] = 'num';

            if (isset($sortable[$column_key])) {
                list( $orderby, $desc_first ) = $sortable[$column_key];

                if ($current_orderby == $orderby) {
                    $order = 'asc' == $current_order ? 'desc' : 'asc';
                    $class[] = 'sorted';
                    $class[] = $current_order;
                } else {
                    $order = $desc_first ? 'desc' : 'asc';
                    $class[] = 'sortable';
                    $class[] = $desc_first ? 'asc' : 'desc';
                }

                $column_display_name = '<a href="' . esc_url(add_query_arg(compact('orderby', 'order'), $current_url)) . '"><span>' . $column_display_name . '</span><span class="sorting-indicator"></span></a>';
            }

            $id = $with_id ? "id='$column_key'" : '';

            if (!empty($class))
                $class = "class='" . join(' ', $class) . "'";

            if ($column_key === 'col_id') {
                echo "<th scope='col' $id $class $style colspan=\"1\">$column_display_name</th>";
            } elseif ($column_key === 'col_image_name') {
                echo "<th scope='col' $id $class $style colspan=\"4\">$column_display_name</th>";
            } elseif ($column_key === 'col_image_info') {
                echo "<th scope='col' $id $class $style colspan=\"5\">$column_display_name</th>";
            } elseif ($column_key === 'cb') {
                echo "<th scope='col' $id $class style='padding:8px 10px;'>$column_display_name</th>";
            } else {
                echo "<th scope='col' $id $class $style colspan=\"3\">$column_display_name</th>";
            }
        }
    }
    
    function prepare_items() {
        global $wpdb, $_wp_column_headers;
        $where = array('1=1');

        $keyword = !empty($_GET["txtkeyword"]) ? $_GET["txtkeyword"] : '';
        if (isset($keyword) && $keyword != '') {
            $where[] .= '(link_text LIKE "%' . $keyword . '%" OR link_url LIKE "%' . $keyword . '%")';
        }

        if (isset($_GET['metaseo_link_source']) && $_GET['metaseo_link_source'] == 'internal') {
            $where[] .= 'internal = 1';
        }
        
        if (isset($_GET['metaseo_link_source']) && $_GET['metaseo_link_source'] == 'external') {
            $where[] .= 'internal = 0';
        }
        
        $where[] .= 'type="url"';
                
        $orderby = !empty($_GET["orderby"]) ? ($_GET["orderby"]) : 'id';
        $order = !empty($_GET["order"]) ? ($_GET["order"]) : 'asc';
        $sortable = $this->get_sortable_columns();
        if (in_array($orderby, $sortable)) {
            $orderStr = $orderby;
        } else {
            $orderStr = 'id';
        }

        if ($order == "asc") {
            $orderStr .= " ASC";
        } else {
            $orderStr .= " DESC";
        }

        if (!empty($orderby) & !empty($order)) {
            $orderStr = ' ORDER BY ' . $orderStr;
        }

        $query = "SELECT * FROM " . $wpdb->prefix . "wpms_links WHERE " . implode(' AND ', $where) . $orderStr;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $total_items = $wpdb->query($query);
        if (!empty($_REQUEST['metaseo_broken_link_per_page'])) {
            $_per_page = intval($_REQUEST['metaseo_broken_link_per_page']);
        } else {
            $_per_page = 0;
        }

        $per_page = get_user_option('metaseo_broken_link_per_page');
        if ($per_page !== false) {
            if ($_per_page && $_per_page !== $per_page) {
                $per_page = $_per_page;
                update_user_option(get_current_user_id(), 'metaseo_broken_link_per_page', $per_page);
            }
        } else {
            if ($_per_page > 0) {
                $per_page = $_per_page;
            } else {
                $per_page = 10;
            }
            add_user_meta(get_current_user_id(), 'metaseo_broken_link_per_page', $per_page);
        }

        $paged = !empty($_GET["paged"]) ? $_GET["paged"] : '';
        if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
            $paged = 1;
        }

        $total_pages = ceil($total_items / $per_page);

        if (!empty($paged) && !empty($per_page)) {
            $offset = ($paged - 1) * $per_page;
            $query .= ' LIMIT ' . (int) $offset . ',' . (int) $per_page;
        }

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'total_pages' => $total_pages,
            'per_page' => $per_page
        ));

        $this->items = $wpdb->get_results($query);
    }
    
    function search_box1() {
        if (empty($_REQUEST['txtkeyword']) && !$this->has_items())
            return;
        $txtkeyword = (!empty($_REQUEST['txtkeyword'])) ? urldecode(stripslashes($_REQUEST['txtkeyword'])) : "";
        if (!empty($_REQUEST['orderby']))
            echo '<input type="hidden" name="orderby" value="' . esc_attr($_REQUEST['orderby']) . '" />';
        if (!empty($_REQUEST['order']))
            echo '<input type="hidden" name="order" value="' . esc_attr($_REQUEST['order']) . '" />';
        if (!empty($_REQUEST['post_mime_type']))
            echo '<input type="hidden" name="post_mime_type" value="' . esc_attr($_REQUEST['post_mime_type']) . '" />';
        if (!empty($_REQUEST['detached']))
            echo '<input type="hidden" name="detached" value="' . esc_attr($_REQUEST['detached']) . '" />';
        ?>
        <p class="search-box">

            <input type="search" id="image-search-input" name="txtkeyword" value="<?php echo esc_attr(stripslashes($txtkeyword)); ?>" />
        <?php submit_button('Search', 'button', 'search', false, array('id' => 'search-submit')); ?>
        </p>
        <?php
    }
    
    function follow_action(){
        ?>
        <select name="metaseo_follow_action" class="metaseo_follow_action">
            <option value="0"><?php _e('-- Selection --','wp-meta-seo') ?></option>
            <option value="follow_selected"><?php _e('Follow selected','wp-meta-seo') ?></option>
            <option value="nofollow_selected"><?php _e('Nofollow selected','wp-meta-seo') ?></option>
            <option value="follow_all"><?php _e('Follow all','wp-meta-seo') ?></option>
            <option value="nofollow_all"><?php _e('Nofollow all','wp-meta-seo') ?></option>
        </select>
        <input type="button" class="button btn_apply_follow" value="<?php _e('Apply','wp-meta-seo') ?>">
        <div data-comment_paged="1" data-paged="1" class="button wpms_scan_link page_link_meta"><?php _e('Re-index content links', 'wp-meta-seo') ?></div>
        <span class="spinner spinner_apply_follow"></span>
        <?php
    }
    
    function link_source_fillter(){
        if(isset($_GET['metaseo_link_source'])){
            $link_source = $_GET['metaseo_link_source'];
        }else{
            $link_source = 0;
        }
        ?>
        <select name="metaseo_link_source" class="metaseo_link_source">
            <option value="0" <?php selected($link_source, 0) ?>><?php _e('Link source','wp-meta-seo') ?></option>
            <option value="internal" <?php selected($link_source, 'internal') ?>><?php _e('Internal','wp-meta-seo') ?></option>
            <option value="external" <?php selected($link_source, 'external') ?>><?php _e('External','wp-meta-seo') ?></option>
        </select>
        <?php
    }

    function months_fillter($post_type, $name, $namebutton) {
        global $wpdb, $wp_locale;

        $months = $wpdb->get_results("
			SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month
			FROM $wpdb->posts
			WHERE post_type IN $post_type 
			ORDER BY post_date DESC 
		");
        
        $months = apply_filters('months_dropdown_results', $months, $post_type);
        $month_count = count($months);

        if (!$month_count || ( 1 == $month_count && 0 == $months[0]->month ))
            return;

        $m = isset($_REQUEST['sldate']) ? $_REQUEST['sldate'] : 0;
        ?>
        <label for="filter-by-date" class="screen-reader-text"><?php _e('Filter by date','wp-meta-seo'); ?></label>
        <select name="<?php echo $name ?>" id="filter-by-date" class="metaseo-filter">
            <option<?php selected($m, 0); ?> value="0"><?php _e('All dates','wp-meta-seo'); ?></option>
        <?php
        foreach ($months as $arc_row) {

            if (0 == $arc_row->year)
                continue;
            $month = zeroise($arc_row->month, 2);
            $year = $arc_row->year;
            printf("<option %s value='%s' >%s</option>\n", selected($m, "$year-$month", false), esc_attr("$arc_row->year-$month"), sprintf(__('%1$s %2$d'), $wp_locale->get_month($month), $year)
            );
        }
        ?>
        </select>

            <?php
            submit_button(__('Filter'), 'button', $namebutton, false, array('id' => 'image-submit'));
        }

        function display_rows() {
            $url = URL;
            $url = preg_replace('/(^(http|https):\/\/[w]*\.*)/', '', $url);
            $records = $this->items;
            $alternate = "";

            list( $columns, $hidden ) = $this->get_column_info();
            if (!empty($records)) {
                foreach ($records as $rec) {
                    echo '<tr id="record_' . $rec->id . '" data-link="'.$rec->id.'" data-post_id="'.$rec->source_id.'">';
                    foreach ($columns as $column_name => $column_display_name) {

                        $class = sprintf('class="%1$s column-%1$s"', $column_name);
                        $style = "";

                        if (in_array($column_name, $hidden)) {
                            $style = ' style="display:none;"';
                        }

                        $attributes = $class . $style;

                        switch ($column_name) {
                            case 'cb':
                                echo '<td scope="row" class="check-column" style="padding:8px 10px;">';
                                echo '<input id="cb-select-'.$rec->id.'" class="metaseo_link" type="checkbox" name="link['.$rec->id.']" value="'.$rec->id.'">';
                                echo '</td>';
                                break;

                            case 'post_id':
                                $post = get_post($rec->source_id);
                                $row_action = array (
                                                'edit' => '<a target="_blank" href="'.get_edit_post_link( $rec->source_id ).'" title="Edit this item">Edit</a>',
                                                'view' => '<a target="_blank" href="'.get_post_permalink( $rec->source_id ).'" title="View &#8220;test&#8221;" rel="permalink">View</a>'
                                                );
                                echo '<td class="col_id" colspan="3">';
                                echo '<a target="_blank" href="'.get_edit_post_link( $rec->source_id ).'">'.$post->post_title.'</a>';
                                echo $this->row_actions($row_action ,false);
                                echo '</td>';
                                break;

                            case 'col_link_url':
                                echo '<td class="wpms_link_html" colspan="3">';
                                echo '<a target="_blank" href="'.$rec->link_url.'">'.$rec->link_url.'</a>';
                                echo '</td>';
                                break;

                            case 'col_link_title':
                                echo '<td colspan="3">';
                                echo '<input type="text" data-post_id="'.$rec->source_id.'" name="metaseo_link_title" id="metaseo_link_title" class="metaseo_link_title" value="'.$rec->meta_title.'">';
                                echo '<div data-post_id="'.$rec->source_id.'" class="wpms_update_link">'.__('Update','wp-meta-seo').'</div>';
                                echo '<strong class="wpms_mesage_link">'.__('Saved.','wp-meta-seo').'</strong>';
                                echo '<strong class="wpms_error_mesage_link">'.__('Error.','wp-meta-seo').'</strong>';
                                echo '</td>';
                                break;

                            case 'col_link_label':
                                echo '<td colspan="3">'.strip_tags($rec->link_text).'</td>';
                                break;
                            
                            case 'col_follow':
                                if($rec->follow==1){
                                    $follow = '<i class="material-icons wpms_ok wpms_change_follow" data-type="done">done</i>';
                                }else{
                                    $follow = '<i class="material-icons wpms_warning wpms_change_follow" data-type="warning">warning</i>';
                                }
                                echo '<td colspan="3">'.$follow.'</td>';
                                break;
                        }
                    }

                    echo '</tr>';
                }
            }
        }

        public function process_action() {
            global $wpdb;
            $current_url = set_url_scheme('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $redirect = false;

            if (isset($_POST['search']) and $_POST['search'] === 'Search') {
                $current_url = add_query_arg(array("search" => "Search", "txtkeyword" => urlencode(stripslashes($_POST["txtkeyword"]))), $current_url);
                $redirect = true;
            }

            if (isset($_POST['filter_date_action']) and $_POST['filter_date_action'] === 'Filter') {
                $current_url = add_query_arg(array("sldate" => $_POST["sldate"]), $current_url);
                $redirect = true;
            }

            if (!empty($_POST['paged'])) {
                $current_url = add_query_arg(array("paged" => intval($_POST['paged'])), $current_url);
                $redirect = true;
            }
            
            if (isset($_POST['metaseo_link_source'])) {
                $current_url = add_query_arg(array("metaseo_link_source" => $_POST['metaseo_link_source']), $current_url);
                $redirect = true;
            }

            if (!empty($_POST['metaseo_link_per_page'])) {
                $current_url = add_query_arg(array("metaseo_link_per_page" => intval($_POST['metaseo_link_per_page'])), $current_url);
                $redirect = true;
            }

            if ($redirect === true) {
                wp_redirect($current_url);
                ob_end_flush();
                exit();
            }
        }
    }