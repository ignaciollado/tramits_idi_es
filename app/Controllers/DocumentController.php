<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class DocumentController extends BaseController
{
    use ResponseTrait;

    public function index($nif = null, $timestamp = null)
    {
    $path = WRITEPATH . 'documentos/' . $nif . '/' . $timestamp;
    $files = [];

    if (is_dir($path)) {
        $dirFiles = array_diff(scandir($path), ['.', '..']);

        foreach ($dirFiles as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            $files[] = [
                'name'      => utf8_encode($file),
                'extension' => utf8_encode($extension),
                'url'       => base_url("writable/documentos/$nif/$timestamp/" . rawurlencode($file))
            ];
        }
    }

    return $this->respond($files);
    }


    public function upload($nif = null, $timestamp = null)
    {
        try {
            $files = $this->request->getFiles();
            $uploadedFiles = [];
            $path = WRITEPATH . 'uploads/' . $nif . '/' . $timestamp;

            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
    
            if (!isset($files['documents']) || empty($files['documents'])) {
                return $this->fail('No documents were uploaded.')
                    ->setHeader('Access-Control-Allow-Origin', '*')
                    ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                    ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            }
    
            // Verificar si 'documents' es un solo archivo o un array de archivos
            $documents = is_array($files['documents']) ? $files['documents'] : [$files['documents']];
    
            foreach ($documents as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $fileName = $file->getClientName();
                    if ($file->move($path, $fileName)) {
                        $uploadedFiles[] = [
                            'name' => utf8_encode($file->getClientName()),
                            'path' => utf8_encode($path . '/' . $fileName)
                        ];
                    } else {
                        return $this->failServerError('Failed to move the file.')
                            ->setHeader('Access-Control-Allow-Origin', '*')
                            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
                    }
                } else {
                    return $this->fail($file->getErrorString())
                        ->setHeader('Access-Control-Allow-Origin', '*')
                        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
                }
            }
            return $this->respond(['status' => 'success', 'message' => 'Document uploaded successfully', 'file_name' => $uploadedFiles])
                ;
        } catch (\Exception $e) {
            return $this->failServerError('An error occurred while uploading documents.')
              ;
        }
    }  

    public function delete($foldername = null, $timestamp = null, $fileName = null)
    {
        $path = WRITEPATH . 'documentos/' . $foldername . '/' . $timestamp . '/' . $fileName;
        if (file_exists($path)) {
            unlink($path);
            return $this->respondDeleted(['message' => 'Documento eliminado correctamente'])
               ;
        }

        return $this->failNotFound('Document not found!!!')
           ;
    }

    public function view($nif = null, $timestamp = null, $fileName = null)
    {
        $path = WRITEPATH . 'documentos/' . $nif . '/' . $timestamp . '/' . $fileName;
        if (file_exists($path)) {
            return $this->response->download($path, null)->setFileName($fileName);
        }

        return $this->failNotFound('Document not found!!!');
    }

    public function options()
    {
        return $this->response->setStatusCode(204); // No Content
    }
    
    public function optionsDelete()
    {
        return $this->response->setStatusCode(204); // No Content
    }
}
