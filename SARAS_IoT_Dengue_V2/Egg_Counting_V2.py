#SARAS-EGG Counting
#V 2.0.2 
#Update: 
#- add crop value x parameter on running script (4 Februari 2020)
#- remove string "Egg Counted is:" (14 Februari 2020)
#- remove enter after egg value (14 Februari 2020)
#- add crop y value parameter on running script (14 Februari 2020)
#- change output format (by mas Mulyawan)
#- change read param system from input param to config.ini 

#Library import 
import cv2
import numpy as np
import imutils
import argparse
import configparser
config = configparser.ConfigParser()
config.read('IoTDengue.ini')

# uncomment when need to plot an image
#from matplotlib import pyplot as plt

# Running function parameters
ap = argparse.ArgumentParser()
ap.add_argument('-i','--image',required=True) #lokasi gambar
ap.add_argument('-j','--parameter',required=True) #Jenis parameter 
ap.add_argument('-k','--node',required=True) #nomor node
args = vars(ap.parse_args())
eggparam = config[args["parameter"]][args["node"]]
eggparam = eggparam.split(',')
xcrop = int(eggparam[0])
ycrop = int(eggparam[1])


# Load, rotate and crop image
img = cv2.imread(args["image"])
img = imutils.rotate(img,180)
h = img.shape[0]
w = img.shape[1]
img = img[0:h-ycrop,xcrop:w]

# Convert image to HSV and Split to get value part
hsv = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)
hue ,saturation ,value = cv2.split(hsv)

# Apply adaptive threshold with Gaussian
thresh = cv2.adaptiveThreshold(value, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY, 255, 17)
thresh = cv2.bitwise_not(thresh)

# Detecting blobs as noise
# Maximum blobs size
contours, hierarchy = cv2.findContours(thresh, cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)
threshold_blobs_area = 2
# Loop over all contours and fill draw black color for area smaller than threshold.
for i in range(1, len(contours)):
    index_level = int(hierarchy[0][i][1])
    if index_level <= i:
        cnt = contours[i]
        area = cv2.contourArea(cnt)
        if area <= threshold_blobs_area:
            # Draw black color for detected blobs
            cv2.drawContours(thresh, [cnt], -1, 0, -1, 1)
            
#Label and count the egg 
ret, labels = cv2.connectedComponents(thresh)
label_hue = np.uint8(179 * labels / np.max(labels))

# None object protection
if ret == 0:
    ret = 2
elif ret == 1:
    ret = 2
else:
    ret = ret
    
# result  
blank_ch = 255 * np.ones_like(label_hue)
labeled_img = cv2.merge([label_hue, blank_ch, blank_ch])
labeled_img = cv2.cvtColor(labeled_img, cv2.COLOR_HSV2BGR)
labeled_img[label_hue == 0] = 0
#print(int(ret-2), end='')
print('{"sys"}:{"eggnumber":', int(ret-2), '}', end='')