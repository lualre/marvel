<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('img/icon-marvel.png') }}" />
        <title>Sucursales</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                font-family: 'Nunito', sans-serif;
            }

            .full-height {
                height: 100rem;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 4vh;
            }

            .marvel{
                color: #F91313;
            }

            .icon1{
                color: #1DA8E5;
                cursor: pointer;
            }

            .icon2{
                color: #ED1310;
                cursor: pointer;
            }

            .icon3{
                color: #00B94E;
            }

        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active col-md-2 align-self-center">
                        <a class="nav-link" href="{{url('/')}}">
                            <img src="{{ asset('img/icon-marvel.png') }}" alt="marvel" class="img-fluid" style="width: 40%;"></span>
                        </a>
                    </li>
                    <li class="nav-item col-md-6 align-self-center">
                        <a class="nav-link h3">Bienvenido al Mundo del Comic </a>
                            {{-- <strong class="marvel">MARVEL</strong> --}}
                    </li>
                    <li class="nav-item col-md-2 align-self-center">
                        <a class="nav-link" href="{!!  route('sucursales') !!}">Sucursales</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ session('status') }}
            </div>
        @endif

            <br>
            <div class="container-sm">
                <div class="d-flex flex-row-reverse">
                    <button type="button" class="btn btn-primary" onclick="abreModal()">
                        <i class="fas fa-plus"></i> Agregar Sucursal
                    </button>
                </div>
                <br>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sucursales  as $values)
                        <tr>
                        <th scope="row">{{$values->id}}</th>
                        <td>{{$values->name}}</td>
                        <td>{{$values->status}}</td>
                        <td>
                            <i class="fas fa-pencil-alt icon1" onclick="abreModal2({{$values->id}})" data-toggle="tooltip" data-placement="right" title="Editar"></i> &nbsp;
                            <i class="fas fa-trash-alt icon2" onclick="confirmacion( {{$values->id}}, '{{$values->name}}' )" data-toggle="tooltip" data-placement="right" title="Eliminar"></i>  &nbsp;
                            <a href="{!!  route('sucursales/add', [$values->id, $values->name] ) !!}"  data-toggle="tooltip" data-placement="right" title="Agregar Comics"><i class="fas fa-plus-circle icon3"></i></a>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- MODAL -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div id="formSucursal"></div>
            </div>

            <!-- Modal Delete -->
            <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form method="POST" action="{{ route('sucursales/delete') }}">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="modal-body">
                            <div class="alert alert-warning text-center mt-3" role="alert">
                                <input type="hidden" name="id" id="id">
                               <h5>¿Esta seguro de querer eliminar la sucursal <span id="name"></span> ?</h5>
                               <p class="align-self-center">
                                    <i class="fas fa-exclamation fa-2x"></i>
                               </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>


        </div>

        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });

            function abreModal(){
                $.ajax({
                    type:'POST',
                    url:'/loadForm',
                    data:{_token:'{{ csrf_token() }}'},
                    success:function(data){
                        $('#formSucursal').html(data);
                        $('#exampleModal').modal('show');
                    }
                });
            }

            function abreModal2(id){
                $.ajax({
                    type:'POST',
                    url:'/loadFormEdit',
                    data:{id: id, _token:'{{ csrf_token() }}'},
                    success:function(data){
                        $('#formSucursal').html(data);
                        $('#exampleModal').modal('show');
                    }
                });
            }

            function confirmacion(id, name){
                $('#delete').modal('show');
                $('#name').html(name);
                $('#id').val(id);
            }


        </script>

        <script src="https://kit.fontawesome.com/dc7af8d0aa.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js">
        // <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


    </body>

</html>


