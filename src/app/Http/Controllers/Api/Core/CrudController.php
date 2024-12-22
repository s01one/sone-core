<?php

namespace sOne\Core\app\Http\Controllers\Api\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CrudController extends Controller
{
    /**
     * Получить список записей и конфигурацию полей.
     *
     * @param string $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($model)
    {
        $class = $this->getModelClass($model);
        $records = $class::all();

        $fields = $this->getFieldsConfig($class);

        return response()->json([
            'data' => $records,
            'fields' => $fields,
        ]);
    }

    /**
     * Создать новую запись.
     *
     * @param Request $request
     * @param string $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $model)
    {
        $class = $this->getModelClass($model);
        $fields = $this->getFieldsConfig($class, 'store');

        $validator = Validator::make($request->all(), $this->getValidationRules($fields));

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $record = $class::create($request->all());

        return response()->json($record, 201);
    }

    /**
     * Показать одну запись и конфигурацию полей.
     *
     * @param string $model
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($model, $id)
    {
        $class = $this->getModelClass($model);
        $record = $class::findOrFail($id);

        $fields = $this->getFieldsConfig($class, 'show');

        return response()->json([
            'data' => $record,
            'fields' => $fields,
        ]);
    }

    /**
     * Обновить запись.
     *
     * @param Request $request
     * @param string $model
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $model, $id)
    {
        $class = $this->getModelClass($model);
        $record = $class::findOrFail($id);
        $fields = $this->getFieldsConfig($class, 'update');

        $validator = Validator::make($request->all(), $this->getValidationRules($fields, $id));

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $record->update($request->all());

        return response()->json($record);
    }

    /**
     * Удалить запись.
     *
     * @param string $model
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($model, $id)
    {
        $class = $this->getModelClass($model);
        $record = $class::findOrFail($id);
        $record->delete();

        return response()->json(null, 204);
    }

    /**
     * Массовое удаление записей.
     *
     * @param Request $request
     * @param string $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request, $model)
    {
        $class = $this->getModelClass($model);
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['message' => 'Нет ID для удаления.'], 400);
        }

        $deleted = $class::bulkDelete($ids);

        return response()->json(['deleted' => $deleted], 200);
    }

    /**
     * Импорт данных.
     *
     * @param Request $request
     * @param string $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request, $model)
    {
        $class = $this->getModelClass($model);
        $class::importData($request);

        return response()->json(['message' => 'Импорт завершён успешно.'], 200);
    }

    /**
     * Экспорт данных.
     *
     * @param string $model
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export($model)
    {
        $class = $this->getModelClass($model);
        return $class::exportData();
    }

    /**
     * Получить класс модели по названию.
     *
     * @param string $model
     * @return string
     */
    private function getModelClass($model)
    {
        $class = 'App\\Models\\' . Str::studly($model);

        if (!class_exists($class)) {
            abort(404, 'Модель не найдена.');
        }

        return $class;
    }

    /**
     * Получить конфигурацию полей для модели.
     *
     * @param string $class
     * @param string|null $action
     * @return array
     */
    private function getFieldsConfig($class, $action = null)
    {
        if (method_exists($class, 'getFieldsConfig')) {
            return $class::getFieldsConfig($action);
        }

        return [
            ['name' => 'id', 'label' => 'ID', 'type' => 'number', 'sortable' => true],
            ['name' => 'name', 'label' => 'Имя', 'type' => 'text', 'sortable' => true],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'sortable' => true],
            ['name' => 'created_at', 'label' => 'Создано', 'type' => 'date', 'sortable' => true],
        ];
    }

    /**
     * Получить правила валидации для полей.
     *
     * @param array $fields
     * @param int|null $id
     * @return array
     */
    private function getValidationRules($fields, $id = null)
    {
        $rules = [];

        foreach ($fields as $field) {
            if (isset($field['validation'])) {
                $rules[$field['name']] = $field['validation'];
            }
        }

        return $rules;
    }
}
