<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Figma_Custom_Theme
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar">
    <div class="sidebar-inner">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </div>
</aside><!-- #secondary -->
