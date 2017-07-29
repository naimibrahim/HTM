from twython import Twython, TwythonError
from pymongo import MongoClient
import datetime
import sys


CONSUMER_KEY = 'R70m2rfc3en3Zpsr48LYdPR89'
CONSUMER_SECRET = '2iDmqfp3ZHn2ACEr3SC0VJ4nTKYwUIjQwqicEHoMnKllRGlKf8'
OAUTH_TOKEN = '28974427-i6SeIw1KaVfci75rQ9iwifsu2tle01NOIT9duLMSw'
OAUTH_TOKEN_SECRET = 'h2YUuGSMHUbYHieehGUKxTpTLwjdfBDg1JWfLf2e4lBLJ'

search_keyword = sys.argv[1];
language = "id"; #bahasa tweet yg akan dicari

latitude = 3.147564	# geographical centre of search - Dataran Merdeka Kuala Lumpur
longitude = 101.693125	# geographical centre of search - Dataran Merdeka Kuala Lumpur
max_range = 500 # search range in kilometres

# Requires Authentication as of Twitter API v1.1
twitter = Twython(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET)
try:
    search_results = twitter.search(q=search_keyword, count=200, lang=language, geocode="%f,%f,%dkm" % (latitude, longitude, max_range))
except TwythonError as e:
    print e

client = MongoClient('localhost', 27017)

db = client.tweet_htm

posts = db.posts

for tweet in search_results['statuses']:
    tweet['search_term'] = search_keyword
    tweet['search_by'] = "naim"
    print 'Tweet from @%s Date: %s' % (tweet['user']['screen_name'].encode('utf-8'),
                                       tweet['created_at'])
    print tweet['text'].encode('utf-8'), '\n'
    post_id = posts.insert(tweet)
