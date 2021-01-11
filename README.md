# php-json-sever

[![Build Status](https://github.com/sawarame/php-json-server/workflows/build/badge.svg?branch=master)](https://github.com/sawarame/php-json-server/actions?query=workflow%3Abuild+branch%3Amaster)
[![Version](https://img.shields.io/packagist/v/sawarame/php-json-server.svg?style=flat)](https://packagist.org/packages/sawarame/php-json-server)

`php-json-server` is RESTful API with PHP. The data can be wrote json format, and you can easily set up RESTful API mock server.

## Installation and Startup

Use [Composer](https://getcomposer.org/) for installation and server start-up.

```sh
# install
$ composer create-project sawarame/php-json-server path/to/install
```

Once installed, You can startup `php-json-server` with PHP build-in server.

```sh
# Startup with PHP build-in server
$ cd path/to/install
$ composer run --timeout 0 serve
```

Then visit the site at http://localhost:8080/. If the welcome page is displayed, installation and startup are successful.

## Prepare data

Save data file in the path below.

```
path/to/install/data/db/schema_name.json
```

The `schema_name` of file name is used to data name. The data name can be any name, and multiple datas can be saved under different name. There is a `sample.json` in the initial state.
```json
[
    {
        "id": 1,
        "name": "Red",
        "code": "#ff0000"
    },
    {
        "id": 2,
        "name": "Green",
        "code": "#00ff00"
    },
    {
        "id": 3,
        "name": "Blue",
        "code": "#0000ff"
    }
]
```
Data must wrote by array of json format. Data structure is arbitrary, but `id` column is required.

## Read data

To get the data named `schema_name`, access below URL with GET method.

```sh
$ curl -X GET 'http://localhost:8080/schema_name'
```

Default data rows per page is 20. if you want to change it, use `rows` parameter.

```sh
$ curl -X GET 'http://localhost:8080/schema_name?rows=10'
```

How to change page is use `page` parameter.

```sh
$ curl -X GET 'http://localhost:8080/schema_name?page=2'
```

You can search by using the column name as the parameter.

```sh
$ curl -X GET 'http://localhost:8080/schema_name?name=Green'
```

Normally, When multiple parameters are specified, the search will be an AND condition.
If you want to search with OR condition, use `or` to `search_type` parameter.

```sh
$ curl -X GET 'http://localhost:8080/sample?name[]=Red&name[]=Green&search_type=or'
```

### Response header

The response header contains information about paging.

| name | description |
|:---|:---|
| PJS-Total: | Total number of datas. |
| PJS-pages: | Total number of pages. |
| PJS-Rows: | Rows of current page. |

## Find row

Example below receive the data that `id` column value is 123.

```sh
$ curl -X GET 'http://localhost:8080/schema_name/123'
```

## Insert row

Use POST method for insert data.

```sh
$ curl -X POST 'http://localhost:8080/schema_name' \
  -H 'Content-Type: application/json' \
  --data-raw '{"name":"Gray","code":"#808080"}'
```

Created data will be returned.

```json
{"id":4,"name":"Gray","code":"#808080"}
```

## Update row

Use PUT method for update data.

```sh
$ curl -X PUT 'http://localhost:8080/schema_name/2' \
  -H 'Content-Type: application/json' \
  --data-raw '{"name":"Yellow","code":"#FFFF00"}'
```

Updated data will be returned.

```json
{"id":2,"name":"Yellow","code":"#FFFF00"}
```

## Delete row

Use DELETE method for delete data.

```sh
$ curl -X DELETE 'http://localhost:8080/schema_name/4'
```

Deleted data will be returned.

```json
{"id":4,"name":"Gray","code":"#808080"}
```
