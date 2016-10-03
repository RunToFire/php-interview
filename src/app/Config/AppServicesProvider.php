<?php

namespace Config;

class AppServicesProvider {

	public function register(\Interop\Container\ContainerInterface $container) {

		if (!isset($container['json_serializer'])) {
			$container['json_serializer'] = function($c) {
				return new \Services\Serialization\JsonSerializer();
			};
		}

		if (!isset($container['student_repository'])) {
			$container['student_repository'] = function($c) {
				$serializer = $c['json_serializer'];
				$repo = new \Services\Repository\JsonRepository(__DIR__ . '/../../resources/students.json', $serializer);
				return $repo;
			};
		}

		if (!isset($container['view'])) {
			$container['view'] = function ($container) {
				$view = new \Slim\Views\Twig(__DIR__ . '/../Views/');
				$view->addExtension(new \Slim\Views\TwigExtension(
					$container['router'],
					$container['request']->getUri()
				));

				return $view;
			};
		}

	}

}
