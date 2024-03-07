<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Venta; 
use Illuminate\Http\Request;

class CrudVentas extends Controller
{
    public function getDataTable()
    {
        try {
            $ventas = Venta::all();
            return response()->json(['ventas' => $ventas], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los datos de la tabla de ventas: ' . $e->getMessage()], 500); 
        }
    }

    public function updateElement(Request $request)
    {
        Log::info('Recibiendo solicitud para actualizar elemento: ' . $request->getContent());

        try {
            $data = $request->json()->all();
            $id = $data['id'];
            $user_id = $data['user_id']; 
            $product_name = $data['product_name'];
            $price = $data['price']; 

            $venta = Venta::updateOrCreate(['id' => $id], ['user_id' => $user_id, 'product_name' => $product_name, 'price' => $price]); 
            $message = $venta->wasRecentlyCreated ? "Se ha insertado un nuevo registro con ID: $id" : "Se ha actualizado el registro con ID: $id";
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
            $deleted = Venta::destroy($id); // Cambia User por Venta
            return response()->json(['message' => "Se ha eliminado el registro $deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el registro de venta: ' . $e->getMessage()], 500); 
        }
    }
}
