import re
def strip(path):
    file=open(path,"r")
    for line in file:
        d=re.search("system",line)
        if d:
            return True
        
    return False
    
