<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PindustActividadesCNAEModel;
use CodeIgniter\API\ResponseTrait;

class PindustActividadesCNAEController extends ResourceController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new PindustActividadesCNAEModel();
    }

    // GET /actividades
    public function index()
    {
        try {
            $data = $this->model->findAll();
            return $this->response
                ->setHeader('Access-Control-Allow-Origin', '*')
                ->setJSON($data);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // GET /actividades/{id}
    public function show($id = null)
    {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                return $this->failNotFound("Registro con ID $id no encontrado.");
            }
            return $this->respond($data);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // POST /actividades
    public function create()
    {
        try {
            $input = $this->request->getJSON(true);
            if (!$this->model->insert($input)) {
                return $this->failValidationError(json_encode($this->model->errors()));
            }
            return $this->respondCreated($input);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // PUT /actividades/{id}
    public function update($id = null)
    {
        try {
            $input = $this->request->getJSON(true);
            if (!$this->model->update($id, $input)) {
                return $this->failValidationError(json_encode($this->model->errors()));
            }
            return $this->respond($input);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // DELETE /actividades/{id}
    public function delete($id = null)
    {
        try {
            if (!$this->model->find($id)) {
                return $this->failNotFound("Registro con ID $id no encontrado.");
            }
            $this->model->delete($id);
            return $this->respondDeleted(["id" => $id]);
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // preflight
    public function options()
    {
        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->setHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type')
            ->setStatusCode(200); // No Content
    } 
}
