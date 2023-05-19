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
    public function create($idExp = null, $convo = null, $linea = null, $empresa = null, $nif = null) {
        date_default_timezone_set("Europe/Madrid");
        $apiModel = new ApiModel();
        $currentDateTime = date("Y-m-d h:i:s");//0000-00-00 00:00:00

        $where = "idExp = " . $idExp;
        $where .= " AND convocatoria = '" . $convo ."'";
        $where .= " AND tipo_tramite = '" . $linea ."'";
        $data = $apiModel->where( $where )->findAll();

        if($data){
            $mensaje = 'El expediente ya existe.';
            $response = [
                'status'   => 404,
                'error'    => null,
                'messages' => [
                'fail' => $mensaje
                ]
            ];
            return $this->fail($response);
        }else{
            $mensaje = 'Expediente fue creado satisfactoriamente.';

            $data = [
                'idExp' => $idExp,
                'empresa' => str_replace("%20", " ", $empresa),
                'nif'  => $nif,
                'tipo_tramite' => $linea,
                'convocatoria' => $convo,
                'fecha_completado' => $currentDateTime
            ];
            $expediente = $apiModel->insert($data);
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                'success' => $mensaje
            ]
            ];
            /* return $this->respondCreated($response); */
            return $this->respondCreated($expediente);

        }
    }

    // single by IdExp, optionally convo, optionally linea de ayuda
    public function getExpediente($idExp=null, $convo=null, $linea=null ) {
        $apiModel = new ApiModel();

        $linea = str_replace("%20", " ", $linea);

        $where = "idExp = " . $idExp;
        if ($convo !== 'any') {
            $where .= " AND convocatoria = '" . $convo ."'";
        }
        $where .= " AND tipo_tramite = '" . $linea ."'";

        $data = $apiModel->where( $where )->findAll();

        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Expediente does not exist.');
        }
    }

    // single by NIF (DNI, CIF, NIE), optionally linea de ayuda
    public function getExpedientebyNIF($nif = null, $linea = null, $convo = null) {
          $apiModel = new ApiModel();
  
          $linea = str_replace("%20", " ", $linea);
  
          $where = "nif = '" . $nif ."'";
          $data = $apiModel->where( $where )->findAll();
  
          if($data){
              return $this->respond($data);
          }else{
              return $this->failNotFound('Expediente with this NIF does not exist.');
          }
    }

    // single by expediente IDI (nnnn/AAAA) and convo
    public function getExpedientebyExp($idExp = null, $convo = null) {
            $apiModel = new ApiModel();
    
            $where = "idExp = '" . $idExp ."'";
            $where .= " AND convocatoria = '" . $convo ."'";
            $data = $apiModel->where( $where )->findAll();
    
            if($data){
                return $this->respond($data);
            }else{
                return $this->failNotFound('Expediente with this NIF does not exist.');
            }
    }

    // obtiene todo los datos de la convo-linea ayuda por id
    public function getConvocatoria($id = null) {
        $apiModel = new ApiModel();

        $where = "id = '" . $id ."'";

        $data = $apiModel->where( $where )->findAll();

        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound(`Convocatoria with this parameters does not exist.`);
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