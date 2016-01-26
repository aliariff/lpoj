#!/usr/bin/python
# -*- coding: utf-8 -*-
from KThread import *
import os
import time
from threading import Timer


def func():

    # print "Function started"

    os.system('/var/www/gemastik/result/out')


    # while True:
    # ....print "Function finished"

a = os.fork()
if a == 0:
    func()
else:
    os.system('kill ' + str(a))
