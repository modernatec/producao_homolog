<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Extended pagination style
 * 
 * @preview  « Previous | Page 2 of 11 | Showing items 6-10 of 52 | Next »
 */
?>

<p class="<?php echo $style ?>">

        <?php if ($previous_page): ?>
        	<a href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="prev"><?php echo __('Previous') ?></a>
        <?php else: ?>
                &laquo; <?php echo __('Previous') ?>
        <?php endif ?>

        | <?php echo "page" ?> <?php echo $current_page ?> <?php echo $of ?> <?php echo $total_pages ?>

        | <?php "page" ?> <?php echo $current_first_item ?>&ndash;<?php echo $current_last_item ?> <?php echo $of ?> <?php echo $total_items ?>

        | <?php if ($next_page): ?>
                <a href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next"><?php echo __('Next') ?></a>
        <?php else: ?>
                <?php echo __('Next') ?> &raquo;
        <?php endif ?>

</p>