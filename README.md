# Developer Guide

## Pre-requisites

**Required:**

- [Makefile](https://en.wikipedia.org/wiki/Makefile)
- [Docker](https://www.docker.com) v19.03 or higher.
- The instructions have been tested to run with Mac OS.

## Getting started
1. Add `www.demo.webdev998 www.demo.webdev998` to your hosts file for `127.0.0.1`.
2. There is a simple `make` command which will spin up the Docker development environment. Run `make clean` to build the environment.

If Docker complains about port clashes due to other services running on them, please edit them the in the `.env ` file
and use alternative ones.

To access the site visit:
- `https://www.demo.webdev998/` for the `dev` environment (Symfony Debug and toolbar enabled)
- `https://www.demo.webdev999/` for the `behat` environment (Symfony Debug and toolbar disabled)

Run `make help` to see useful common commands which can be used during development.

When switching development branches in Git, it is wise to run `make clean` as this will ensure the Docker environment is in the correct state.

## Database access

Connect to the docker MySQL database using your favourite client on `127.0.0.1` using `demo` user with `passw0rd` password.

It is also possible to connect to the mysql container with `make mysql`.  Once in the container you can then connect to the mysql shell with `mysql` as there is no root password. 

##  Application notes

##  Simple Journey

Visit https://www.demo.webdev998/

