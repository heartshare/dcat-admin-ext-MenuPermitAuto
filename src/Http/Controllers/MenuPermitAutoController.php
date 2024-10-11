<?php

namespace Dcat\Admin\MenuPermitAuto\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Illuminate\Routing\Controller;

use Dcat\Admin\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Dcat\Admin\Models\Permission;
use Illuminate\Support\Facades\DB;

class MenuPermitAutoController extends Controller
{
    protected $signature = 'admin:menu';
    protected $description = 'backup or populate menu data';
    private $backupPath = '';
    
    public function index(Content $content)
    {
        return $content
            ->title('Title')
            ->description('Description')
            ->body(Admin::view('tony.menu-permit-auto::index'));
    }

    public function syncMenuPeimit() {
        $this->backupPath = storage_path('menu-backup.bak');
        if ($this->backupMenu() == 200) {
            if ($this->fillMenu() == 200) {
                return 200;
            }
        }
        return 400;
    }

    /**
     * backup menu
     */
    private function backupMenu()
    {
        $res = file_put_contents($this->backupPath, serialize(optional(Menu::get())->toArray()));
        return $res ? 200 : 400;
    }
    
    /**
     * fill menu
     */
    private function fillMenu()
    {
        $menu = unserialize(file_get_contents($this->backupPath));

        $permission = $this->generatePermissions($menu);

        Menu::truncate();
        Menu::insert($menu);

        Permission::truncate();
        Permission::insert($permission);

        DB::table('admin_permission_menu')->truncate();
        foreach ($permission as $item) {
            $query = DB::table('admin_permission_menu');
            $query->insert([
                'permission_id' => $item['id'],
                'menu_id'       => $item['id'],
            ]);
            if ($item['parent_id'] != 0) {
                $query->insert([
                    'permission_id' => $item['id'],
                    'menu_id'       => $item['parent_id'],
                ]);
            }
        }
        return 200;
    }

    private function generatePermissions($menu)
    {
        $permissions = [];
        foreach ($menu as $item) {
            $temp = [];

            $temp['id']         = $item['id'];
            $temp['name']       = $item['title'];
            $temp['slug']       = (string)Str::uuid();
            $temp['http_path']  = $this->getHttpPath($item['uri']);
            $temp['order']      = $item['order'];
            $temp['parent_id']  = $item['parent_id'];
            $temp['created_at'] = $item['created_at'];
            $temp['updated_at'] = $item['updated_at'];

            $permissions[] = $temp;
            unset($temp);
        }

        return $permissions;
    }

    private function getHttpPath($uri)
    {
        if ($uri == '/') {
            return '';
        }

        if ($uri == '') {
            return '';
        }

        if (strpos($uri, '/') !== 0) {
            $uri = '/' . $uri;
        }

        return $uri . '*';
    }
    
}
