#!/usr/bin/python
# -*- coding: utf-8 -*-

import _mysql
import threading
import os
import paths
import database

db = _mysql.connection(host='localhost', user='root', passwd='change_me'
                       , db='pclp')

# i = 0

while True:
    try:
        list1 = os.listdir(paths.statusPath)
        list1.sort()
        for i in list1:
            data = i.split('.')
            db.query("UPDATE pc_submit SET SCORE = '" + data[2]
                     + "', STATUS_ID = '" + data[3]
                     + "', SUBMIT_LOG = '" + data[4]
                     + "' WHERE SUBMIT_HASH ='" + data[1] + "'")
            os.system('rm ' + paths.statusPath + '*')
    except Exception:

            # print "UPDATE pc_submit SET SCORE = " +data[2]+ "', STATUS_ID = '"+data[3]+"', SUBMIT_LOG = '"+data[4]+"' WHERE SUBMIT_HASH ='"+data[1]

        db = _mysql.connection(host='localhost', user='root',
                               passwd='change_me', db='pclp')

        # print data
        # print "update pc_submit set STATUS_ID="+data[2]+" where SUBMIT_HASH='"+data[1]+"'"
        # db.query("update pc_submit set STATUS_ID="+data[2]+" where SUBMIT_HASH='"+data[1]+"'")
        # i=i+1
        # if i%100==0:
        # ....db.close()
        # ....db = _mysql.connection(host="localhost",user="root",passwd="123",db="pclp")
        # os.system("mv "+paths.statusPath+"/"+i+" "+paths.rootCompilerPath+"backup2")
