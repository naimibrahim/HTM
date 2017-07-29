from twython import Twython, TwythonError
from pymongo import MongoClient
import datetime
import sys


CONSUMER_KEY = 'R70m2rfc3en3Zpsr48LYdPR89'
CONSUMER_SECRET = '2iDmqfp3ZHn2ACEr3SC0VJ4nTKYwUIjQwqicEHoMnKllRGlKf8'
OAUTH_TOKEN = '28974427-i6SeIw1KaVfci75rQ9iwifsu2tle01NOIT9duLMSw'
OAUTH_TOKEN_SECRET = 'h2YUuGSMHUbYHieehGUKxTpTLwjdfBDg1JWfLf2e4lBLJ'

user_id = sys.argv[1];
dm_text = sys.argv[2];
language = "en";

# Requires Authentication as of Twitter API v1.1
twitter = Twython(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET)
try:
    responses = twitter.send_direct_message(screen_name=user_id, text=dm_text)
except TwythonError as e:
    print e

client = MongoClient('localhost', 27017)
db = client.tweet_htm
messages = db.messages

messages_id = messages.insert(responses)
