<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PindustDocumentoModel;
use Exception;

class PindustDocumentoController extends ResourceController
{
    protected $modelName = PindustDocumentoModel::class;
    protected $format    = 'json';

    // GET /pindustdocument
    public function index()
    {
        try {
            $data = $this->model->findAll();
            return $this->respond($data);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // GET /pindustdocument/{nif}/{timestamp}
    public function show($nif = null, $timestamp = null)
    {
        try {
        $data = $this->model
                     ->where('cifnif_propietario', $nif)
                     ->where('selloDeTiempo', $timestamp)
                     ->findAll();

        if (!$data) {
            return $this->failNotFound("Documento con NIF $nif y timestamp $timestamp no encontrado.");
        }

        return $this->respond($data);
        } catch (\Throwable $e) {
        return $this->failServerError($e->getMessage());
        }
    }


    // GET /pindustdocument/expediente/{id_sol}
    public function getByExpediente($id_sol = null)
    {
        try {
        if (!$id_sol) {
            return $this->failValidationError("Debe proporcionar un ID de expediente (id_sol).");
        }

        $data = $this->model->where('id_sol', $id_sol)->findAll();

        if (empty($data)) {
            return $this->failNotFound("No se encontraron documentos para el expediente con ID $id_sol.");
        }

        return $this->respond($data);
        } catch (Exception $e) {
        return $this->failServerError($e->getMessage());
        }
    }

    // POST /pindustdocument
    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            if (!$this->model->insert($data)) {
                return $this->failValidationError(json_encode($this->model->errors()));
            }
            return $this->respondCreated($data);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // PUT /pindustdocument/{id}
    public function update($id = null)
    {
        try {
            $data = $this->request->getJSON(true);
            if (!$this->model->find($id)) {
                return $this->failNotFound("Documento con ID $id no encontrado.");
            }
            if (!$this->model->update($id, $data)) {
                return $this->failValidationError(json_encode($this->model->errors()));

            }
            return $this->respond($data);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // DELETE /pindustdocument/{id}
    public function delete($id = null)
    {
        try {
            if (!$this->model->find($id)) {
                return $this->failNotFound("Documento con ID $id no encontrado.");
            }
            $this->model->delete($id);
            return $this->respondDeleted(['id' => $id, 'message' => 'Documento eliminado']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function options()
    {
        return $this->response
            ->setStatusCode(204); // No Content
    }    
}
