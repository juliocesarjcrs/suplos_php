<?php

namespace App\Controllers;

use Core\Container;
use App\Traits\Response;
use Core\BaseController;

class BienesController extends BaseController
{
  use Response;

    public function index()
    {
        $bienModel = Container::getModel("Bien");
        $data = $bienModel->All();
        $this->json_response($data);
    }
    public function store($request)
    {

      $data =  [
        'id' => $request->post->id,
          'direccion' => $request->post->direccion,
          'ciudad' => $request->post->ciudad,
          'telefono' => $request->post->telefono,
          'codigo_postal' => $request->post->codigo_postal,
          'tipo' => $request->post->tipo,
          'precio' => $request->post->precio,
        ];
        $bienModel = Container::getModel("Bien");
        $data = $bienModel->create($data);
        $this->json_response($data, 201);
    }
    public function destroy($id)
    {
        $bienModel = Container::getModel("Bien");
        $data = $bienModel->delete($id);
        $this->json_response($data);
    }
}
