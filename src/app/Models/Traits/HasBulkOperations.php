<?php

namespace sOne\Core\app\Models\Traits;

trait HasBulkOperations
{
    /**
     * Выполнить массовое удаление записей.
     *
     * @param array $ids
     * @return int
     */
    public static function bulkDelete(array $ids): int
    {
        return self::whereIn('id', $ids)->delete();
    }

    /**
     * Выполнить массовое обновление записей.
     *
     * @param array $ids
     * @param array $data
     * @return int
     */
    public static function bulkUpdate(array $ids, array $data): int
    {
        return self::whereIn('id', $ids)->update($data);
    }
}
