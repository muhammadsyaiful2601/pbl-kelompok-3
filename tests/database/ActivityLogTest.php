<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\ActivityLogModel;

/**
 * @internal
 */
final class ActivityLogTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'App';

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure the helper is loaded
        helper(['activity', 'url']);
    }

    public function testLogActivityNotLoggedIn(): void
    {
        // Clear session mock
        $session = service('session');
        $session->destroy();

        // Run log activity
        log_activity('tambah', 'sekolah', 1, 'Menambahkan sekolah');

        // Verify that no database record was written
        $model = new ActivityLogModel();
        $this->assertCount(0, $model->findAll());
    }

    public function testLogActivityLoggedIn(): void
    {
        // Mock session log-in
        $session = service('session');
        $session->set([
            'id_user'      => 42,
            'username'     => 'testadmin',
            'nama_lengkap' => 'Test Admin',
            'role'         => 'admin',
            'logged_in'    => true
        ]);

        // Run log activity
        log_activity('ubah', 'sekolah', 10, 'Mengubah sekolah test');

        // Verify that db record was written and contents match
        $model = new ActivityLogModel();
        $logs = $model->findAll();

        $this->assertCount(1, $logs);
        
        $log = $logs[0];
        $this->assertEquals(42, $log['id_user']);
        $this->assertEquals('testadmin', $log['username']);
        $this->assertEquals('Test Admin', $log['nama_lengkap']);
        $this->assertEquals('admin', $log['role']);
        $this->assertEquals('ubah', $log['action']);
        $this->assertEquals('sekolah', $log['target_table']);
        $this->assertEquals(10, $log['target_id']);
        $this->assertEquals('Mengubah sekolah test', $log['description']);
        $this->assertNotEmpty($log['ip_address']);
        $this->assertNotEmpty($log['created_at']);
    }
}
