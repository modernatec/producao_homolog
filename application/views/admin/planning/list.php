<div class="topo" >
    <div class="tabs_panel">
        <ul class="tabs">
            <? foreach($projectList as $key=>$project){?>
            <!--li class="round"><a class="ajax" data-clear="#direita" id='tab_<?=$key+1;?>' href='<?=URL::base();?>admin/objects/getObjects/<?=$project->id?>' ><?=$project->name?></a></li-->
            <?}?>
        </ul>  
    </div>
    <div class="clear" id="filtros"></div>
</div>
<div id="page" class="scrollable_content">
    <table>
        <?
            $begin = new DateTime( '2015-06-01' );
            $end = new DateTime( '2015-08-31' );
            $end = $end->modify( '+1 day' ); 

            $interval = new DateInterval('P1M');
            $monthrange = new DatePeriod($begin, $interval ,$end);

            
            foreach($monthrange as $month){
                $num = cal_days_in_month(CAL_GREGORIAN, $month->format("m"), $month->format("Y"));
                echo '<th colspan="'.$num.'">'.$month->format("F").'/'.$month->format("Y").'</th>';
            }

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);

            echo '<tr>';
            foreach($daterange as $date){
                $class = ($date->format("N") == '6' || $date->format("N") == '7') ? 'weekend' : 'data';
                echo '<td><div class="'.$class.'">'.$date->format("D")."</div></td>";
            }
            echo '</tr>';

            echo '<tr>';
            foreach($daterange as $date){
                $class = ($date->format("N") == '6' || $date->format("N") == '7') ? 'weekend' : 'data';
                echo '<td><div class="'.$class.'">'.$date->format("d")."</div></td>";
            }
            echo '</tr>';

            $b1 = new DateTime('2015-06-10' );
            $e1 = new DateTime('2015-06-15' );
            $diff = $b1->diff($e1)->d + 1;
            $width = 30.8;

            echo '<tr>';
            foreach($daterange as $date){
                $class = ($date->format("N") == '6' || $date->format("N") == '7') ? 'weekend' : 'data';
                $colspan = ($date->format("Y-m-d") == '2015-06-10') ? '<span class="evento" style="width:'.$width*$diff.'px;" >teste</span' : '';

                echo '<td><div class="'.$class.'">'.$colspan.'</div></td>';
            }
            echo '</tr>';

            
        ?>
    </table>
</div>