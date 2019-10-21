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


key = "5bea29aec07ce4f0a098fd3f9f460e4a"
tvDB = "https://api.themoviedb.org/3/search/tv?api_key={0}".format(key)
movieDB = "https://api.themoviedb.org/3/search/movie?api_key={0}".format(key)







def firstfun():
    #print("1")
    mycursor = mydb.cursor()
    mycursor.execute("SELECT * FROM movies_test WHERE img IS NULL OR img = ''")
    myresult = mycursor.fetchall()
    print(len(myresult))
    num = 0
    for x in myresult:
        #print("2")
        #print("3")
        url = "{0}&query={1}".format(movieDB, x[1])
        hdr = {'User-Agent': 'Mozilla/5.0'}
        req = Request(url,headers=hdr)
        page = urlopen(url)
        #print(page.read())
        p = json.load(page)
        num += 1
        if(p['total_results'] == 0):
            poster = "f"
            reld = "f"
            genre = "f"
            mycursor.execute("UPDATE movies_test SET img = '{0}', genre = '{1}', releasedate = '{2}' WHERE id = {3}".format(poster, str(genre), reld, x[0]))
            print("Updated ID: {0}   /   {1} # F".format(x[0], num))
        else:
            poster = p['results'][0].get("poster_path", "null")
            genre = p['results'][0].get("genre_ids", "null")
            reld = p['results'][0].get("release_date", "null")
            if(poster == 'null' or poster is None):
                poster = "f"
                mycursor.execute("UPDATE movies_test SET img = '{0}', genre = '{1}', releasedate = '{2}' WHERE id = {3}".format(poster, str(genre), reld, x[0]))

                print("Updated ID: {0}   /   {1}  {2}".format(x[0], num, poster))
            else:
                mycursor.execute("UPDATE movies_test SET img = '{0}', genre = '{1}', releasedate = '{2}' WHERE id = {3}".format(poster, str(genre), reld, x[0]))

                print("Updated ID: {0}   /   {1}  {2}".format(x[0], num, poster))


mycursor = mydb.cursor()
mycursor.execute("SELECT * FROM series WHERE img IS NULL OR img = ''")
myresult = mycursor.fetchall()
def secfun():
    print(len(myresult))
    num = 0
    for x in myresult:
        #print("2")
        #print("3")
        url = "{0}&query={1}".format(tvDB, x[1])
        hdr = {'User-Agent': 'Mozilla/5.0'}
        req = Request(url,headers=hdr)
        page = urlopen(url)
        #print(page.read())
        p = json.load(page)
        num += 1
        if(p['total_results'] == 0):
            poster = "f"
            reld = "f"
            genre = "f"
            mycursor.execute("UPDATE series SET img = '{0}', genre = '{1}', releasedate = '{2}' WHERE id = {3}".format(poster, str(genre), reld, x[0]))
            print("Updated ID: {0}   /   {1} # F".format(x[0], num))
        else:

            poster = p['results'][0].get("poster_path", "null")
            genre = p['results'][0].get("genre_ids", "null")
            reld = p['results'][0].get("first_air_date", "null")
            if(poster == 'null' or poster is None):
                poster = "f"
                mycursor.execute("UPDATE series SET img = '{0}', genre = '{1}', releasedate = '{2}' WHERE id = {3}".format(poster, str(genre), reld, x[0]))

                print("Updated ID: {0}   /   {1} # D {2}".format(x[0], num, poster))
            else:
                mycursor.execute("UPDATE series SET img = '{0}', genre = '{1}', releasedate = '{2}' WHERE id = {3}".format(poster, str(genre), reld, x[0]))

                print("Updated ID: {0}   /   {1} # S {2}".format(x[0], num, poster))
#firstfun()
secfun()
