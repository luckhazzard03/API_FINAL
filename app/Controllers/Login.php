<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsuarioModel;

class Login extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // Instancia del modelo UsuarioModel para interactuar con la base de datos
        $userModel = new UsuarioModel();

        // Obtener el valor del parámetro 'Email' enviado en la solicitud HTTP
        $email = $this->request->getPost('email');

        // Obtener el valor del parámetro 'Password' enviado en la solicitud HTTP
        $password = $this->request->getPost('password');

        // Verificar si 'Email' y 'Password' están presentes en la solicitud
        if (!$email || !$password) {
            return $this->respond(['error' => 'Email and password are required.'], 400);
        }

        // Buscar en la base de datos un usuario cuyo correo electrónico coincida con $email
        $user = $userModel->where('Email', $email)->first();

        // Verificar si no se encontró ningún usuario con el correo electrónico proporcionado
        if (is_null($user)) {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        }

        // Verificar si la contraseña proporcionada coincide con la contraseña almacenada en la base de datos
        if ($password !== $user['Password']) {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        }

        // Si las credenciales son válidas, se puede proceder con lógica adicional o simplemente retornar un mensaje de éxito
        return $this->respond(['message' => 'Login successful'], 200);
    }
}
