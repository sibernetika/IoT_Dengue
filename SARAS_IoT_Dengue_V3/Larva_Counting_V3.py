#SARAS-Larva Counting
#V 2.0.1
#Update: 
#- add crop x and y1 and y2 value parameter on running script (14 Februari 2020)
#- remove enter after larva value (14 Februari 2020) 
#- change output format (by mas Mulyawan)
#- change read param system from input param to config.ini 
#- update new mechanism with blur photo protection (resulted in small reads suddenly) 

#import Library
import cv2 as cv
import argparse
import numpy as np
import imutils
import configparser
config = configparser.ConfigParser()
config.read('/opt/lampp/htdocs/smartdengue/payton/IoT_Dengue.ini')

# Running parameter function 
ap = argparse.ArgumentParser()
ap.add_argument("-i", "--image", required=True) #lokasi gambar
ap.add_argument("-j", "--parameter", required=True) #jenis parameter
ap.add_argument("-k", "--node", required=True) #nomor node
args = vars(ap.parse_args())
larvaparam = config[args["parameter"]][args["node"]]
larvaparam = larvaparam.split(',')
xcrop = int(larvaparam[0])
y1crop = int(larvaparam[1])
y2crop = int(larvaparam[2])

# Load, rotate dan crop image
original = cv.imread(args["image"])
original = imutils.rotate(original,180)
h = original.shape[0]
w = original.shape[1]
original = original[y2crop:h-y1crop,xcrop:w]

# RGB to HSV converter
hsv = cv.cvtColor(original, cv.COLOR_BGR2HSV)
hue ,saturation ,value = cv.split(hsv)

# Adaptive_Threshold_Gaussian Filter
thresh = cv.adaptiveThreshold(value, 255, cv.ADAPTIVE_THRESH_GAUSSIAN_C, cv.THRESH_BINARY, 255, 17)
thresh = cv.bitwise_not(thresh)

# Find image contours
contours, hierarchy = cv.findContours(thresh, cv.RETR_TREE, cv.CHAIN_APPROX_SIMPLE)
# Detecting blobs as noise
# Maximum blobs size
threshold_blobs_area = 17
# Loop over all contours and fill draw black color for area smaller than threshold.
for i in range(1, len(contours)):
    index_level = int(hierarchy[0][i][1])
    if index_level <= i:
        cnt = contours[i]
        area = cv.contourArea(cnt)
        if area <= threshold_blobs_area:
            # Draw black color for small blobs
            cv.drawContours(thresh, [cnt], -1, 0, -1, 1)
            
# Dilatation and erosion filter
kernel = np.ones((15,15), np.uint8)
img_dilation = cv.dilate(thresh, kernel, iterations=1)
img_erode = cv.erode(img_dilation,kernel, iterations=1)

# clean all noise after dilatation and erosion
img_erode = cv.medianBlur(img_erode, 5)
img_erode = cv.GaussianBlur(img_erode,(5,5),0)

# Labeling and Counting
ret, labels = cv.connectedComponents(img_erode)
label_hue = np.uint8(179 * labels / np.max(labels))

# None object protection
if ret == 0:
    ret = 2
elif ret >= 1:
    ret = ret+1
else:
    ret = ret
ret = ret-2
# result    
blank_ch = 255 * np.ones_like(label_hue)
labeled_img = cv.merge([label_hue, blank_ch, blank_ch])
labeled_img = cv.cvtColor(labeled_img, cv.COLOR_HSV2BGR)
labeled_img[label_hue == 0] = 0
# print(int(ret-2), end='')

#added blur protection
config = configparser.RawConfigParser()
config.read("/opt/lampp/htdocs/smartdengue/payton/log_value/"+args["node"]+".log")
val_bef = int(config[args["parameter"]][args["node"]])
if ret>5:
    ret = 5
    
str(ret)
config.set(args["parameter"], args["node"], ret)
with open("/opt/lampp/htdocs/smartdengue/payton/log_value/"+args["node"]+".log", 'w') as configfile:
    config.write(configfile)

#print the result  
print('{"sys":{"larvanumber":', int(ret-2), '}}', end='')
