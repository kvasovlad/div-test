<?php

namespace App\Services;

use App\Data\RequestData;
use App\Enums\RequestStatusesEnum;
use App\Models\Request;

use App\Repositories\RequestRepository;

class RequestService
{
    /**
     * @param RequestRepository $requestRepository
     */
    public function __construct(
        protected RequestRepository $requestRepository
    ){
    }

    /**
     * @param RequestData $data
     * @return Request
     */
    public function create(RequestData $data): Request
    {
        $data->status = RequestStatusesEnum::Active;
        return $this->requestRepository->create($data);
    }

    /**
     * @param RequestData $data
     * @return Request
     */
    public function update(RequestData $data): Request
    {
        $data->status = RequestStatusesEnum::Resolved;
        return $this->requestRepository->update($data);
    }

    /**
     * @param RequestData $data
     * @return mixed
     */
    public function getData(RequestData $data): mixed
    {
        return $this->requestRepository->getData($data);
    }
}
