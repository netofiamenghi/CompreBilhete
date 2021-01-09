<?php

// require_once './gerenciador/util/conexao.php';
require_once './gerenciador/util/funcoes.php';

class Visitante
{
    public static function logar($email, $senha, $conexao): bool
    {
        $retorno = false;
        $sql = "select * from visitante where email = '$email' and status = 'A'";
        $resultado = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($resultado) == 1) :
            $dados = mysqli_fetch_array($resultado);
            if (password_verify($senha, $dados['senha'])) :
                session_start();
                $_SESSION['visitante'] = true;
                $_SESSION['idVisitante'] = $dados['id'];
                $_SESSION['nomeVisitante'] = $dados['nome'];
                $_SESSION['sobrenomeVisitante'] = $dados['sobrenome'];
                $_SESSION['emailVisitante'] = $dados['email'];
                $_SESSION['codAreaVisitante'] = $dados['cod_area'];
                $_SESSION['telefoneVisitante'] = limpaCEPCPF($dados['telefone']);
                $_SESSION['cepVisitante'] = $dados['cep'];
                $_SESSION['cpfVisitante'] = $dados['cpf'];
                $_SESSION['nascimentoVisitante'] = $dados['datanascimento'];
                $_SESSION['logradouroVisitante'] = $dados['logradouro'];
                $_SESSION['numeroVisitante'] = $dados['numero'];
                $_SESSION['complementoVisitante'] = $dados['complemento'];
                $_SESSION['bairroVisitante'] = $dados['bairro'];
                $_SESSION['cidadeVisitante'] = $dados['cidade'];
                $_SESSION['estadoVisitante'] = $dados['estado'];
                $retorno = true;
            endif;
        endif;
        mysqli_close($conexao);
        return $retorno;
    }
}
