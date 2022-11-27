<?php

namespace App\Controllers;
use App\FrameworkTools\Abstracts\Controllers\AbstractControllers;
use App\FrameworkTools\Database\DatabaseConnection;

class LucasController extends AbstractControllers{

    //GET
    public function santos1(){
        try{
            $pets = DatabaseConnection::start()->getPDO()
                        ->query("SELECT * FROM petshop;")
                        ->fetchAll();
            view([
                "success" => true,
                "response_data" => $pets
                ]);
        }catch(\Exception $e){
            view([
                "success" => false,
                "error" => $e
            ]);
        }
    }

    //POST
    public function santos2(){
        try{
            //Tanto nome quanto tipo de serviço podem ser nulos, mas não faria sentido inserir se ambos fossem
            
            $this->params = $this->processServerElements->getInputJSONData();

            if(!$this->params["name"] && !$this->params["service"])
                throw new \Exception("Um dos campos precisa estar preenchido.");
    
            $statement = $this->pdo->prepare("INSERT INTO petshop (name_pet,type_service) VALUES (:pet_name,:type_service)");     
            $statement->execute([
                ':pet_name' => $this->params["name"] ? $this->params["name"] : null,
                ':type_service' => $this->params["service"] ? $this->params["service"] : null
            ]);

            view([
                "success" => true
                ]);
        }catch(\Exception $e){
            view([
                "success" => false,
                "error" => $e->getMessage()
            ]);
        }
    }
    
    //PUT
    final const tryinToPost = "Caso esteja tentando fazer a inserção de um novo dado, use a rota '/santos2' com o método POST.";
    public function santos3(){
        try{
            $idPet = getFrom("id_pet", $this->processServerElements->getVariables());
            if (!$idPet)
                throw new \Exception("Para atualização de dados, a requisição deve conter o parâmetro 'id_pet'. ".self::tryinToPost);

            $pet = $this->pdo->query("SELECT * FROM petshop WHERE id_petshop = '{$idPet}';")
                ->fetch();
            if (!$pet) 
                throw new \Exception("Você está tentando alterar um dado que não existe. ".self::tryinToPost);

            $this->params = $this->processServerElements->getInputJSONData();
            
            $data = "";
            $toStatement = [];

            foreach ($this->params as $key => $value) {
                if ($key === 'id_pet') 
                    throw new \Exception("Operação não permitida. Remova o campo 'id_pet' do corpo da requisição.");

                if ($key === 'name_pet' || $key === 'name' || $key === 'pet_name') {
                    $data .= "name_pet = :name,";
                    $toStatement[':name'] = $value;
                }

                if ($key === 'type_service' || $key === 'service' || $key === 'service_type'|| $key === 'service_name') {
                    $data .= " type_service = :service,";
                    if($value != "banho" && $value != "tosa")
                        throw new \Exception("Os únicos tipos de serviço oferecidos por esta pet shop são 'banho' e 'tosa'.");
                    $toStatement[':service'] = $value;
                }
            }
            
            if(!$data)
                throw new \Exception("Nada para alterar.");

            $data = substr($data,0,-1);
            $statement = $this->pdo->prepare("UPDATE petshop SET {$data} WHERE id_petshop = {$idPet}");     
            $statement->execute($toStatement);

            view([
                "success" => true
                ]);
        }catch(\Exception $e){
            view([
                "success" => false,
                "error" => $e->getMessage()
            ]);
        }
    }

    //DELETE
    public function padilhadossantos4(){
        try{
            $idPet = getFrom("id_pet", $this->processServerElements->getVariables());
            if (!$idPet)
                throw new \Exception("Para deleção de dados, a requisição deve conter o parâmetro 'id_pet'.");

            $pet = $this->pdo->query("SELECT * FROM petshop WHERE id_petshop = '{$idPet}';")
                ->fetch();
            if (!$pet) 
                throw new \Exception("Você está tentando deletar um dado que não existe.");

            $stmt = $this->pdo->prepare("DELETE FROM petshop WHERE id_petshop= :id_pet");
            $stmt->execute(['id_pet' => $idPet]);

            view([
                "success" => true
                ]);
        }catch(\Exception $e){
            view([
                "success" => false,
                "error" => $e->getMessage()
            ]);
        }
    }
}
