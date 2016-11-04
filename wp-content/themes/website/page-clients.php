<?php
/**
 * Template Name:  Clients
 */
get_header();
$clients = get_clients();
?>
<div class="clients-box-main">
    <?php
    if ($clients) {

        foreach ($clients as $client) {
            ?>
            <?php if ($client['has_link']) { ?>
    <a class="clients-box" href="<?php echo $client['link']; ?>" target=")blank">
                <?php } ?>
                <div class="clients-box">
                    <?php if ($client["has_title"]) { ?>
                        <h1><?php echo $client["title"]; ?></h1>
                    <?php }
                    ?>
                    <?php if ($client["picture"]) { ?>
                        <img src="<?php echo $client["picture"]["url"]; ?>">
                    <?php }
                    ?>
                </div>
                <?php if ($client['has_link']) { ?>
                </a>
            <?php } ?>
            <?php
        }
    }
    ?>
</div>

<?php
get_footer();
