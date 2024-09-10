<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ComandaModel;

class Comanda extends BaseController
{
    use ResponseTrait;

    /**
     * Obtiene todas las comandas.
     *
     * @return mixed
     */
    public function index()
    {
        $comandaModel = new ComandaModel();
        $comandas = $comandaModel->orderBy('Comanda_id')->findAll();
        return $this->respond($comandas);
    }

    /**
     * Crea una nueva comanda.
     *
     * @return mixed
     */
    public function create()
    {
        $comandaModel = new ComandaModel();
        $data = [
            'Fecha' => $this->request->getPost('Fecha'),
            'Hora' => $this->request->getPost('Hora'),
            'Total_platos' => $this->request->getPost('Total_platos'),
            'Precio_Total' => $this->request->getPost('Precio_Total'),
            'Tipo_Menu' => $this->request->getPost('Tipo_Menu'),
            'idUsuario_fk' => $this->request->getPost('idUsuario_fk'),
            'idMesa_fk' => $this->request->getPost('idMesa_fk'),
            'create_at' => date('Y-m-d H:i:s'), // Fecha y hora actual
            'update_at' => date('Y-m-d H:i:s')  // Fecha y hora actual
        ];

        // Inserta la comanda en la base de datos
        if ($comandaModel->insert($data)) {
            return $this->respondCreated(['message' => 'Comanda creada exitosamente']);
        } else {
            return $this->fail($comandaModel->errors(), 400);
        }
    }

    /**
     * Obtiene una comanda por su ID.
     *
     * @param int $id ID de la comanda
     * @return mixed
     */
    public function show($id)
    {
        $comandaModel = new ComandaModel();
        $comanda = $comandaModel->find($id);

        if ($comanda === null) {
            return $this->failNotFound('Comanda no encontrada.');
        }

        return $this->respond($comanda);
    }

    /**
     * Actualiza una comanda por su ID.
     *
     * @param int $id ID de la comanda a actualizar
     * @return mixed
     */
    public function update($id)
    {
        $comandaModel = new ComandaModel();
        $comanda = $comandaModel->find($id);

        if ($comanda === null) {
            return $this->failNotFound('Comanda no encontrada.');
        }

        $data = [
            'Fecha' => $this->request->getVar('Fecha'),
            'Hora' => $this->request->getVar('Hora'),
            'Total_platos' => $this->request->getVar('Total_platos'),
            'Precio_Total' => $this->request->getVar('Precio_Total'),
            'Tipo_Menu' => $this->request->getVar('Tipo_Menu'),
            'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),
            'idMesa_fk' => $this->request->getVar('idMesa_fk'),
            'update_at' => date('Y-m-d H:i:s') // Actualiza la fecha y hora de actualización
        ];

        // Actualiza la comanda en la base de datos
        if ($comandaModel->update($id, $data)) {
            return $this->respondUpdated(['message' => 'Comanda actualizada exitosamente']);
        } else {
            return $this->fail($comandaModel->errors(), 400);
        }
    }

    /**
     * Elimina una comanda por su ID.
     *
     * @param int $id ID de la comanda a eliminar
     * @return mixed
     */
    public function delete($id)
    {
        $comandaModel = new ComandaModel();
        $comanda = $comandaModel->find($id);

        if ($comanda === null) {
            return $this->failNotFound('Comanda no encontrada.');
        }

        // Elimina la comanda de la base de datos
        if ($comandaModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Comanda eliminada exitosamente']);
        } else {
            return $this->fail($comandaModel->errors(), 400);
        }
    }
}
