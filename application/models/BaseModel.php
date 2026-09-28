<?php

namespace App\Models;

/**
 * The only place SQL lives. A model gets the DB repository
 * (Easysite\Library\Db\Class\SqlRepository) and is created lazily via
 * UsesModels::model() — only when a command/service actually needs it.
 */
abstract class BaseModel
{
    public function __construct(protected $db) {}

    protected function now(): string
    {
        return date('Y-m-d H:i:s');
    }

    /** Find the internal id by an external id, or insert a new row. Leaves an existing row untouched. */
    protected function insertIfMissing(string $table, string $idColumn, int $externalId, array $columns): int
    {
        $existing = $this->db->fetchOne(
            "SELECT id FROM {$table} WHERE {$idColumn} = :eid LIMIT 1",
            ['eid' => $externalId]
        );
        if ($existing) {
            return (int) $existing['id'];
        }

        return (int) $this->db->insert($table, array_merge([$idColumn => $externalId], $columns));
    }

    /** Same, for join tables with no external id: existence is checked by a natural key. */
    protected function insertIfMissingByKeys(string $table, array $keys, array $columns = []): void
    {
        $where = implode(' AND ', array_map(fn ($k) => "{$k} = :{$k}", array_keys($keys)));
        if ($this->db->fetchOne("SELECT 1 AS found FROM {$table} WHERE {$where} LIMIT 1", $keys)) {
            return;
        }
        $this->db->insert($table, array_merge($keys, $columns));
    }

    /** external id => internal id. */
    protected function idMapOf(string $table, string $idColumn): array
    {
        $map = [];
        foreach ($this->db->fetchAll("SELECT id, {$idColumn} FROM {$table}") as $row) {
            $map[(int) $row[$idColumn]] = (int) $row['id'];
        }

        return $map;
    }

    /**
     * CALL a stored procedure with IN and OUT parameters (OUT via @o_* variables on
     * the same connection). Returns [out_name => value].
     */
    protected function callProcedure(string $name, array $in, array $outNames): array
    {
        $placeholders = [];
        $params = [];
        foreach (array_values($in) as $i => $value) {
            $placeholders[] = ':p' . $i;
            $params['p' . $i] = $value;
        }
        $outVars = array_map(fn ($n) => '@o_' . $n, $outNames);

        $this->db->query(
            'CALL ' . $name . '(' . implode(',', array_merge($placeholders, $outVars)) . ')',
            $params
        )->closeCursor();

        $select = implode(',', array_map(fn ($n) => "@o_{$n} AS {$n}", $outNames));

        return $this->db->fetchOne('SELECT ' . $select) ?: [];
    }
}
