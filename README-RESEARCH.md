# Research

Request-Interop is based on research including the following projects, which model their request objects on the PHP superglobals:

- [aura/web](https://github.com/auraphp/Aura.Web/blob/2.x/src/Request.php) (aura)
- [Cake 2 _CakeRequest_](https://github.com/pieceofcake2/cakephp/blob/2.x/src/Network/CakeRequest.php) (cake2)
- [Code Igniter 3 _CI_Input_](https://github.com/bcit-ci/CodeIgniter/blob/3.1-stable/system/core/Input.php) (ci3)
- [flightphp/core](https://github.com/flightphp/core/blob/master/flight/net/Request.php) (flight)
- [horde/controller](https://github.com/horde/Controller/blob/horde_controller2/lib/Horde/Controller/Request/Http.php) (horde)
- [joomla/input](https://github.com/joomla-framework/input/blob/3.x-dev/src/Input.php) (joomla)
- [Klein](https://github.com/klein/klein.php/blob/master/src/Klein/Request.php) (klein)
- [MediaWiki](https://github.com/wikimedia/mediawiki/blob/master/includes/Request/WebRequest.php) (mediawiki)
- [nette/http](https://github.com/nette/http/blob/master/src/Http/Request.php) (nette)
- [Phalcon HTTP Request](https://github.com/phalcon/cphalcon/blob/v3.4.0/phalcon/http/request.zep) (phalcon)
- [Slim 2](https://github.com/slimphp/Slim/blob/2.x/Slim/Http/Request.php) (slim2)
- [symfony/http-foundation](https://github.com/symfony/http-foundation/blob/6023ec7607254c87c5e69fb3558255aca440d72b/Request.php) (symfony)
- [tempestphp/tempest-framework](https://github.com/tempestphp/tempest-framework/blob/main/packages/http/src/IsRequest.php) (tempest)
- [YAF](https://www.php.net/yaf) (yaf)
- [yiisoft/yii2-dev](https://github.com/yiisoft/yii2/blob/5fb3f809c59f742537df77e0da1ad36a1175834a/framework/web/Request.php) (yii2)
- [Zend Framework 1](https://github.com/zendframework/zf1/blob/master/library/Zend/Controller/Request/Http.php) (zf1)

The following projects were considered but eventually excluded, because they attempt to model their request objects on HTTP messages instead of on the PHP superglobals:

- Lithium [_lithium\\action\\Request_](https://github.com/UnionOfRAD/lithium/blob/1.3/action/Request.php)
- PSR-7 [_Psr\\Http\\Message\\ServerRequestInterface_](https://github.com/php-fig/http-message/blob/master/src/ServerRequestInterface.php)
- Zend Framework 2 [_Zend\\Http\\PhpEnvironment\\Request_](https://github.com/zendframework/zendframework/blob/release-2.4/library/Zend/Http/PhpEnvironment/Request.php)

(The last two are remarkably similar.)

See also <https://docs.google.com/spreadsheets/d/e/2PACX-1vQzJP00bOAMYGSVQ8QIIJkXVdAg-OMEfkgna7-b2IsuoWN8x_TazxEYn-yVDF2XQIqnzmHqdDO3KEKx/pubhtml> for an earlier version of this research.


## Mutability

The projects offer varying levels of nominal mutability. Note that "readonly" here means the project does not allow *public* mutability; formal `readonly` might not be in place, thus allowing mutablity within protected or private scopes, but not from outside the object.

|           | Readonly | Mutable |
| --------- | -------- | ------- |
| aura      | x        |         |
| cake2     |          | x       |
| ci3       | x        |         |
| flight    |          | x       |
| horde     | x        |         |
| joomla    | x        |         |
| klein     | x        |         |
| mediawiki |          | x       |
| nette     | x        |         |
| phalcon   | x        |         |
| symfony   |          | x       |
| tempest   | x        |         |
| yaf       | x        |         |
| yii2      |          | x       |
| zf1       |          | x       |


None of the researched projects advertise immutablity.

## Superglobals

The projects provide access to the most or all of the following superglobals via a property or method.

### `$_GET`

|           | Access                 | Type                      |
| --------- | ---------------------- | ------------------------- |
| aura      | `$query`               | _Values_ class            |
| cake2     | `$query`               | `array`                   |
| ci3       | `get()`                | `array`                   |
| flight    | `$query`               | _Collection_ class        |
| horde     | `getGetVars()`         | `array`                   |
| joomla    | `$get`                 | _Input_ class             |
| klein     | `paramsGet()`          | _DataCollection_ class    |
| mediawiki | `getQueryValuesOnly()` | `array`                   |
| nette     | `getQuery()`           | `array`                   |
| phalcon   | `getQuery()`           | `array`                   |
| slim2     | `get()`                | `array`                   |
| symfony   | `$query`               | _InputBag_ class          |
| tempest   | `$query`               | `array`                   |
| yaf       | `getQuery()`           | `array`                   |
| yii2      | `getQueryParams()`     | `array`                   |
| zf1       | `getQuery()`           | `array`                   |


### `$_POST`

The naming for this superglobal is less consistent than for the other superglobals; the researchers presume it is because `$_POST` is a representation of the HTTP request body, which may be present in requests other than POST.

|           | Access             | Type                      | post | data | params | body |
| --------- | ------------------ | ------------------------- | ---- | ---- | ------ | ---- |
| aura      | `$post`            | _Values_ class            | x    |      |        |      |
| cake2     | `$data`            | `array`                   |      | x    |        |      |
| ci3       | `post()`           | `array`                   | x    |      |        |      |
| flight    | `$data`            | _Collection_ class        |      | x    |        |      |
| horde     | `getPostVars()`    | `array`                   | x    |      |        |      |
| joomla    | `$post`            | _Input_ class             | x    |      | x      |      |
| klein     | `paramsPost()`     | _PostCollection_ class    | x    |      |        |      |
| mediawiki | `getPostValues()`  | `array`                   | x    |      |        |      |
| nette     | `getPost()`        | `array`                   | x    |      |        |      |
| phalcon   | `getPost()`        | `array`                   | x    |      |        |      |
| slim2     | `post()`           | `array`                   | x    |      |        |      |
| symfony   | `$request`         | _InputBag_ class          |      |      |        |      |
| tempest   | `$body`            | `array`                   |      |      |        | x    |
| yaf       | `getPost()`        | `array`                   | x    |      |        |      |
| yii2      | `getBodyParams()`  | `array|object`            |      |      | x      | x    |
| zf1       | `getPost()`        | `array`                   | x    |      |        |      |

### `$_COOKIE`

|           | Access              | Type                      |
| --------- | ------------------- | ------------------------- |
| aura      | `$cookies`          | _Values_ class            |
| cake2     | -                   | -                         |
| ci3       | `cookie()`          | `array`                   |
| flight    | `$cookies`          | _Collection_ class        |
| horde     | `getCookieVars()`   | `array`                   |
| joomla    | `$cookie`           | _Cookie_ class            |
| klein     | `cookies()`         | _CookieCollection_ class  |
| mediawiki | `getCookieArray()`  | `array`                   |
| nette     | `$cookies`          | `array`                   |
| phalcon   | -                   | -                         |
| slim2     | `cookies()`         | _Cookies_ class           |
| symfony   | `$cookies`          | _InputBag_ class          |
| tempest   | `$cookies`          | `array`                   |
| yaf       | `getCookie()`       | `array`                   |
| yii2      | `getCookies()`      | _CookieCollection_ class  |
| zf1       | `getCookie()`       | `array                    |

### `$_SERVER`

|           | Access              | Type                      |
| --------- | ------------------- | ------------------------- |
| aura      | `$server`           | _Values_ class            |
| cake2     | `env()`             | `array`                   |
| ci3       | `server()`          | `array`                   |
| flight    | -                   | -                         |
| horde     | `getServerVars()`   | `array`                   |
| joomla    | `$server`           | _Input_ class             |
| klein     | `server()`          | _ServerCollection_ class  |
| mediawiki | -                   | -                         |
| nette     | -                   | -                         |
| phalcon   | `getServer()`       | `array`                   |
| slim2     | -                   | -                         |
| symfony   | `$server`           | _ServerBag_ class         |
| tempest   | -                   | -                         |
| yaf       | `getServer()`       | `array`                   |
| yii2      | -                   | -                         |
| zf1       | `getServer()`       | `array`                   |

### `$_FILES`

Note that some projects retain only the native `$_FILES` structure, while others provide a restructured variation.

| Project   | Access               | Type                            | Structure    |
| --------- | -------------------- | ------------------------------- | ------------ |
| aura      | `$files`             | _Files_ class                   | Restructured |
| cake2     | `$data`              | `array`                         | Restructured |
| ci3       | (1)                  | _CI_Upload_ class               | Restructured |
| flight    | `getUploadedFiles`   | _UploadedFile_ array            | Restructured |
| horde     | `getFileVars()`      | `array`                         | Native       |
| joomla    | `$files`             | _Files_ class                   | Native       |
| klein     | `files()`            | _UploadedFileCollection_        | Native       |
| mediawiki | `getUpload()`        | _WebRequestUpload_              | Restructured |
| nette     | `getFiles()`         | _FileUpload_ array              | Restructured |
| phalcon   | `getUploadedFiles()` | _File_ array                    | Restructured |
| slim2     | -                    | -                               | -            |
| symfony   | `$files`             | _FileBag_ class                 | Restructured |
| tempest   | `files()`            | _Upload_ array                  | Restructured |
| yaf       | `getFiles()`         | `array`                         | Native       |
| yii2      | -                    | -                               | -            |
| zf1       | -                    | -                               | -            |

(1) _CI_Upload_ is unusual, in that it is more of a file-processing object than a file representation object.

## Headers

Most projects provide access to the incoming request headers, typically extracted from `$_SERVER` values.

|           | Access             | Type                      |
| --------- | ------------------ | ------------------------- |
| aura      | `$headers`         | _Headers_ class           |
| cake2     | `header()`         | `array`                   |
| ci3       | `request_headers()`| `array`                   |
| flight    | `getHeaders()`     | `array`                   |
| horde     | `getHeaders()`     | `array`                   |
| joomla    | -                  | -                         |
| klein     | `headers()`        | _HeadersCollection_ class |
| mediawiki | `getAllHeaders()`  | `array`                   |
| nette     | `getHeaders()`     | `array`                   |
| phalcon   | `getHeaders()`     | `array`                   |
| slim2     | `headers()`        | _Headers_ class           |
| symfony   | `$headers`         | _HeaderBag_ class         |
| tempest   | `$headers`         | _RequestHeaders_ class    |
| yaf       | -                  | -                         |
| yii2      | `getHeaders()`     | _HeaderCollection_ class  |
| zf1       | `getHeader()` (1)  | `string`                  |

(1) ZF1 only allows retrieval of one header at a time.

## Method

The projects make the HTTP method of the incoming request accessible via a property or method.

|           | Access            | Type              |
| --------- | ----------------- | ----------------- |
| aura      | `$method`         | _Method_ class    |
| cake2     | `method()`        | `string`          |
| ci3       | `method()`        | `string`          |
| flight    | `$method`         | `string`          |
| horde     | `getMethod()`     | `string`          |
| joomla    | `getMethod()`     | `string`          |
| klein     | `method()`        | `string`          |
| mediawiki | `getMethod()`     | `string`          |
| nette     | `getMethod()`     | `string`          |
| phalcon   | `getMethod()`     | `string`          |
| slim2     | `getMethod()`     | `string`          |
| symfony   | `getMethod()`     | `string`          |
| tempest   | `getMethod()`     | _Method_ enum     |
| yaf       | `getMethod()`     | `string`          |
| yii2      | `getMethod()`     | `string`          |
| zf1       | `getMethod()`     | `string`          |

## URI/URL

Most projects provide a representation of the incoming request URI or URL, accessible via a property or method:

|           | URI | URL | Access             | Type              |
| --------- | --- | --- | ------------------ |------------------ |
| aura      |     | x   | `$url`             | _Url_ class       |
| cake2     |     | x   | `$url`             | `string`          |
| ci3       |     | x   | `$uri`             | _CI_URI_ class    |
| flight    |     | x   | `$url`             | `string`          |
| horde     | -   | -   | -                  | -                 |
| joomla    | -   | -   | -                  | -                 |
| klein     | x   |     | `uri()`            | `string`          |
| mediawiki |     | x   | `getRequestURL()`  | `string`          |
| nette     |     | x   | `getUrl()`         | _UrlScript_ class |
| phalcon   | x   |     | `getURI()`         | `string`          |
| slim2     | x   |     | `getResourceUri()` | `string`          |
| symfony   | x   |     | `getUri()`         | `string`          |
| tempest   | x   |     | `$uri`             | `string`          |
| yaf       | x   |     | `getRequestUri()`  | `string`          |
| yii2      |     | x   | `getUrl()`         | `string`          |
| zf1       | x   |     | `getRequestUri()`  | `string`          |

## Raw Body Content

Most projects provide access to `php://input` via a property or method, though the naming is inconsistent.

|           | Access              | Type                    | raw | body | content | input |
| --------- | ------------------- | ----------------------- | --- | ---- | ------- | ----- |
| aura      | -                   | -                       |     |      |         |       |
| cake2     | -                   | -                       |     |      |         | x     |
| ci3       | `$raw_input_stream` | `string`                | x   |      |         |       |
| flight    | `getBody()`         | `string`                |     | x    |         |       |
| horde     | -                   | -                       |     |      |         |       |
| joomla    | -                   | -                       |     |      |         |       |
| klein     | `body()`            | `string`                |     | x    |         |       |
| mediawiki | `getRawInput()`     | `string`                | x   |      |         | x     |
| nette     | `getRawBody()`      | `string|null`           | x   | x    |         |       |
| phalcon   | `getRawBody()`      | `string`                | x   | x    |         |       |
| slim2     | `getBody()`         | `string`                |     | x    |         |       |
| symfony   | `getContent()`      | `string|resource`       |     |      | x       |       |
| tempest   | `$raw`              | `string`                | x   |      |         |       |
| yaf       | `getRaw()`          | `mixed`                 | x   |      |         |       |
| yii2      | `getRawBody()`      | `string`                | x   | x    |         |       |
| zf1       | `getRawBody()`      | `string`                | x   | x    |         |       |


### Factories

The projects offer varying levels of support for creating request objects from
the PHP superglobals. Some projects provide factory methods or constructors that
accept superglobal arrays, while others require only instantiation via the `new`
keyword.

- "Factory Class" indicates a separate factory class for creating the request object.
- "Factory Method" indicates a method on the creation method on request object itself.

|           | Factory Class | Factory Method | `new` |
| --------- | ------------- | -------------- | ----- |
| aura      | x             |                |       |
| cake2     |               |                | x     |
| ci3       |               |                | x     |
| flight    |               |                | x     |
| horde     |               |                | x     |
| joomla    |               |                | x     |
| klein     |               | x              |       |
| mediawiki |               |                | x     |
| nette     | x             |                |       |
| phalcon   |               |                | x     |
| slim2     |               |                | x     |
| symfony   |               | x              |       |
| tempest   | x             |                |       |
| yaf       |               |                | x     |
| yii2      |               |                | x     |
| zf1       |               |                | x     |

Signatures are as follows:

|           | Creation Signature                                                                   |
| --------- | ------------------------------------------------------------------------------------ |
| aura      | `public function WebFactory::newRequestGlobals(): Request\Globals`                   |
| cake2     | `public function __construct(?string $url = null, bool $parseEnvironment = true)`    |
| ci3       | `public function __construct()`                                                      |
| flight    | `public function __construct(array $config = [])`                                    |
| horde     | -                                                                                    |
| joomla    | `public function __construct(?array $source = $_REQUEST, array $options = [])`       |
| klein     | `public static function createFromGlobals(): Request`                                |
| mediawiki | `public function __construct()`                                                      |
| nette     | `public function RequestFactory::fromGlobals(): Request`                             |
| phalcon   | -                                                                                    |
| slim2     | `public function __construct(\Slim\Environment $env)`                                |
| symfony   | `public static function createFromGlobals(): static`                                 |
| tempest   | `public function RequestFactory::make(): PsrRequest`                                 |
| yaf       | `public function __construct(?string $uri = null, ?string $base_uri = null)` |
| yii2      | -                                                                                    |
| zf1       | `public function __construct(string\|Zend_Uri\|null $uri = null)`                    |

## Superglobal Coupling

Coupling of request objects to the superglobal variables is varied across the
researched projects.

- "Injected" indicates the superglobals (or the request property values
  themselves) are passed as arguments into the creation mechanism from the
  outside. The request object is decoupled from the superglobals; changes to one
  do not affect the other.

- "Located" indicates the creation mechanism copies the superglobals itself from
  the inside. The request object is decoupled from the superglobals; changes to
  one do not affect the other.

- "Coupled" indicates the request object uses the superglobals themselves;
  changes to the superglobals are reflected inside the requested object.

|           | Injected | Located | Coupled |
| --------- | -------- | ------- | ------- |
| aura      | x        |         |         |
| cake2     |          | x       |         |
| ci3       |          |         | x       |
| flight    |          | x       |         |
| horde     |          |         | x       |
| joomla    |          | x       |         |
| klein     |          | x       |         |
| mediawiki |          | x       |         |
| nette     | x        |         |         |
| phalcon   |          |         | x       |
| slim2     |          | x       |         |
| symfony   |          | x       |         |
| tempest   | x        |         |         |
| yaf       |          | x       |         |
| yii2      |          |         | x       |
| zf1       |          |         | x       |
