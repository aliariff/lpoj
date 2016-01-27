#!/usr/bin/python
# -*- coding: utf-8 -*-

import _mysql
import threading
import os
import paths
import database
import re

db = _mysql.connection(host=database.host, user=database.user, passwd=database.passwd, db=database.dbname)

while True:
    pat = re.compile('index.html')
    try:
        list1 = os.listdir(paths.statusPath)
        list1.sort()
        for i in list1:
            if i[0] == '.':
                continue
            if pat.search(i) != None:
                continue

            data = i.split('.')
            db.query("UPDATE pc_submit SET SCORE = '" + data[2]
                     + "', STATUS_ID = '" + data[3]
                     + "', SUBMIT_LOG = '" + data[4]
                     + "' WHERE SUBMIT_HASH ='" + data[1] + "'")
            os.system('rm ' + paths.statusPath + '*')
    except Exception:
        print 'exception'
