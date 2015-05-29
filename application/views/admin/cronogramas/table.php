
	<span class='list_alert light_blue round'>
	<?
        if(count($objectsList) <= 0){
            echo 'não encontrei objetos com estes critérios.';    
        }else{
            echo 'encontrei: '. count($objectsList).' objeto(s)';
        }
    ?>
	</span>
	
		<?
			function GetDays($sStartDate, $sEndDate){  
				  // Firstly, format the provided dates.  
				  // This function works best with YYYY-MM-DD  
				  // but other date formats will work thanks  
				  // to strtotime().  
				  $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
				  $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));  
				  
				  // Start the variable off with the start date  
				  $aDays[] = $sStartDate;  
				  
				  // Set a 'temp' variable, sCurrentDate, with  
				  // the start date - before beginning the loop  
				  $sCurrentDate = $sStartDate;  
				  
				  // While the current date is less than the end date  
				  while($sCurrentDate < $sEndDate){  
				    // Add a day to the current date  
				    $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
				  
				    // Add this new day to the aDays array  
				    $aDays[] = $sCurrentDate;  
				  }  
				  
				  // Once the loop has finished, return the  
				  // array of days.  
				  return $aDays;  
			}

		
		?>
		<div class="crono_fixed scrollable_content left">
			<?foreach($objectsList as $objeto){?>
				<div class="crono_item">
					<p><?=$objeto->title?></p>
					<p><?=$objeto->taxonomia?></p>
				</div>
			<?}?>			
		</div>

		<div class="crono scrollable_content">
			<table>
				<?foreach($objectsList as $objeto){?>
					<tr>
						<? 
							$datas = GetDays('2015/05/28','2015/06/28');
							foreach ($datas as $data) {
								echo '<td>'.$data.'</td>';
							}
						?>
					</tr>
				<?}?>			
			</table>
		</div>
		<!--div class="scrollable_content">
			<?foreach($objectsList as $objeto){?>
				<div class="crono_row">
					<div class="crono_fixed">
						<p><?=$objeto->title?></p>
						<p><?=$objeto->taxonomia?></p>
					</div>
					<? 
						$datas = GetDays('2015/05/28','2015/06/28');
						foreach ($datas as $data) {
							//echo '<div class="crono">'.$data.'</div>';
						}
					?>
				</div>
			<?}?>
		</div-->


