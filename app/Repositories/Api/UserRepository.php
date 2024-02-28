<?php
namespace App\Repositories\Api;

use App\Models\User;

class UserRepository extends Repository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getUserlist($data)
    {
        $term = $data->term ?? "";
        $sort = $data->sortBy ?? 'id';
        $order = $data->orderBy ?? 'desc';
        $perPage = $data->perPage ?? 10;

        $users = $this->model->select('*');
        if ($term) {
            $users->whereLike(['name', 'email'], $term);
        }
        return $users->orderBy($sort, $order)->paginate($perPage);
    }

}
