<?php

namespace App\Http\Controllers;

use App\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use League\Fractal\TransformerAbstract;

/**
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected BaseService $service;
    protected TransformerAbstract $transformer;

    public function __construct(BaseService $service, TransformerAbstract $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @return BaseService
     */
    public function getService(): BaseService
    {
        return $this->service;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $pageSize = $request->input('page.size', null);
        $pageNumber = $request->input('page.number', null);

        return $request->has('page')
            ? $this->paginate($this->getService()->paginate($pageSize, $pageNumber, ['*']))
            : $this->response($this->getService()->findWithQueryBuilder());
    }

    /**
     * @param mixed $id
     * @return JsonResponse
     */
    public function baseShow($id)
    {
        return $this->response($this->getService()->find($id));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function baseDestroy($id, Request $request)
    {
        return $this->getService()->delete($id)
            ? $this->response(null, 204)
            : $this->response(null, 422);
    }

    /**
     * @param $data
     * @param int|null $defaultHttpCode
     * @param array $headers
     * @return mixed
     */
    public function response($data, ?int $defaultHttpCode = 200, array $headers = [])
    {
        $transformer = $this->getTransformer();

        return fractal($data, $transformer)
            ->serializeWith(new JsonApiSerializer())
            ->withResourceName($this->getService()->getEntityClassName())
            ->respond($defaultHttpCode, $this->getHeaders($headers));
    }

    /**
     * @param LengthAwarePaginator $data
     * @param int|null $defaultHttpCode
     * @param array $headers
     * @return mixed
     */
    public function paginate(LengthAwarePaginator $data, ?int $defaultHttpCode = 200, array $headers = [])
    {
        $transformer = app($this->getTransformer());

        return fractal($data, $transformer)
            ->serializeWith(new JsonApiSerializer())
            ->withResourceName($this->getService()->getEntityClassName())
            ->paginateWith(new IlluminatePaginatorAdapter($data))
            ->respond($defaultHttpCode, $this->getHeaders($headers));
    }

    /**
     * @param $errors
     * @param int|null $defaultHttpCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($errors, ?int $defaultHttpCode = 422, array $headers = [])
    {
        return response()->json(['errors' => static::getContent($errors)], static::getHttpCode($errors, $defaultHttpCode), static::getHeaders($headers));
    }

    /**
     * @param $headers
     * @return array
     */
    protected function getHeaders($headers)
    {
        $contentType = Arr::get($headers, 'Content-Type', Arr::get($headers, 'content-type'));

        if ($contentType === null) {
            $headers['Content-Type'] = 'application/vnd.api+json';
        }

        return $headers;
    }

    /**
     * @param $errors
     * @return array
     */
    protected static function getContent($errors)
    {
        $result = [];

        foreach ($errors as $error)
        {
            $result[] = $error->toArray();
        }

        return $result;
    }

    /**
     * @param $errors
     * @param int|null $defaultHttpCode
     * @return int|null
     */
    protected static function getHttpCode($errors, ?int $defaultHttpCode = null)
    {
        if (!blank($defaultHttpCode)) {
            return $defaultHttpCode;
        }

        $collection = collect($errors);

        $grouped = $collection->groupBy(function ($item, $key) {
            return $item->getStatus();
        });

        $sorted = $grouped->sortByDesc(function ($item, $key) {
            return $item->count();
        });

        $httpCode = $sorted->keys()->first();

        return $httpCode ?? 422;
    }

    public function getTransformer()
    {
        return $this->transformer;
    }

}
