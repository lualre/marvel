<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('img/icon-marvel.png') }}" />
        <title>Comics Marvel</title>
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
            <div class="container-sm">
                <br>
                <h1>Listado de Comics</h1>
                <div class="row pl-24 pr-24 pb-24">
                    @foreach($results  as $values)
                        <div class="col-md-3 pl-4 pr-4" style="padding-bottom: 15px;" onclick="abreModal({{$values->id}})">
                            <div class="card" style="height: 100% !important;">
                                <img src="{{  $values->thumbnail->path.'.'.$values->thumbnail->extension  }}" class="card-img-top" height="330">
                                <div class="card-body">
                                    <span class="card-text">{{ $values->title }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- MODAL INFO --}}
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <strong class="modal-title" id="exampleModalLabel">Información</strong>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="infoComic"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
            </div>

        </div>

        <script>
            function abreModal(id){
                $.ajax({
                    type:'POST',
                    url:'/informacion',
                    data:{id:id, _token:'{{ csrf_token() }}'},
                    success:function(data){
                        $('#infoComic').html(data);
                        $('#exampleModal').modal('show');
                    }
                });
            }
        </script>

        <script src="https://kit.fontawesome.com/dc7af8d0aa.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js">
        // <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


    </body>

</html>


