<?php get_project_services_list(); ?>
<div class='load-container' data-url="<?php echo get_permalink($post->ID); ?>" data-page="2" data-filter="<?php $_GET['service']; ?>" data-page-slug="projects">
    <div class='load-content'>
        <?php get_template_part('_load_more_content'); ?>
        <div class="load-content-loading">
            <div class="load-container load1">
                <div class="loader">Loading...</div>
            </div>
        </div>
    </div>
    <div class="projects-load-more">
        <?php if (get_load_more_type() == 'button') { ?>
            <a class='load-button'><?php echo get_load_more_button_title(); ?>
                <div class="inner">
                    <div class="load-container load1">
                        <div class="loader">Loading...</div>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>

</div>
<script type="text/javascript">
    $(function () {
        $('.load-container').loadMore({
            type: '<?php echo get_load_more_type(); ?>'
        });
    });
</script>
