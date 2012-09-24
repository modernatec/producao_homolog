<div class="span-24 last">
<div class="Section">
  <div class="SectionHeading"> Points </div>
  <div class="SectionContent">
    <table class="DataTable">
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Image</th>
        <th>Status</th>
      </th>
      <? foreach ($plans as $key => $plan):
      $status = ($plan->status == 1) ? "inative" : "active";
      ?>
      <tr>
        <td><?=$plan->id;?></td>
        <td><?=$plan->name;?></td>
        <td><?=$plan->image;?></td>
        <td><a href="<?=URL::base();?>admin/plan/edit/<?=$plan->id;?>?status=<?=$plan->status;?>&page=<?=$page;?>" class="<?=$status;?>"></a></td>
      </tr>
      <?php endforeach;?>
    </table>
    <div class="PaginationWidget">
    	<ul>
    	<?=$pages;?>
    	</ul>
    </div>
  </div>
</div>
