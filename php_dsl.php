<?php
function buf($arg = null) {
	static $buf = array();
	if($arg) {
		$buf[] = str_replace(array('_'), ' ', $arg);
	}
	return $buf;
}

spl_autoload_register(function($class) {
	buf($class);
	if(!class_exists($class)) {
		eval(sprintf('
		class %s {
			static function __callStatic($method, $arg) { buf($method); return new self;}
			function __call($method, $arg) { buf($method."\n"); return $this;}
		}
		', $class));
	}
});

register_shutdown_function(function() {
	print implode(" ", buf());
});

Hello::beautiful()->how_are_you();

I::am_fine()->thanks();
