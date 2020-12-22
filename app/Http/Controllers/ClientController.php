<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;

class ClientController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message = null;

        $clients = Client::all();

        if ($clients->isEmpty()) {
            $message = $this->sendError('No hay datos', ['No hay clientes registrados'], 422);
        } else {
            $message = $this->sendResponse($clients, 'Datos recuperados correctamente');
        }

        return $message;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = null;

        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'identification' => 'required|numeric|unique:clients',
            'telephone' => 'required|numeric'
        ]);

        if($validator->fails()) {
            $message = $this->sendError('Error de validación', [$validator->errors()], 422);
        }else {
            $client = new Client();
            $client->name = $request->get('name');
            $client->surname = $request->get('surname');
            $client->identification = $request->get('identification');
            $client->telephone = $request->get('telephone');

            $client->save();

            $message = $this->sendResponse($client, 'Cliente registrado correctamente');
        }

        return $message;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = null;

        $client = Client::find($id);

        if($client === null){
            $message = $this->sendError('Error en la consulta', ['El cliente no existe'], 422);
        }else{
            $message = $this->sendResponse($client, 'Cliente encontrado correctamente');
        }

        return $message;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = null;

        $client = Client::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'identification' => 'required|numeric',
            'telephone' => 'required|numeric'
        ]);

        if($client === null){
            $message = $this->sendError('Error al actualizar el registro', ['Cliente no encontrado'], 422);
        }elseif ($validator->fails()) {
            $message = $this->sendError('Error de validación', [$validator->errors()], 422);
        }else{
            $client->name = $request->get('name');
            $client->surname = $request->get('surname');
            $client->identification = $request->get('identification');
            $client->telephone = $request->get('telephone');
            $client->save();

            $message = $this->sendResponse($client, 'Cliente actualizado correctamente');
        }

        return $message;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = null;

        $client = Client::find($id);

        if($client === null){
            $message = $this->sendError('Error en la consulta', ['No se encontro el registro'], 422);
        }else{
            $client->delete();
            $message = $this->sendResponse($client, 'Cliente eliminado correctamente');
        }

        return $message;
    }
}
