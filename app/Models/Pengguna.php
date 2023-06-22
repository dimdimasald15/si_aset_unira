<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;


class Pengguna extends Model
{
    protected $table            = 'petugas';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id', 'nip', 'email', 'username', 'password', 'role', 'created_by', 'created_at', 'update_by', 'update_at', 'deleted_by', 'deleted_at', 'foto'];
    protected $useSoftDeletes   = true;
    protected $useTimestamps    = false;
    protected $createdField     = 'created_at';
    protected $updatedField     = null;
    protected $deletedField     = 'deleted_at';
    protected $useAutoIncrement = true;
    protected $allowCallbacks   = true;
    protected $beforeInsert = ['setInsertData'];
    protected $beforeUpdate = ['setUpdateData'];

    public function setInsertData(array $data)
    {
        $username = session()->get('username');
        if (
            !empty($username) &&
            !array_key_exists('created_by', $data)
        ) {
            $data['data']['created_at'] = Time::now('Asia/Jakarta', 'id_ID');
            $data['data']['created_by'] = $username;
        }
        return $data;
    }

    public function setUpdateData(array $data)
    {
        $username = session()->get('username');
        if (!empty($username) && !array_key_exists('updated_by', $data)) {
            $data['data']['updated_at'] = Time::now('Asia/Jakarta', 'id_ID');
            $data['data']['updated_by'] = $username;
        }
        return $data;
    }

    public function setSoftDelete($id)
    {
        $session = \Config\Services::session();
        $data = [
            'deleted_by' => $session->get('username'),
            'deleted_at' => Time::now('Asia/Jakarta', 'id_ID')
        ];
        $this->update($id, $data);
    }

    public function updatePassword($id, $newPassword)
    {
        $builder = $this->db->table($this->table);

        $builder->where('id', $id);
        $builder->update(['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);
    }
}
