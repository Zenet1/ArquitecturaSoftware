<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

/**
 * EmpleadoController
 */
class EmpleadoController extends Controller
{
    /**
     * Muestra la lista de empleados registrados
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['empleados']=Empleado::paginate(2);
        return view('empleado.index', $datos);
    }

    /**
     * Muestra el formulario de creacion de nuevo empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleado.create');
    }

    /**
     * Guarda el nuevo empleado registrado
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
            'Foto'=>'required|max:10000|mimes:jpeg,png,jpg',
        
        ];

        $mensaje=[
            'required'=>'Se requiere :attribute'
        ];

        $this->validate($request, $campos, $mensaje);

        //$datosEmpleado = request()->all();
        $datosEmpleado = request()->except('_token');

        if($request->hasFile('Foto')){
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }

        Empleado::insert($datosEmpleado);
        //return response()->json($datosEmpleado);

        return redirect('empleado')->with('mensaje','Empleado agregado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Muestra el formulario para editar
     *  un empleado seleccionado
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $empleado=Empleado::findOrFail($id);

        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Actualiza el empleado editado en la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
            
        
        ];

        $mensaje=[
            'required'=>'Se requiere :attribute'
        ];

        if($request->hasFile('Foto')){
            $campos=[
                'Foto'=>'required|max:10000|mimes:jpeg,png,jpg'
            ];

            $mensaje=[
                'required'=>'Se requiere :attribute'
            ];
        }

        $this->validate($request, $campos, $mensaje);


        $datosEmpleado = request()->except('_token', '_method');

        if($request->hasFile('Foto')){
            $empleado=Empleado::findOrFail($id);
            Storage::delete('public/'.$empleado->Foto);
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }

        Empleado::where('id', '=', $id)-> update($datosEmpleado);

        $empleado=Empleado::findOrFail($id);

        //return view('empleado.edit', compact('empleado'));
        return redirect('empleado')->with('mensaje','Empleado Modificado');
    }

    /**
     * Elimina el empleado seleccionado de la base de datos
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $empleado=Empleado::findOrFail($id);

        if(Storage::delete('public/'.$empleado->Foto)){
            Empleado::destroy($id);
        }else{

        }
        
        return redirect('empleado')->with('mensaje','Empleado eliminado correctamente');
    }
  
public function deleteall(Request $request){
    $ids = $request-> get('ids');
    //$dbs = DB::delete('delete from posts where id in ('.implode(",",$ids).')');
    //$dbs = DB::destroy('posts')->whereIn('id', explode(',',$ids))->delete();
    $dbs = DB::delete('Delete from empleado where id in ('.implode(",", $ids).')');
    return redirect('posts');
}


}
