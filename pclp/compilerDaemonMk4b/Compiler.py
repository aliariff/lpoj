#!/usr/bin/python
# -*- coding: utf-8 -*-
import os
import _mysql
import paths
import database
import MySQLdb
import sys

# from threading import Thread
# from threading import Timer

from sandbox import *
import time


class Compiler:

    log = 'compiler.log'
    dbName = 'lpoj'

    def __init__(self, path):
        self.canonicalPath = path
        print path
        path2 = path.rsplit('/')
        self.filename = path2[len(path2) - 1]
        data = self.filename.split('_-_')
        print data
        self.hashcode = data[1]
        self.waktu = data[0]
        self.soal = data[2]
        self.user = data[3]
        self.filetype = data[4].rsplit('.')[1]
        self.filename = data[4].rsplit('.')[0]
        self.root = os.curdir

        self.inputPath = paths.inputPath

        self.outputPath = paths.outputPath

        self.sourcePath = paths.sourcePath

        self.testPath = paths.testPath

        self.tmpPath = paths.tmpPath
        self.compiled = 0
        self.db = MySQLdb.connect(host='localhost', user='root',
                                  passwd='change_me',
                                  db=Compiler.dbName)

    def compile(self):
        if os.path.isfile(self.canonicalPath):
            if self.filetype == 'c':
                returnStat = os.system('gcc -o ' + self.outputPath
                        + 'out ' + self.canonicalPath + ' -lm')
                self.compiled = 1 - returnStat
            elif self.filetype == 'cpp':
                returnStat = os.system('g++ -o ' + self.outputPath
                        + 'out ' + self.canonicalPath)
                self.compiled = 1 - returnStat
            elif self.filetype == 'pas':
                print 'fpc ' + self.canonicalPath + ' -o' \
                    + self.outputPath + 'out'
                returnStat = os.system('fpc ' + self.canonicalPath
                        + ' -o' + self.outputPath + 'out')
                self.compiled = 1 - returnStat
            elif self.filetype == 'java':
                returnStat = os.system('javac -d ' + self.outputPath
                        + ' ' + self.canonicalPath + ' > '
                        + self.tmpPath + 'tmpLog')
                self.compiled = 1 - returnStat
            else:

                # self.db.query("UPDATE `pc_submit` SET `STATUS_ID` = '10' WHERE `pc_submit`.`SUBMIT_HASH` ='"+str(self.hashcode)+"'")

                status = open('/root/pclp/status/' + self.waktu + '.'
                              + self.hashcode + '.0.10', 'w')
                status.close()

    def testRun(o):
        print o
        os.system(o)

        # return returnStat

    def malcode(self):

        # self.db.query("UPDATE `pc_submit` SET `STATUS_ID` = '11' WHERE `pc_submit`.`SUBMIT_HASH` ='"+str(self.hashcode)+"'")

        # CAMIN
        # self.db.query("UPDATE pc_submit SET SUBMIT_LOG = '1' WHERE SUBMIT_HASH ='"+str(self.hascode)+"'")

        logs = open(Compiler.log, 'a')
        logs.write('kompilasi ' + self.hashcode + ' ' + self.filename
                   + '.' + self.filetype + ' ' + self.user + ' '
                   + self.soal + ' GAGAL, MALICIOUS CODE\n')
        logs.close()
        status = open('/root/pclp/status/' + self.waktu + '.'
                      + self.hashcode + '.0.11.1', 'w')
        status.close()
        return

    def test(self):

        # print self.outputPath+"out"+"<"+self.testPath+self.soal

        returnStat = 0
        if self.compiled != 1:
            logs = open(Compiler.log, 'a')

            # self.db.query("UPDATE `pc_submit` SET `STATUS_ID` = '2' WHERE `pc_submit`.`SUBMIT_HASH` ='"+str(self.hashcode)+"'")

        # CAMIN
            # self.db.query("UPDATE pc_submit SET SUBMIT_LOG = '2' WHERE SUBMIT_HASH ='"+str(self.hashcode)+"'")

            status = open('/root/pclp/status/' + self.waktu + '.'
                          + self.hashcode + '.0.2.2', 'w')
            status.close()

            # print "kompilasi gagal, tidak bisa melanjutkan test\n"
            # op=open(self.tmpPath+"tmpLog","r")

            logs.write('kompilasi ' + self.hashcode + ' '
                       + self.filename + '.' + self.filetype + ' '
                       + self.user + ' ' + self.soal
                       + ' GAGAL, COMPILE ERROR\n')
            logs.close()
            return
        else:

        # langkah menjalankan program

            if self.filetype == 'java':
                limiter = open(paths.limiterPath + self.soal, 'r')
                memoryL = open(paths.memoryPath + self.soal, 'r')
                limit = limiter.readline()
                limiter.close()
                memory = memoryL.readline()
                memoryL.close()
                execPath = os.getcwd()
                os.chdir(self.outputPath)

                # v=Thread(target=testRun,args=("java "+self.filename+"<"+self.testPath+self.soal+">"+self.tmpPath+"tempOut",))
                # returnStat = testRun()

                returnStat = os.system('java -Duser.language=EN '
                        + self.filename + '<' + self.testPath
                        + self.soal + '>' + self.tmpPath + '/tempOut &')

                # returnStat = os.system(execPath+"/executor.sh "+str(4108200+int(memory))+' "'+"java "+self.filename+'" '+self.testPath+self.soal+" "self.tmpPath+"tempOut")
                # langkah membatasi running time

                time.sleep(float(limit))
                os.system('ps -C java -o pid= > pid')
                if os.path.getsize('./pid') != 0:
                    pid = open('./pid')
                    os.system('kill ' + pid.readline())
                    pid.close()

                    # self.db.query("UPDATE `pc_submit` SET `STATUS_ID` = '4' WHERE `pc_submit`.`SUBMIT_HASH` ='"+str(self.hashcode)+"'")

                    status = open('/root/pclp/status/' + self.waktu
                                  + '.' + self.hashcode + '.0', 'w')
                    status.close()

                    return
            else:
                limiter = open(paths.limiterPath + self.soal, 'r')
                limit = limiter.readline()
                limit = float(limit) * 1000
                limiter.close()
                memoryL = open(paths.memoryPath + self.soal, 'r')
                memo = memoryL.readline()
                memoryL.close()

                counter = len([name for name in
                              os.listdir('/root/pclp/inputcase/')
                              if self.soal in name])
                total = 0

                # CAMIN

                submit_log = ''

                # NPC2014

                status_log = '.7.'

                for i in range(1, counter + 1):
                    print 'i = ' + str(i)
                    s = Sandbox(self.outputPath + 'out',
                                stdin=open(self.testPath + self.soal
                                + '_' + str(i), 'r'),
                                stdout=open(self.tmpPath + '/tempOut',
                                'w'), quota=dict(cpu=int(limit),
                                memory=int(memo), wallclock=int(limit)))
                    s.run()
                    y = s.probe()

                    # submit_log dan status_log tidak konsisten/sama pada compiler dengan database pc_status

                    if s.result == 3:

                        # CAMIN

                        submit_log += '3 '
                        status_log = '.5.'

                        # status = open("../status/"+self.waktu+"."+self.hashcode+".5","w")
                        # status.close()

                        logs = open(Compiler.log, 'a')
                        logs.write('running ' + self.hashcode + ' '
                                   + self.filename + '.'
                                   + self.filetype + ' ' + self.user
                                   + ' ' + self.soal + ' testcase'
                                   + str(i)
                                   + ' GAGAL, Memory Limit Exceeded\n')
                        logs.close()
                        continue
                    if s.result == 5:

                        # CAMIN

                        submit_log += '5 '
                        status_log = '.4.'

                        # status = open("../status/"+self.waktu+"."+self.hashcode+".4","w")
                        # status.close()

                        logs = open(Compiler.log, 'a')
                        logs.write('running ' + self.hashcode + ' '
                                   + self.filename + '.'
                                   + self.filetype + ' ' + self.user
                                   + ' ' + self.soal + ' testcase'
                                   + str(i)
                                   + ' GAGAL, Time Limit Exceeded\n')
                        logs.close()
                        continue
                    if s.result == 6:

                        # CAMIN

                        submit_log += '6 '
                        status_log = '.3.'

                        # status = open("../status/"+self.waktu+"."+self.hashcode+".3","w")
                        # status.close()

                        logs = open(Compiler.log, 'a')
                        logs.write('running ' + self.hashcode + ' '
                                   + self.filename + '.'
                                   + self.filetype + ' ' + self.user
                                   + ' ' + self.soal + ' testcase'
                                   + str(i) + ' GAGAL, Runtime Error\n')
                        logs.close()
                        continue

                    print 'diff ' + self.tmpPath + '/tempOut ' \
                        + self.inputPath + self.soal + '_' + str(i) \
                        + ' > ' + self.tmpPath + 'tmpLog'

                    # os.system("cat "+self.tmpPath+"tempOut")

                    returnStat = 0
                    p = 0
                    toll = open(paths.tollerancepath + self.soal, 'r')
                    try:
                        p = float(toll.read())
                    except ValueError:
                        print 'exception'
                    toll.close()
                    if p == 0:
                        returnStat = os.system('diff ' + self.tmpPath
                                + '/tempOut ' + self.inputPath
                                + self.soal + '_' + str(i))
                    else:
                        returnStat = os.system('python ./custdiff.py '
                                + self.tmpPath + '/tempOut '
                                + self.inputPath + self.soal + ' '
                                + str(p))
                    if returnStat == 0:
                        print returnStat

                        # status = open("../status/"+self.waktu+"."+self.hashcode+".0","w")
                        # status.close()

                        submit_log += '7 '
                        logs = open(Compiler.log, 'a')
                        logs.write('running ' + self.hashcode + ' '
                                   + self.filename + '.'
                                   + self.filetype + ' ' + self.user
                                   + ' ' + self.soal + ' testcase'
                                   + str(i) + ' SUKSES, AC\n')
                        logs.close()
                        print 'Sukses'
                        cursor = self.db.cursor()
                        sql = \
                            "select persentase from pc_testcase where inputcase = 'testCase" \
                            + str(self.soal) + '_' + str(i) + "'"
                        cursor.execute(sql)
                        results = cursor.fetchall()
                        for row in results:
                            print row[0]
                            total = total + int(row[0])
                    else:
                        print returnStat
                        returnStat = os.system('diff -iwB '
                                + self.tmpPath + '/tempOut '
                                + self.inputPath + self.soal + '_'
                                + str(i))
                        if returnStat == 0:

                            # CAMIN

                            submit_log += '8 '
                            status_log = '.6.'
                            logs = open(Compiler.log, 'a')
                            logs.write('running ' + self.hashcode + ' '
                                    + self.filename + '.'
                                    + self.filetype + ' ' + self.user
                                    + ' ' + self.soal + ' testcase'
                                    + str(i)
                                    + ' GAGAL, Presentation Error\n')
                            logs.close()

                            # self.db.query("UPDATE `pc_submit` SET STATUS_ID = '6' WHERE `pc_submit`.`SUBMIT_HASH` ='"+str(self.hashcode)+"'")
                            # status = open("../status/"+self.waktu+"."+self.hashcode+".6","w")
                            # status.close()

                            print 'presentation error'
                        else:

                            # CAMIN

                            submit_log += '9 '
                            status_log = '.1.'
                            logs = open(Compiler.log, 'a')
                            logs.write('running ' + self.hashcode + ' '
                                    + self.filename + '.'
                                    + self.filetype + ' ' + self.user
                                    + ' ' + self.soal + ' testcase'
                                    + str(i) + ' GAGAL, Wrong Answer\n')
                            logs.close()

                            # self.db.query("UPDATE `pc_submit` SET `STATUS_ID` = '1' WHERE `pc_submit`.`SUBMIT_HASH` ='"+str(self.hashcode)+"'")
                            # status = open("../status/"+self.waktu+"."+self.hashcode+".1","w")
                            # status.close()

                            print 'gagal'

                # CAMIN
                # self.db.query("UPDATE pc_submit SET SUBMIT_LOG = '"+submit_log+"' WHERE SUBMIT_HASH ='"+str(self.hashcode)+"'")

                status = open('/root/pclp/status/' + self.waktu + '.'
                              + self.hashcode + '.' + str(total)
                              + status_log + submit_log, 'w')
                status.close()
                logs = open(Compiler.log, 'a')
                logs.write('HASIL ' + str(self.hashcode) + ' '
                           + self.filename + '.' + self.filetype + ' '
                           + self.user + ' ' + self.soal + ' '
                           + str(total) + '\n')
                logs.close()
                print 'total = ' + str(total)
