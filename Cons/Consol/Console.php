<?php 
require_once("../Classes/Console.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = isset($_POST['id'])?$_POST['id']:0;
    $ano = isset($_POST['ano'])?$_POST['ano']:"";
    $est = isset($_POST['est'])?$_POST['est']:0;
    $pre = isset($_POST['pre'])?$_POST['pre']:0;
    $marc = isset($_POST['marc'])?$_POST['marc']:0;
    $mode = isset($_POST['mode'])?$_POST['mode']:0;
   // $anexo = isset($_POST['anexo'])?$_POST['anexo']:"";
    $acao = isset($_POST['acao'])?$_POST['acao']:"";

    $destino_anexo = 'uploads/'.$_FILES['anexo']['name'];
    move_uploaded_file('../'.$_FILES['anexo']['tmp_name'], $destino_anexo);
    $Console = new Console($id,$ano,$est,$pre,$marc,$mode,$destino_anexo);
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

    $id = isset($_GET['id'])?$_GET['id']:0;
    $resultado = Console::listar(1,$id);
    if ($resultado)
        $Console = $resultado[0];
    $busca = isset($_GET['busca'])?$_GET['busca']:0;
    $tipo = isset($_GET['tipo'])?$_GET['tipo']:0;
   
    $lista = Console::listar($tipo, $busca);

}
?>