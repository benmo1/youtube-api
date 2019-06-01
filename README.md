
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

---

###Notes 

Tests may hang if `test` is run straight after `start`. This is because the mysql server takes a while to start and the tests require a database connection. However, it retries the connection until it works so they should run.

One test is skipped because it hits the actual youtube api. This means it requires the YOUTUBE_API_KEY mentioned above. It can be run as a one off but not part of the regular suite.


---

###Things that could be better

- Fetching results from youtube asynchronously (although node is better than php for this, database insertion may be the bottleneck anyway - see below)
- Returning paginated results in the get all endpoint
- Indexes on the videos title column so that searching is qiucker
- Bulk mysql insert (don't insert entities one at a time) for faster database storage
- Mocking out the google service so we can have better test coverage around MorrisPhp\YouTube\Service
