#!/bin/bash

create_database_ () {
psql --username=postgres <<-EOSQL
CREATE USER $1 WITH PASSWORD '$1';
CREATE DATABASE $1 WITH OWNER $1;
GRANT ALL PRIVILEGES ON DATABASE $1 TO $1;
EOSQL
}

### redproduct ###
create_database_ test
