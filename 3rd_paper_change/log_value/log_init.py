#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Thu Jun 25 15:14:11 2020

@author: moezeus
"""
import configparser
config = configparser.ConfigParser()
i = 0
for i in range(1,76):
    str1 = "node"
    str2 = str(i)
    str3 = ".log"
    newstr = "_".join((str1, str2))
    config['Information'] = {'Data': 'Jumlah telur dan larva'}
    config['Egg_Counting'] = {}
    egg = config['Egg_Counting']
    egg[newstr] = '0'
    
    config['Larva_Counting'] = {}
    egg = config['Larva_Counting']
    egg[newstr] = '0'
    
    newstr2 = "".join((newstr,str3))
    
    with open(newstr2, 'w') as configfile:
        config.write(configfile)

