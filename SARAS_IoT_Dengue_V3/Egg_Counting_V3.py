#SARAS-EGG Counting
#V 3.2.4
#Update: 
#- add crop value x parameter on running script (4 Februari 2020)
#- remove string "Egg Counted is:" (14 Februari 2020)
#- remove enter after egg value (14 Februari 2020)
#- add crop y value parameter on running script (14 Februari 2020)
#- change output format (by mas Mulyawan)
#- change read param system from input param to config.ini (Juni 2020)
#- update new mechanism with blur photo protection (resulted in small reads suddenly) (Juni 2020)
#- update cross check criteria (Juni 2020)
#- update offset mechanism to give zero initial value (7 Juli 2020)
#- update threshold value to give difference in sensitivity (8 Juli 2020)
#- update image sharpening algorithm (8 Juli 2020)
#- update lock value before (remove value tolerance system) (15 Agustus 2020)

#Library import 
import cv2
import numpy as np
import imutils
import argparse
import configparser
config = configparser.ConfigParser()
config.read('/opt/lampp/htdocs/smartdengue/payton/IoTDengue.ini')

# uncomment when need to plot an image
#from matplotlib import pyplot as plt

# image sharpening algorithm
def unsharp_mask(image, kernel_size=(5, 5), sigma=1.0, amount=1.0, threshold=0):
    """Return a sharpened version of the image, using an unsharp mask."""
    blurred = cv2.GaussianBlur(image, kernel_size, sigma)
    sharpened = float(amount + 1) * image - float(amount) * blurred
    sharpened = np.maximum(sharpened, np.zeros(sharpened.shape))
    sharpened = np.minimum(sharpened, 255 * np.ones(sharpened.shape))
    sharpened = sharpened.round().astype(np.uint8)
    if threshold > 0:
        low_contrast_mask = np.absolute(image - blurred) < threshold
        np.copyto(sharpened, image, where=low_contrast_mask)
    return sharpened

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
offset = int(eggparam[2])
threshold = int(eggparam[3])


# Load, rotate and crop image
img = cv2.imread(args["image"])
sharp_img = unsharp_mask(img)
img = imutils.rotate(sharp_img,180)
h = img.shape[0]
w = img.shape[1]
img = img[0:h-ycrop,xcrop:w]

# Convert image to HSV and Split to get value part
hsv = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)
hue ,saturation ,value = cv2.split(hsv)

# Apply adaptive threshold with Gaussian
thresh = cv2.adaptiveThreshold(value, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY, 255, threshold)
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

ret = ret-2   
# result  
blank_ch = 255 * np.ones_like(label_hue)
labeled_img = cv2.merge([label_hue, blank_ch, blank_ch])
labeled_img = cv2.cvtColor(labeled_img, cv2.COLOR_HSV2BGR)
labeled_img[label_hue == 0] = 0
#print(int(ret-2), end='')

#added blur protection
config = configparser.RawConfigParser()
config.read("/opt/lampp/htdocs/smartdengue/payton/log_value/"+args["node"]+".log")
val_bef = int(config[args["parameter"]][args["node"]])
# if abs(ret-val_bef)>10: # Update checking mechanism
#     if ret < val_bef:
#         ret = val_bef
if ret < val_bef:
    ret = val_bef
		
#give offset value if neccessary
ret = ret-offset
if ret<0:
	ret=0
str(ret)

#write new value
config.set(args["parameter"], args["node"], ret)
with open("/opt/lampp/htdocs/smartdengue/payton/log_value/"+args["node"]+".log", 'w') as configfile:
    config.write(configfile)

#print the result    
print('{"sys":{"eggnumber":', int(ret), '}}', end='')
