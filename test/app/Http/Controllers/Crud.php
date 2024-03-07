<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Http\Request;

class Crud extends Controller
{
    public function getDataTable()
    {
        try {
            $users = User::all();
            return response()->json(['users' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los datos de la tabla de usuarios: ' . $e->getMessage()], 500);
        }
    }
    public function updateElement(Request $request)
    {
        Log::info('Recibiendo solicitud para actualizar elemento: ' . $request->getContent());

        try {
            $data = $request->json()->all();
            $id = $data['id'];
            $name = $data['name'];
            $email = $data['email'];
            $password = 'nothing'; // Se asume que el campo de contraseña se envía en la solicitud

            $user = User::updateOrCreate(['id' => $id], ['name' => $name, 'email' => $email, 'password' => $password]);
            $message = $user->wasRecentlyCreated ? "Se ha insertado un nuevo registro con ID: $id" : "Se ha actualizado el registro con ID: $id";
            Log::info($message);

            return response()->json(['message' => $message], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = 'Error al procesar la solicitud: ' . $e->getMessage();
            Log::error($errorMessage);

            return response()->json(['error' => $errorMessage], 500);
        }
    }


    public function deleteElement(string $id)
    {
        try {
            $deleted = User::destroy($id);
            return response()->json(['message' => "Se ha eliminado el registro $deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el usuario: ' . $e->getMessage()], 500);
        }
    }
}
