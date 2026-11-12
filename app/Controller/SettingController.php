
<?php

require_once dirname(__DIR__) . '/Models/Model.php';
require_once dirname(__DIR__) . '/Models/Settings.php';

class SettingController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }

    // READ: Display all settings
    public function index()
    {
        $settingModel = new Settings();
        $setting = $settingModel->all();

        $this->view('setting/store_setting', [
            'setting' => $setting
        ]);
    }

    // CREATE: Display create form
    public function create()
    {
        $this->view('setting/create');
    }

    // STORE: Save new setting
    public function store_setting()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $data = [
            'setting_key' => trim($_POST['setting_key'] ?? ''),
            'setting_value' => trim($_POST['setting_value'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($data['setting_key'] === '') {
            exit('Setting key is required.');
        }

        $settingModel = new Settings();
        $settingModel->create($data);

        header('Location: /dashboard_shopping/store_setting');
        exit;
    }

    // EDIT: Display edit form
   public function edit()
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$id || $id < 1) {
        http_response_code(400);
        exit('Invalid setting ID.');
    }

    $settingModel = new Settings();
    $editItem = $settingModel->find($id);

    if ($editItem === null) {
        http_response_code(404);
        exit('Setting not found.');
    }

    // ⚠️ បន្ថែម 3 បន្ទាត់នេះ
    $allSettings = $settingModel->all();
    $settingsByKey = [];
    foreach ($allSettings as $item) {
        $settingsByKey[$item['setting_key']] = $item;
    }

    $this->view('setting/edit', [
        'editItem'      => $editItem,
        'settingsByKey' => $settingsByKey,   // ← បន្ថែម
    ]);
}

    // UPDATE: Save edited setting
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            http_response_code(400);
            exit('Invalid setting ID.');
        }

        $data = [
            'setting_key'   => trim($_POST['setting_key'] ?? ''),
            'setting_value' => trim($_POST['setting_value'] ?? ''),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        if ($data['setting_key'] === '') {
            exit('Setting key is required.');
        }

        $settingModel = new Settings();
        $setting = $settingModel->find($id);

        if ($setting === null) {
            http_response_code(404);
            exit('Setting not found.');
        }

        $settingModel->update($id, $data);

        // ត្រឡប់ទៅ list វិញ (គ្មាន view)
        header('Location: /dashboard_shopping/store_setting');
        exit;
    }

    // DELETE: Remove setting
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            http_response_code(400);
            exit('Invalid setting ID.');
        }

        $settingModel = new Settings();
        $setting = $settingModel->find($id);

        if ($setting === null) {
            http_response_code(404);
            exit('Setting not found.');
        }

        $settingModel->delete($id);

        header('Location: /dashboard_shopping/store_setting');
        exit;
    }
}
