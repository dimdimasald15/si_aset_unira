<?php

namespace App\Services;

class DeleteTemporaryService
{
    protected $db;
    protected $model;

    public function __construct($model)
    {
        $this->db = \Config\Database::connect();
        $this->model = $model;
    }

    public function softDelete($id, $name, $nameValue)
    {
        try {
            $this->model->setSoftDelete($id);
            return [
                'success' => "Data $name : $nameValue berhasil dihapus",
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}
