import requests
from bs4 import BeautifulSoup
import datetime
import mysql.connector

class HighlighCrawler:
    

    # Replace these values with your actual MySQL server information
    host = "127.0.0.1"
    user = "root"
    password = ""
    database = "football_live"



    def insertData(self, data_list):


        insert_query = """
        INSERT INTO sport_highlights (
            referer,
            link,
            link_type,
            league,
            match_date,
            team1_name,
            team2_name,
            vs,
            team1_logo,
            team2_logo
        ) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s ); """
        try:
            # Create a connection to the MySQL server
            connection = mysql.connector.connect(
                host=self.host,
                user=self.user,
                password=self.password,
                database=self.database,
                charset='utf8mb4'
            )

            cursor = connection.cursor()
           
            for data in data_list:
                cursor.execute(insert_query, data)
                    
            # Commit the changes to the database
            connection.commit()
            
            print("complete successfully!")
        except mysql.connector.Error as err:
            print("Error:", err)

        finally:
            cursor.close()
            connection.close()

    def fetchLastDate(self):
        try:
            # Create a connection to the MySQL server
            connection = mysql.connector.connect(
                host=self.host,
                user=self.user,
                password=self.password,
                database=self.database,
                charset='utf8mb4'
            )

            cursor = connection.cursor()
            
            cursor.execute('select match_date from sport_highlights order by match_date desc limit 1')
            last = cursor.fetchone()

            if last ==None: return None

            last_date = last[0]

            return last_date
        except:
            print('error on fetching last date')
        finally:
            cursor.close()
            connection.close()

    def checkExists(self, date, team1, team2):
        exists = True
        try:
            # Create a connection to the MySQL server
            connection = mysql.connector.connect(
                host=self.host,
                user=self.user,
                password=self.password,
                database=self.database,
                charset='utf8mb4'
            )

            cursor = connection.cursor()
            
            cursor.execute('select * from sport_highlights where team1_name=%s and team2_name=%s and match_date=%s', (team1, team2, date))
            result = cursor.fetchone()
    
            exists= result != None
        except:
            print('checking exist failed')
            
        finally:
            cursor.close()
            connection.close()

        return exists

    
    def crawlData(self):
        url = 'https://bingsportlive.com/high-light'

        resp = requests.get(url)

        html = resp.text

        bs = BeautifulSoup(html, features="html.parser")

        items = bs.find_all("a", class_="item-match")

        data_list = []

        last_date = self.fetchLastDate()

        for item in items:
            link = item['href']
            league = item.find("div", class_="league-name").text.strip()
            timestamp = int(item.find("div", class_='time-match')['data-timestamp'])
            leftTeam = item.find('div', class_='left-team').text.strip()
            rightTeam = item.find('div', class_='right-team').text.strip()
            vs = item.find('div', class_='txt-vs').text.strip()

            logos = item.find_all('div', class_='box-image-logo')
            leftLogo = logos[0].find('img')['data-src']
            rightLogo = logos[1].find('img')['data-src']


            match_datetime = datetime.datetime.fromtimestamp(timestamp)
            # formatted_date = date_object.strftime("%Y-%m-%d") #convert to str

            if last_date != None:
                if match_datetime < last_date:
                    continue

                if match_datetime == last_date:
                    if self.checkExists(match_datetime, leftTeam, rightTeam):
                        continue
                
            resp = requests.get(link)

            highlight_link = None
            item_map = ('https://bingsportlive.com', highlight_link, 'Default', league, match_datetime, leftTeam, rightTeam, vs, leftLogo, rightLogo)

            if resp.status_code!=200:
                data_list.append(item_map)
                continue

            soup = BeautifulSoup(resp.text, 'html.parser')

            script_tag = soup.find("script", string=lambda string: string and "link_highlight" in string)

            if script_tag:
                highlight_link = script_tag.text.split("link_highlight = ")[1].split(";")[0].strip()
                highlight_link = highlight_link.replace("'", '')
                print(highlight_link)

            item_map = ('https://bingsportlive.com', highlight_link, 'Default', league, match_datetime, leftTeam, rightTeam, vs, leftLogo, rightLogo)
            data_list.append(item_map)

        self.insertData(data_list)   


if __name__ == "__main__":
    crawler = HighlighCrawler()
    crawler.crawlData()
    # crawler.checkExists()