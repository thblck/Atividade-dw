<?php 
require_once("../Classes/Console.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = isset($_POST['id'])?$_POST['id']:0;
    $ano = isset($_POST['ano'])?$_POST['ano']:"";
    $est = isset($_POST['est'])?$_POST['est']:0;
    $pre = isset($_POST['pre'])?$_POST['pre']:0;
    $marc = isset($_POST['marc'])?$_POST['marc']:0;
    $mode = isset($_POST['mode'])?$_POST['mode']:0;
    //$anexo = isset($_POST['anexo'])?$_POST['anexo']:"";
    $acao = isset($_POST['acao'])?$_POST['acao']:"";

    $destino_anexo = 'uploads/'.$_FILES['anexo']['name'];
    move_uploaded_file($_FILES['anexo']['tmp_name'],PATH_UPLOAD.$destino_anexo);
    $Console = new Console($id,$ano,$est,$pre, $marc, $mode,$destino_anexo);
    if ($acao == 'salvar')
        if ($id > 0)
            $resultado = $Console->alterar();
        else
            $resultado = $Console->inserir();
    elseif ($acao == 'excluir')
        $resultado = $Console->excluir();

    if ($resultado)
        header("Location: index.php");
    else
        echo "Erro ao salvar dados: ". $Console;
}elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $formulario = file_get_contents('form_cad_Console.html');

    $id = isset($_GET['id'])?$_GET['id']:0;
    $resultado = Console::listar(1,$id);
    if ($resultado){
        $Console = $resultado[0];
        $formulario = str_replace('{id}',$Console->getId(),$formulario);
        $formulario = str_replace('{ano}',$Console->getano(),$formulario);
        $formulario = str_replace('{est}',$Console->getest(),$formulario);
        $formulario = str_replace('{pre}',$Console->getpre(),$formulario);
        $formulario = str_replace('{marc}',$Console->getmarc(),$formulario);
        $formulario = str_replace('{mode}',$Console->getmode(),$formulario);
        $formulario = str_replace('{anexo}',$Console->getAnexo(),$formulario);
    }else{
        $formulario = str_replace('{id}',0,$formulario);
        $formulario = str_replace('{ano}','',$formulario);
        $formulario = str_replace('{est}','',$formulario);
        $formulario = str_replace('{pre}','',$formulario);
        $formulario = str_replace('{marc}','',$formulario);
        $formulario = str_replace('{mode}','',$formulario);
        $formulario = str_replace('{anexo}','',$formulario);
    }
    print($formulario); 
    include_once('lista_Console.php');
 

}
?>