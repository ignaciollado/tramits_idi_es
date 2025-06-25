<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Exception;
use App\Models\PindustExpedienteModel;

class PindustExpedienteController extends ResourceController
{
    protected $modelName = PindustExpedienteModel::class;
    protected $format    = 'json';
    use ResponseTrait;

    // GET /api/pindustexpediente
    public function index()
    {
        try {
            $data = $this->model->orderBy('id','ASC')->findAll();
            return $this->respond($data);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // GET /api/pindustexpediente/{id}
    public function show($id = null)
    {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                return $this->failNotFound("Expediente con ID $id no encontrado.");
            }
            return $this->respond($data);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // GET /pindustexpediente/convocatoria/{convocatoria}
// Opcional: ?tipo_tramite=valor
public function getByConvocatoria($convocatoria = null)
{
    try {
        if (!$convocatoria) {
            return $this->failValidationError("Debe proporcionar una convocatoria.");
        }

        $tipoTramite = $this->request->getGet('tipo_tramite');

        $builder = $this->model->where('convocatoria', $convocatoria);

        if ($tipoTramite) {
            $builder->where('tipo_tramite', $tipoTramite);
        }

        $data = $builder->findAll();

        if (empty($data)) {
            return $this->failNotFound("No se encontraron expedientes con convocatoria = $convocatoria" . ($tipoTramite ? " y tipo_tramite = $tipoTramite" : "") . ".");
        }

        return $this->respond($data);
    } catch (Exception $e) {
        return $this->failServerError($e->getMessage());
    }
}

    // POST /api/pindustexpediente
    public function create()
    {
        try {
            $data = $this->request->getJSON(true);

            $insertedId = $this->model->insert($data, true); // El segundo parámetro true hace que devuelva el ID insertado

            if (!$insertedId) {
                return $this->failValidationError(json_encode($this->model->errors()));
            }

            return $this->respondCreated([
                'message' => 'Registro creado correctamente',
                'id' => $insertedId
            ]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }


    // PUT /api/pindustexpediente/{id}
    public function update($id = null)
    {
        try {
            $data = $this->request->getJSON(true);
            if (!$this->model->find($id)) {
                return $this->failNotFound("Expediente con ID $id no encontrado.");
            }
            if (!$this->model->update($id, $data)) {
                return $this->failValidationError(json_encode($this->model->errors()));
            }
            return $this->respond($data);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // DELETE /api/pindustexpediente/{id}
    public function delete($id = null)
    {
        try {
            if (!$this->model->find($id)) {
                return $this->failNotFound("Expediente con ID $id no encontrado.");
            }
            $this->model->delete($id);
            return $this->respondDeleted(['id' => $id, 'message' => 'Expediente eliminado']);
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
