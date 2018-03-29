# Snowflake Parameters Extractors

[![Build Status](https://travis-ci.org/keboola/ex-snowflake-parameters.svg?branch=master)](https://travis-ci.org/keboola/ex-snowflake-parameters)

Fetch snowflake account parameters



## Development
 
Clone this repository and init the workspace with following command:

```
git clone https://github.com/keboola/ex-snowflake-parameters
cd ex-snowflake-parameters
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
