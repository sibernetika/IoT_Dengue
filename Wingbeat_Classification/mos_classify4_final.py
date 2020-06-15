#SARAS-Mos Classify
#V 1.0.1 
#Update : 
#- add model path parameter on running script (3 Februari 2020)

#import Library
import librosa
import numpy as np
import argparse
from keras.models import load_model
import pandas as pd 
from sklearn.decomposition import PCA


# Running parameter function 
ap = argparse.ArgumentParser()
ap.add_argument('-i','--audio',required=True)
ap.add_argument('-j','--model',required=True)
args = vars(ap.parse_args())

# Load model classification
model = load_model(args["model"])

# Extracting feature and calculating standard deviation value
y, sr = librosa.load(args["audio"], mono=True, duration=30)
mfcc = librosa.feature.mfcc(y=y, sr=sr, n_mfcc=13,fmin=400, fmax=10000)
mfcc_delta = librosa.feature.delta(mfcc)
mfcc_delta2 = librosa.feature.delta(mfcc, order=2)
mean = np.mean(mfcc, axis=1)
mean_delta = np.mean(mfcc_delta, axis=1)
mean_delta2 = np.mean(mfcc_delta2, axis=1)
#mean = np.array(mean.reshape(1,-1))


# Load data to a Dataframe
df = pd.DataFrame(mean)
df1 = pd.DataFrame(mean_delta)
df2 = pd.DataFrame(mean_delta2)
df = df.append(df1, ignore_index=True)
df = df.append(df2, ignore_index=True)
df = df.T
X_uji = np.array(df)
#dataset = PCA(7).fit_transform(X_uji)
#pca = PCA(7)
#dataset = PCA(7).transform(X_uji)
#dataset = dataset.T

# Predict and give percentage of the results
a=model.predict(X_uji)
predicts1 = {"aegypti betina":round((a[0][1]*100),2),
             "others":round((a[0][0]*100),2)}
for key, value in sorted(predicts1.items(),key=lambda item: item[1], reverse=True):
    print(f"{key};{value}%,")
