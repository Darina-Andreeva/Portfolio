<?php
/**
 * Template Name: Contacts
 */
get_header();
$contacts = get_contacts();
?>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1466.075820484768!2d23.34064685811135!3d42.70050979479137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40aa8578da87b1e5%3A0x6fa230885ba43b72!2z0YPQuy4g4oCe0KHRgtCw0YDQsCDQv9C70LDQvdC40L3QsOKAnCA4OCwgMTUyNyDQodC-0YTQuNGP!5e0!3m2!1sbg!2sbg!4v1478172244190" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
 <?php
    $single = contacts_single($contacts);
    if ($single) {
        ?>
        <div class="contacts-discription">
            <h1><?php echo $single->title; ?></h1>
            <?php if ($single->description) {
                ?>
                <p><?php echo $single->description; ?></p>
            <?php } ?>
        </div>
    <?php }?>

<div class="contacts-discription">
    <h1>Contacts Form</h1>
    <?php get_form('contacts'); ?>
</div>
<?php
nb_googleMaps($contacts);
get_footer();?>
 