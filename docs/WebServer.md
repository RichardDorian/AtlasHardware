# Web Server

This document contains information about the web server we use and what program is open to the internet.

We decided to use Apache for the web server. It works well and is configurable. The school requires us to use Apache, so we didn't have much of a choice. We also use PHP for the server-side scripting (also required by the school).

## Configuration

### Apache

The configuration we use is pretty standard for a PHP application.

```
LoadModule rewrite_module modules/mod_rewrite.so

DocumentRoot "path/to/project/www"
<Directory "path/to/project/www">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Require all granted
    DirectorySlash Off
</Directory>
```

### PHP

For security reasons we have disabled the `expose_php`. With this off, the user cannot see the PHP version we're using (which can prevent attacks). In fact, the user cannot see we are using PHP at all since we rewrite the URLs containing `.php`.

```ini
expose_php=off
```

### `.htaccess`

In the `www` folder, there's a file called `.htaccess` which rewrite the URLs to remove the `.php` extension.
For example, if you request `/test.php`, the server will return a `404` even if the file exists. However, if you request `/test`, the server will "call" the `/test/index.php` file.
