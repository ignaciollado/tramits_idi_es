<?php 

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ApiModel;


class ApiController extends ResourceController
{

  protected $modelName = 'App\Models\ApiModel';   
  protected $format = 'json';

  use ResponseTrait;

    // get all
    public function index(){

     /*  $apiModel = new ApiModel();
      $data = $apiModel->orderBy('id', 'DESC')->findAll();
      return $this->respond($data); */

      return $this->respond($this->model->orderBy('id','ASC')->findAll());
    
    }

    // create
    public function create() {
        $apiModel = new ApiModel();
        $data = [
            'empresa' => $this->request->getVar('empresa'),
            'nif'  => $this->request->getVar('nif'),
        ];
        $apiModel->insert($data);
        $response = [
          'status'   => 201,
          'error'    => null,
          'messages' => [
              'success' => 'Expediente created successfully!'
          ]
      ];
      return $this->respondCreated($response);
    }

    // single by IdExp
    public function getExpediente($id = null, $program = null, $convo = null) {
        $apiModel = new ApiModel();

        $program = str_replace("%20", " ", $program);

        $where = "idExp = " . $id;
        $where .= " AND tipo_tramite = '" . $program ."'";
        $where .= " AND convocatoria = '" . $convo ."'";
        $data = $apiModel->where( $where )->findAll();

        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Expediente does not exist.');
        }
    }

        // single by NIF
        public function getExpedientebyNIF($nif = null, $program = null, $convo = null) {
          $apiModel = new ApiModel();
  
          $program = str_replace("%20", " ", $program);
  
          $where = "nif = '" . $nif ."'";
         /*  $where .= " AND tipo_tramite = '" . $program ."'";
          $where .= " AND convocatoria = '" . $convo ."'"; */
          $data = $apiModel->where( $where )->findAll();
  
          if($data){
              return $this->respond($data);
          }else{
              return $this->failNotFound('Expediente does not exist.');
          }
      }

    // update
    public function update($id = null){
        $apiModel = new ApiModel();
        $id = $this->request->getVar('id');
        $data = [
            'empresa' => $this->request->getVar('empresa'),
            'nif'  => $this->request->getVar('nif'),
        ];
        $apiModel->update($id, $data);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
              'success' => 'Expediente updated.'
          ]
      ];
      return $this->respond($response);
    }

    // delete
    public function delete($id = null){
        $apiModel = new ApiModel();
        $data = $apiModel->where('id', $id)->delete($id);
        if($data){
            $apiModel->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Expediente deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Expediente does not exist.');
        }
    }

  /*   private function genericResponse($data, $msj, $code)    {        
      if ($code == 200) {            
        return $this->respond(array( "data" => $data, "code" => $code )); 
        //, 404, "No hay nada"        
      } else {            
        return $this->respond(array(  "msj" => $msj,  "code" => $code )); 
      }
    } */
   
}