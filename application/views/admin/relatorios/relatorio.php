<div class="content">
	<table width="800px">
    <? 
    	if($organizar == "collection_id"){
    		echo '<tr>
					<td >taxonomia</td>
					<td >tipo</td>
					<td >status</td>
					<td >retorno</td>
					<td >prova</td>
					<td >anotações</td>
				</tr>';	
	    	foreach ($collectionList as $collection) {
	    		echo '<tr style="margin:10px 0px;background:#fff;"><td colspan="6"><b>'.$collection->collection->name.'</b></td></tr>';
	    			
	    			foreach ($objecList as $object) {
			    		if($object->collection_id == $collection->collection->id){
			    			if(strtotime($object->retorno) < strtotime("now")){
			    				$class = "style='color:#ff0000'";
			    			}else{
			    				$class = "style='color:#000'";
			    			}
			    			echo '<tr>
			    					<td '.$class.'><a '.$class.' href="'.URL::base().'admin/objects/view/'.$object->id.'" title="Editar">'.$object->taxonomia.'</td>
			    					<td '.$class.'>'.$object->typeobject->name.'</td>
			    					<td '.$class.'>'.$object->statu->status.'</td>
			    					<td '.$class.'>'.Utils_Helper::data($object->retorno,'d/m/Y').'</td>
			    					<td '.$class.'>'.$object->prova.'</td>
			    					<td '.$class.'>'.$object->anotacoes.'</td>
			    				</tr>';	
			    		}
			    	}
	    	}
	    }

	    if($organizar == "status_id"){
	    	echo '<tr>
					<td >taxonomia</td>
					<td >tipo</td>
					<td >fornecedor</td>
					<td >retorno</td>
					<td >prova</td>
					<td >anotações</td>
				</tr>';	
	    	foreach ($statusList as $status) {
	    		echo '<tr style="margin:10px 0px;background:#fff;"><td colspan="6"><b>'.$status->status.'</b></td></tr>';
	    			foreach ($objecList as $object) {
			    		if($object->status_id == $status->id){
			    			if(strtotime($object->retorno) < strtotime("now")){
			    				$class = "style='color:#ff0000'";
			    			}else{
			    				$class = "style='color:#000'";
			    			}
			    			echo '<tr>
			    					<td '.$class.'><a '.$class.' href="'.URL::base().'admin/objects/view/'.$object->id.'" title="Editar">'.$object->taxonomia.'</td>
			    					<td '.$class.'>'.$object->typeobject->name.'</td>
			    					<td '.$class.' width="100">'.$object->supplier->empresa.'</td>
			    					<td '.$class.' width="100">'.Utils_Helper::data($object->retorno,'d/m/Y').'</td>
			    					<td '.$class.'>'.$object->prova.'</td>
			    					<td '.$class.'>'.$object->anotacoes.'</td>
			    				</tr>';	
			    		}
			    	}	
	    	}
	    }

	    if($organizar == "supplier_id"){
	    	echo '<tr>
					<td >taxonomia</td>
					<td >tipo</td>
					<td >status</td>
					<td >retorno</td>
					<td >prova</td>
					<td >anotações</td>
				</tr>';	
	    	foreach ($supplierList as $supplier) {
	    		echo '<tr style="margin:10px 0px;background:#fff;"><td colspan="6"><b>'.$supplier->empresa.'</b></td></tr>';
	    			foreach ($objecList as $object) {
			    		if($object->supplier_id == $supplier->id){
			    			if(strtotime($object->retorno) < strtotime("now")){
			    				$class = "style='color:#ff0000'";
			    			}else{
			    				$class = "style='color:#000'";
			    			}
			    			echo '<tr>
			    					<td '.$class.'><a '.$class.' href="'.URL::base().'admin/objects/view/'.$object->id.'" title="Editar">'.$object->taxonomia.'</td>
			    					<td '.$class.'>'.$object->typeobject->name.'</td>
			    					<td '.$class.'>'.$object->statu->status.'</td>
			    					<td '.$class.'>'.Utils_Helper::data($object->retorno,'d/m/Y').'</td>
			    					<td '.$class.'>'.$object->prova.'</td>
			    					<td '.$class.'>'.$object->anotacoes.'</td>
			    				</tr>';		
			    		}
			    	}
	    	}
	    }

	    if($organizar == "typeobject_id"){
	    	echo '<tr>
					<td >taxonomia</td>
					<td >fornecedor</td>
					<td >status</td>
					<td >retorno</td>
					<td >prova</td>
					<td >anotações</td>
				</tr>';	
	    	foreach ($typeList as $type) {
	    		echo '<tr style="margin:10px 0px;background:#fff;"><td colspan="6"><b>'.$type->name.'</b></td></tr>';
	    			foreach ($objecList as $object) {
			    		if($object->typeobject_id == $type->id){
			    			if(strtotime($object->retorno) < strtotime("now")){
			    				$class = "style='color:#ff0000'";
			    			}else{
			    				$class = "style='color:#000'";
			    			}
			    			echo '<tr>
			    					<td '.$class.'><a '.$class.' href="'.URL::base().'admin/objects/view/'.$object->id.'" title="Editar">'.$object->taxonomia.'</td>
			    					<td '.$class.' width="100">'.$object->supplier->empresa.'</td>
			    					<td '.$class.'>'.$object->statu->status.'</td>
			    					<td '.$class.'>'.Utils_Helper::data($object->retorno,'d/m/Y').'</td>
			    					<td '.$class.'>'.$object->prova.'</td>
			    					<td '.$class.'>'.$object->anotacoes.'</td>
			    				</tr>';		
			    		}
			    	}
	    	}
	    }


    ?>
    </table>
</div>

