<?php

namespace App\Repositories;

use App\Data\RequestData;
use App\Models\Request;
use Illuminate\Database\Eloquent\Builder;


class RequestRepository
{
    /**
     * Create new request
     * @param RequestData $data
     * @return Request
     */
    public function create(RequestData $data): Request
    {
        return Request::create($data->all());
    }

    /**
     * Update Request
     * @param RequestData $data
     * @return Request
     */
    public function update(RequestData $data): Request
    {
        $requestModel = Request::find($data->id);
        $requestModel->update($data->except('id')->toArray());
        return $requestModel;
    }

    /**
     * @param RequestData $data
     * @return Request
     */
    public function getData(RequestData $data): mixed
    {
        return Request::query()
            ->when($data->status, function (Builder $builder) use ($data) {
                return $builder->where('status', $data->status);
            })
            ->get();
    }
}
