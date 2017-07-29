from twython import Twython, TwythonError
from pymongo import MongoClient
import datetime
import sys


CONSUMER_KEY = 'R70m2rfc3en3Zpsr48LYdPR89'
CONSUMER_SECRET = '2iDmqfp3ZHn2ACEr3SC0VJ4nTKYwUIjQwqicEHoMnKllRGlKf8'
OAUTH_TOKEN = '28974427-i6SeIw1KaVfci75rQ9iwifsu2tle01NOIT9duLMSw'
OAUTH_TOKEN_SECRET = 'h2YUuGSMHUbYHieehGUKxTpTLwjdfBDg1JWfLf2e4lBLJ'
twitter = Twython(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET)
language = "en";

client = MongoClient('localhost', 27017)
db = client.tweet_htm
posts = db.posts

for keyword in posts.find().distinct('search_term'):
    
	
	try:
	    search_results = twitter.search(q=keyword, count=200, lang=language)
	except TwythonError as e:
	    print e


	for tweet in search_results['statuses']:
	    tweet['search_term'] = keyword
	    tweet['search_by'] = "naim"
	    print 'Tweet from @%s Date: %s' % (tweet['user']['screen_name'].encode('utf-8'),
	                                       tweet['created_at'])
	    print tweet['text'].encode('utf-8'), '\n'
	    post_id = posts.insert(tweet)
    


'''

search_keyword = sys.argv[1];


# Requires Authentication as of Twitter API v1.1
twitter = Twython(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET)
try:
    search_results = twitter.search(q=search_keyword, count=200, lang=language)
except TwythonError as e:
    print e



for tweet in search_results['statuses']:
    tweet['search_term'] = search_keyword
    tweet['search_by'] = "naim"
    print 'Tweet from @%s Date: %s' % (tweet['user']['screen_name'].encode('utf-8'),
                                       tweet['created_at'])
    print tweet['text'].encode('utf-8'), '\n'
    post_id = posts.insert(tweet)
'''