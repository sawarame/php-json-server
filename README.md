# php-json-rest-sever

`php-json-rest-server` is REST API with PHP. The data source can be wrote json format, and be able to easily set up API mock server.

## Installation

## How to use

### Set up data
Save data file in the below path.

```
path/to/install/data/db/schema_name.json
```

The `schema_name` of file name is used to data name. There is a `sample.json` in the initial state. Data must wrote by array of json format. Data structure is arbitrary, but `id` column is required.

### Read data

To display the data named `schema_name`, access below URL with GET method.

```
http://localhost:8080/schema_name
```
