#!/usr/bin/python
# -*- coding: utf-8 -*-

import _mysql
import threading
import os
import paths
import database

db = _mysql.connection(host=database.host, user=database.user, passwd=database.passwd, db=database.dbName)

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
        print 'exception'
