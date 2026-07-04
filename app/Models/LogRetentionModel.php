<?php

namespace App\Models;

use CodeIgniter\Model;

class LogRetentionModel extends Model
{
    protected $table         = 'log_retention_settings';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['key', 'value', 'updated_at'];
    protected $useTimestamps = false;

    /**
     * Get a setting value by key.
     */
    public function getSetting(string $key): ?string
    {
        $row = $this->where('key', $key)->first();
        return $row ? $row['value'] : null;
    }

    /**
     * Set a setting value by key.
     */
    public function setSetting(string $key, string $value): void
    {
        $existing = $this->where('key', $key)->first();
        if ($existing) {
            $this->update($existing['id'], [
                'value'      => $value,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $this->insert([
                'key'        => $key,
                'value'      => $value,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Get auto_delete_days value (default: 30).
     */
    public function getAutoDeleteDays(): int
    {
        $days = $this->getSetting('auto_delete_days');
        return $days ? (int) $days : 30;
    }
}