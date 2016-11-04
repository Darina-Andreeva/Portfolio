
<img class="close-search toggle-search" src="<?php echo nb_content('images', 'search-icon-png-22.png'); ?>" style="width: 35px; height: 35px;">
<div class="search-box">
    <div class="search-colapse">
       
        <form role="search" method="get" class="search-form" action="<?php echo home_url(); ?>">
            <input type="text" class="search-field" id="search-field" placeholder="<?php echo nb_tm('search-here'); ?>" value="<?php echo get_search_query() ?>" name="s" />
            <div class="tooltip-holder">
                <span class="input-content"><?php echo get_search_query() ?></span>
                <span class="input-tooltip"><?php echo nb_tm('search-tooltip'); ?></span>
            </div>
            <span class="loop-black">
                <input type="submit" class="search-submit" value="">
            </span>
        </form>                 
    </div>
</div>
<!--<a class="search toggle-search search-button open-search">
    <img src="<?php //echo nb_content('images', 'Search icon white.svg'); ?>" />
</a>-->
<script type="text/javascript">
    $(function () {
        $('.search-button').searchform({
            'container': '.search-box',
            'colapse': '.search-colapse',
            'close': '.close-search',
            'field': $('.search-box .search-field')
        });

    });
</script>