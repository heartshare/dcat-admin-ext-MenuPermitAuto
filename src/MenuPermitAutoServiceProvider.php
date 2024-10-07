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
