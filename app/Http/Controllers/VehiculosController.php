<?php

namespace App\Http\Controllers;

use App\Propietario;
use App\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehiculosController extends Controller
{
    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'placa' => 'required|max:45',
            'color' => 'required|max:45',
            'propietario' => 'required|integer|min:1',
        ]);

        if($validator->fails()){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = $validator->errors()->toArray();
            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        $propietario = Propietario::find($request->propietario);

        if(!$propietario){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = 'propietario no valido';
            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        $db_search = Vehiculo::where('placa', $request->placa)->withTrashed()->first();
        if(count($db_search)){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = 'la placa ya se encuentra registrada';

            if($db_search['deleted_at']) {
                ResponseController::$response['messagess'][] = 'el vehiculo fue eliminado con anterioridad y se encuentra desactivado, consulte con el administrador del sistema';
            }

            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        $vehiculo = new Vehiculo($request->all());

        try {
            if (!$object = $propietario->vehiculos()->save($vehiculo)) {
                ResponseController::$response['errors'] = true;
                ResponseController::$response['messagess'][] = 'error guardando el registro';
                return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
            }

            ResponseController::$response['success'] = true;
            ResponseController::$response['messagess'][] = 'registro exitoso';
            ResponseController::$response['data']['created-object'] = $object->toArray();
            return ResponseController::response(ResponseController::$error_codes['OK']);

        }catch (\Exception $e){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = 'error guardando el registro';
            ResponseController::$response['messagess'][] = $e->getMessage();
            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }
    }

    public function get_all(){

        $vehiculos = [];
        foreach (Vehiculo::all() as $vehiculo){
            $vehiculos[$vehiculo->id] = $vehiculo;
        }

        if(!count($vehiculos)){
            ResponseController::$response['messagess'][] = 'no existen vehiculos registrados';
        }

        ResponseController::$response['success'] = true;
        ResponseController::$response['data'] = $vehiculos;
        return ResponseController::response(ResponseController::$error_codes['OK']);
    }

}
