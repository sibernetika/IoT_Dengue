#SARAS-Mos Classify
#V 1.0.1 
#Update : 
#- add model path parameter on running script (3 Februari 2020)

#import Library
import librosa
import numpy as np
import argparse
from keras.models import load_model

# Running parameter function 
ap = argparse.ArgumentParser()
ap.add_argument('-i','--audio',required=True)
ap.add_argument('-j','--model',required=True)
args = vars(ap.parse_args())

# Load model classification
model = load_model(args["model"])

# Extracting feature and calculating standard deviation value
y, sr = librosa.load(args["audio"], mono=True, duration=30)
mfcc = librosa.feature.mfcc(y=y, sr=sr, n_mfcc=13, fmax=1000)
mean = np.std(mfcc, axis=1)
mean = np.array(mean.reshape(1,-1))
X_uji = mean

# Predict and give percentage of the results
a=model.predict(X_uji)
predicts1 = {"aegypti":round((a[0][1]*100),2)}
for key, value in sorted(predicts1.items(),key=lambda item: item[1], reverse=True):
    print(f"{key}={value}%&")