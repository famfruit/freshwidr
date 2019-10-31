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
sql = "SELECT * FROM series WHERE status = 0"
mycursor = mydb.cursor()
mycursor.execute(sql)
myresult = mycursor.fetchall()
for x in myresult:
    title = x[1]
    url = "https://api.themoviedb.org/3/search/tv?api_key={0}&query={1}".format(key, title)
    hdr = {'User-Agent': 'Mozilla/5.0'}
    req = Request(url,headers=hdr)
    page = urlopen(url)
    page = json.load(page)
    page = page['results'][0]
    i_pop = page['popularity']
    i_vote = page['vote_count']
    i_airdate = page['first_air_date']
    i_id = page['id']
    i_overview = page['overview'].replace("'", "")
    i_backdrop = page['backdrop_path']
    i_poster = page['poster_path']
    i_avg = page['vote_average']
    #print("{0}: \n".format(x[1]), i_pop, i_vote, i_id, i_backdrop, i_poster, i_overview)
    sql = "UPDATE series SET i_pop = {0}, i_vote = {1}, i_avg = {7}, i_id = {2}, i_overview = '{3}', i_bg = '{4}', i_img = '{5}' WHERE id = {6}".format(i_pop, i_vote, i_id, i_overview, i_backdrop, i_poster, x[0], i_avg)
    mycursor.execute(sql)
    print("UPDATED: {0}".format(x[1]))
