<?php

namespace Dcat\Admin\MenuPermitAuto;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\MenuPermitAuto\Http\Middleware\MenuPermitAuto;

class MenuPermitAutoServiceProvider extends ServiceProvider
{
	/*protected $js = [
        'js/index.js',
    ];
	protected $css = [
		'css/index.css',
	];*/

public function boot()
    {
        Admin::navbar(function (Navbar $navbar) {
            if (request()->is('admin/auth/menu')) {
                Admin::script(<<<SCRIPT
                    const cardHeader = document.querySelector('.card-header.pb-1.with-border');
                    const newDiv = document.createElement('div');
                    const button = document.createElement('button');
                    const link = document.createElement('a');
                    button.textContent = '菜单权限同步';
                    button.classList.add('btn', 'btn-outline-primary', 'btn-sm');
                    link.appendChild(button);
                    link.href = '/admin/auth/permissions';
                    newDiv.appendChild(link);
                    cardHeader.appendChild(newDiv);
                SCRIPT);
            }
        });
    }

    protected $middleware = [
        'middle' => [ // 注册中间件
            MenuPermitAuto::class,
        ],
    ];

	/*public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

		//

	}*/

	public function settingForm()
	{
		return new Setting($this);
	}
}
