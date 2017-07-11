<?php
namespace Hyperbolaa\Alisms;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class AlismsServiceProvider extends ServiceProvider
{

    /**
     * boot process
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
	protected function setupConfig()
	{
		$source_config = realpath(__DIR__ . '/../../config/config.php');

		if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
			$this->publishes([
				$source_config => config_path('alisms.php'),
			]);
		} elseif ($this->app instanceof LumenApplication) {
			$this->app->configure('alisms');
		}

		$this->mergeConfigFrom($source_config, 'alisms');
	}

    /**
     * Register the service provider.
     *
     * @return void
     */
	public function register()
	{
		$this->app->bind('alisms.yun', function ($app)
		{
			$alisms = new Sdk\SmsYun();
			$alisms->setAccessKeyId($app->config->get('alisms.yun.access_key_id'))
				->setAccessKeySecret($app->config->get('alisms.yun.access_key_secret'))
				->setCommonSignName($app->config->get('alisms.yun.common_sign_name'))
				->setSpreadSignName($app->config->get('alisms.yun.spread_sign_name'))
				->setTemplateCode($app->config->get('alisms.yun.template_code'));
			return $alisms;
		});
		$this->app->bind('alisms.api', function ($app)
		{
			$alisms = new Sdk\SmsApi();
			$alisms->setAppKey($app->config->get('alisms.api.api_app_key'))
				->setAppSecret($app->config->get('alisms.api.api_app_secret'))
				->setSignName($app->config->get('alisms.api.api_sign_name'))
				->setTemplateCode($app->config->get('alisms.api.api_template_code'));
			return $alisms;
		});
		$this->app->bind('alisms.note', function ($app)
		{
			$alisms = new Sdk\SmsNote();
			$alisms->setAccessKeyId($app->config->get('alisms.note.access_key_id'))
				->setAccessKeySecret($app->config->get('alisms.note.access_key_secret'))
				->setCommonSignName($app->config->get('alisms.note.common_sign_name'))
				->setTemplateCode($app->config->get('alisms.note.template_code'));
			return $alisms;
		});
	}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'alisms.yun',
            'alisms.api',
            'alisms.note',
        ];
    }
}
