<div class="header">
    <a href="javascript:void(0)" class="close_pop">
        <div class="right icon icon_excluir_white">fechar</div>
    </a>
    <span> Informações do OED</span>
</div>
<div class="panel_content clear left" style="width:400px;">
    <div class="clear scrollable_content">  
        <!--OED histórico para frente-->
        <ul class="list_item"> 
            <?
            foreach ($array_pathFoward as $objetoF) {?>
                <li>
                    <?
                        $view = View::factory('admin/acervo/list_item');
                        $view->objeto = $objetoF;
                        $view->current_auth = $current_auth;
                        $view->header_class = '';
                        $view->display = 'hide';
                        echo $view;
                    ?>
                </li>
            <?};?>
        </ul>
        <!--OED escolhido-->
        <?
            $view = View::factory('admin/acervo/list_item');
            $view->objeto = $objeto;
            $view->current_auth = $current_auth;
            $view->header_class = 'selected';
            $view->display = 'block';
            echo $view;
        ?>
        <!--OED histórico para tras-->
        <ul class="list_item">           
        <?
            foreach ($array_path as $objetoB) {?>
                <li>
                    <?
                        $view = View::factory('admin/acervo/list_item');
                        $view->objeto = $objetoB;
                        $view->current_auth = $current_auth;
                        $view->header_class = '';
                        $view->display = 'hide';
                        echo $view;
                    ?>
                </li>
        <?};?>
        </ul>
    </div> 
</div>
<div class="left hide" id="acervo_preview">
    <!--iframe class="iframe_body" frameBorder="0" scrolling="no" src="" allowtransparency="true" ></iframe-->
</div>
