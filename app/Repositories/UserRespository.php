<?php


namespace App\Repositories;


use App\User;

class UserRespository extends BaseRepository
{
    /**
     * @var User
     */
    protected $model;

    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return [];
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        // TODO: Implement model() method.
        return User::class;
    }


}
