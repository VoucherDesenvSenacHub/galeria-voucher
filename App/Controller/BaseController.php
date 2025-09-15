<?php

abstract class BaseController {
  /**
   * Array com os métodos permitidos. Ex: array("GET", "POST")
   * @var array
   */
  protected array $metodosPermitidos = [];

  /**
   * Método pricipal para gerenciar as requisições da Controller. Ver uso no código do script
   * @return void
   */
  public abstract function gerenciarRequisicao(): void;

  /**
   * Método para retornar JSON. Possui parâmetro "pretty" para formatar a saída, utilizado para facilitar o debug 
   * @param array $data Array com chaves contendo os dados
   * @param int $code Código de resposta, padrão 200.
   * @param bool $pretty Formata a saída para melhor visualização
   * @return void
   */
  protected function toJson(array $data, int $code = 200, bool $pretty = false): void{
    header("Content-Type: application/json; charset=utf-8");
    http_response_code($code);
    echo json_encode($data, $pretty ? JSON_PRETTY_PRINT : 0);
    exit();
  }

  /**
   * Função de ajuda com retorno para métodos não permitidos. Usar no valor default do switch em gerenciarRequisicao
   * @return void
   */
  protected function gerenciarMetodosNaoPermitidos(){
    if(count($this->metodosPermitidos) == 0)return

    header('allow: ' . implode(', ', $this->metodosPermitidos));
    http_response_code(405);
    exit();
  } 
}


//Exemplo de implementação da BaseController
// class TesteController extends BaseController{
//   protected array $metodosPermitidos = ['GET', 'POST'];
//   public function gerenciarRequisicao():void
//   {
//     switch($_SERVER['REQUEST_METHOD']){
//       case 'GET':
//         $this->gerenciarGet();
//         break;
//       case 'POST':
//         $this->gerenciarPost();
//         break;
//       default:
//         $this->gerenciarMetodosNaoPermitidos();
//         break;
//     };
//   }

//   private function gerenciarGet():void{
//     $this->toJson(["message" => 'GETO']) ;
//   }

//   private function gerenciarPost():void{
//     $this->toJson(["message" => 'POSTO']);
//   }
      
//  }

//Exemplo de uso no final do arquivo
//  $controller = new TesteController();
//  $controller->gerenciarRequisicao();