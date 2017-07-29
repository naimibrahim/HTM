import csv
import re
import nltk
import sys
import pymongo
from pymongo import MongoClient
import json
from bson.objectid import ObjectId



def getStopWordList(path):
	stopWords = []
	stopWords = open(path)
	return stopWords

#start process_tweet
def processTweet(tweet):
    # process the tweets
 
    #Convert to lower case
    tweet = tweet.lower()
    #Convert www.* or https?://* to URL
    tweet = re.sub('((www\.[\s]+)|(https?://[^\s]+))','URL',tweet)
    #Convert @username to AT_USER
    tweet = re.sub('@[^\s]+','AT_USER',tweet)
    #Remove additional white spaces
    tweet = re.sub('[\s]+', ' ', tweet)
    #Replace #word with word
    tweet = re.sub(r'#([^\s]+)', r'\1', tweet)
    #trim 
    tweet = tweet.strip('\'"')
    return tweet
#end

#start replaceTwoOrMore
def replaceTwoOrMore(s):
    #look for 2 or more repetitions of character and replace with the character itself
    pattern = re.compile(r"(.)\1{1,}", re.DOTALL)
    return pattern.sub(r"\1\1", s)
#end

 #start extract_features
def extract_features(tweet):
    tweet_words = set(tweet)
    features = {}
    for word in featureList:
        features['contains(%s)' % word] = (word in tweet_words)
    return features
#end

#start getfeatureVector
def getFeatureVector(tweet):
    featureVector = []
    #split tweet into words
    words = tweet.split()
    for w in words:
        #replace two or more with two occurrences
        w = replaceTwoOrMore(w)
        #strip punctuation
        w = w.strip('\'"?,.')
        #check if the word stats with an alphabet
        val = re.search(r"^[a-zA-Z][a-zA-Z0-9]*$", w)
        #ignore if it is a stop word
        if(w in stopWords or val is None):
            continue
        else:
            featureVector.append(w.lower())
    return featureVector
#end
 

#Read the tweets one by one and process it
#inpTweets = csv.reader(open('C:\\xampp\\htdocs\\mysentimen\\data\\sample_festival_belia_tweet.csv', 'rb'), delimiter=',', quotechar='|')
stopWords = getStopWordList('malay_stopword.txt')
featureList = []
 
#connect to database (mongodb)
client = MongoClient('localhost', 27017)
db = client.tweet_database
posts = db.users_posts

user_id = ObjectId(sys.argv[1])


tweets = [] #declare array tweets

#cari semua tweet yang telah ditrained, dapatkan text tweet dan sentimenya
for post in posts.find({"search_term" : sys.argv[2],"userId": user_id ,"sentimen" : {'$exists':'true','$ne':"irrelevent",'$ne':"null"},"trained":"y","text":{'$exists':'true'}},{"text":1,"search_term":1,"sentimen":1,"trained":1}): 
    sentiment1 = post['sentimen']
    tweet = post['text'].encode('utf-8') 
    processedTweet = processTweet(tweet)
    featureVector = getFeatureVector(processedTweet)
    featureList.extend(featureVector)
    tweets.append((featureVector, sentiment1));
    




 
# Remove featureList duplicates
featureList = list(set(featureList))
 
# Extract feature vector for all tweets in one shot
training_set = nltk.classify.util.apply_features(extract_features, tweets)

# Train the classifier
NBClassifier = nltk.NaiveBayesClassifier.train(training_set)
# Test the classifier
#testTweet = 'Jay Weatherill might continue to speak up & resist GST rise. Unfortunately, itll all be fading fast in Campbell Newmans mind. '
#testTweet = sys.argv[1];

#user_id = ObjectId("54f91504aefda581df7f1d96")

sentimentnb = []
#id_each_users_posts = []
#print "<?xml version='1.0' encoding='UTF-8'?> "
#print "array("


i = 0
for post in posts.find({"search_term" : sys.argv[2],"userId": user_id,"trained":"n","text":{'$exists':'true'}},{"text":1,"search_term":1,"trained":1,"screen_name":1}):
    i += 1
    id_users_posts = post['_id']
    tweet = post['text'].encode('utf-8') 
    #print("\nTweet are :" + tweet + "\n")
    processedTestTweet = processTweet(tweet)
    sentimen_user = NBClassifier.classify(extract_features(getFeatureVector(processedTestTweet)))
    #print "{\"_id\":\"" + str(id_each_users_posts)  + "\",\"nbsentimen\":\"" + sentimen_user + "\"}"
    #print "<sentimen><id>" + str(id_each_users_posts)  + "</id><nbsentimen>" + sentimen_user + "</nbsentimen></sentimen>"
    print str(id_users_posts)  + "=>" + sentimen_user
    #id_each_users_posts[i] = ObjectId(id_each_users_posts)
    #sentimentnb.append(post['_id'],[sentimen_user])
    #update_statment1 = "$set: {\"value.nbsentiment\":\"" + sentimen_user + "\"}"
    #print  "  " + sentimen_user[i]
    #post.update({"$set" : {"nbsentimen" : sentimen_user }})

#print ");"
#print id_each_users_posts[1]


