<?php

namespace Dcat\Admin\MenuPermitAuto\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Illuminate\Routing\Controller;

class MenuPermitAutoController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Title')
            ->description('Description')
            ->body(Admin::view('tony.menu-permit-auto::index'));
    }
}