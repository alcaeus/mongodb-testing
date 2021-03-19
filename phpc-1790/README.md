# [PHPC-1790](https://jira.mongodb.org/browse/PHPC-1790)
### Empty '$unset' along with '$set' in same updateOne() causes failure to write data

### Testing for yourself

1. Run `composer install` to install dependencies
2. Launch the test script: `./orig.php`
3. The script tries to connect to MongoDB on locahost on the default port. You
   can change this by setting the `MONGODB_URI` variable:
   `MONGODB_URI="mongodb+srv://<username>:<password>@some-cluster.tld/" ./orig.php`
