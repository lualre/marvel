
<div class="col-md-12 pl-4 pr-4 row">
    <div class="col-md-4">
        <img src="{{ ($results->images) ? $results->images[0]->path.'.'.$results->images[0]->extension : asset('img/comic.jpg') }}" class="card-img-top"  height="330">
    </div>
    <div class="col-md-8 col">
        <p>
            <strong>Titulo: </strong>{{$results->title}}
        </p>
        <p>
            <strong>Volumne: </strong>
        </p>
        <p>
            <strong>Fecha de lanzamiento:</strong>  {{date("d/m/Y", strtotime($results->dates[0]->date))}}
        </p>
        <p>
            <strong>Paginas: </strong> {{$results->pageCount}}
        </p>
        <p>
            <strong> Descripción: </strong> {{$results->description}}
        </p>
        <p>
            <strong>Sucursales con existencia: </strong>  {{$results->creators->available}}
        </p>
    </div>
</div>

<strong>Personajes:</strong>
<div class="row">
    @foreach($results->characters->items  as $characters)
        <div class="col-md-3">
            <img src="{{$characters->img}}" alt="" class="img">
            <small>
                    {{$characters->name}} ,
            </small>

        </div>
    @endforeach
</div>


<style>
.img{
    width: 20%;
    border-radius: 50%;
}
</style>
