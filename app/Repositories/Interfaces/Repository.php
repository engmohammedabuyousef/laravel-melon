<?php

namespace App\Repositories\Interfaces;

interface Repository
{
    function getAll(array $attributes);

    function getById($id);

    function create(array $attributes);

    function update(array $attributes, $id = null);

    function delete($id);
}
