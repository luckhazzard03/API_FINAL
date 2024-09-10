<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsuarioModel;

class Usuario extends BaseController
{
    use ResponseTrait;

    /**
     * Muestra todos los usuarios.
     *
     * @return mixed
     */
    public function index()
    {
        $usuarioModel = new UsuarioModel();
        $usuarios = $usuarioModel->findAll();
        return $this->respond($usuarios);
    }

    /**
     * Crea un nuevo usuario.
     *
     * @return mixed
     */
    public function create()
    {
        $usuarioModel = new UsuarioModel();

        // Obtener los datos del formulario (form-data)
        $data = [
            'Nombre' => $this->request->getPost('Nombre'),
            'Password' => $this->request->getPost('Password'),
            'Email' => $this->request->getPost('Email'),
            'Telefono' => $this->request->getPost('Telefono'),
            'idRoles_fk' => $this->request->getPost('idRoles_fk'),
            'create_at' => date('Y-m-d H:i:s'), // Fecha y hora actual
            'update_at' => date('Y-m-d H:i:s')  // Fecha y hora actual
        ];

        // Insertar el usuario en la base de datos
        if ($usuarioModel->insert($data)) {
            return $this->respondCreated(['message' => 'Usuario creado exitosamente']);
        } else {
            return $this->fail($usuarioModel->errors(), 400);
        }
    }

    /**
     * Muestra un usuario por su ID.
     *
     * @param int $id ID del usuario
     * @return mixed
     */
    public function show($id)
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id);

        if ($usuario === null) {
            return $this->failNotFound('Usuario no encontrado.');
        }

        return $this->respond($usuario);
    }

    /**
     * Actualiza un usuario por su ID.
     *
     * @param int $id ID del usuario a actualizar
     * @return mixed
     */
    public function update($id)
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id);

        if ($usuario === null) {
            return $this->failNotFound('Usuario no encontrado.');
        }

        // Obtener los datos del cuerpo de la solicitud (JSON)
        $json = $this->request->getJSON();

        // Preparar los datos para la actualización
        $data = [
            'Nombre' => isset($json->Nombre) ? $json->Nombre : $usuario['Nombre'],
            'Password' => isset($json->Password) ? $json->Password : $usuario['Password'],
            'Email' => isset($json->Email) ? $json->Email : $usuario['Email'],
            'Telefono' => isset($json->Telefono) ? $json->Telefono : $usuario['Telefono'],
            'idRoles_fk' => isset($json->idRoles_fk) ? $json->idRoles_fk : $usuario['idRoles_fk'],
            'update_at' => date('Y-m-d H:i:s') // Actualiza la fecha y hora de actualización
        ];

        // Actualizar el usuario en la base de datos
        if ($usuarioModel->update($id, $data)) {
            return $this->respondUpdated(['message' => 'Usuario actualizado exitosamente']);
        } else {
            return $this->fail($usuarioModel->errors(), 400);
        }
    }

    /**
     * Elimina un usuario por su ID.
     *
     * @param int $id ID del usuario a eliminar
     * @return mixed
     */
    public function delete($id)
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id);

        if ($usuario === null) {
            return $this->failNotFound('Usuario no encontrado.');
        }

        // Eliminar el usuario de la base de datos
        if ($usuarioModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Usuario eliminado exitosamente']);
        } else {
            return $this->fail($usuarioModel->errors(), 400);
        }
    }
}
