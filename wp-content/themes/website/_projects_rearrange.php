<?php
get_header();
get_project_services_list();
$projects = nb_search_posts();
?>
<div class="projects projects-box-rearrange-all">
    <?php foreach ($projects as $project) {
        ?>
        <div class="rearrange-grid active">
            <div class="move-projects">
                <div class="content-hidden">

                    <?php
                    echo get_picture(get_field('picture', $project->ID), [
                        'type' => 'img',
                        'default' => 'slider',
                        'url' => 'url'
                    ]);
                    ?>
                    <h1><?php echo $project->post_title; ?></h1>
                    <p><?php echo content_short($project->post_content, 100); ?></p>
                     <p><?php echo get_price($project) ;?></p>
					


                </div>
                <a  href="<?php echo get_permalink($project->ID); ?>" class="project-item active<?php
                foreach (getProjectTerms($project->ID) as $service) {
                    echo ' service-' . $service->slug;
                }
                ?> projects-box-rearrange">
                    <?php
                    echo get_picture(get_field('picture', $project->ID), [
                        'type' => 'img',
                        'default' => 'slider',
                        'url' => 'url'
                    ]);
                    ?>
                    <h1><?php echo $project->post_title; ?></h1>
                    <p><?php echo content_short($project->post_content, 100); ?></p>
                </a>
            </div>
        </div>
    <?php } ?>
</div>

<?php
get_footer();

