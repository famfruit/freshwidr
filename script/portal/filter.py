import mysql.connector
from urllib.request import Request, urlopen
import json
mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="",
  database="media",
  autocommit=True
)


def main():
    mycursor = mydb.cursor()
    mycursor.execute("SELECT * FROM movies_test WHERE img = 'null' OR img = '' OR img = 'f' AND status = 0")
    myresult = mycursor.fetchall()
    print(len(myresult))
    for x in myresult:
        mycursor.execute("UPDATE movies_test SET status = {0} WHERE id = {1}".format(1, x[0]))
        print(x[8], x[0], x[1])
main()
