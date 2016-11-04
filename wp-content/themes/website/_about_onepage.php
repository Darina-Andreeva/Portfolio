
<?php
$contents = get_about_content();
foreach ($contents as $content) { ?>
    <div class="about-content">
        <h1><?php echo $content['title']; ?></h1>
        <?php if ($content['type'] == 'info') { ?>
            <p><?php echo $content['description']; ?></p>
        <?php } else if ($content['type'] == 'team') { ?>
            <div class="team-box">
                <?php foreach ($content['team'] as $member) { ?>
                    <div class="member-box">
                        <?php if ($member["name"]) { ?>
                            <h1><?php echo $member["name"]; ?></h1>
                        <?php } ?>
                        <?php if ($member["picture"]) { ?>
                            <img src="<?php echo $member["picture"]["url"]; ?>">
                        <?php }
                        ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>

