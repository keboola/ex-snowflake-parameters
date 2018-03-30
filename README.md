# Snowflake Parameters Extractors

[![Build Status](https://travis-ci.org/keboola/ex-snowflake-parameters.svg?branch=master)](https://travis-ci.org/keboola/ex-snowflake-parameters)

The extractor fetches Snowflake account [parameters](https://docs.snowflake.net/manuals/sql-reference/parameters.html).
Snowflake account name (host) is also stored with each parameter.

Output example:

host | key | value | default | level | description
---- | --- | ----- | ----- | ------ | ----
kebooladev.snowflakecomputing.com | SSO_LOGIN_PAGE | false | false | | Enable federated authentication for console login and redirects preview page to console login

## Development
 
Clone this repository and init the workspace with following command:

```
git clone https://github.com/keboola/ex-snowflake-parameters
cd ex-snowflake-parameters
```

Download latest [Snowflake DEB ODBC drivers](https://docs.snowflake.net/manuals/user-guide/odbc-download.html) as save it to `./docker/snowflake-odbc.deb`.

```
docker-compose build
docker-compose run --rm dev composer install --no-scripts
```

Prepare snowflake user for tests:
```sql
create user your_name_ex_account_params  PASSWORD = 'your_password';
```

Create `.env` file:
```
SNOWFLAKE_HOST=
SNOWFLAKE_USER=
SNOWFLAKE_PASSWORD=

```

Run the test suite using this command:

```
docker-compose run --rm dev composer tests
```
 
# Integration

For information about deployment and integration with KBC, please refer to the [deployment section of developers documentation](https://developers.keboola.com/extend/component/deployment/) 
