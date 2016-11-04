<?php
$similar_projects = get_project_similars();
if ($similar_projects) {
    ?>
<h1>Related Projects</h1>
    <div class="all-projects-box">
        <?php foreach ($similar_projects as $project) { ?>
            <a  class="projects-box" href="<?php echo get_permalink($project->ID); ?>">
                <?php
                echo get_picture(get_field('picture', $project->ID), [
                    'type' => 'img',
                    'default' => 'slider',
                    'url' => 'url'
                ]);
                ?>
                <h1><?php echo apply_filters('the_title', $project->post_title); ?></h1>
                <p><?php echo content_short($project->post_content, 100); ?></p>
            </a>
        <?php } ?>
    </div>
<?php } ?>

