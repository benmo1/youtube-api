
###Instructions


Navigate to the build folder and source convenience aliases:

```sh
cd ./build/dev
. scripts.sh
```

Aliases are as follows, and must be run from `./build/dev`:

```sh
build - installs vendor libs, creates dev .env
start - starts php dev server, mysql server
stop - shuts down the servers
test - runs phpunit, services must be running for this to work
```

Copy your api key into the `.env` as `YOUTUBE_API_KEY` after you have run build

You can access the endpoints at localhost:8080/youtube-search
