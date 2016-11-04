<?php
$social = get_social_links();
if ($social) {
    ?>
    <ul>
        <?php foreach ($social as $social) { ?>
            <li>
                <a href="<?php echo $social['url']; ?>" target="_blank">
                    <img src="<?php echo $social['picture']['url']; ?>">
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>