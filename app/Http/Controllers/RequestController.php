<?php

namespace App\Http\Controllers;

use App\Data\RequestData;
use App\Services\RequestService;
use Illuminate\Http\JsonResponse;

class RequestController extends Controller
{
    /**
     * @param RequestService $requestService
     */
    public function __construct(
        protected RequestService $requestService
    ){
    }

    /**
     * @param RequestData $data
     * @return JsonResponse
     */
    public function index(RequestData $data): JsonResponse
    {
        $requests = $this->requestService->getData($data);
        return response()->json(RequestData::collect($requests));
    }

    /**
     * @param RequestData $data
     * @return JsonResponse
     */
    public function save(RequestData $data): JsonResponse
    {
        $newRequest = $this->requestService->create($data);
        return response()->json($newRequest, 201);
    }

    /**
     * @param RequestData $data
     * @return JsonResponse
     */
    public function update(RequestData $data): JsonResponse
    {
        $updatedRequest = $this->requestService->update($data);
        return response()->json($updatedRequest);
    }
}
