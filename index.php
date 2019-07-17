<?php
/**
 * The template for displaying main-page.
 *
 * @package Skyeng
 */

get_header(); ?>

    <div class="site_content">

        <?php
        include('templates/form_sherlock.php');
        include('templates/forms_letters.php');
        ?>

    </div>

<?php
get_footer();