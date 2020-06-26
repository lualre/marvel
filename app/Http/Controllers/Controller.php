<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use  GuzzleHttp \ Client ;
use App\Sucursales;
use App\Inventario;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function loadInformacion(Request $request){
        $client  =  new  Client ([
            'base_uri'  =>  'http://gateway.marvel.com'
        ]);
        $response = $client->request('GET', '/v1/public/comics/'.$request->get('id').'?ts=1&apikey=14cfef4a2ed0248b39a2f9897cbe6dd8&hash=ddc175e39e993b7af94eb8f6856aa1cb');
        $data = json_decode($response->getBody()->getContents());
        $results = $data->data->results;


        foreach($results as $value){
            foreach($value->characters->items AS $characters){
                $ruta = explode(".com", $characters->resourceURI);
                $final = $ruta[1];
                $info = $client->request('GET', $final.'?ts=1&apikey=14cfef4a2ed0248b39a2f9897cbe6dd8&hash=ddc175e39e993b7af94eb8f6856aa1cb');
                $info2 = json_decode($info->getBody()->getContents());
                $characters->img = $info2->data->results[0]->thumbnail->path.'.'.$info2->data->results[0]->thumbnail->extension;
            }
        }
        $results = $results[0];
        return view('partials.informacion')
            ->with('results', $results);
    }


    public function sucursales(){

        $sucursales = DB::table('sucursales')->get();

        return view('sucursales')
            ->with('sucursales', $sucursales);
    }

    public function sucursalesSave(Request $request){
        if($request->estatus){
            $status = 1;
        }else{
            $status = 0;
        }
        $sucursal = new Sucursales;
        $sucursal->name = $request->nombre;
        $sucursal->status =  $status;
        $sucursal->save();

        return redirect('sucursales')->with('status', 'La Sucursal se guardo exitosamente!');
    }


    public function loadFormSucursales(){
        return view('partials.formSucursales');
    }

    public function loadFormSucursalesEdit(Request $request){
        $sucursal = Sucursales::find($request->id);

        return view('partials.formSucursalEdit')
            ->with('sucursal', $sucursal);;
    }

    public function sucursalesEdit(Request $request){
        if($request->estatus == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        $sucursal = Sucursales::find($request->id);
        $sucursal->name = $request->nombre;
        $sucursal->status =  $status;
        $sucursal->save();

        return redirect('sucursales')->with('status', 'La Sucursal se modifico exitosamente!');
    }

    public function sucursalesDelete(Request $request){

        $sucursal = Sucursales::find($request->id);
        $sucursal->delete();

        return redirect('sucursales')->with('status', 'La Sucursal se elimino exitosamente!');
    }


    public function sucursalesAdd($idSucursal, $nombreSucursal){
        $inventario = DB::table('inventario')->where('id_sucursal', $idSucursal)->get();
        $client  =  new  Client ([
            'base_uri'  =>  'http://gateway.marvel.com'
        ]);
        $response = $client->request('GET', '/v1/public/comics?ts=1&apikey=14cfef4a2ed0248b39a2f9897cbe6dd8&hash=ddc175e39e993b7af94eb8f6856aa1cb');
        $data = json_decode($response->getBody()->getContents());
        $results = $data->data->results;
        if(count($inventario) == 0 ) {
            foreach($results as $values){
                $stock = new Inventario;
                $stock->id_sucursal = $idSucursal;
                $stock->id_comic =  $values->id;
                $stock->nombre_comic = $values->title;
                $stock->image = $values->thumbnail->path.'.'.$values->thumbnail->extension;
                $stock->stock =  0;
                $stock->save();
            }
            $inventario = DB::table('inventario')->where('id_sucursal', $idSucursal)->get();
        }
        return view('inventario', compact('inventario', 'nombreSucursal', 'idSucursal'));
    }

    public function saveInventory(Request $request){
        foreach($request->inventory as $values){
            $storehouse = Inventario::find($values['idInventario']);
            $storehouse->stock = $values['stock'];
            $storehouse->save();
        }
        return '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">x</button>'.'Inventario acualizado exitosamente!'.'</div>';
    }

}
