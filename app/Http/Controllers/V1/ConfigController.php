<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateConfigRequest;
use App\Http\Resources\V1\ConfigDetailResource;
use App\Http\Resources\V1\ConfigListResource;
use App\Models\Config;

class ConfigController extends Controller
{
    public function index()
    {
        $subjects = Config::jsonPaginate();

        return ConfigListResource::collection($subjects)->additional([
            'message' => 'Success to get all configs',
        ]);
    }

    public function update(UpdateConfigRequest $request, Config $config)
    {
        $config->update($request->validated());

        return (new ConfigDetailResource($config))
            ->additional([
                'message' => 'Success to update config',
            ])
            ->response()
            ->setStatusCode(200);
    }
}
