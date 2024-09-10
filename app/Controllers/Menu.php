<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MenuModel;

class Menu extends BaseController
{
    use ResponseTrait;

    /**
     * Obtiene todos los menús.
     *
     * @return mixed
     */
    public function index()
    {
        $menuModel = new MenuModel();
        $menus = $menuModel->orderBy('Menu_id')->findAll();
        return $this->respond($menus);
    }

    /**
     * Crea un nuevo menú.
     *
     * @return mixed
     */
    public function create()
    {
        $menuModel = new MenuModel();
        $data = [
            'Tipo_Menu' => $this->request->getPost('Tipo_Menu'),
            'Precio_Menu' => $this->request->getPost('Precio_Menu'),
         	 'create_at' => date('Y-m-d H:i:s'), // Fecha y hora actual
            'update_at' => date('Y-m-d H:i:s')  // Fecha y hora actual
        ];

        // Inserta el menú en la base de datos
        if ($menuModel->insert($data)) {
            return $this->respondCreated(['message' => 'Menú creado exitosamente']);
        } else {
            return $this->fail($menuModel->errors(), 400);
        }
    }

    /**
     * Obtiene un menú por su ID.
     *
     * @param int $id ID del menú
     * @return mixed
     */
    public function show($id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);

        if ($menu === null) {
            return $this->failNotFound('Menú no encontrado.');
        }

        return $this->respond($menu);
    }

    /**
     * Actualiza un menú por su ID.
     *
     * @param int $id ID del menú a actualizar
     * @return mixed
     */
    public function update($id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);

        if ($menu === null) {
            return $this->failNotFound('Menú no encontrado.');
        }

        $data = [
            'Tipo_Menu' => $this->request->getVar('Tipo_Menu'),
            'Precio_Menu' => $this->request->getVar('Precio_Menu'),
            'update_at' => date('Y-m-d H:i:s') // Actualiza la fecha y hora de actualización
        ];

        // Actualiza el menú en la base de datos
        if ($menuModel->update($id, $data)) {
            return $this->respondUpdated(['message' => 'Menú actualizado exitosamente']);
        } else {
            return $this->fail($menuModel->errors(), 400);
        }
    }

    /**
     * Elimina un menú por su ID.
     *
     * @param int $id ID del menú a eliminar
     * @return mixed
     */
    public function delete($id)
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->find($id);

        if ($menu === null) {
            return $this->failNotFound('Menú no encontrado.');
        }

        // Elimina el menú de la base de datos
        if ($menuModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Menú eliminado exitosamente']);
        } else {
            return $this->fail($menuModel->errors(), 400);
        }
    }
}
