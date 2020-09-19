<?php

namespace App\Http\Controllers\Admin\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportUsersRequest;
use App\Services\Users\ImportService;
use Illuminate\Http\Request;

class ImportUsersController extends Controller
{
    protected $service;

    public function __construct(ImportService $importService)
    {
        $this->service = $importService;
    }

    public function __invoke(ImportUsersRequest $request)
    {
        $result = $this->service->importUsers($request->validated());
        return response()->json($result);
    }
}
