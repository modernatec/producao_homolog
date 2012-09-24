<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Digg pagination style
 * 
 * @preview  « Previous  1 2 … 5 6 7 8 9 10 11 12 13 14 … 25 26  Next »
 */
?>

<p class="pagination">

        <?php if ($previous_page): ?>
                <li><a href="<?php echo HTML::chars($page->url($first_page)) ?>" rel="first">&laquo; <?php echo __('First') ?></a></li>
        <?php else: ?>
                <li><a href="javascript:void(0);" class="disabled"><?php echo __('First') ?> </a></li>
        <?php endif ?>


        <?php if ($total_pages < 13): /* « Previous  1 2 3 4 5 6 7 8 9 10 11 12  Next » */ ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $current_page): ?>
                                <li><a href="javascript:void(0);" class="selected"><?php echo $i ?></a></li>
                        <?php else: ?>
                                <li><a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a></li>
                        <?php endif ?>
                <?php endfor ?>

        <?php elseif ($current_page < 9): /* « Previous  1 2 3 4 5 6 7 8 9 10 … 25 26  Next » */ ?>

                <?php for ($i = 1; $i <= 10; $i++): ?>
                        <?php if ($i == $current_page): ?>
                               <li><a href="javascript:void(0);" class="selected"><?php echo $i ?></a></li>
                        <?php else: ?>
                                <li><a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a></li>
                        <?php endif ?>
                <?php endfor ?>

                &hellip;
                <li><a href="<?php echo HTML::chars($page->url($total_pages - 1)) ?>"><?php echo $total_pages - 1 ?></a></li>
                <li><a href="<?php echo HTML::chars($page->url($total_pages)) ?>"><?php echo $total_pages ?></a></li>

        <?php elseif ($current_page > $total_pages - 8): /* « Previous  1 2 … 17 18 19 20 21 22 23 24 25 26  Next » */ ?>

                <li><a href="<?php echo HTML::chars($page->url(1)) ?>">1</a></li>
                <li><a href="<?php echo HTML::chars($page->url(2)) ?>">2</a></li>
                &hellip;

                <?php for ($i = $total_pages - 9; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $current_page): ?>
                                <li><a href="javascript:void(0);" class="selected"><?php echo $i ?></a></li>
                        <?php else: ?>
                                <li><a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a></li>
                        <?php endif ?>
                <?php endfor ?>

        <?php else: /* « Previous  1 2 … 5 6 7 8 9 10 11 12 13 14 … 25 26  Next » */ ?>

                <a href="<?php echo HTML::chars($page->url(1)) ?>">1</a>
                <a href="<?php echo HTML::chars($page->url(2)) ?>">2</a>
                &hellip;

                <?php for ($i = $current_page - 5; $i <= $current_page + 5; $i++): ?>
                        <?php if ($i == $current_page): ?>
                                <li><a href="javascript:void(0);" class="selected"><?php echo $i ?></a></li>
                        <?php else: ?>
                                <li><a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a></li>
                        <?php endif ?>
                <?php endfor ?>

                &hellip;
                <li><a href="<?php echo HTML::chars($page->url($total_pages - 1)) ?>"><?php echo $total_pages - 1 ?></a></li>
                <li><a href="<?php echo HTML::chars($page->url($total_pages)) ?>"><?php echo $total_pages ?></a></li>

        <?php endif ?>


        <?php if ($next_page): ?>
        		<li><a href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next"><?php echo __('Next') ?> &raquo;</a></li>
        <?php else: ?>
                <li><a href="javascript:void(0);" class="disabled"><?php echo __('Next') ?></a></li>
        <?php endif ?>

</p>