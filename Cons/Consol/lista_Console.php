<?php 
    require_once("../Classes/Console.class.php");
    $busca = isset($_GET['busca'])?$_GET['busca']:0;
    $tipo = isset($_GET['tipo'])?$_GET['tipo']:0;
   
    $lista = Console::listar($tipo, $busca);
    $itens = '';
    foreach($lista as $Console){
        $item = file_get_contents('itens_listagem_Console.html');
        $item = str_replace('{id}',$Console->getId(),$item);
        $item = str_replace('{ano}',$Console->getano(),$item);
        $item = str_replace('{est}',$Console->getest(),$item);
        $item = str_replace('{pre}',$Console->getpre(),$item);
        $item = str_replace('{marc}',$Console->getmarc(),$item);
        $item = str_replace('{mode}',$Console->getmode(),$item);
        $item = str_replace('{anexo}',$Console->getAnexo(),$item);
        $itens .= $item;
    }
    $listagem = file_get_contents('listagem_Console.html');
    $listagem = str_replace('{itens}',$itens,$listagem);
    print($listagem);
     
?>