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
		<div style="display:inline-block">
			<div>
				<?foreach($objectsList as $objeto){?>
					<div class="crono_row">
						<div class="crono"><?=$objeto->taxonomia?></div>
					</div>
				<?}?>
			</div>
			<div style="background:red">
			teste
			</div>
		</div>
		
		<!--div class="scrollable_content cronolist">
			<?foreach($objectsList as $objeto){?>
				<div class="crono_row">
					<div class="crono"><?=$objeto->taxonomia?></div>
					<? 
						$datas = GetDays('2015/05/28','2015/06/28');
						foreach ($datas as $data) {
							//echo '<div class="crono">'.$data.'</div>';
						}

					?>
				</div>
			<?}?>
		</div-->
	
	
