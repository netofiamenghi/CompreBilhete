<?php

require_once 'Conexao.php';

class Contato
{
    public $nome;
    public $email;
    public $telefone;
    public $cidade;
    public $texto;

    public function inserir()
    {
        $query = "insert into contato (nome,email,telefone,cidade,texto) 
        values ('$this->nome','$this->email','$this->telefone','$this->cidade','$this->texto')";
        $conexao = Conexao::conectar();
        $conexao->exec($query);
    }
}
