<?php

namespace App\Http\Controllers;

use App\Propietario;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropietariosController extends Controller
{

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'cedula' => 'required|max:45',
            'nombres' => 'required|max:45',
            'apellidos' => 'required|max:45',
            'ciudad' => 'required|max:45',
        ]);

        if($validator->fails()){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = $validator->errors()->toArray();
            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        $db_search = Propietario::where('cedula', $request->cedula)->withTrashed()->first();
        if(count($db_search)){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = 'la cedula ya se encuentra registrada';

            if($db_search['deleted_at']) {
                ResponseController::$response['messagess'][] = 'el usuario fue eliminado con anterioridad y se encuentra desactivado, consulte con el administrador del sistema';
            }

            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        try {
            if (!$object = Propietario::create($request->all())) {
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

        $propietarios = [];
        foreach (Propietario::all() as $propietario){
            $propietarios[$propietario->id] = $propietario;
        }

        if(!count($propietarios)){
            ResponseController::$response['messagess'][] = 'no existen propietarios';
        }

        ResponseController::$response['success'] = true;
        ResponseController::$response['data'] = $propietarios;
        return ResponseController::response(ResponseController::$error_codes['OK']);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'cedula' => 'required|max:45',
            'nombres' => 'required|max:45',
            'apellidos' => 'required|max:45',
            'ciudad' => 'required|max:45',
        ]);

        if($validator->fails()){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = $validator->errors()->toArray();
            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        $propietario = Propietario::find($request->id);
        if(!$propietario){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = 'id invalido';
            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        try {
            if (!$propietario->update($request->all())) {
                ResponseController::$response['errors'] = true;
                ResponseController::$response['messagess'][] = 'error actualizando el registro';
                return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
            }
        }catch (\Exception $e){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = 'error actualizando el registro';
            ResponseController::$response['messagess'][] = $e->getMessage();
            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        ResponseController::$response['messagess'][] = 'registro actualizado';
        return ResponseController::response(ResponseController::$error_codes['OK']);
    }

    public function delete(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
        ]);

        if($validator->fails()){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = $validator->errors()->toArray();
            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        $propietario = Propietario::find($request->id);
        if(!$propietario){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = 'id invalido';
            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        try {
            if (!$propietario->delete()) {
                ResponseController::$response['errors'] = true;
                ResponseController::$response['messagess'][] = 'error eliminando el registro';
                return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
            }
        }catch (\Exception $e){
            ResponseController::$response['errors'] = true;
            ResponseController::$response['messagess'][] = 'error eliminando el registro';
            ResponseController::$response['messagess'][] = $e->getMessage();
            return ResponseController::response(ResponseController::$error_codes['BAD REQUEST']);
        }

        ResponseController::$response['messagess'][] = 'registro eliminado';
        return ResponseController::response(ResponseController::$error_codes['OK']);
    }
}
