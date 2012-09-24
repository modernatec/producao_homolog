<?php defined('SYSPATH') OR die('No direct access allowed.');?>

        <?php if ($previous_page): ?>
        	<li class="btn-voltar-pages"><a href="javascript:loadInfo(<?php echo $previous_page; ?>)" rel="prev"><?php echo __('Voltar') ?></a></li>
        <?php else: ?>
            <li class="btn-voltar-pages"><a href="javascript:void(0);"><?php echo __('Voltar') ?></a></li>
        <?php endif ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <?php if ($i == $current_page): ?>
                <li><a class="selected" href="#"><?php echo $i ?></a></li>
            <?php else: ?>
                <li><a href="javascript:loadInfo(<?php echo $i ?>)"><?php echo $i ?></a></li>
            <?php endif ?>
            <?if ($i < $total_pages) : ?>
            <?php endif; ?>
        <?php endfor ?>
        <?php if ($next_page): ?>
            <li class="btn-avancar-pages"><a href="javascript:loadInfo(<?php echo $next_page; ?>)" rel="next"><?php echo __('Avançar') ?></a></li>
        <?php else: ?>
            <li class="btn-avancar-pages"><a href="javascript:void(0);"><?php echo __('Avançar') ?> </a></li>
        <?php endif ?>