<div class="wrapper">
    <h1><?php echo nb_get_page_row_data()->data['title']; ?></h1>
    <div class="template-<?php echo nb_get_page_row_data()->data["type"]; ?> template-<?php echo nb_get_page_row_data()->place; ?> slider-main slider-carousel slider-theme">
        <?php foreach (nb_get_page_row_data()->data["items"] as $slide) { ?> 
            <div class="item">
                <div class="img-item" style="<?php
                echo get_picture($slide['picture'], [
                    'type' => 'background',
                    'default' => 'slider',
                    'url' => 'url'
                ]);
                ?>background-size: cover;">
                </div>
                <div class="slide-content">
                    <div class="container">
                        <div class="wrapper-slider">
                            <div class="wrapper-three">
                                <h1 class="upper-home"><?php echo $slide['title']; ?></h1>
                                <p><?php echo $slide['description']; ?></p>
                                <?php if (!empty($slide['link'])) { ?>
                                    <a class="slider-button" href="<?php echo get_slider_url($slide); ?>">
                                        <?php echo $slide['link_title']; ?>
                                    </a>
                                <?php } elseif (!empty($slide['link2'])) {
                                    ?>
                                    <a class="slider-button" href="<?php echo $slide['link2']; ?>">
                                        <?php echo $slide['link_title']; ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php get_view_button(); ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".template-<?php echo nb_get_page_row_data()->place; ?>").owlCarousel({
            navigation: true,
            slideSpeed: 1200,
            paginationSpeed: 1000,
            addClassActive: true,
            singleItem: true
        });

    });
</script>



