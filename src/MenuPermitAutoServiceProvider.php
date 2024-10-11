<?php

namespace Dcat\Admin\MenuPermitAuto;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\MenuPermitAuto\Http\Middleware\MenuPermitAuto;
use Dcat\Admin\Layout\Navbar;

class MenuPermitAutoServiceProvider extends ServiceProvider
{
	/*protected $js = [
        'js/index.js',
    ];
	protected $css = [
		'css/index.css',
	];*/

    protected $middleware = [
        'middle' => [ // 注册中间件
            MenuPermitAuto::class,
        ],
    ];

	/*public function register()
	{
		//
	}*/

	public function init()
	{
		parent::init();

		 Admin::navbar(function (Navbar $navbar) {
            if (request()->is('admin/auth/menu')) {
                Admin::script(<<<SCRIPT
                    const cardHeader = document.querySelector('.card-header.pb-1.with-border');
                    const newDiv = document.createElement('div');
                    const button = document.createElement('button');
                    button.textContent = '菜单权限同步';
                    button.classList.add('btn', 'btn-outline-primary', 'btn-sm');
                    button.addEventListener('click', () => {
                        fetch('auth/sync-menu-permit')
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('网络响应失败');
                                    Dcat.error('服务器出现未知错误');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('成功:', data);
                                Dcat.success(data);
                            })
                            .catch((error) => {
                                console.error('错误:', error);
                                 Dcat.error('服务器出现未知错误');
                            });
                    });
                    newDiv.appendChild(button);
                    cardHeader.appendChild(newDiv);
                SCRIPT);
            }
        });

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
