import csv
import re
import nltk
import sys

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
inpTweets = csv.reader(open('C:\\xampp\\htdocs\\mysentimen\\data\\sample_festival_belia_tweet.csv', 'rb'), delimiter=',', quotechar='|')
stopWords = getStopWordList('C:\\xampp\\htdocs\\mysentimen\\data\\feature_list\\malay_stopword.txt')
featureList = []
 
# Get tweet words
tweets = []
for row in inpTweets:
    sentiment = row[0]
    tweet = row[1]
    processedTweet = processTweet(tweet)
    featureVector = getFeatureVector(processedTweet)
    featureList.extend(featureVector)
    tweets.append((featureVector, sentiment));
#end loop


 
# Remove featureList duplicates
featureList = list(set(featureList))
 
# Extract feature vector for all tweets in one shote
training_set = nltk.classify.util.apply_features(extract_features, tweets)

# Train the classifier
NBClassifier = nltk.NaiveBayesClassifier.train(training_set)
# Test the classifier
#testTweet = 'Jay Weatherill might continue to speak up & resist GST rise. Unfortunately, itll all be fading fast in Campbell Newmans mind. '
testTweet = sys.argv[1];

processedTestTweet = processTweet(testTweet)
print "Tweet are : <br/><br/> " + testTweet + "<br/><hr/><br/> Sentimen :"
print NBClassifier.classify(extract_features(getFeatureVector(processedTestTweet)))