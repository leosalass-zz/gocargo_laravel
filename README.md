# Propietarios y Vehiculos
API desarrollada en laravel para crear propietarios y vehiculos.   

Este proyecto incluye Homested para evitar errores de configuraciones, para utilizarlo es necesario tener Vagrant configurado. para mayor informacion: https://laravel.com/docs/5.4/homestead

## configuraciones del dominio en el archivo hosts
192.168.11.10	gocargo-la.app

## levantar la maquina virtual
vagrant up

## end-points

### Propietarios 

#### Crear propietario
Route: /api/propietarios  
Method: POST  
Params: [  
            'cedula' => 'required|max:45',  
            'nombres' => 'required|max:45',  
            'apellidos' => 'required|max:45',  
            'ciudad' => 'required|max:45',  
]

##### Listar propietarios
Route: /api/propietarios  
Method: GET

##### Actualizar propietario
Route: /api/propietarios  
Method: PUT  
Params: [  
            'id' => 'required|integer|min:1',  
            'cedula' => 'max:45',  
            'nombres' => 'max:45',  
            'apellidos' => 'max:45',  
            'ciudad' => 'max:45',  
]

##### Eliminar propietario
Route: /api/propietarios  
Method: DELETE  
Params: [  
            'id' => 'required|integer|min:1',  
]


### Vehiculos

##### Crear vehiculos
Route: /api/vehiculos  
Method: POST  
Params: [  
            'placa' => 'required|max:45',  
            'color' => 'required|max:45',  
            'propietario' => 'required|integer|min:1',  
]

##### Listar vehiculos
Route: /api/vehiculos  
Method: GET  

##### Listar vehiculos de un propietario
/api/propietarios/vehiculos  
Method: PUT  
Params: [  
            'propietario' => 'required|integer|min:1',  
]  

##### Actualizar vehiculos
Route: /api/vehiculos  
Method: PUT  
Params: [  
            'id' => 'required|integer|min:1'  ,
            'placa' => 'required|max:45',  
            'color' => 'required|max:45',  
            'propietario' => 'required|integer|min:1'  ,
]  

##### Eliminar vehiculos
Route: /api/vehiculos  
Method: DELETE  
Params: [  
            'id' => 'required|integer|min:1',  
]  
