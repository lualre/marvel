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
            .img{
                width: 10%;
                border-radius: 50%;
            }
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
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
            <div id="message">
            </div>
            <div class="container-sm">
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <h2>
                            Sucursal {{ $nombreSucursal }}
                            <input type="hidden" id="idSucursal" value="{{ $idSucursal }}">
                        </h2>
                    </div>
                    <div class="col-md-6 d-flex flex-row-reverse">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onClick="saveData()">
                            <i class="fas fa-plus"></i> Guardar
                        </button>
                    </div>
                </div>

                <br>

                <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Existencias</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($inventario  as $key => $values)
                        <tr>
                        <th scope="row">{{ $values->id_comic }}</th>
                        <td>{{ $values->nombre_comic }}</td>
                        <td><img src="{{ $values->image  }}" class="img"></td>
                        <td>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon1" onClick="increment({{ $key }})">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                                <input type="number" name="stock[]" id="stock{{$key}}" class="form-control text-center" aria-label="Amount (to the nearest dollar)" value="{{ $values->stock }}">
                                <input type="hidden" name="idComic[]" class="form-control" value="{{ $values->id_comic }}">
                                <input type="hidden" name="idInventario[]" class="form-control" value="{{ $values->id }}">

                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon1" onClick="decrement({{ $key }})">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <script>

            function saveData(){
                var inputStock = document.getElementsByName('stock[]');
                var inputComics = document.getElementsByName('idComic[]');
                var inputInventario = document.getElementsByName('idInventario[]');
                var idSucursal = document.getElementById('idSucursal').value;
                var request = [];
                for (let index = 0; index < inputStock.length; index++) {
                    let json = { idInventario: inputInventario[index].value,
                                 idSucursal: idSucursal, idComic: inputComics[index].value,
                                 stock: inputStock[index].value };
                    request.push(json);
                }
                console.log(request);
                $.ajax({
                    type:'POST',
                    url:'/inventory/save',
                    data:{ _token: '{{ csrf_token() }}', inventory: request },
                    success:function(data){
                        $('#message').html(data);
                    }
                });
            }

            function increment(key) {
                var stockElememt = document.getElementById('stock'+key);
                stockElememt.value = ++stockElememt.value;
            }

            function decrement(key) {
                var stockElememt = document.getElementById('stock'+key);
                stockElememt.value = (--stockElememt.value  < 0)? 0: stockElememt.value;
            }

        </script>

        <script src="https://kit.fontawesome.com/dc7af8d0aa.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js">
        // <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


    </body>

</html>


