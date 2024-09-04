<?php

namespace App\Http\Controllers;

use App\Repositories\ContactRepository;
use App\Http\Requests\Contact\Index;
use App\Http\Requests\Contact\Store;
use App\Http\Requests\Contact\Update;
use App\Http\Requests\Contact\Delete;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{

    protected ContactRepository $contactRepository;


    public function __construct()
    {
        $this->contactRepository = new ContactRepository();
    }

    /**
     * handles contact index
     *
     * @param App\Http\Requests\Contact\Index $request
     * @return Illuminate\Http\JsonResponse
     */
    public function index(Index $request): JsonResponse
    {
        $data = $request->validated();
        $response = $this->contactRepository->index($data);
        return $this->contactRepository->getJsonResponse($response);
    }

    /**
     * handles contact store
     *
     * @param App\Http\Requests\Contact\Store $request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Store $request): JsonResponse
    {
        $data = $request->validated();
        $response = $this->contactRepository->store($data);
        return $this->contactRepository->getJsonResponse($response);
    }

    /**
     * handles contact update
     *
     * @param App\Http\Requests\Contact\Update $request
     * @return Illuminate\Http\JsonResponse
     */
    public function update(Update $request, $id): JsonResponse
    {
        $data = $request->validated();
        $response = $this->contactRepository->update($data, $id);
        return $this->contactRepository->getJsonResponse($response);
    }

    /**
     * handles contact delete
     *
     * @param App\Http\Requests\Contact\Delete $request
     * @return Illuminate\Http\JsonResponse
     */
    public function delete(Delete $request, $id): JsonResponse
    {
        $data = $request->validated();
        $response = $this->contactRepository->delete($data, $id);
        return $this->contactRepository->getJsonResponse($response);
    }
}
