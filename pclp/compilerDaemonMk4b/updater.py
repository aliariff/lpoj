import paths
import _mysql
import os
import database
class Updater:
	def __init__(self):
		self.db=_mysql.connection(host="10.151.34.9",user="root",passwd="123",db="pclp")
	def update(self):
		self.db.query("select * from pc_problem")
		result = self.db.store_result()
		for i in range(result.num_rows()):
			row = result.fetch_row()
			print row[0][0]
			testCase = open(paths.testPath+row[0][0],"w")
			print row[0][5]
			testCase.writelines(row[0][5])
			testCase.close()
			inputCase = open(paths.inputPath+row[0][0],"w")
			inputCase.write(row[0][6])
			inputCase.close()
			limiter = open(paths.limiterPath+row[0][0],"w")
			limiter.write(row[0][7])
			limiter.close()
			memory = open(paths.memoryPath+row[0][0],"w")
			memory.write(row[0][8])
			memory.close()
			tollerance = open(paths.tollerancepath+row[0][0],"w")
			tollerance.write(row[0][9])
			tollerance.close()
			if not os.path.exists("/root/pclp/backup/"+row[0][0]):
				os.system("mkdir /root/pclp/backup/"+row[0][0])
		files = os.listdir("/root/pclp/komparator/")
		print files 
		for i in files:
			os.system("fromdos "+"/root/pclp/komparator/"+i)
			
if __name__=="__main__":
	updater = Updater()
	updater.update()
