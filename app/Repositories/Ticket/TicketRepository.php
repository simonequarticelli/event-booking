<?php

namespace App\Repositories\Ticket;

use App\Models\Ticket;

class TicketRepository implements TicketRepositoryInterface
{
    protected Ticket $model;

    public function __construct()
    {
        $this->model = new ticket();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function save(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
