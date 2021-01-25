<?php

namespace App\Controllers;

use App\Excel\Excel;
use App\Traits\Response;
use Core\BaseController;
use Core\Container;

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
        $price = $request->post->precio;
        $price2 = str_replace(",", ".", $price);
        $price2 = floatval($price2);
        $data = [
            'id' => $request->post->id,
            'direccion' => $request->post->direccion,
            'ciudad' => $request->post->ciudad,
            'telefono' => $request->post->telefono,
            'codigo_postal' => $request->post->codigo_postal,
            'tipo' => $request->post->tipo,
            'precio' => $price2,
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
    public function exportar($request)
    {
        $bienModel = Container::getModel("Bien");
        $data = $bienModel->All();
        if (isset($request->get->tipo)) {
            $data = array_values($this->filterData($data, 'tipo', $request->get->tipo));
        }
        if (isset($request->get->ciudad)) {
            $data = array_values($this->filterData($data, 'ciudad', $request->get->ciudad));
        }
        $headers = [
            'id',
            'direccion',
            'ciudad',
            'telefono',
            'codigo_postal',
            'tipo',
            'precio',
        ];
        return Excel::createExcel($data, $headers);
    }
    public function filterData($collection, string $field, $query)
    {
        $collection = array_filter($collection, function ($obj) use ($field, $query) {
            if ($obj->$field === $query) {
                return true;
            }
            return false;
        });
        return $collection;
    }
}
