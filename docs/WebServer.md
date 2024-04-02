# Web Server

This document contains information about the web server we use and what program is exposed to the internet.

We decided to use Apache for the web server. It works well and is configurable. The school requires us to use Apache, so we didn't have much of a choice. We also use PHP for the server-side scripting (also required by the school).

## Configuration

### Apache

The configuration we use is pretty standard for a PHP application.

```
LoadModule rewrite_module modules/mod_rewrite.so
LoadModule deflate_module modules/mod_deflate.so
LoadModule filter_module modules/mod_filter.so

DocumentRoot "path/to/project/www"
<Directory "path/to/project/www">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Require all granted
    DirectorySlash Off
</Directory>
```

### PHP

For security reasons we have disabled the `expose_php`. With this off, the user cannot see the PHP version we're using (which can prevent attacks). In fact, the user cannot see we are using PHP at all since we rewrite the URLs containing `.php`. We're also going to change the name of the session cookie as we still want to remove any indication that we use php.

```ini
expose_php=off
session.name=SessionCookie
```

### `.htaccess`

In the `www` folder, there's a file called `.htaccess` which rewrite the URLs to remove the `.php` extension.
For example, if you request `/test.php`, the server will return a `404` even if the file exists. However, if you request `/test`, the server will "call" the `/test/index.php` file.

We also enable text compression (using `mod_deflate`) to reduce the amount of data sent over the network.

## Note on minification

If you happen to run the server on a Linux machine, you can use [PageSpeed](https://www.modpagespeed.com/) which is a module made by Google that minifies the HTML, CSS and JavaScript files. It's a great tool to use, but it's not required. See the download page for Apache [here](https://www.modpagespeed.com/doc/download).
