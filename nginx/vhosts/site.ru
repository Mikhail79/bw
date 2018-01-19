charset utf-8;

# pagespeed off;

access_log logs/site.ru/access.log;
error_log logs/site.ru/error.log;

root /var/www/site.ru;

index index.php index.html;


location / {
	
	if ( !-e $request_filename ) {
	
		rewrite ^(.*)$ /index.php?_route=$1 last;
		
	}
	
}


location /cp/ {

#	auth_basic "Private Area";
#	auth_basic_user_file /var/www/.htpasswd;

	if ( !-e $request_filename ) {
	
		rewrite ^/cp/(.*)$ /cp/index.php?_route=$1 last;
		
	}		
}


# Запретить обращение к index.php|html без параметров. Полезно для SEO.
if ( $request_uri ~ "^/index\.php$" ){
	
	rewrite ^/index\.php$ / permanent;
	
}


# Полный запрет к файлам кэша сайта.
location ~* ^/internals/cache {
	deny all;
	return 404;
}

# Полный запрет к файлам кэша CP.
location ~* ^/cp/internals/cache {
	deny all;
	return 404;
}

# Полный запрет доступа к PHP-скриптам в директории ядра.
location ~* ^/kernel/.*\.php$ {
	deny all;
	return 404;
}

# Полный запрет доступа к PHP-скриптам в директории сайта.
location ~* ^/internals/.*\.php$ {
	deny all;
	return 404;
}

# Полный запрет доступа к PHP-скриптам в директории CP.
location ~* ^/cp/internals/.*\.php$ {
	deny all;
	return 404;
}

# Полный запрет доступа к файлам начинающимся с точки, таким как: .htaccess, .git, .gitignore
location ~ /\. {
	deny all;
	return 404;
}


# Полный запрет.
location ~* "^/kernel/.*\.(html|phtml|inc|sql|tpl|log|txt|zip|gz|jar|bak|ser)$" {
	deny all;
	return 404;
}

# Полный запрет.
location ~* "^/internals/.*\.(html|phtml|inc|sql|tpl|log|txt|zip|gz|jar|bak|ser)$" {
	deny all;
	return 404;
}

# Полный запрет.
location ~* "^/cp/internals/.*\.(html|phtml|inc|sql|tpl|log|txt|zip|gz|jar|bak|ser)$" {
	deny all;
	return 404;
	# Исключение.
	location ~* ^/cp/internals/other/tinymce {
		allow all;
	}
}

# Кэшировать статические файлы.
location ~* \.(?:jpg|jpeg|gif|png|bmp|ico|pdf|flv|swf|html|htm|txt|css|js|woff|woff2|svg|ttf|xml|zip|tgz|rar|doc|docx|xls)$ {
	add_header Cache-Control public;
	add_header Cache-Control must-revalidate;
	expires 1y;
	access_log off;
	log_not_found off;	
}


# Когда используется одна директория для множества сайтов и необходимо, чтобы robots.txt был разным
# в зависимости от домена, но по одному и тому же относительному пути.

#	location /robots.txt {
#		if ( !-e $request_filename ) {
#			rewrite /robots.txt /robots/$host.txt last;
#		}
#	}


location ~* \.php$ {

	# Для отсутствующих PHP-скриптов переход на 404 страницу.
	try_files $uri @http404;

	# PHP7
	fastcgi_pass 127.0.0.1:9001;
	
	# PHP5
	#fastcgi_pass 127.0.0.1:9000;
	
	# Задаёт имя файла, который при создании переменной $fastcgi_script_name будет добавляться после URI, если URI заканчивается слэшом.	
	fastcgi_index index.php;	
	
	include fastcgi_params;
			
	fastcgi_param HTTPS on;
	
	fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

	# Для обработки 404 при отсутствующих php-скриптах, обязательно должен быть error_page 404 /404 - и страница должна быть статичной! 
	# Если 404 страница не статичная, то нужно использовать try_files.
	# fastcgi_intercept_errors on;
	
}




# Для обработки 404 ошибки для php-файлов.
location @http404 {
	
	# PHP7
	fastcgi_pass 127.0.0.1:9001;
	
	# PHP5
	#fastcgi_pass 127.0.0.1:9000;
	
	# Задаёт имя файла, который при создании переменной $fastcgi_script_name будет добавляться после URI, если URI заканчивается слэшом.	
	fastcgi_index index.php;	
	
	include fastcgi_params;
	
	fastcgi_param HTTPS on;
	
	fastcgi_param SCRIPT_FILENAME $document_root/http_pages/404.php;

}		

 
	
error_page 403 /http_pages/403.php;
error_page 404 /http_pages/404.php;
error_page 500 /http_pages/500.php;
error_page 502 /http_pages/500.php;
error_page 504 /http_pages/500.php;
error_page 503 /http_pages/503.php;






# Исключение. 
# TODO Перечислить конкретные файлы.
# TODO Подлежит удалению.
#location ~* ^/cp/internals/other/tinymce/.*\.php$ {
#	fastcgi_param	HTTPS on;
#	fastcgi_pass   127.0.0.1:9000;
#	# Задаёт имя файла, который при создании переменной $fastcgi_script_name будет добавляться после URI, если URI заканчивается слэшом.
#	fastcgi_index  index.php;
#	include        fastcgi_params;
#	fastcgi_param SCRIPT_FILENAME  $document_root$fastcgi_script_name;	
#}	

