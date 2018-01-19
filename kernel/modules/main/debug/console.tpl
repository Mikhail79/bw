
<link rel="stylesheet" href="{$vars.css_url}" />
<script>
	function debug_get_request_info( id ){

		//var list = document.querySelectorAll('request_info');
		//console.log(list);

		$('.debug_info .request_info').hide();

		$('#' + id).show();

	}
</script>
<div>
	<div class="debug_console">
		<div class="debug_console_title">Консоль отладки:</div>
		<div class="debug_console_info">
			PHP: <b>{$vars.php_version}</b><br />
			Память используемая скриптом memory_get_usage(): <b>{$vars.memory_get_usage} байт</b>, допустимо: <b>{$vars.memory_limit} байт</b><br />
			Память используемая скриптом memory_get_peak_usage(): <b>{$vars.memory_get_peak_usage} байт</b>, допустимо: <b>{$vars.memory_limit} байт</b><br />
			Ваш IP: <b>{$vars.remote_addr}</b><br />
			ID сессии: <b>{$vars.session_id}</b><br />
			Строка запроса $_SERVER['QUERY_STRING']: <b>{$vars.query_string}</b><br />
			$_SERVER['REQUEST_METHOD']: <b>{$vars.request_method}</b><br />
			$_SERVER['REQUEST_URI']: <b>{$vars.request_uri}</b><br />
			Директория сайта $_SERVER['DOCUMENT_ROOT']: <b>{$vars.document_root}</b><br />
			Кол-во запросов к БД: <b>{$vars.queries_count}</b><br />
			Время генерации страницы: <b>{$vars.gen_time} секунд</b>, допустимо: <b>{$vars.max_execution_time} секунд</b><br />
	 	</div>			
		<div class="debug_console_queries">{$vars.queries}</div>
		<div class="debug_console_title">Подключенные файлы get_included_files(), {$vars.included_files_count}:</div>
		<div class="included_files">{$vars.included_files}</div>
		{$vars.variables}
	</div>
	<div class="div_expander" onmousedown="div_expander(event,this)"></div>
</div>