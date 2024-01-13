<?php

namespace App\Repositories\Ticket;

interface TicketRepositoryInterface
{
    public function all();

    public function find($id);

    public function save(array $data);

    public function update(array $data, $id);

    public function delete($id);
}
