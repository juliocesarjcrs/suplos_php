<?php

namespace App\Controllers;

use Core \Container;
use App\Traits\Response;
use Core\BaseController;

class HomeController extends BaseController
{
    use Response;
    private $data;
    public function __construct()
    {
        parent::__construct();
        $url = __DIR__ . "/../../storage/database/data-1.json";
        $file = file_get_contents($url);
        $this->data = json_decode($file);
    }
    public function index()
    {
        $temp_data = $this->data;
        $this->view->citys = $this->getSelectData($temp_data, 'Ciudad');
        $this->view->tipos = $this->getSelectData($temp_data, 'Tipo');
        $this->renderView('home/index');

    }
    public function getSelectData($collection, string $field)
    {

        $data = [];
        foreach ($collection as $key => $current) {
            static $final = array();
            if (!in_array($current->$field, $final)) {
                $final[] = $current->$field;
                $data[] = ["id" => $key + 1, 'name' => $current->$field];
            }
        }
        return $data;
    }
    public function consume_data($request)
    {
        $data = $this->data;
        if (isset($request->get->tipo)) {
            $data = array_values($this->filterData($data, 'Tipo', $request->get->tipo));
        }
        if (isset($request->get->ciudad)) {
            $data = array_values($this->filterData($data, 'Ciudad', $request->get->ciudad));
        }
        $data = $this->estaGuardado($data);
        $this->json_response($data);
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
    public function estaGuardado($data)
    {
        $bienModel = Container::getModel("Bien");
        $data_guardada = $bienModel->All();
        foreach ($data as $key => $original) {
            $original->guardada = false;
            foreach ($data_guardada as $key2 => $val) {
                if($val->id == $original->Id){
                    $original->guardada = true;
                }
            }
        }
        return $data;

    }
}
