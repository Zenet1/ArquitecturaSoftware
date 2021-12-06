
@extends('layouts.app')

@section('content')

<div class="container">


    @if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
    {{Session::get('mensaje')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    @endif
<a href="{{ url('empleado/create') }}" class="btn btn-success"><i class="fas fa-user-plus"></i> Registrar nuevo empleado. </a>
<form method="post">
    @csrf
    {{ method_field('DELETE')}}
    
<br>
<table class="table table-hover">
    <thead class="thead-light">
        <tr>
            <th><input type="checkbox" class="selectall"></th>
            <th>ID</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($empleados as $empleado)
        <tr>
            <td><input type="checkbox" name="ids[]" class="selectbox" value="{{$empleado->id}}"></td>
            <td>{{$empleado->id}}</td>
            <td><img class="img-thumbnail img-fluid" src="{{asset('storage').'/'.$empleado->Foto}}" alt="foto" width="100"></td>
            <td>{{$empleado->Nombre}}</td>
            <td>{{$empleado->ApellidoPaterno}}</td>
            <td>{{$empleado->ApellidoMaterno}}</td>
            <td>{{$empleado->Correo}}</td>
            <td><a href="{{ url('/empleado/'.$empleado->id.'/edit') }}" class="btn btn-warning"><i class="fas fa-user-edit"></i></a>  

                <form action="{{ url('/empleado/'.$empleado->id) }}" class="d-inline" method="post">
                @csrf
                {{ method_field('DELETE')}}
                
                <button type="submit" class="btn btn-danger" onclick="return confirm('El empleado se borrara')" >
                <i class='fas fa-user-minus'></i>
                </button>
                </form>

            </td>
        </tr>
        @endforeach
        
    </tbody>
</table>
</form>
{!! $empleados->links() !!}

<script type="text/javascript">
    $('.selectall').click(function(){  
        $('.selectbox').prop('checked',$(this).prop('checked'));
        $('.selectall').prop('checked',$(this).prop('checked'));
    });

    $('.selectbox').change(function(){ 
        var total = $('.selectbox').length;
        var number = $('.selectbox:checked').length;
        if(total == number){
            $('.selectall').prop('checked',true);
        }else{
            $('.selectall').prop('checked',false);
        }
        
    });
</script>

</div>
@endsection
