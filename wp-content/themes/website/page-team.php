<?php
/**
 * Template Name: About Team
 */
get_header();
$aboutTeam = get_about_team(); ?>
<?php get_template_part("_about_list_subpages"); ?>
<div class="about-team-box">
    <?php if ($aboutTeam) {
        foreach ($aboutTeam as $team) {?> 
            <?php if ($team["name"]) { ?>
                <div class="about-team-content">
                    <h1><?php echo $team["name"]; ?></h1>
                <?php } ?>
                <?php if ($team["picture"]) { ?>
                    <img class="about-img" src="<?php echo $team["picture"]["url"]; ?>">
                <?php }?>
            </div>
            <?php }
    } ?>
</div>
<?php get_footer();

