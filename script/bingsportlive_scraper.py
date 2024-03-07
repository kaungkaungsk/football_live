import requests
from bs4 import BeautifulSoup
import json
import pytz
from datetime import datetime


def scrapt_live(url):
  
  resp = requests.get(url)
  if resp.status_code !=200:
    print('fail: ', url)
    return None
  else:
    print('success: ', url)

  soup = BeautifulSoup(resp.text, 'html.parser')
  script_tag = soup.find("script", string=lambda string: string and "matchInfo" in string)

  if script_tag:
    matchInfo = script_tag.text.split("matchInfo = ")[1].split("};")[0].strip() + '}'
    match_info_js = json.loads(matchInfo)

    utc_datetime = match_info_js['date_time']
    myanmar_datetime = utc_to_myanmar(utc_datetime)

    info = match_info_js['info']

    link_live = match_info_js['link_live']
    
    video_links = []
    
    if link_live != None:
      for i in json.loads(link_live):
        video_links.append({
          'id': i['id'],
          'name': i['extra_title'],
          'link': i['stream_link'],
          'referer': 'https://bingsportlive.com',
        })

    match_data = {}

    #data is empty, we don't use 
    # if info['localteam_title']=='' or info['visitorteam_title']=='':
    #   return None

    teams = str(match_info_js['name']).split('vs')

    match_data['video_links'] = video_links

    match_data['date'] = myanmar_datetime.strftime("%Y-%m-%d %H:%M:%S %p")
    
    match_data['home'] = {
      'team_id': 99,
      # 'name': info['localteam_title'],
      'name': teams[0].strip(),
      'logo': info['localteam_logo'],
    }

    match_data['away'] = {
      'team_id': 98,
      # 'name': info['visitorteam_title'],
      'name': teams[1].strip(),
      'logo': info['visitorteam_logo'],
    }

    match_data['fixture_id'] = match_info_js['id']

    match_data['league'] = {
      'name': info['league_title'],
      'logo': info['league_icon'],
      'country': info['country_title'],
    }

    return match_data

  else: 
    return None



def utc_to_myanmar(utc_dt):
  utc_dt = pytz.utc.localize(datetime.fromisoformat(utc_dt)) 
  myanmar_tz = pytz.timezone('Asia/Yangon')
  myanmar_dt = utc_dt.replace(tzinfo=pytz.utc).astimezone(myanmar_tz)
  return myanmar_dt

def scrapt_matches():

  url = 'https://bingsportlive.com/live-stream-football.html'
  resp = requests.get(url)

  if resp.status_code != 200: 
    print('fail to connect')
    return

  soup = BeautifulSoup(resp.text, 'html.parser')
  items = soup.find_all("a", class_="item-match")

  match_links = []

  for i in items:
    match_links.append(i['href'])

  return match_links


# entry point
if __name__=='__main__':
  match_links = scrapt_matches()

  data = []
  for i in match_links:
    _data = scrapt_live(i)

    if _data == None:
      print('fail data : ', i)
    else:
      data.append(_data)

  # data = scrapt_live('https://bingsportlive.com/live-sport/deportivo-riestra-vs-talleres-cordoba-1629351490.html')
  with open('../storage/app/data/bingsportlive.json', 'w') as f:
    f.write(json.dumps(data))

   