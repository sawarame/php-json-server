# php-json-rest-sever

`php-json-rest-server` is REST API with PHP. The data source can be wrote json format, and be able to easily set up REST API mock server.

## Installation

## How to use

### Set up data
Save data file in the below path.

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

### Read data

To get the data named `schema_name`, access below URL with GET method.

```
http://localhost:8080/schema_name
```

Default data rows per page is 20. if you want to change it, use `rows` parameter.

```
http://localhost:8080/schema_name?rows=10
```

How to change page is use `page` parameter.

```
http://localhost:8080/schema_name?rows=10
```

#### Response header

The response header contains information about paging.

| name | description |
|:---|:---|
| Rest-Api-Total: | Total number of datas. |
| Rest-Api-pages: | Total number of pages. |
| Rest-Api-Rows: | Rows of current page. |

### Find data.
